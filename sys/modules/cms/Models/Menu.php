<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use P3in\Models\MenuItem;
use P3in\Models\Website;

class Menu extends Model
{
    protected $fillable = [
        'name'
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
     * @param      \App\MenuItem  $menu_item  The navigation item
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
     * @param      \App\MenuItem  $menu_item  The navigation item(s)
     */
    public function drop($item)
    {
        if (is_array($item)) {

            foreach($item as $single) {

                $this->drop($single);

            }

            return $this;

        }

        if (is_int($item)) {

            $menu_item = $this->items()->where('id', $item)->firstOrFail();

        } elseif ($item instanceof MenuItem) {

            $menu_item = $this->items()->where('id', $item->id)->firstOrFail();

        }

        if ($menu_item->delete() && $this->clean($menu_item)) {

            return true;

        } else {

            throw new \Exception("Errors while removing MenuItem");

        }
    }

    /**
     * Recursively cleans MenuItem and children
     *
     * @param      \P3in\Models\MenuItem  $menuitem  The menuitem
     */
    private function clean(MenuItem $menuitem)
    {
        $children = MenuItem::where('parent_id', $menuitem->id)->get();

        if ($children) {

            foreach ($children as $child) {

                $this->clean($child);

            }

        }

        $menuitem->delete();

        return true;
    }

    /**
     * render
     */
    public function render($clean = false)
    {
        if ($clean) {
            $this
                ->makeHidden('id')
                ->makeHidden('website_id')
                ->makeHidden('created_at');

            $this->items->each(function ($item) {
                $item
                    ->makeHidden('id')
                    ->makeHidden('menu_id')
                    ->makeHidden('parent_id')
                    ->makeHidden('req_perm')
                    ->makeHidden('navigatable_id')
                    ->makeHidden('navigatable_type')
                    ->makeHidden('created_at')
                    ;
            });
        }
        // return $this->mapTree($items);
        return $this->buildTree($this->items);
    }

    /**
     * Single-pass Tree Mapping from flat array
     *
     * @param      array  $dataset  The dataset
     *
     * @return     array  Nested Tree structure
     */
    // @TODO: Delete this, other method works just fine :)
    // public function mapTree(array $dataset)
    // {
    //     $map = [];
    //     $tree = [];

    //     foreach ($dataset as $id => &$node) {
    //         $current =& $map[$node['id']];

    //         // @TODO better way to assign this? intersect_keys(array_flip) didn't work as expected
    //         $current['id'] = $node['id'];
    //         $current['parent_id'] = $node['parent_id'];
    //         $current['title'] = $node['title'];
    //         $current['url'] = $node['url'];
    //         $current['new_tab'] = $node['new_tab'];
    //         $current['clickable'] = $node['clickable'];
    //         $current['icon'] = $node['icon'];

    //         if ($node['parent_id'] == null) {
    //             $tree[$node['id']] =& $current;
    //         } else {
    //             $map[$node['parent_id']]['children'][$node['id']] =& $current;
    //         }
    //     }

    //     // dd(array_values_recursive($tree));

    //     return $tree;
    // }

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

                $tree[] = $node;

                unset($node); // mmm doesn't actually unset
            }
        }

        return $tree;
    }
}
