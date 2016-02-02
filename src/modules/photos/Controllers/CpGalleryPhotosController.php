<?php

namespace P3in\Controllers;

use Auth;
use P3in\Models\Gallery;
use P3in\Models\GalleryItem;
use P3in\Models\Photo;
use Illuminate\Http\Request;
use P3in\Controllers\UiBaseController;
use P3in\Models\Option;
use P3in\Models\Website;

class CpGalleryPhotosController extends UiBaseController
{


    public $meta_install = [
        'index' => [
            'data_targets' => [
                [
                    'route' => 'galleries.photos.show',
                    'target' => '#main-content-out',
                ],[
                    'route' => 'galleries.photos.index',
                    'target' => '#record-detail',
                ],
            ],
        ],
        'show' => [
            'data_targets' => [
                [
                    'route' => 'galleries.photos.show',
                    'target' => '#main-content-out',
                // ],[
                //     'route' => 'galleries.pages.show',
                //     'target' => '#record-detail',
                ],
            ],
            'heading' => 'Gallery Informations',
            'sub_section_name' => 'Gallery Administration',
        ],
        'edit' => [
            'data_targets' => [
                [
                    'route' => 'galleries.photos.show',
                    'target' => '#main-content-out',
                ],[
                    'route' => 'galleries.photos.edit',
                    'target' => '#record-detail',
                ],
            ],
            'heading' => 'Gallery Information',
            'route' => 'galleries.photos.update'
        ],
        'create' => [
            'data_targets' => [
                [
                    'route' => 'galleries.photos.create',
                    'target' => '#main-content-out',
                ],
            ],
            'heading' => 'Add a page to this website',
            'route' => 'galleries.photos.store'
        ],
        'form' => [],
    ];

    public function __construct()
    {
        $this->middleware('auth');

        $this->controller_class = __CLASS__;
        $this->module_name = 'photos';

        $this->setControllerDefaults();
    }
    /**
     *
     */
    public function index($gallery_id)
    {

        $gallery = Gallery::findOrFail($gallery_id)
            ->load('photos.galleryItem', 'photos.user');

        $photos = $gallery->photos
            ->each(function($photo) {
                $photo->type = $photo->getOption(Photo::TYPE_ATTRIBUTE_NAME, 'label');
                $photo->item_id = $photo->galleryItem->id;
            });

        return view('photos::galleries.index', compact('gallery', 'photos', 'options'))
            ->with('meta', $this->meta)
            ->with('options', Option::byLabel(Photo::TYPE_ATTRIBUTE_NAME)->content);
    }

    /**
     *
     */
    public function create($gallery_id)
    {
        return $this->build('create', ['galleries', $gallery_id, 'photos']);
    }

    /**
     *  Store
     */
    public function store(Request $request, $gallery_id)
    {

        $gallery = Gallery::findOrFail($gallery_id)->load('items', 'photos.user');

        if ($request->has('reorder')) {

            $this->sort($gallery->items, $request->reorder);

        }

        if ($request->has('bulk')) {

            $items = Photo::whereIn('id', $request->ids)->get();

            $this->bulk($items, $request->bulk, $request->has('attributes') ? $request->get('attributes') : []);

            // we add this only when there is a bulk update for now till we sort out how to avoid it, if possible.
            $gallery = Gallery::findOrFail($gallery_id)->load('items', 'photos.user');

        }

        if ($request->hasFile('file')) {

            $atributes = [];

            if (get_class($gallery->galleryable) === Website::class) {

                $website = $gallery->galleryable;

                $disk = $website->getDiskInstance();

                $attributes['storage'] = $website->site_url;

            } else {

                $disk = Storage::disk(config('app.default_storage'));

            }

            $gallery->addPhoto(Photo::store($request->file, Auth::user(), $attributes, $disk, 'images/'));

        }

        return view('photos::photo-grid')->with('photos', $gallery->photos)->with('gallery', $gallery);

    }

    // /**
    //  * Show
    //  *
    //  */
    // public function show($gallery_id, $photo_id)
    // {
    //     return $this->build('show', ['galleries', $gallery_id, 'photos', $photo_id]);
    // }

    // /**
    //  *
    //  */
    // public function edit($gallery_id, $photo_id)
    // {
    //     return $this->build('edit', ['galleries', $gallery_id, 'photos', $photo_id]);
    // }

    // /**
    //  *
    //  */
    // public function update(Request $request, $gallery_id, $photo_id)
    // {
    //     $record = Gallery::findOrFail($gallery_id);

    //     $record->update($request->all());

    //     return $this->build('edit', ['galleries', $gallery_id, 'photos', $photo_id]);
    // }

}
