<?php

/**
 *  HasGallery
 *
 *  provides hooks to link galleries to the model without hardcoding a dependency
 *
 *  Client code must implement getGalleryName()
 */

namespace P3in\Traits;

use Auth;
use P3in\Models\Gallery;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait HasGallery
{

    /**
     * Client code provides means for storing the gallery name
     */
    abstract function getGalleryName();

    /**
     *  galleries
     *
     *  @WARNING => THIS DOESN"T WORK WITH EAGER LOADING!!!!!
     */
    public function gallery()
    {

        $rel = $this->morphOne(Gallery::class, 'galleryable');

        if (!$rel->get()->count()) {

            $this->getOrCreateGallery($this->getGalleryName());

            $this->fresh();

        }

        return $rel;
    }

    /**
     * getOrCreateGallery
     */
    public function getOrCreateGallery($name)
    {
        try {
            // return Gallery::where('name', '=', $name)->firstOrFail();
            return Gallery::where('galleryable_id', $this->{$this->primaryKey})
                ->where('galleryable_type', get_class($this))
                ->firstOrFail();

        } catch (ModelNotFoundException $e) {

            if (!\Auth::check()) {

                throw new \Exception('User must be logged in order to create a gallery.');

            }

            return Gallery::create([
                'name' => $name,
                'description' => '',
                'user_id' => \Auth::user()->id,
                'galleryable_id' => $this->{$this->primaryKey},
                'galleryable_type' => get_class($this)
            ]);

        }
    }


    /**
     * make, for whichever reason
     */
    private function make($attributes = [])
    {
        return Gallery::create($attributes);
    }
}
