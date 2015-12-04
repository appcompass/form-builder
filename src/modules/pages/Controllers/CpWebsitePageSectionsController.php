<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Auth;
use BostonPads\Models\Photo;
use DB;
use Illuminate\Http\Request;
use P3in\Controllers\UiBaseController;
use P3in\Models\Page;
use P3in\Models\PageSection;
use P3in\Models\Section;
use P3in\Models\Website;
use Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CpWebsitePageSectionsController extends UiBaseController
{
    public $meta_install = [
        'edit' => [
            'data_targets' => [
                [
                    'route' => 'websites.pages.show',
                    'target' => '#main-content-out',
                ],[
                    'route' => 'websites.pages.section.edit',
                    'target' => '#content-edit',
                ],
            ],
        ],
    ];

    public function __construct()
    {

        $this->middleware('auth');

        $this->controller_class = __CLASS__;
        $this->module_name = 'pages';

        $this->setControllerDefaults();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $website_id, $page_id)
    {
        $website = Website::findOrFail($website_id);

        $page = $website->pages()->findOrFail($page_id);

        if ($request->has('reorder')) {

            foreach($request->reorder as $order => $item_id) {

                DB::table('page_section')->where('id', $item_id)
                    ->update(['order' => $order]);

            }

            return redirect()->action('\P3in\Controllers\CpWebsitePagesController@show', [$page->website->id, $page->id]);

        }

        $order = intVal( DB::table('page_section')
            ->where('page_id', '=', $page_id)
            ->max('order') ) + 1;

        $section = Section::findOrFail($request->section_id);

        if ($section->fits !== $request->layout_part) {

            return $this->json([], false, 'Unable to complete the request, section has been dragged in the wrong spot.');

        }

        $page->sections()
            ->attach($section, [
                'order' => $order,
                'section' => $section->fits,
                'type' => null
            ]);

        return redirect()->action('\P3in\Controllers\CpWebsitePagesController@show', [$page->website->id, $page->id]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($website_id, $page_id, $section_id)
    {
        $page = Page::findOrFail($page_id)->load('sections.photos');

        $section = $page->sections()
            ->where('page_section.id', $section_id)
            ->firstOrFail();

        $photos = $section->photos;

        $edit_view = 'sections/'.$section->edit_view;

        $this->setBaseUrl(['websites', $website_id, 'pages', $page_id, 'section', $section->pivot->id]);

        $meta = $this->meta;

        $record = json_decode($section->pivot->content);

        return view($edit_view, compact('meta', 'section', 'page', 'photos', 'record'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $website_id, $page_id, $section_id)
    {
        $section = PageSection::findOrFail($section_id);

        $content = $request->except(['_token', '_method']);

        $existing_content = json_decode($section->content, true);

        foreach($request->file() as $field_name => $file) {

            if ($file instanceof UploadedFile) {

                $photo = $section->addPhoto($file, Auth::user());

                $content[$field_name] = $photo->path;

            }

            else if (is_array($file)) {

                foreach($file as $idx => $single_file) {

                    if (is_null($single_file['image'])) {

                        // if not passed the image field comes back null, we don't want that
                        $content[$field_name][$idx]['image'] = $existing_content[$field_name][$idx]['image'];

                        continue;

                    }

                    $photo = $section->addPhoto($single_file['image'], Auth::user());

                    $content[$field_name][$idx]['image'] = $photo->path;
                }
            }
        }

        $content = array_replace($existing_content, $content);

        $result = DB::table('page_section')->where('id', $section_id)
            ->update(['content' => json_encode($content)]);

        return $this->json($this->setBaseUrl(['websites', $website_id, 'pages', $page_id, 'section', $section_id, 'edit']));
    }

    /**
     * @return P3in\Models\Photo
     */
    public function makePhoto(UploadedFile $file, PageSection $section)
    {
        return Photo::store($file, Auth::user(), [
            'status' => Photo::STATUSES_ACTIVE
        ]);


        $content[$field_name][$idx]['image'] = $photo->id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $website_id, $page_id, $section_id) {

        $page = Page::findOrFail($page_id);

        DB::table('page_section')
            ->where('id', $section_id)
            ->delete();

        return redirect()->action('\P3in\Controllers\CpWebsitePagesController@show', [$page->website->id, $page->id]);
    }

}
