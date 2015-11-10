<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Auth;
use Event;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use P3in\Controllers\ModularBaseController;
use P3in\Models\Navmenu;

class UiBaseController extends ModularBaseController {

    public $records;
    public $record;

    public function build($type)
    {
        $method = 'view'.$type;

        return call_user_func([$this, $method]);
    }

    private function viewIndex()
    {
        return view('ui::index', [
            'meta' => $this->meta,
            'records' => $this->records,
        ]);
    }

    private function viewCreate()
    {
        return view('ui::create', [
            'meta' => $this->meta,
        ]);
    }

    private function viewShow()
    {
        return view('ui::show', [
            'meta' => $this->meta,
            'record' => $this->record,
            'nav' => $this->getCpSubNav(),
            'left_panels' => $this->getLeftPanels(),
        ]);

    }

    private function viewEdit()
    {
        return view('ui::edit', [
            'meta' => $this->meta,
            'record' => $this->record,
        ]);
    }

    // public function processRequest(Request $request, $lib = [])
    // {
    //     if ($request->reorder) {

    //         foreach ($request->reorder as $i => $item_id) {

    //             $itemObj = $lib['model']::findOrFail($item_id);

    //             foreach ($lib['reorder']['chain'] as $method) {
    //                 $itemObj = $itemObj->$method();
    //             }

    //             $itemObj->update([$lib['reorder']['field'] => $i]);

    //         }

    //     }elseif($request->bulk){

    //         if (!empty($request->ids)) {

    //             switch ($request->bulk) {
    //                 case 'update':

    //                     foreach ($request->ids as $item_id) {

    //                         $itemObj = $lib['model']::findOrFail($item_id);

    //                         if (isset($request->options)) {

    //                             foreach ($request->options as $option_name => $option_value) {

    //                                 if ($option_value) {

    //                                     $itemObj->setOption($option_name, $option_value);

    //                                 }


    //                             }

    //                         }

    //                         if (!empty($request->attributes)) {
    //                            $itemObj->update((array) $request->attributes);
    //                         }

    //                     }

    //                 break;
    //                 case 'delete':

    //                     $lib['model']::destroy($request->ids);

    //                 break;
    //             }
    //         }
    //     }else{
    //         return false;
    //     }
    //     return true;
    // }

    /**
     *
     */
    public function getCpSubNav($id = null)
    {

        if (!is_null($id)) {

            // dd($id);

        }

        $navmenu_name = 'cp_'.$this->module_name.'_subnav';

        $navmenu = Navmenu::byName($navmenu_name);

        return $navmenu;

    }

    /**
     *
     */
    public function getLeftPanels() {}

}