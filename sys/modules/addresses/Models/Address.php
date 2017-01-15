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

class Address extends Model
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
        'number',
        'street',
        'suffix',
        'city',
        'state',
        'zip',
        'location',
        'addressable_id',
        'addressable_type',
    ];

    protected $appends = ['formatted'];

    /**
    *   Fields that needs to be treated as a date
    *
    */
    protected $dates = [];

    protected $postgisFields = [
        'location' => Point::class
    ];

    public function addressable()
    {
        return $this->morphTo();
    }

    // Google API version
    public static function addAddressLink($addressable_id, $addressable_type, $address_object)
    {
        $address_lookup = Address::lookup($address_object);
        $found_address = [];

        if (!empty($address_lookup->results)) {
            $found_address['number'] = $address_object['number'];
            $found_address['street'] = $address_object['street'];
            $found_address['city'] = $address_object['city'];
            $found_address['state'] = $address_object['state'];
            $found_address['zip'] = $address_object['postal_code'];
            $found_address['addressable_id'] = $addressable_id;
            $found_address['addressable_type'] = $addressable_type;

            $found_address = array_merge($found_address, Address::structureGoogleResult($address_lookup->results[0]));
        }

        if (!empty($found_address)) {
            return static::create($found_address);
        }
    }

    public static function structureGoogleResult($address)
    {
        // Defaults.
        $rslt = [
            'number' => '',
            'street' => '',
            'city' => '',
            'state' => '',
            'zip' => '',
            'suffix' => '',
            'location' => new Point($address->geometry->location->lat, $address->geometry->location->lng),
        ];

        foreach ($address->address_components as $comp) {
            switch (true) {
                case in_array('street_number', $comp->types):
                    $rslt['number'] = $comp->long_name;
                    break;
                case in_array('route', $comp->types):
                    $rslt['street'] = $comp->long_name;
                    break;
                case in_array('neighborhood', $comp->types):
                    $rslt['city'] = $comp->long_name;
                    break;
                case in_array('locality', $comp->types):
                    $rslt['city'] = $comp->long_name;
                    break;
                case in_array('administrative_area_level_1', $comp->types):
                    $rslt['state'] = $comp->long_name;
                    break;
                case in_array('postal_code', $comp->types):
                    $rslt['zip'] = $comp->long_name;
                    break;
            }
        }

        return $rslt;
    }

    public static function lookup($address)
    {
        if ((is_array($address) && count(array_filter($address)) >= 3) || is_string($address)) {
            $client = new GC();
            $params = [
                'address' => is_string($address) ? $address : implode(' ', $address),
                'key' => env('GOOGLE_API_KEY'),
            ];
            try {
                $res = $client->get('https://maps.googleapis.com/maps/api/geocode/json', [
                    'query' => $params
                ]);
            } catch (RequestException $e) {
                return false;
            }

            return json_decode($res->getBody());
        } else {
            return [];
        }
    }

    public static function newFromString($address)
    {
        $lookup = Address::lookup($address);

        if (!empty($lookup->results)) {
            $structued = Address::structureGoogleResult($lookup->results[0]);

            $address = Address::firstOrNew([
                'number' => $structued['number'],
                'street' => $structued['street'],
                'city' => $structued['city'],
                'state' => $structued['state'],
                'zip' => $structued['zip'],
                'suffix' => $structued['suffix']
            ]);

            $address->location = $structued['location'];

            return $address;
        }

        return null;
    }

    public function getFormattedAttribute()
    {
        return $this->number.' '.$this->street.' '.$this->city.' '.$this->state.' '.$this->zip;
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
    public function scopeWhereDistance(Builder $query, Point $point, $operator = null, $distance = null, $boolean = 'and')
    {
        $field = DB::raw(
            sprintf("ST_Distance(%s.location, ST_GeogFromText('%s'))",
                $this->getTable(),
                $point->toWKT()
            )
        );

        return $query->where($field, $operator, $distance, $boolean);
    }
}
