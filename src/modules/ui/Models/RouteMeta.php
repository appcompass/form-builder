<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use P3in\ModularBaseModel;

class RouteMeta extends ModularBaseModel
{
    protected $fillable = [
        'name',
        'config',
    ];

    protected $casts = [
        'config' => 'object',
    ];

    public function scopeByName($query, $name)
    {
        return $query->where('name', $name);
    }

    // public function scopeWithForm($query, $name)
    // {
    //     $form_name = substr($name, 0, strrpos($name, '.')).'.form';
    //     $escaped_form_name = DB::connection()->getPdo()->quote($form_name);

    //     return $query
    //         ->select(
    //             "*",
    //             DB::connection()->raw("(SELECT config FROM route_metas WHERE name = $escaped_form_name) as form")
    //         );
    //     // substr($meta->base_url, 0, strrpos($meta->base_url, '.'))
    // }

    public function getCombinedAttribute()
    {
        $config = $this->config;
        if ($config) {
            $config->form = $this->form;
        }
        return $config;
    }
}
