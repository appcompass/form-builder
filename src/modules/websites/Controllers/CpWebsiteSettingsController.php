<?php
namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use P3in\Models\Section;
use P3in\Models\Website;

class CpWebsiteSettingsController extends UiBaseResourceController
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');

        $this->init($request, function($routes) use ($request){

            if (!empty($routes->params['websites'])) {
                $website = $routes->params['websites'];
                $settings = $website->settings;
            }else{
                throw new NotFoundHttpException;
            }
            return $settings;
        });

    }

    /**
     *
     */
    public function index(Request $request)
    {
        $this->setTemplate('ui::resourceful.edit', true);

        $this->meta->base_url = $request->path().'/'.$this->model->id;
        $this->model = $this->model->data;

        if (isset($this->model->logo) AND !$this->params['websites']->hasLogo()) {
            $this->model->logo = '';
        }
        return parent::edit($request);
    }

    /**
     *
     */
    public function store(Request $request)
    {

        $data = $request->except(['_token', '_method']);
        if ($request->hasFile('logo')) {
            $fileObj = $request->file('logo');

            if ($fileObj->getSize()) {
                $logo = $this->params['websites']->addLogo($fileObj);

                $data['logo'] = $logo->path;
            }
        }
        $records = $this->params['websites']->settings($data);

        if (!empty($data['color_primary']) || !empty($data['color_secondary'])) {
            try {

                $this->params['websites']->deploy();

            } catch (\RuntimeException $e) {

                \Log::error("Error while deploying $this->params['websites']->site_name: ".$e->getMessage());

                return $this->json([], false, 'Error during deployment. Please contact us.' );

            }
        }
        return $this->json('/websites/'.$this->params['websites']->id.'/settings');

    }

    /**
     *
     *
     */
    public function update(Request $request)
    {
        return $this->store($request);
    }

    public function destroy(Request $request)
    {
        return null;
    }

}
