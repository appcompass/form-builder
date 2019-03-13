<?php

namespace AppCompass\Models;

/* Criteria field example
[
 'select' => ['plus3_people.id', 'users.email', 'users.id'],
 'join' => ['plus3_people', 'id', 'user_id'],
 'sort' => ['users.id', 'ASC'],
 'limit' => 5,
 'where' => ['users.id', 4]
]
*/

use Illuminate\Database\Eloquent\Model;

class FieldSource extends Model
{
    public $fillable = [
        'sourceable_id',    // we get data from
        'sourceable_type',
        'data',
        'criteria',
        'related_field',
    ];

    public $timestamps = false;

    protected $casts = [
        'data'     => 'array',
        'criteria' => 'array',
    ];

    public function sourceable()
    {
        return $this->morphTo();
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    //////////////////////////////////////////////
    // @TODO convert all this into a magic method, or something
    //////////////////////////////////////////////

    public function setData(array $data)
    {
        $this->data = $data;

        $this->save();

        return $this;
    }

    /**
     * adds a sub select
     *
     * @param      array $fields The fields
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function select(array $fields)
    {
        $criteria = $this->criteria;

        $criteria['select'] = $fields;

        $this->update(['criteria' => $criteria]);

        return $this;
    }

    /**
     * { function_description }
     *
     * @param      <type>  $destination_table  The destination table
     * @param      <type>  $origin_field       The origin field
     * @param      <type>  $destination_field  The destination field
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function join($destination_table, $origin_field, $destination_field)
    {
        $criteria = $this->criteria;

        $criteria['join'] = [$destination_table, $origin_field, $destination_field];

        $this->update(['criteria' => $criteria]);

        return $this;
    }

    public function relatesTo($name)
    {
        $this->update(['related_field' => $name]);

        return $this;
    }

    // @TODO: we should prob use the same structure as Eloquent or QueryBuilder,
    // i.e. allow inclusion of the operator and boolean.
    public function where($key, $value = null)
    {
        $criteria = $this->criteria;

        if (is_null($key)) {
            unset($criteria['where']);
        } else {
            $criteria['where'] = [$key, $value];
        }


        $this->update(['criteria' => $criteria]);

        return $this;
    }

    public function sort($key, $direction)
    {
        $criteria = $this->criteria;

        $criteria['sort'] = [$key, $direction];

        $this->update(['criteria' => $criteria]);

        return $this;
    }

    public function limit(int $limit)
    {
        $criteria = $this->criteria;

        $criteria['limit'] = $limit;

        $this->update(['criteria' => $criteria]);

        return $this;
    }

    public function config(array $config = null)
    {
        if (is_null($config)) {
            return [
                'criteria'        => $this->criteria,
                'sourceable_type' => $this->sourceable_type,
                'related_field'   => $this->related_field,
            ];
        }
    }

    public function render()
    {
        return SourceBuilder::render($this);
    }

    public function toArray()
    {
        return $this->render();
    }
}
