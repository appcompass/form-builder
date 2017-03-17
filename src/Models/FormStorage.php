<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\Form;

class FormStorage extends Model
{

    protected $fillable = [
        'form_id',
        'content'
    ];

    public $table = 'form_storage';

    protected $casts = [
        'content' => 'object'
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public static function store(array $content, Form $form)
    {
        $storage = new static(['content' => $content]);

        // info($content);

        $storage->form()->associate($form);

        $storage->save();

        return $storage;
    }

}