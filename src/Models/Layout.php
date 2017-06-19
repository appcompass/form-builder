<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\Website;

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

    /**
     *
     */
    public static $rules = [
        'name' => 'required',
        'config' => 'required'
    ];

    /**
     * A redirect belogns to a Website
     */
    public function website()
    {
        return $this->belongsTo(Website::class);
    }

}
