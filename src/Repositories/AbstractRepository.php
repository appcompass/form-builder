<?php

namespace P3in\Repositories;

use P3in\Interfaces\AbstractRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Auth;

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

    // model's default list view
    protected $view = 'Table';

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

        }

        foreach((array) $search as $column => $string) {

            $this->builder->where($column, 'like', "%{$string}%");

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
            $sorters = json_decode(request()->sorters, true);
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
    public function create($request)
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
        return $this->make()
            ->builder
            ->where($this->model->getTable() . '.' . $this->model->getKeyName(), $id)
            ->firstOrFail();
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

            return;

        }

        // for show() if a model has been set we only wanna load rels
        if ($this->model->id) {

            return $this->model;

        }

        if (request()->has('page')) {

            return $this->paginate(request()->per_page, request()->page);

        } else {

            return $this->paginate();

        }
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

        return [
            'data' => $data,
            'view' => $this->view
        ];
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
        $storage = head(array_where($attributes, function($val, $key){
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
}
