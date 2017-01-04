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

    // public funciton website()
    // {
    //     return $this->belongsTo(Website::class);
    // }

    /**
     * items
     *
     * @return     HasMany  [NavItem]
     */
    public function items()
    {
        return $this->hasMany(NavItem::class)->with('navigatable')->orderBy('id', 'DESC');
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

        } else if ($item instanceof NavItem) {

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

        return $this->mapTree($items);

        // return $this->fastMapTree($this->items->toArray());
    }

    function mapTree($dataset) {

        $refs = [];
        $tree = [];

        foreach($dataset as $id => &$node) {

            $thisref =& $refs[$node['id']];

            $thisref['parent_id'] = $node['parent_id'];

            $thisref['label'] = $node['label'];

            $thisref['url'] = $node['url'];

            $thisref['label'] = $node['label'];

            $thisref['new_tab'] = $node['new_tab'];

            if ($node['parent_id'] == null) {

                $tree[$node['id']] =& $thisref;

            } else {

                $refs[$node['parent_id']]['children'][$node['id']] =& $thisref;

            }
        }

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

            // $this->counter++;

            if ($node['parent_id'] === $parent_id) {

                $children = $this->buildTree($items, $node['id']);

                if ($children) {

                    $node['children'] = $children;

                }

                $tree[] = $node;

                unset($node); // mmm doesn't actually unset

            }

        }

        return $tree;

    }

}
