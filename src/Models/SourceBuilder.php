<?php

namespace AppCompass\FormBuilder\Models;

use Illuminate\Database\Eloquent\Builder;

class SourceBuilder
{
    /**
     * render
     *
     * @param      FieldSource  $field_data  The field data
     *
     * @return     array        ( description_of_the_return_value )
     */
    // @TODO: re-write this, it's a queries in loops nightmare.
    public static function render(FieldSource $field_data)
    {
        $instance = new static;

        // do we return the data stored in the fieldData (precendece)?
        if ($field_data->data) {
            return $field_data->data;

        // if both type and id are set we want a single record
        } elseif (!is_null($field_data->sourceable_id) && !is_null($field_data->sourceable_type)) {
            return $field_data->sourceable->toArray();

        // when the type is set but not the id we resolve the query using fieldsource's criteria
        } elseif (!is_null($field_data->sourceable_type) && is_null($field_data->sourceable_id)) {

            // instantiate the model pointed by FieldSource
            $source_instance = new $field_data->sourceable_type();

            // get a Builder instance (so we can take care of scopes eventually)
            $instance->builder = $source_instance->newQuery();

            $instance->table = $source_instance->getTable();

            // build the actual query
            $builder = $instance->parseCriteria($field_data->criteria);

            // @NOTE @TODO we limit to 150 only to prevent cp hiccups. there is a note on trello on how to refactor this
            // $builder->limit(150);

            // looks like toArray screws it up if you're not using a numeric id
            return $builder->get()->toArray();
        }
    }

    /**
     * parseCriteria field and build a query
     *
     * @param      array                                  $criteria  The criteria
     * @param      \Illuminate\Database\Eloquent\Builder  $builder         The builder
     * @param      array                                  $builder_params  The builder
     *                                                                     parameters
     *
     * @return     \Illuminate\Database\Eloquent\Builder  ( description_of_the_return_value )
     */
    public function parseCriteria(array $criteria)
    {
        foreach ($criteria as $method => $single_criteria) {

            // @TODO/@NOTE the pain point here is the UI not sending correctly formed arrays, to solve make sure ui
            // doesn't send strings instead of arrays i.e. NOT '["item1", "item2"]' (join, looking at you)

            call_user_func_array([$this, $method], (array) $single_criteria);
        }

        return $this->builder;
    }

    /**
     * sort
     *
     * @param      array                                  $order  The order
     * @param      \Illuminate\Database\Eloquent\Builder  $builder  The builder
     *
     * @return     \Illuminate\Database\Eloquent\Builder  ( description_of_the_return_value )
     */
    public function sort($key, $direction)
    {
        return $this->builder->orderBy($key, $direction);
    }

    /**
     * select
     *
     * @param      array   $columns  The columns
     * @param      \Illuminate\Database\Eloquent\Builder  $builder  The builder
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function select()
    {
        $what = array_values(func_get_args());
        $what[] = '*';
        return $this->builder->select($what);
    }

    /**
     * join - simple source.field = dest.field join
     *
     * @param      <type>  $destination_table  The destination table
     * @param      <type>  $origin_field       Field in the starting table
     * @param      <type>  $destination_field  Field on destination table
     * @param      \Illuminate\Database\Eloquent\Builder  $builder  The builder
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function join($destination_table, $origin_field, $destination_field)
    {
        $origin = $this->table . '.' . $origin_field;

        $destination = $destination_table . '.' . $destination_field;

        $this->builder->join($destination_table, $origin, '=', $destination);
    }

    /**
     * where
     *
     * @param      <type>  $field   The field
     * @param      <type>  $clause  The clause
     */
    public function where($field, $clause)
    {
        $this->builder->where($field, $clause);
    }

    /**
     * limit
     *
     * @param      \Illuminate\Database\Eloquent\Builder  $builder  The builder
     * @param      integer                                $limit    The limit
     *
     * @return     <type>                                 ( description_of_the_return_value )
     */
    public function limit(int $limit)
    {
        return $this->builder->limit($limit);
    }
}
