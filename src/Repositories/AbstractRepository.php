<?php

namespace P3in\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use P3in\Interfaces\AbstractRepositoryInterface;

abstract class AbstractRepository implements AbstractRepositoryInterface
{
    // Builder
    protected $builder;

    // Model
    protected $model;

     // Link parent/children
    protected $with = [];

    // eager relations we wanna paginate
    protected $paginatedWith = [];

    // @TODO it works well and it's simple but not enough. maybe.
    // list of items that must be defined when persising the repo
    // ['user' => ['from' => 'id', 'to' => 'user_id'], [...]]
    protected $requires;

    /**
     * { function_description }
     */
    protected function make()
    {
        if (! $this->builder) {

            $this->builder = $this->getBuilder();

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

            if (in_array($relation, $this->paginatedWith)) {

                $this->builder->with([$relation => function($q) {

                    $q->paginate(10, ['*'], 'page', \Request::get('page'));

                }]);

            } else {

                $this->builder->with($relation);

            }

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

        // @TODO should this go here? relations are loaded when actually executing something i guess? -f
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

            $search = request()->search;

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

            $sorters = request()->sorters;

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
    // @TODO inject FormRequest
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

        // so we kwow it's a request instance

        // we can fetch all the attributes and add to that
        $res = $request->all();

        // loop through the requirements, expects field[from] and field[to] to match
        // respectively from -> field in the source object, to -> what it matches against in
        // current table i.e. 'user' => ['from' => 'id', 'to' => 'user_id']
        // it's a bit verbose but appears to be very flexible
        foreach ($this->requires as $requirement => $field)
        {
            if (!property_exists($request, $requirement)) {

                throw new \Exception('Requirement not satisfied: ' . $requirement);

            }

            $res[$field['to']] = $request->{$requirement}->{$field['from']};

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

        return [
            'data' => $this->make()->builder->paginate($per_page, ['*'], 'page', $page)
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
