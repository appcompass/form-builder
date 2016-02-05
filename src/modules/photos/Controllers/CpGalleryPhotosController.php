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
                    'route' => 'galleries.show',
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
    public function index(Gallery $galleries)
    {

        $galleries->load('photos.galleryItem', 'photos.user');

        $photos = $galleries->photos
            ->each(function($photo) {
                $photo->type = $photo->getOption(Photo::TYPE_ATTRIBUTE_NAME, 'label');
                $photo->item_id = $photo->galleryItem->id;
            });

        return view('photos::galleries.index', compact('photos', 'options'))
            ->with('gallery', $galleries)
            ->with('meta', $this->meta)
            ->with('options', Option::byLabel(Photo::TYPE_ATTRIBUTE_NAME)->content);
    }

    /**
     *
     */
    public function create(Gallery $galleries)
    {
        return $this->build('create', ['galleries', $galleries->id, 'photos']);
    }

    /**
     *  Store
     */
    public function store(Request $request, Gallery $galleries)
    {

        $galleries->load('items', 'photos.user');

        if ($request->has('reorder')) {

            $this->sort($galleries->items, $request->reorder);

        }

        if ($request->has('bulk')) {

            $items = Photo::whereIn('id', $request->ids)->get();

            $this->bulk($items, $request->bulk, $request->has('attributes') ? $request->get('attributes') : []);

            // we add this only when there is a bulk update for now till we sort out how to avoid it, if possible.
            $gallery = Gallery::findOrFail($galleries->id)->load('items', 'photos.user');

        }

        if ($request->hasFile('file')) {

            $atributes = [];

            if (get_class($galleries->galleryable) === Website::class) {

                $website = $galleries->galleryable;

                $disk = $website->getDiskInstance();

                $attributes['storage'] = $website->site_url;

            } else {

                $disk = Storage::disk(config('app.default_storage'));

            }

            $galleries->addPhoto(Photo::store($request->file, Auth::user(), $attributes, $disk, 'images/'));

        }

        return view('photos::photo-grid')
            ->with('photos', $galleries->photos)
            ->with('gallery', $galleries);

    }
}
