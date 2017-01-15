<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\Website;
use P3in\Models\NavItem;

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
     * @return     HasMany  [NavItem]
     */
    public function items()
    {
        return $this->hasMany(NavItem::class)->with('navigatable')->orderBy('sort', 'ASC');
    }

    /**
     * add
     *
     * @param      \App\NavItem  $nav_item  The navigation item
     *
     * @return     boolean
     */
    public function add(NavItem $nav_item)
    {
        $nav_item->menu_id = $this->id;

        return $nav_item->save();
    }

    /**
     * Drop NavItem
     *
     * @param      \App\NavItem  $nav_item  The navigation item
     */
    public function drop($item)
    {
        if (is_int($item)) {
            $nav_item = $this->items()->where('id', $item)->firstOrFail();
        } elseif ($item instanceof NavItem) {
            $nav_item = $this->items()->where('id', $item->id)->firstOrFail();
        }

        if ($nav_item->delete()) {
            return true;
        } else {
            throw new \Exception("Errors while removing NavItem");
        }
    }

    /**
     * render
     */
    public function render()
    {
        $items = $this->items->toArray();

        // return $this->mapTree($items);
        return $this->buildTree($items);
    }

    /**
     * Single-pass Tree Mapping from flat array
     *
     * @param      array  $dataset  The dataset
     *
     * @return     array  Nested Tree structure
     */
    public function mapTree(array $dataset)
    {
        $map = [];
        $tree = [];

        foreach ($dataset as $id => &$node) {
            $current =& $map[$node['id']];

            // @TODO better way to assign this? intersect_keys(array_flip) didn't work as expected
            $current['id'] = $node['id'];
            $current['parent_id'] = $node['parent_id'];
            $current['title'] = $node['title'];
            $current['url'] = $node['url'];
            $current['new_tab'] = $node['new_tab'];
            $current['clickable'] = $node['clickable'];
            $current['icon'] = $node['icon'];

            if ($node['parent_id'] == null) {
                $tree[$node['id']] =& $current;
            } else {
                $map[$node['parent_id']]['children'][$node['id']] =& $current;
            }
        }

        // dd(array_values_recursive($tree));

        return $tree;
    }

    /**
     * Builds a menu tree recursively.
     *
     * @param      array   $items     The items
     * @param      <type>  $parent_id  The parent identifier
     *
     * @return     array   The tree.
     */
    private function buildTree(array &$items, $parent_id = null)
    {
        $tree = [];

        foreach ($items as &$node) {
            if ($node['parent_id'] === $parent_id) {
                $children = $this->buildTree($items, $node['id']);

                if ($children) {
                    $node['children'] = $children;
                } else {
                    $node['children'] = [];
                }

                $tree[] = $node;

                unset($node); // mmm doesn't actually unset
            }
        }

        return $tree;
    }
}
