<?php

namespace P3in\Models;

use Iluminate\Database\Eloquent\Model;
use P3in\Models\Form;

class FormStorage extends Model
{

    protected $fillable = [
        'form_id',
        'content'
    ];

    protected $casts = [
        'content' => 'object'
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public static function store(array $content, Form $form)
    {
        $storage = new static($content);

        $storage->form()->associate($form);

        $storage->save();

        return $storage;
    }

}