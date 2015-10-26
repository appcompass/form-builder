<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;

class UiConfig extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'modules_ui_config';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['module_name', 'config'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'config' => 'object',
    ];

}
