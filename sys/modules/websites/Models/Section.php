<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\Form;
use P3in\Models\Page;

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
    public function scopeGetType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Gets the container.
     *
     * @return     <type>  The container.
     */
    public static function getContainer()
    {
        return static::getType('container')->firstOrFail();
    }
}
