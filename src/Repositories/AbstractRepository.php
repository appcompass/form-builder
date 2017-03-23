<?php

namespace P3in\Repositories;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Route;
use P3in\Interfaces\AbstractRepositoryInterface;
use P3in\Models\Form;
use P3in\Models\Resource;

abstract class AbstractRepository implements AbstractRepositoryInterface
{

    // @TODO PHP 7.1 allows for public/private constants. consider
    // logged user only can see owned items
    const SEE_OWNED = 0;

    // looged user sees any, edits owned
    const EDIT_OWNED = 0;

    // key on the model representing relation
    // @TODO explore dot.separation (maybe after loading relations)
    protected $owned_key = 'user_id';

    // repo locks if use doesn't have permissions
    private $locked = false;

    // always null in normal context, populated in child context.
    // @TODO: feels off setting this here, but the current alternative is more code.
    protected $owned = null;

    // Builder
    protected $builder;

    // Model
    protected $model;

     // Link parent/children
    protected $with = [];

    // @TODO it works well and it's simple but not enough. maybe.
    // list of items that must be defined when persising the repo
    // ['user' => ['from' => 'id', 'to' => 'user_id']]
    protected $requires = [
        'methods' => [],
        'props' => []
    ];

    // // model's default list view
    // protected $view = 'Table';
    // view types: ['Table','Card','Map', 'Chart', 'etc'] and what ever other types a module in the future may need.
    // @TODO: consider moving additional ones into the models rather than repositories.
    // i.e. make use of HasCardView trait for Card layouts, and other traits for other layout types.
    protected $view_types = ['Table'];
    // create types: 'Page' - 'Add New' button that leads to new create view,
    // 'Inline' - instead of taking the user to a page, it renders the form inline
    // where normally the Add New button would be for Page types.
    protected $create_type = 'Page';
    //update types: 'Page' - normal full page behavior, 'Modal' - modal edit view, like for a photo when clicked on a grid.
    protected $update_type = 'Page';

    /**
     * { function_description }
     */
    protected function make()
    {
        if (! $this->builder) {

            $this->builder = $this->getBuilder();

        }

        // @TODO consider how to work with relations, it could happen the Model doesn't have a user_id directly (we prob should avoid that to keep it simpler)
        // SEE_OWNED has the highest priority
        if (static::SEE_OWNED) {

            if (!Auth::check()) {

                $this->locked = true;

            }

            if (!Auth::user()->isAdmin()) {


                $this->builder->where($this->owned_key, \Auth::user()->id);

            }

        }

        $this->loadRelations();

        $this->sort();

        $this->search();

        return $this;
    }

    /**
     * Gets the builder.
     *
     * @return     <type>  The builder.
     */
    public function getBuilder()
    {
        if (!$this->builder) {

            $this->builder = $this->model->newQuery();

        }

        return $this->builder;
    }

    /**
     * Loads relations.
     */
    private function loadRelations()
    {
        $with = [];

        foreach($this->with as $relation) {

            $this->builder->with($relation);

        }

        return $this;
    }

    /**
     *
     */
    public function fromModel(Model $model)
    {
        $this->builder = $model->newQuery();

        $this->setModel($model);

        $this->loadRelations();

        return $this;
    }

