<?php

namespace P3in\Models;

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
        'linked_id',        // data belongs to
        'linked_type',
        'data',
        'criteria'
    ];



    public $timestamps = false;

    protected $casts = [
        'data' => 'array',
        'criteria' => 'array'
    ];

    public function sourceable()
    {
        return $this->morphTo();
    }

    // public function field()
    // {
    //     return $this->belongsTo(Field::class);
    // }

    public function linked()
    {
        return $this->morphTo();
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

    public function select(array $fields)
    {
        $criteria = $this->criteria;

        $criteria['select'] = $fields;

        $this->update(['criteria' => $criteria]);

        return $this;
    }

    public function join($destination_table, $origin_field, $destination_field)
    {
        $criteria = $this->criteria;

        $criteria['join'] = [ $destination_table, $origin_field, $destination_field ];

        $this->update(['criteria' => $criteria]);

        return $this;
    }

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

    public function toArray()
    {
        return SourceBuilder::render($this);
    }
}