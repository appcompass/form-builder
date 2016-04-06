<?php

namespace P3in\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use P3in\Controllers\UiBaseController;
use P3in\Models\Gallery;
use P3in\Models\GalleryItem;
use P3in\Models\Video;
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
        $this->nav_name = 'cp_gallery_videos_subnav';

        $this->setControllerDefaults();
    }
    /**
     *
     */
    public function index(Gallery $galleries)
    {

        // $galleries = Video::whereIn('id', $galleries->videos->lists('itemable_id'))->get()

        $galleries->load('videos', 'videos.itemable.user');

        if (empty($this->meta->base_url)) {
            $this->setBaseUrl(['galleries', $galleries->id, 'videos']);
        }

        return view('videos::galleries.index')
            // ->with('videos', $videos)
            ->with('videos', $galleries->videos)
            ->with('gallery', $galleries)
            ->with('meta', $this->meta);
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

            $items = Video::whereIn('id', $request->ids)->get();

            $this->bulk($items, $request->bulk, $request->has('attributes') ? $request->get('attributes') : []);
        }

        if ($request->hasFile('file')) {
            $video = Video::store($request->file, Auth::user());
            $galleries->addVideo($video);

            if (!empty($this->keep_gallery_polymorphic) && !is_null($galleries->galleryable)) {
                $galleries->galleryable->videos()->save($video);
            }

        }

        // we add this only when there is a bulk update for now till we sort out how to avoid it, if possible.
        $galleries = Gallery::findOrFail($galleries->id)->load('items', 'videos.user');

        return view('videos::video-grid')
            ->with('videos', $galleries->videos)
            ->with('gallery', $galleries);

    }
}
