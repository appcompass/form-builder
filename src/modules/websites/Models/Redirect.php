<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\Website;

class Redirect extends Model
{
    public $table = 'website_redirects';

    /**
     * Mass assignable
     */
    public $fillable = ['from', 'to', 'type', 'website_id'];

    /**
     * A redirect belogns to a Website
     */
    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    /**
     *
     */
    public static $rules = [
        'from' => 'required',
        'to' => 'required',
        'type' => 'required'
    ];

    /**
     *
     */
    public static function addRedirect(Website $website, $from, $to, $type)
    {
        $redirect = new self([
            'from' => $from,
            'to' => $to,
            'type' => $type
        ]);

        $redirect->website()->associate($website);

        return $redirect->save();
    }

    /**
     *  Render a single redirect
     */
    public function render($base_url)
    {
        return "rewrite ^{$this->from}$ \$scheme://{$base_url}".$this->to. " last";
        // return "rewrite ^{$this->from}$ \$scheme://{$base_url}".trim($this->to, '/'). " last";
    }

    /**
     * Return all the redirects for a specific website
     */
    public static function forWebsite(Website $websites)
    {
        return Redirect::where('website_id', '=', $websites->id);
    }

    /**
     *  Render the redirects for a specific website
     */
    public static function renderForWebsite(Website $websites)
    {
        $acc = '';

        foreach (Redirect::forWebsite($websites)->get() as $redirect) {

            $acc .= $redirect->render($websites->site_url) . ";\n";

        }

        return $acc;
    }
}
