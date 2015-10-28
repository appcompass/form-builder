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

class UiBaseController extends ModularBaseController {

    // public function __construct()
    // {
    // }

    public function build()
    {
        $args = func_get_args();

        if (empty($args[0])) {
            throw new Exception('First Param is required.');
        }

        $method = 'run'.ucwords($args[0]); unset($args[0]);

        return empty($args) ? call_user_func([$this, $method]) : call_user_func_array([$this,$method], $args);
    }

    private function runIndex()
    {
        $records = func_get_arg(0);

        return view('ui::index', [
            'meta' => $this->meta,
            'records' => $records,
        ]);
    }

    private function runCreate()
    {
        return view('ui::create', [
            'meta' => $this->meta,
        ]);
    }

    private function runStore()
    {
        $record = func_get_arg(0);

        $subnav = Event::fire('navigation.cms.sub', json_encode(['origin' => get_class($record), 'id' => $record->id] ))[0];

        return view('ui::show', [
            'meta' => $this->meta,
            'record' => $record,
            'subnav' => $subnav,
        ]);

    }

    private function runShow()
    {
        $record = func_get_arg(0);

        $subnav = Event::fire('navigation.cms.sub', json_encode(['origin' => get_class($record), 'id' => $record->id] ))[0];

        return view('ui::show', [
            'meta' => $this->meta,
            'record' => $record,
            'subnav' => $subnav,
        ]);

    }

    private function runEdit()
    {
        $record = func_get_arg(0);
        return view('ui::edit', [
            'meta' => $this->meta,
            'record' => $record,
        ]);
    }

    private function runUpdate()
    {
        $record = func_get_arg(0);

        return view('ui::edit', [
            'meta' => $this->meta,
            'record' => $record,
        ]);
    }

    private function runDestroy()
    {
        $records = func_get_arg(0);

        return view('ui::index', [
            'meta' => $this->meta,
            'records' => $records,
        ]);
    }

}