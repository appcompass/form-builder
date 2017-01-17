<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use P3in\Interfaces\Linkable;
use P3in\Models\Layout;
use P3in\Models\PageContent;
use P3in\Models\Section;
use P3in\Models\Website;

class Page extends Model implements Linkable {
	use SoftDeletes
	// , HasPermissions
	;

	protected $fillable = [
		'slug',
		'title',
		'meta',
	];

	protected $guarded = [
		'url', // url are ALWAYS gonna be generated
	];

	protected $casts = [
		'meta' => 'object',
	];

	/**
	 * website
	 *
	 * @return     BelongsTo
	 */
	public function website() {
		return $this->belongsTo(Website::class);
	}

	/**
	 * parent
	 *
	 * @return     BelongsTo
	 */
	public function parent() {
		return $this->belongsTo(Page::class, 'parent_id');
	}

	/**
	 * children
	 *
	 * @return     HasMany
	 */
	public function children() {
		return $this->hasMany(Page::class, 'parent_id');
	}

	/**
	 * layouts
	 *
	 * @return     BelongsToMany
	 */
	public function layouts() {
		return $this->belongsToMany(Layout::class)
			->withPivot('order')
			->orderBy('pivot_order', 'asc');
	}

	/**
	 * Page Sections
	 *
	 * @return     BelongsToMany
	 */
	public function sections() {
		return $this->belongsToMany(Section::class);
	}

	/**
	 * content
	 *
	 * @return     HasMany
	 */
	public function contents() {
		return $this->hasMany(PageContent::class)->orderBy('order', 'asc');
	}

	/**
	 * get the Page via it's url
	 *
	 * @param      <type>  $query  The query Builder instance
	 * @param      <type>  $url    The url
	 *
	 * @return     Builder
	 */
	public function scopeByUrl($query, $url) {
		$escaped_url = DB::connection()->getPdo()->quote($url);
		$raw_url = DB::raw($escaped_url);

		return $query
			->select(
				"*",
				DB::raw("NULLIF(substring($escaped_url from url), url) AS dynamic_segment")
			)
			->where($raw_url, 'SIMILAR TO', DB::raw('url'));
	}

	/**
	 * Sets the url based on slug
	 *
	 * @param      <type>  $slug   The slug
	 */
	public function setSlugAttribute($slug) {
		$this->attributes['slug'] = $slug;

		$this->attributes['url'] = $this->buildUrl();

		if ($this->exists) {
			$this->save();

			$this->updateChildrenUrl();
		}
	}

	/**
	 * updateChildrenUrl
	 *
	 *  Updates children's url
	 *
	 */
	public function updateChildrenUrl() {
		foreach ($this->children as $child) {
			$child->url = $child->buildUrl();

			$child->save();
		}
	}

	/**
	 * buildUrl
	 *
	 * @return     string   Full Url, including parents
	 */
	private function buildUrl() {
		$page = $this;

		$slugs = [$this->slug];

		while ($page->parent_id !== null) {
			$page = $page->parent;

			array_push($slugs, $page->slug);
		}

		return '/' . implode('/', array_reverse($slugs));
	}

	/**
	 * Makes a menu item.
	 *
	 * @return     MenuItem
	 */
	public function makeMenuItem($order = 0): MenuItem{

		// @TODO find a way to auto-determine order based on previous insertions

		$item = new MenuItem([
			'title' => $this->title,
			'alt' => $this->title,
			'order' => $order,
			'new_tab' => false,
			'url' => null,
			'clickable' => true,
			'icon' => null,
		]);

		$item->navigatable()->associate($this);

		return $item;
	}
}
