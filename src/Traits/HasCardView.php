<?php

namespace P3in\Traits;

trait HasCardView
{


    public function __construct(array $attributes = [])
    {

        $this->append('card_photo');

        parent::__construct($attributes);
    }

    abstract public function getCardPhotoUrl();

    public function getCardPhotoAttribute()
    {
        return $this->getCardPhotoUrl();
    }

}
