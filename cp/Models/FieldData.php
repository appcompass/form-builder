<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;

class FieldData extends Model
{
    public $fillable = [
        'sourceable_id',
        'sourceable_type',
        'data',
        'criteria'
    ];

    protected $table = 'field_data';

    public $timestamps = false;

    protected $casts = [
        'data' => 'array',
        'criteria' => 'array'
    ];

    public function sourceable()
    {
        return $this->morphTo();
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function select(array $fields)
    {
        $criteria = $this->criteria;

        $criteria['select'] = $fields;

        $this->update(['criteria' => $criteria]);

        return $this;
    }

    public function where($key, $value)
    {
        $criteria = $this->criteria;

        $criteria['where'] = [$key, $value];

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

    public function toArray()
    {
        return DataBuilder::render($this);
    }
}