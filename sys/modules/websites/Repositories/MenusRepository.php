<?php

namespace P3in\Repositories;

use P3in\Interfaces\MenusRepositoryInterface;
use P3in\Models\Menu;

class MenusRepository extends AbstractRepository implements MenusRepositoryInterface
{

    public $with = ['items'];

    public function __construct(Menu $model)
    {
        $this->model = $model;
    }

}