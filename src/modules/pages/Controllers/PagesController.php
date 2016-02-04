<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\View\Factory;
use Mail;
use P3in\Models\Page;
use P3in\Models\Section;
use P3in\Models\Website;
use ReCaptcha\ReCaptcha;

class PagesController extends Controller
{

    public function renderPage(Request $request, $url = '')
    {
        $page = Page::byUrl($url)->ofWebsite()->firstOrFail();

        $data = $page->render();

        return view('layouts.master.'.str_replace(':', '_', $page->layout), $data);

    }

    public function renderSitemap(Request $request, $type = 'xml')
    {
        $sitemap = \App::make("sitemap");

        $sitemap->setCache('laravel.sitemap', 60);

        if (!$sitemap->isCached()) {
            $pages = Page::with('content')->ofWebsite()->get();

             foreach ($pages as $page) {
                $sitemap->add(URL::to($page->url), $page->updated_at, $page->priority, $page->update_frequency, $page->images);
             }
        }

        return $sitemap->render($type);
    }

    public function submitForm(Request $request)
    {
        $website = Website::current();

        if ($website->settings('recaptcha_secret_key')) {
            $recaptcha = new ReCaptcha($website->settings('recaptcha_secret_key'));
            $resp = $recaptcha->verify($request->get('g-recaptcha-response'), $request->getClientIp());

            if (!$resp->isSuccess()) {
                return redirect($request->get('redirect'))->with('errors', $resp->getErrorCodes());
            }
        }

        $from = $website->settings('from_email');

        if (!$from) {
            return redirect($request->get('redirect'))->with('errors', ['Error 42: Please contact the website admin.']);
        }

        $to = $request->has('form_id') ? base64_decode($request->get('form_id')) : $website->settings('to_email');
        $data = $request->except(['_token', 'form_id', 'meta', 'redirect', 'heading', 'subheading', 'text', 'style', 'form_name', 'file', 'g-recaptcha-response']);
        $meta = unserialize(base64_decode($request->get('meta')));

        $formData = [
            'website' => $website,
            'data' => $data,
            'name' => $request->get('form_name'),
            'messaging' => $meta['email_body_intro'],
        ];

        Mail::send('mail.form-submission', $formData, function($message) use($from, $to, $request, $website) {
            $message->from($from)
                ->to($to)
                ->bcc('support@p3in.com')
                ->subject('New '.$request->get('form_name').' from '.$website->site_name);

            foreach($request->file() as $field_name => $file) {

                $message->attach($file->getRealPath(), [
                    'as' => $file->getClientOriginalName(),
                    'mime' => $file->getMimeType()
                ]);

            }

        });

        return redirect($request->get('redirect'))->with('success_message', $meta['success_message']);

    }
}
