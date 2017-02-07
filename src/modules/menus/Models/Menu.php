<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use P3in\Models\MenuItem;
use P3in\Models\Website;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'website_id'
    ];

    /**
     * Website
     *
     * @return     BelongsTo    Website
     */
    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    /**
     * items
     *
     * @return     HasMany  [MenuItem]
     */
    public function items()
    {
        return $this->hasMany(MenuItem::class)->with('navigatable')->orderBy('order', 'ASC');
    }

    /**
     * add
     *
     * @param      \App\MenuItem  $nav_item  The navigation item
     *
     * @return     MenuItem instance
     */
    public function add(MenuItem $menu_item)
    {
        return $menu_item->menu()->associate($this)->save();
    }

    /**
     * Drop MenuItem
     *
     * @param      \App\MenuItem  $nav_item  The navigation item
     */
    public function drop($item)
    {
        if (is_int($item)) {
            $nav_item = $this->items()->where('id', $item)->firstOrFail();
        } elseif ($item instanceof MenuItem) {
            $nav_item = $this->items()->where('id', $item->id)->firstOrFail();
        }

        if ($nav_item->delete()) {
            return true;
        } else {
            throw new \Exception("Errors while removing MenuItem");
        }
    }

    /**
     * render
     */
    public function render($clean = false)
    {
        $this->load('items');

        if ($clean) {
            $this->makeHidden(['id', 'website_id', 'created_at']);

            $this->items->each(function ($item) {
                $item->makeHidden(['id', 'menu_id', 'parent_id', 'req_perm', 'navigatable_id', 'navigatable_type', 'created_at']);
            });
        }

        $user_perms = [];

        if (\Auth::check()) {

            $user_perms = \Auth::user()->allPermissions()->toArray();

        }

        $items = $this->items()
            ->whereNull('req_perm')
            ->orWhereIn('req_perm', array_keys($user_perms))
            ->get();

        return $this->buildTree($items);
    }

    /**
     * Builds a menu tree recursively.
     *
     * @param      array   $items     The items
     * @param      <type>  $parent_id  The parent identifier
     *
     * @return     array   The tree.
     */
    private function buildTree(Collection &$items, $parent_id = null)
    {
        $tree = [];

        foreach ($items as &$node) {
            if ($node->parent_id === $parent_id) {
                $children = $this->buildTree($items, $node->id);

                if ($children) {
                    $node->children = $children;
                } else {
                    $node->children = [];
                }

                // @TODO make this add conditional based on permissions
                $tree[] = $node;

                unset($node); // mmm doesn't actually unset
            }
        }

        return $tree;
    }
}