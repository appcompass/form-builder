<?php

namespace P3in\Models;

use GuzzleHttp\Client as GC;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Phaza\LaravelPostgis\Eloquent\Builder;
use Phaza\LaravelPostgis\Eloquent\PostgisTrait;
use Phaza\LaravelPostgis\Geometries\Point;

class Location extends Model
{
    use PostgisTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lat_lng',
    ];

    /**
    *   Fields that needs to be treated as a date
    *
    */
    protected $dates = [];

    protected $postgisFields = [
        'lat_lng' => Point::class
    ];

    public function locationable()
    {
        return $this->morphTo();
    }

    /**
     * Scope to search for records within a certain distance from a Point
     *
     * @param Builder $query
     * @param Point   $point
     * @param null    $operator
     * @param null    $distance
     * @param string  $boolean
     * @return $this
     */
    public function scopeWhereDistance(Builder $query, Point $point, $operator = null, $distance = 0, $boolean = 'and')
    {
        $field = DB::raw(
            sprintf("ST_Distance(%s.lat_lng, ST_GeogFromText('%s'))",
                $this->getTable(),
                $point->toWKT()
            )
        );

        return $query->where($field, $operator, $distance, $boolean);
    }
}
