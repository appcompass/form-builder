<?php

namespace P3in\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use P3in\Traits\HasJsonConfigFieldTrait;
use P3in\Models\Page;
use P3in\Models\Section;
use P3in\Traits\HasDynamicContent;
use P3in\Traits\HasPhotos;

class PageSectionContent extends Model
{
    use HasDynamicContent, HasJsonConfigFieldTrait, HasPhotos;

    protected $table = 'page_section_content';

    protected $fillable = [
        'config',
        'order',
        'content',
    ];

    protected $casts = [
        'config' => 'object',
        'content' => 'object',
    ];

    // protected $with = ['section'];

    /**
     *
     */
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    /**
     *
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * parent
     *
     * @return     BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * children
     *
     * @return     HasMany
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Link to FieldSource
     *
     * @return     morphOne
     */
    public function source()
    {
        // @TODO @jubair can we make this ->load() to cut queries #
        return $this->morphOne(\P3in\Models\FieldSource::class, 'linked');
    }


    // @TODO: these are mainly used by the PageBUilder, but puting them here
    // is too generic, which is why we had them originally as setOrder etc.
    public function order(int $val)
    {
        $this->update(['order' => $val]);
    }

    public function props(array $val)
    {
        return $this->setConfig('props', $val);
    }

    public function content(array $val)
    {
        $this->update(['content' => $val]);
    }

    public function config($key, $val = null)
    {
        return $this->setConfig($key, $val);
    }


    /**
     * Gets the content attribute.
     *
     * @return     <type>  The content attribute.
     */
    public function getContentAttribute()
    {
        $content = json_decode($this->attributes['content']);

        if ($content === '[]') {

            $content = json_decode('{}');

        }

        if ($this->source) {

            // @TODO this needs to go, why is content sometimes an array and sometimes an object
            // when content is empty json_decode treats it as an array, how can it tell...
            if (is_array($content)) {

                $content[$this->source->related_field] = $this->source->render();

            } else {

                $content->{$this->source->related_field} = $this->source->render();

            }

            // we don't need a separate field in this case
            unset($this->source);

            return $content;

        } else {

            // if content doesn't have a linked source just return actual content

            return $content;

        }
    }

    /**
     * Add a child container to a parent.
     * @param int $order
     * @param array $config
     * @return Model PageSectionContent
     */
    public function addContainer(Section $container)
    {
        return $this->addSection($container);
    }

    /**
     * Add a section to a container.
     *
     * @param      Section    $section
     * @param      int        $order
     * @param      array      $data         The data
     * @param      boolean    $returnChild  The return child
     * @param      int   $columns
     *
     * @throws     Exception  (description)
     *
     * @return     Model      PageSectionContent
     */
    public function addSection(Section $section)
    {
        if (!$this->isContainer()) {

            throw new Exception('a Section can only be added to a Container.');

        }

        $child = new self;

        $child->config = $section->config;

        $child->section()->associate($section);

        $child->page()->associate($this->page);

        $this->children()->save($child);

        // if ($returnChild) {

        return $child;

        // }

        // return $this;
    }

    /**
     * Saves a content.
     *
     * @param      <type>  $content  The content
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function saveContent($content)
    {
        $this->content = $content;
        $this->save();
        return $this;
    }

    /**
     * Edit - returns config data for dynamic fields
     *
     * @return     array  ( description_of_the_return_value )
     */
    public function edit()
    {
        if ($this->source) {

            $source = $this->source;

            $content = json_decode($this->attributes['content']);

            // @TODO this needs to go, why is content sometimes an array and sometimes an object
            // when content is empty json_decode treats it as an array, how can it tell...
            if (is_array($content)) {

                $content[$this->source->related_field] = $this->source->config();

            } else {

                $content->{$this->source->related_field} = $this->source->config();

            }

        } else {

            $content = json_decode($this->attributes['content']);

        }

        $website = $this->page->website;

        return [
            'form' => $this->section->form ? $this->section->form->render() : null,
            'gallery' => $website->gallery,
            'storage' => $website->storage,
            'content' => $content
        ];
    }

    /**
     * Determines if container.
     *
     * @return     boolean  True if container, False otherwise.
     */
    public function isContainer()
    {
        return $this->section->type === 'container';
    }

    public function getBasePhotoPath()
    {

    }
}
