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

    public function runIndex(Collection $records)
    {
        return view('ui::index', [
            'meta' => $this->meta,
            'records' => $records,
        ]);
    }

    public function runCreate()
    {
        return view('ui::create', [
            'meta' => $this->meta,
        ]);
    }

    public function runStore(Model $record)
    {
        $subnav = Event::fire('navigation.cms.sub', json_encode(['origin' => get_class($record), 'id' => $record->id] ))[0];

        return view('ui::show', [
            'meta' => $this->meta,
            'record' => $record,
            'subnav' => $subnav,
        ]);

    }

    public function runShow(Model $record)
    {
        $subnav = Event::fire('navigation.cms.sub', json_encode(['origin' => get_class($record), 'id' => $record->id] ))[0];

        return view('ui::show', [
            'meta' => $this->meta,
            'record' => $record,
            'subnav' => $subnav,
        ]);

    }

    public function runEdit(Model $record)
    {
        return view('ui::edit', [
            'meta' => $this->meta,
            'record' => $record,
        ]);
    }

    public function runUpdate(Model $record)
    {

        return view('ui::edit', ['record' => $record]);
    }

    public function runDestroy(Collection $records)
    {
        return view('ui::index', [
            'meta' => $this->meta,
            'records' => $records,
        ]);
    }

}