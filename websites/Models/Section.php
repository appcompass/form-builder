<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\Layout;
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

	public function layout() {
		return $this->belongsTo(Layout::class);
	}

	public function pages()
	{
		return $this->belongsToMany(Page::class);
	}

    public function form()
    {
        return $this->morphMany(Form::class, 'formable');
    }
}
