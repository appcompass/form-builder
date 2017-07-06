<?php

namespace P3in\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use P3in\Builders\PageBuilder;
use P3in\Interfaces\WebsitePagesRepositoryInterface;
use P3in\Models\Link;
use P3in\Models\Page;
use P3in\Models\PageSectionContent;
use P3in\Models\Photo;
use P3in\Models\Section;
use P3in\Models\Website;
use P3in\Requests\FormRequest;

class WebsitePagesController extends AbstractChildController
{
    public function __construct(WebsitePagesRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * show
     *
     * @param      <type>  $parent  The parent
     * @param      <type>  $model   The model
     *
     * @return     array   ( description_of_the_return_value )
     */
    public function show(FormRequest $request, Model $parent, Model $model)
    {
        // dd($model->);
        // dd($model->buildContentTree());
        $this->repo->raw_data = true;
        return $this->repo->output([
            'page' => $model->toArray(),
            'layout' => $model->buildContentTree(true)
        ]);
        // return [
        //     'page' => $model->toArray(),
        //     'data' => $model->buildContentTree(true)
        // ];
    }

    public function update(FormRequest $request, Model $parent, Model $model)
    {
        PageBuilder::update($model, $request->all());

        return ['message' => 'Page updated.'];
    }

    // @TODO: these should live in their own controllers
    // using a repo that manages Section model interface.
    public function containers(FormRequest $request, Model $parent, Model $model)
    {
        return response()->json([
            'collection' => $this->getSections($parent, true)
        ]);
    }

    public function sections(FormRequest $request, Model $parent, Model $model)
    {
        return response()->json([
            'collection' => $this->getSections($parent)
        ]);
    }

    private function getSections(Model $parent, $containers = false)
    {
        $sections = Section::where('type', $containers ? '=' : '!=', 'container')->where(function ($query) use ($parent) {
            $query->whereNull('website_id')
                    ->orWhere('website_id', $parent->id);
        })->with('form')->get();
        $rtn = [];
        foreach ($sections as $section) {
            $pageSectionContent = new PageSectionContent(['content' => '{}']);
            $rtn[] = $pageSectionContent->section()->associate($section);
        }

        return $rtn;
    }

    // @TODO: these should live in their own controllers too.
    public function pageLinks(FormRequest $request, Model $parent, Model $model)
    {
        return response()->json([
            'collection' => $parent->pages
        ]);
    }
    public function externalLinks(FormRequest $request, Model $parent, Model $model)
    {
        // @TODO: $parent->links instead of Link::get()
        return response()->json([
            'collection' => Link::get()
        ]);
    }

    public function uploadMedia(FormRequest $request, Website $website, Page $page)
    {
    // @TODO: used for handling file uploads, move this to field specific handling and right now we only check for two file types, images and videos.
    $this->validate($request, [
        'video' => 'mimetypes:video/x-msvideo,video/mpeg,video/ogv,video/webm,video/3pg,video/3g2',
        // @TODO: change to image.
        'file' => 'mimetypes:image/gif,image/jpeg,image/png,image/svg+xml,image/tiff,image/webp',
    ]);
    $diskName = $website->storage->name;

    // done to set the disk instance config info that is unsed internally in the laravel storage workflow.
    $disk = $website->getDisk();
    // if ($request->hasFile('video')) {
    //     Video
    //     $website->gallery->videos()->save($video);
    // }
    if ($request->hasFile('file')) {
        $name = date('y-m').'/'.strtolower($request->file->getClientOriginalName());
        $path = $request->file->storeAs('images', $name, $diskName);

        $photo = Photo::firstOrNew([
            'path' => $path
        ]);

        $photo->meta = ['url' => $disk->url($path)];

        $photo->user()->associate($request->user());
        $website->gallery->photos()->save($photo);

        return $this->repo->output([
            'image_url' => $photo->url,
        ]);
    }
    return false;
    }
}
