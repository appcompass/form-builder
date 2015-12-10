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
                    'route' => 'websites.show',
                    'target' => '#main-content-out',
                ],[
                    'route' => 'websites.pages.show',
                    'target' => '#record-detail',
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

        if ($request->has('add')) {

            $section = Section::findOrFail($request->section_id);

            if ($section->fits !== $request->layout_part) {

                return $this->json([], false, 'Unable to complete the request, section has been dragged in the wrong spot.');

            }

            $order = intVal( DB::table('page_section')
                ->where('page_id', '=', $page_id)
                ->max('order') ) + 1;

            $this->record = new PageSection([
                'section' => $section->fits,
                'type' => null,
                'order' => $order,
                'type' => null,
                'content' => json_encode([])
            ]);

            $this->record->page()->associate($page);

            $this->record->template()->associate($section);

            $this->record->save();
        }

        if ($request->has('reorder')) {

            $sections = $this->getBase($website_id, $page_id)->get();

            $this->sort($sections, $request->reorder);

        }

        return $this->json($this->setBaseUrl(['websites', $website_id, 'pages', $page_id, 'section', $section->id, 'edit']));

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
        $website = Website::findOrFail($website_id);

        $page = $website->pages()
            ->findOrFail($page_id)
            ->load('sections.photos');

        $section = PageSection::findOrFail($section_id);

        $photos = $section->photos;

        $edit_view = 'sections/'.$section->template->edit_view;

        $this->setBaseUrl(['websites', $website_id, 'pages', $page_id, 'section', $section->id]);

        $meta = $this->meta;

        $record = json_decode($section->content);

        return view($edit_view, compact('meta', 'website', 'section', 'page', 'photos', 'record'));
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

        return $this->json($this->setBaseUrl(['websites', $website_id, 'pages', $page_id, 'section', $section_id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $website_id, $page_id, $section_id)
    {
        $this->record = $this->getBase($website_id, $page_id)->findOrFail($section_id);

        $this->record->delete();

        return $this->json($this->setBaseUrl(['websites', $website_id, 'pages', $page_id]));
    }

    /**
     *
     */
    private function getBase($website_id, $page_id)
    {
        return PageSection::whereHas('page',function($pq) use ($website_id, $page_id) {
            $pq->where('id', $page_id)->whereHas('website', function($sq) use ($website_id) {
                $sq->where('id', $website_id);
            });
        });
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

}
