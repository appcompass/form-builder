<?php

namespace P3in\Interfaces;

use P3in\Models\MenuItem;

interface Linkable
{

    public function makeMenuItem(): MenuItem;

}