    /**
     * Sets the model.
     *
     * @param      \Illuminate\Database\Eloquent\Model  $model  The model
     *
     * @return     <type>                               ( description_of_the_return_value )
     */
    public function setModel(Model $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Gets the model.
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Searches for the first match.
     *
     * @param      <type>  $search  The search
     */
    public function search($search = null)
    {
        if (!request()->has('search') && is_null($search)) {

            return;

        }

        if (is_null($search)) {
            // request sometimes sends empty object string '{}' instead of an
            // actual object, absolute query string values and what not.
            $search = json_decode(request()->search, true);
            if (is_string($search)) {
                $search = json_decode($search, true);
            }

        }

        foreach((array) $search as $column => $string) {

            $this->builder->where($column, 'ilike', "%{$string}%");

        }

    }

    /**
     * { function_description }
     *
     * @param      <type>  $sorters  The sorters
     */
    public function sort($sorters = null)
    {
        if (!request()->has('sorters') && is_null($sorters)) {

            return;

        }

        if (is_null($sorters)) {
            $sorters = request()->sorters;
            if (is_string($sorters)) {
                $sorters = json_decode($sorters, true);
            }
        }

        foreach((array) $sorters as $field => $order) {

            $this->builder->orderBy($field, $order);

        }
    }

    /**
     * { function_description }
     *
     * @param      <type>  $attributes  The attributes
     */
    public function store($request)
    {
        $request = $this->checkRequirements($request);

        // if there is a file in the request, lets store it.
        $this->checkForUploads($request);

        $this->model->fill($request);

        if ($this->model->save()) {

            return $this->model;

        } else {

            return false;

        }
    }

    /**
     * sort
     *
     * @param      <type>  $order  The order
     */
    public function reorder($order, $field = 'order')
    {
        // @TODO this depends on relation, delegate, refactor this into absChild
        $rel = $this->model->{$this->relationName};

        // get the whole list of stuff we're sorting
        $items = $rel->whereIn('id', $order);

        foreach($order as $single) {

            $coll[] = $items->find($single);

        }

        for ($i = 0; $i < count($coll); $i++) {

            $coll[$i]->order = $i;

            $coll[$i]->save();

        }

        return $this;

    }

    /**
     * checkRequirements
     *
     * @param      <type>      $attributes  The attributes
     *
     * @throws     \Exception  (description)
     *
     * @return     <type>      ( description_of_the_return_value )
     */
    protected function checkRequirements($request)
    {

        // @TODO make this look like code

        // so we kwow it's a request instance

        // we can fetch all the attributes and add to that
        $res = $request->all();

        // loop through the requirements, expects field[from] and field[to] to match
        // respectively from -> field in the source object, to -> what it matches against in
        // current table i.e. 'user' => ['from' => 'id', 'to' => 'user_id']
        // it's a bit verbose but appears to be very flexible
        foreach ($this->requires['props'] as $requirement => $field)
        {
            if (!property_exists($request, $requirement)) {

                throw new \Exception('Requirement not satisfied: ' . $requirement);

            }

            $res[$field['to']] = $request->{$requirement}->{$field['from']};

        }

        foreach ($this->requires['methods'] as $requirement => $field)
        {
            if (!method_exists($request, $requirement)) {

                throw new \Exception('Requirement not satisfied: ' . $requirement);

            }

            $res[$field['to']] = $request->{$requirement}()->{$field['from']};

        }

        return $res;
    }


    /**
     * { function_description }
     *
     * @param      <type>  $attributes  The attributes
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function update($attributes)
    {
        $this->model->fill($attributes);

        $this->checkForUploads($attributes);

        return $this->model->save();
    }

    /**
     * destroy model
     */
    public function destroy()
    {
        return $this->model->delete();
    }

    /**
     * { function_description }
     *
     * @param      integer  $limit  The limit
     *
     * @return     <type>   ( description_of_the_return_value )
     */
    public function limit($limit = 15)
    {
        $this->make();

        $this->builder->limit($limit);

        return $this;
    }

    /**
     *
     */
    public function findByPrimaryKey($id)
    {

        return $this->output($this->make()
            ->builder
            ->where($this->model->getTable() . '.' . $this->model->getKeyName(), $id)
            ->firstOrFail());
        // return $this->make()
        //     ->builder
        //     ->where($this->model->getTable() . '.' . $this->model->getKeyName(), $id)
        //     ->firstOrFail();
    }

    /**
     * { function_description }
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * { function_description }
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function get()
    {

        // repo locks if use doesn't have permissions
        if ($this->locked) {

            // return;
            return $this->output([], 401);

        }

        // for show() if a model has been set we only wanna load rels
        if ($this->model->id) {

            $data = $this->model;

        }

        if (request()->has('page')) {

            $data = $this->paginate(request()->per_page, request()->page);

        } else {

            $data = $this->paginate();

        }

        return $this->output($data);
    }

    /**
     * { function_description }
     *
     * @param      <type>   $page      The page
     * @param      integer  $per_page  The per page
     *
     * @return     <type>   ( description_of_the_return_value )
     */
    public function paginate($per_page = 25, $page = null)
    {
        // @TODO per_page sometimes comes through null
        if (!$per_page) {
            $per_page = 25;
        }

        // when paginating evaluate EDIT_OWNED, if true get the results and loop through them
        // attach `abilities` to the resulting data
        // abilities = [create, edit, destoy, index, show]
        $data = $this->make()->builder->paginate($per_page, ['*'], 'page', $page);

        if (static::EDIT_OWNED && !Auth::user()->isAdmin()) {

            foreach ($data as $record) {

                if (Auth::user()->id === $record[$this->owned_key]) {

                    $record['abilities'] = ['edit', 'view', 'create', 'destroy'];

                } else {

                    $record['abilities'] = ['view', 'create'];

                }

            }

        } else {

            foreach ($data as $record) {

                $record['abilities'] = ['edit', 'view', 'create', 'destroy'];

            }

        }

        return $data;

        // return [
        //     'data' => $data,
        //     'view' => $this->view
        // ];
    }

    /**
     * Check for uploads
     *
     * @param      <type>      $attributes  The attributes
     *
     * @throws     \Exception  (description)
     */
    public function checkForUploads($attributes)
    {
        $file = head(array_where($attributes, function($val){
            return is_a($val, UploadedFile::class);
        }));

        $storage = $this->model->storage ? $this->model->storage->name : head(array_where($attributes, function($val, $key){
            return $key == 'disk';
        }));

        if ($file) {
            if (!$storage) {
                throw new \Exception('Must specify a Disk instance to store uploaded file.');
            }

            info("File '{$file->getClientOriginalName()}' submitted for storage in the '{$storage}' disk.");
            // $this->model->storeFile($storage, $file, true);
            $this->model->storeFile($storage, $file, true);
        }
    }

    public function create()
    {
        // output already takes care of binding the form for the route.
        return $this->output([]);
    }

    public function output($data, $code = 200)
    {
        $route = Route::current();
        $route_name = $route->getName();
        $route_params = $route->parameters();
        $resource_form = $this->getResourceForm($route_name);
        // $route->uri()
        $rtn = [
            'route' => $route_name,
            'parameters' => $route_params,
            'api_url' => $this->getApiUrl($route_name, $resource_form),
            'breadcrumbs' => $this-getBreadcrumbs($route_name, $route_params),
            'view_types' => $this->view_types,
            'create_type' => $this->create_type,
            'update_type' => $this->update_type,
            'owned' => $this->owned,
            'abilities' => ['create', 'edit', 'destroy', 'index', 'show'], // @TODO show is per-item in the collection
            'form' => $resource_form,
            'collection' => $data,
        ];

        return response()->json($rtn, $code);
    }

    public function getApiUrl($name, $params)
    {
        $keys = explode('.', $name);
        $values = array_values(array_map(function($param){
            return $param->getKey();
        }, $params));

        $segments = [''];
        $route_type = $this->getRouteType($name);

        for ($i=0; $i < count($keys); $i++) {
            if ($keys[$i] !== $route_type) {
                $segments[] = $keys[$i];
                if (isset($values[$i])) {
                    $segments[] = $values[$i];
                }
            }
        }
        return implode('/', $segments);
    }

    // @TODO: this is actually a bit more complicated because all our routes are 2 depth max but
    // there are some chains like:  websites.pages.content.edit or in one of our client's cases
    // course.class.lesson.students.  I think we'll need to push each step into localStorage
    // so it persists and then update it on route change.  So leaving this alone for now.
    public function getBreadcrumbs($name, $form)
    {
        $rtn = [
            [
                'title' => 'Dashboard',
                'url' => '/',
            ]
        ];

        return $rtn;
    }

    public function getResourceForm($route_name)
    {
        $resource = Resource::where(function($query){
            $query->whereNull('req_role')->orWhereHas('role', function ($query) {
                $query->whereHas('users', function ($query) {
                    $query->where('id', Auth::user()->id);
                });
            });
        })
            ->where('resource',  $route_name)
            ->with('form')
            ->first();

        if (!empty($resource->form)) {
            $route_type = $this->getRouteType($route_name);

            return $resource->form->render($route_type);
        }

    }

    public function getRouteType($route)
    {
        return substr($route, strrpos($route, '.')+1);

    }
}
