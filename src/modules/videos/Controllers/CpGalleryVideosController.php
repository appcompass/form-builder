<?php

namespace P3in\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use P3in\Controllers\UiBaseController;
use P3in\Models\Gallery;
use P3in\Models\GalleryItem;
use P3in\Models\Option;
use P3in\Models\Photo;
use P3in\Models\Website;

class CpGalleryVideosController extends UiBaseController
{


    public $meta_install = [
        'index' => [
            'data_targets' => [
                [
                    'route' => 'galleries.show',
                    'target' => '#main-content-out',
                ],[
                    'route' => 'galleries.videos.index',
                    'target' => '#record-detail',
                ],
            ],
        ],
        'show' => [
            'data_targets' => [
                [
                    'route' => 'galleries.videos.show',
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
                    'route' => 'galleries.videos.show',
                    'target' => '#main-content-out',
                ],[
                    'route' => 'galleries.videos.edit',
                    'target' => '#record-detail',
                ],
            ],
            'heading' => 'Gallery Information',
            'route' => 'galleries.videos.update'
        ],
        'create' => [
            'data_targets' => [
                [
                    'route' => 'galleries.videos.create',
                    'target' => '#main-content-out',
                ],
            ],
            'heading' => 'Add a page to this website',
            'route' => 'galleries.videos.store'
        ],
        'form' => [],
    ];

    public function __construct()
    {
        $this->middleware('auth');

        $this->controller_class = __CLASS__;
        $this->module_name = 'videos';

        $this->setControllerDefaults();
    }
    /**
     *
     */
    public function index(Gallery $galleries)
    {

        $galleries->load('videos.galleryItem', 'videos.user');

        if (empty($this->meta->base_url)) {
            $this->setBaseUrl(['galleries', $galleries->id, 'videos']);
        }

        $videos = $galleries->videos
            ->each(function($photo) {
                $photo->type = $photo->getOption(Photo::TYPE_ATTRIBUTE_NAME, 'label');
                $photo->item_id = $photo->galleryItem->id;
            });

        return view('videos::galleries.index', compact('videos', 'options'))
            ->with('gallery', $galleries)
            ->with('meta', $this->meta)
            ->with('options', Option::byLabel(Photo::TYPE_ATTRIBUTE_NAME)->content);
    }

    /**
     *
     */
    public function create(Gallery $galleries)
    {
        return $this->build('create', ['galleries', $galleries->id, 'videos']);
    }

    /**
     *  Store
     */
    public function store(Request $request, Gallery $galleries)
    {

        $galleries->load('items', 'videos.user');

        if ($request->has('reorder')) {

            $this->sort($galleries->items, $request->reorder);

        }

        if ($request->has('bulk')) {

            $items = Photo::whereIn('id', $request->ids)->get();

            $this->bulk($items, $request->bulk, $request->has('attributes') ? $request->get('attributes') : []);

            // we add this only when there is a bulk update for now till we sort out how to avoid it, if possible.
            $gallery = Gallery::findOrFail($galleries->id)->load('items', 'videos.user');

        }

        if ($request->hasFile('file')) {

            $attributes = ['file_path' => 'videos/'];

            if (get_class($galleries->galleryable) === Website::class) {

                $website = $galleries->galleryable;

                $disk = $website->getDiskInstance();

                $attributes['storage'] = $website->site_url;

            } else {

                $disk = Storage::disk(config('app.default_storage'));

            }

            if (!empty($this->photo_root)) {
                $attributes['file_path'] = $this->photo_root;
            }

            $photo = Photo::store($request->file, Auth::user(), $attributes, $disk);

            $galleries->addPhoto($photo);

            if (!empty($this->keep_gallery_polymorphic) && !is_null($galleries->galleryable)) {
                $galleries->galleryable->videos()->save($photo);
            }

        }

        return view('videos::photo-grid')
            ->with('videos', $galleries->videos)
            ->with('gallery', $galleries);

    }
}
