<?php

namespace P3in\Traits;

use Illuminate\Support\Facades\Cache;
use P3in\Profiles\Profile;

trait HasProfileTrait
{

    public $profiles = [];
    public function __construct()
    {
        // we do this because profiles are loaded once on module install,
        // and we don't want to keep querying for the profiles on every request to
        // any class that uses the HasProfileTrait.
        $this->profiles = Cache::rememberForever('profile_types', function() {
            return Profile::get();
        });
    }

    public function __call($name, $args)
    {
        if ($profile = $this->profiles->where('name', $name)->first()) {
            return $this->hasOne($profile->class_name);
        }else{
            return parent::__call($name, $args);
        }
    }

    public function __get($name)
    {
        if ($profile = $this->profiles->where('name', $name)->first()) {
            return $this->getRelationshipFromMethod($profile->class_name);
        }else{
            return parent::__get($name);
        }
    }

}
