<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\ModularBaseModel;
use P3in\Models\Section;

class Template extends ModularBaseModel
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'templates';

    protected $casts = [
        'content' => 'array'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];

    /**
    *   Fields that needs to be treated as a date
    *
    */
    protected $dates = ['published_at'];

    /**
     *
     *
     */
    public function render($data)
    {

        $out = [];

        foreach ($this->sections as $section) {

            $out[$this->master][] = $section->render($data);

        }

        return $out;
    }

    /**
     *
     *
     */
    public function sections()
    {
        $rel = $this->belongsToMany(Section::class)
            ->withPivot(['template_section', 'order', 'content'])
            ->orderBy('pivot_order', 'asc');

        return $rel;
    }
}
