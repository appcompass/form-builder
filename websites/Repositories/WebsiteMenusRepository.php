<?php

namespace P3in\Repositories;

use P3in\Repositories\AbstractChildRepository;
use P3in\Interfaces\WebsiteMenusRepositoryInterface;
use P3in\Models\Menu;
use P3in\Models\Link;
use P3in\Models\Website;

class WebsiteMenusRepository extends AbstractChildRepository implements WebsiteMenusRepositoryInterface
{
    public function __construct(Menu $model, Website $parent)
    {
        $this->model = $model;

        $this->parent = $parent;

        $this->relationName = 'menus';
    }

    public function findByPrimaryKey($id)
    {
        $model = $this->make()
            ->builder
            ->where($this->model->getTable() . '.' . $this->model->getKeyName(), $id)
            ->firstOrFail();

        return [
            'id' => $model->id,
            'title' => $model->name, // @TODO rename to title for consistency
            'menu' => [
                'menu' => $model->render(),
                'deletions' => [],
                'repo' => [
                    'pages' => $this->parent->pages->each(function ($item) {
                        $item->children = [];
                        $item->type = 'Page';
                    }),
                    'links' => Link::all()->each(function ($item) {
                        $item->children = [];
                        $item->type = 'Link';
                    })
                ]
            ]
        ];

    }
}
