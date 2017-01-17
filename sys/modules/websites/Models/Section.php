<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\Layout;

class Section extends Model {
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

	// public function form()
	// {
	//     return $this->morphOne(Form::class, 'formable');
	// }
}
