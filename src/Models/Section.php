<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\Form;
use P3in\Models\Page;
use P3in\Models\Website;

class Section extends Model
{
    protected $fillable = [
        'name',
        'template',
        'type',
        'config',
    ];

    protected $casts = [
        'config' => 'object',
    ];

    /**
     * Relation to pages
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function pages()
    {
        return $this->belongsToMany(Page::class, 'page_component_content');
    }

    /**
     * Relation to a website
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    /**
     * Plymorphic relatio to Form
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function form()
    {
        return $this->morphOne(Form::class, 'formable');
    }

    /**
     * Get component type.
     *
     * @param      <type>  $query  The query
     * @param      <type>  $type   The type
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public static function getType($type)
    {
        return static::byType($type)->firstOrFail();
    }

    public function scopeByTemplate($query, $template)
    {
        return $query->where('template', $template);
    }

    public static function getTemplate($name)
    {
        return static::byTemplate($name)->firstOrFail();
    }

    /**
     * Make sure config doesn't return empty
     *
     * @return     array  The configuration attribute.
     */
    public function getConfigAttribute($value)
    {
        return json_decode($value) ?? [];
    }
    /**
     * Gets the container.
     *
     * @return     <type>  The container.
     */
    public static function getContainer()
    {
        return static::getType('container');
    }

    // @TODO we need to be able to return the full (empty) form structure.
    // This is mainly used to itialize a section's form content to allow us to be
    // a bit more flexible on teh front-end when calling a UI that hasn't been
    // initially seeded with a form submission yet.
    public function getFormStructure()
    {
        $rtn = [];
        // $this->form;
        return $rtn;
    }
}
