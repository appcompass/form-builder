<?php

namespace P3in\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use P3in\Events\Login;
use P3in\Events\Logout;
use P3in\Models\Resource;
use P3in\Models\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CpResourcesController extends Controller
{
    public function routes(Request $request)
    {
        $cacheKey = 'routes_'.$request->website->id.'_'.(Auth::check() ? Auth::user()->id : 'guest');
        // forever? we would then need to clear this cache when updating a user permission though.
        // @TODO: fix form render so it's not running queries in loops.
        $data = Cache::remember($cacheKey, 0, function () use ($request) {
            $pages = $request->website
                ->pages()
                ->byAllowedRole()
                ->with('sections')
                ->get();

            return [
                // 'resources' => $this->getResources(),
                'routes' => $this->buildRoutesTree($pages),
            ];
        });

        return response()->json($data);
    }

    public function resources(Request $request, string $route = null)
    {
        return response()->json($this->getResources($route));
    }

    private function getResources(string $route = null)
    {
        $query = Resource::byAllowedRole();

        if ($route) {
            $query->where('resource',  $route);
        }

        $resources = $query->with('form')->get();

        $resources->each(function ($resource) {
            if ($resource->form) {
                $route = $resource->resource;
                $route_type = substr($route, strrpos($route, '.')+1);

                $resource->form = $resource->form->render($route_type);
            }
        });

        return $route ? $resources->first() : [
            'resources' => $resources,
        ];
    }

    private function setPageChildren(&$parent, $parent_id, $pages)
    {
        foreach ($pages->where('parent_id', $parent_id) as $page) {
            unset($parent['name']);
            $row = $this->structureRouteRow($page);
            $this->setPageChildren($row, $page->id, $pages);
            $parent['children'][] = $row;
        }
    }

    private function buildRoutesTree($pages)
    {
        $rtn = [];
        foreach ($pages->where('parent_id', null) as $page) {
            $row = $this->structureRouteRow($page);
            $this->setPageChildren($row, $page->id, $pages);
            $rtn[] = $row;
        }
        return $rtn;
    }

    private function structureRouteRow($page)
    {
        // we only go 2 deep (parent/child)
        $segments = array_slice(explode('/',trim($page->url, '/')), -4, 4);
        // websites/id/pages/id/content ends up with an id as the first segment, kill it.
        if (!empty($segments[0]) && strpos($segments[0], ':') === 0) {
                unset($segments[0]);
        }
        // check the resulting url segments against a api route.
        try {
            $request = app('router')->getRoutes()->match(app('request')->create(implode('/', $segments)));
            $name = $request->getName();
        } catch (NotFoundHttpException $e) {
            // fallback which is more of a way of saying "hey, create this route or delete this page"
            $name = str_slug(str_replace('/', '-', $page->url));
        }
        // cp pages are like any other, so we use the sections to define the view type
        // (handy if we ever decided to change a view type for a page).
        $section = $page->sections->first();
        $path = $this->formatPath($page);
        $component = $section ? $section->template : null;
        $row = [
            'path' => $this->formatPath($page),
            'full_path' => $page->url,
            'name' => $name ? $name : strtolower($component),
            'meta' => [
                'title' => $page->title,
            ],
            // might need to be worked out for CP, at least discussed to see if we want to go this route.
            'component' => $component,
        ];

        return $row;
    }

    private function formatPath($page)
    {
        if (!$page->parent_id) {
            return $page->url;
        }
        if ($page->dynamic_url) {
            return substr($page->url, strpos($page->url, $page->slug));
        }
        return $page->slug;
    }
}
