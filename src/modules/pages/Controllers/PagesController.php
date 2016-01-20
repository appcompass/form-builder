<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Factory;
use P3in\Models\Page;
use P3in\Models\Section;
use P3in\Models\Website;
use Mail;

class PagesController extends Controller
{

    public function renderPage(Request $request, $url = '')
    {
        $page = Page::byUrl($url)->ofWebsite()->firstOrFail();

        $data = $page->render();

        return view('layouts.master.'.str_replace(':', '_', $page->layout), $data);

    }

    public function submitForm(Request $request)
    {

        $website = Website::current();

        $from = $website->config->from_email ?: 'info@bostonpads.com';

        $to = $request->get('to') ?: $website->config->default_recipients;

        $data = $request->except(['_token', 'to', 'heading', 'subheading', 'text', 'style', 'form_name', 'file']);

        Mail::send('mail.form-submission', ['website' => $website, 'data' => $data, 'name' => $request->get('form_name')], function($message) use($from, $to, $request, $website) {
            $message->from($from)
                ->to($to)
                ->subject('Form: '.$website->site_name);

                foreach($request->file() as $field_name => $file) {

                    $message->attach($file->getRealPath(), [
                        'as' => $file->getClientOriginalName(),
                        'mime' => $file->getMimeType()
                    ]);

                }

            });

    }
}
