<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\Section;
use P3in\Models\Website;
use Exception;

class Layout extends Model
{
    public $table = 'website_layouts';

    /**
     * Mass assignable
     */
    public $fillable = [
        'name',
        'config',
        'order',
    ];

    protected $casts = [
        'config' => 'object',
    ];

    /**
     *
     */
    public static $rules = [
        'name' => 'required'
    ];

    /**
     * A redirect belogns to a Website
     */
    public function website()
    {
        return $this->belongsTo(Website::class);
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
    public function addChild(Section $section)
    {
        if ($this->parent && !$this->isContainer()) {
            throw new Exception('a Section can only be added to a Container.');
        }

        $child = new self;

        $child->config = $section->config;

        $child->section()->associate($section);

        $this->children()->save($child);

        return $child;
    }

    public function dropChildren($deletions)
    {
        if (is_array($deletions)) {
            foreach ($deletions as $single) {
                $this->dropChildren($single);
            }

            return $this;
        }

        if (is_int($deletions)) {
            $record = $this->children()->findOrFail($deletions);
        } elseif ($deletions instanceof Layout) {
            $record = $this->children()->findOrFail($deletions->id);
        }

        if (!isset($record)) {
            throw new Exception('Error Deleting children.');
        }

        // delete children first to trigger Observers properly.
        // Otherwise DB does auto clean up via cascade on delete,
        // i.e. no Observers triggered.
        if ($record->children->count()) {
            foreach ($record->children as $child) {
                $this->dropChildren($child);
            }
        }

        if ($record->delete()) {
            return true;
        } else {
            throw new Exception("Errors while removing Layout");
        }
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

    public function order(int $val)
    {
        $this->update(['order' => $val]);
    }
}
