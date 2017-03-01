<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use P3in\Controllers\UiBaseController;
use P3in\Models\Page;
use P3in\Models\PageSection;
use P3in\Models\Photo;
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

    public function __construct(Photo $photo)
    {
        $this->photo = $photo;

        $this->middleware('auth');

        $this->controller_class = __CLASS__;
        $this->nav_name = 'cp_pages_subnav';

        $this->setControllerDefaults();

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(websites $websites, $page_id) {}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(websites $websites, $page_id) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Website $websites, $page_id)
    {
        $page = Page::ofWebsite($websites)->findOrFail($page_id);

        if ($request->has('add')) {

            $section = Section::findOrFail($request->section_id);

            if ($section->fits !== $request->layout_part) {

                return $this->json([], false, 'Unable to complete the request, section has been dragged in the wrong spot.');

            }

            $this->record = new PageSection([
                'section' => $section->fits,
                'type' => null,
                'order' => null,
                'type' => null,
                'content' => []
            ]);

            $this->record->page()->associate($page);

            $this->record->template()->associate($section);

            $this->record->save();

            $redirect = $this->setBaseUrl(['websites', $websites->id, 'pages', $page_id]);

        }

        if ($request->has('reorder')) {

            $sections = $page->content()->get();
            $this->sort($sections, $request->reorder);

            $redirect = $request->redirect;

        }

        if (!$redirect) {
            return $this->json([], false, 'Unable to complete the request, looks like your sending bogus data!');
        }

        return $this->json($redirect);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Website $websites, $page_id, $section_id) {}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Website $websites, $page_id, $section_id)
    {

        $page = Page::ofWebsite($websites)
            ->findOrFail($page_id)
            ->load('sections.photos');

        $section = $page->content()
            ->findOrFail($section_id);

        $edit_view = 'sections/'.$section->template->edit_view;

        $this->setBaseUrl(['websites', $websites->id, 'pages', $page_id, 'section', $section_id]);

        $this->meta->heading = 'Edit the '.$websites->site_name.' '.$page->title.' page '.$section->template->name.' section';

        return view($edit_view, [
            'meta' => $this->meta,
            'website' => $websites,
            'section' => $section,
            'page' => $page,
            'photos' => $section->photos,
            'record' => $section->content,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Website $websites, $page_id, $section_id)
    {

        $page = Page::ofWebsite($websites)
            ->findOrFail($page_id);

        $section = $page->content()->findOrFail($section_id);

        $content = $request->except(['_token', '_method']);

        $existing_content = json_decode(json_encode($section->content), true);

        if (isset($content['_selected_image'])) {

            $photo = Photo::findOrFail($content['_selected_image']);

            $section->photos()->save($photo);

            $content['image'] = $photo->path;

        }

        // @TODO move this in a separate method. all it does is handling files scenarios
        foreach($request->file() as $field_name => $file) {

            if ($file instanceof UploadedFile && $file->getSize()) {

                $photo = $section->addPhoto($file, Auth::user());

                $content[$field_name] = $photo->path;

            } elseif (is_array($file)) {
                foreach($file as $idx => $single_file) {

                    if (empty($single_file['image'])) {

                        $selected_field_name = '_selected_'.$field_name;

                        // check if the user has selected an image
                        if (isset($content[$selected_field_name]) AND isset($content[$selected_field_name][$idx])) {

                            $photo = Photo::findOrFail($content['_selected_'.$field_name][$idx]['image']);

                            $section->photos()->save($photo);

                            $content[$field_name][$idx]['image'] = $photo->path;

                        } else {

                            // if not passed the image field comes back null, we don't want that
                            $content[$field_name][$idx]['image'] = $existing_content[$field_name][$idx]['image'];

                        }

                        continue;

                    }else{

                        $photo = $section->addPhoto($single_file['image'], Auth::user());

                        if (isset($content[$field_name]) && isset($content[$field_name][$idx])) {
                            $content[$field_name][$idx]['image'] = $photo->path;
                        }
                    }
                }
            }
        }

        // There should be no instances of UploadedFile in the content array at this point.
        foreach ($content as $k => $v) {
           if ($v instanceof UploadedFile) {
                unset($content[$k]);
           }
        }

        $section->content = array_replace($existing_content, $content);

        $section->save();

        return $this->json($this->setBaseUrl(['websites', $websites->id, 'pages', $page_id, 'section', $section_id, 'edit']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Website $websites, $page_id, $section_id)
    {

        $page = Page::ofWebsite($websites)
            ->findOrFail($page_id);

        $section = $page->content()->findOrFail($section_id);

        $section->delete();

        return $this->json($this->setBaseUrl(['websites', $websites->id, 'pages', $page_id]));
    }

    /**
     *
     */
    private function getBase($website_id, $page_id)
    {
        return PageSection::whereHas('page',function($pq) use ($website_id, $page_id) {
            $pq->where('id', $page_id)
            ->whereHas('website', function($sq) use ($website_id) {
                $sq->where('id', $website_id);
            });
        });
    }

}
