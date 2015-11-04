<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use P3in\Models\Website;
use P3in\Modules\Navigation\LinkClass;
use P3in\Traits\NavigatableTrait as Navigatable;

class Page extends Model
{

	use Navigatable;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'pages';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'title',
		'description',
		'slug',
		'order',
		'parent',
		'website_id',
		'req_permission',
		'published_at'
	];

    /**
    *
    */
    protected $casts = [
        'content' => 'object'
    ];

	/**
	*	Fields that needs to be treated as a date
	*
	*/
	protected $dates = ['published_at'];

	/**
	*	Properties we want to link the class to
	*
	*	@var array
	*/
	protected $navigation_props = ['id'];

	/**
	 *
	 *
	 */
	// public function template()
	// {
	// 	return $this->belongsTo(Template::class);
	// }

	/**
	 *
	 */
	public function sections()
	{

		$rel = $this->belongsToMany(Section::class)
			// ->withPivot(['template_section', 'order', 'content'])
			->withPivot(['order', 'content'])
			->orderBy('pivot_order', 'asc');

		return $rel;

	}

	/**
	 *  Build a LinkClass out of this class
	 */
	public function makeLink()
	{

		return [
		  "label" => $this->title,
		  "url" => '',
		  "req_perms" => null,
		  "props" => [
		      'icon' => 'list',
		      "link" => [
		          'data-click' => $this->slug,
		          'data-target' => '#main-content'
		      ],
		  ]
		];
	}

	/**
	 *	Get the website the page belongs to
	 *
	 */
	public function website()
	{
		return $this->belongsTo(Website::class);
	}

	/**
	 *	Link the page to a website
	 *
	 */
	public function linkToWebsite(Website $website)
	{
		return $this->website()->associate($website)->save();
	}

	/**
	 * Render the page
	 *
	 */
	public function render($data)
	{

		return $this->template
			->render($data);

	}

	/**
	 *
	 */
	public function components()
	{

	  return $this->template()
	  	->with('sections');

	}

	/**
	 *
	 *
	 *
	 */
	public function getFullUrlAttribute()
	{

		return 'https://'.$this->website->site_url.$this->slug;

	}

	/**
	 *
	 *
	 */
	public function byPath($path, User $user)
	{

		try {

			$page = Page::findOrFail($path);

			$this->checkPermissions($user);

		} catch (ModelNotFoundException $e ) {

			return false;

		}

	}

	/**
	 * Check if User has permissions
	 *
	 *
	 */
	public function checkPermissions(User $user = null)
	{

		$this->req_permission = is_array($this->req_permission) ? $this->req_permission : explode(",", $this->req_permission);


		if (count($this->req_permission)) {

			if (is_null($user)) {

				return false;

			}

			return $user->hasPermissions($this->req_permission);

		}

		return true;

	}

}
