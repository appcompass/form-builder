<?php

/**
 *
 * We use json config fields in a few places, so this is used to unifiy the API
 *
 */

namespace AppCompass\Traits;

trait HasJsonConfigFieldTrait
{
    protected static function bootHasJsonConfigFieldTrait()
    {
        static::unguard();
    }

    // usage:  $model->getConfig('something.deep.inside.config')
    public function getConfig($key)
    {
        // array_get is what we need but only works with arrays.
        $conf = json_decode(json_encode($this->config ?: []), true);

        $result = array_get($conf, $key, null);

        return is_array($result) ? (object)$result : $result;
    }

    public function setConfig($key, $val = null)
    {
        if (gettype($key) === 'string') {
            $key = 'config->' . $key;
        } else {
            $val = $key;
            $key = 'config';
        }

        $key = str_replace('.', '->', $key);

        $this->update([$key => $val]);

        return $this;
    }

    // usage: ModelWithThisTrait::byConfig('field->sub_field->other_field', 'value of other_field')->get()
    public function scopeByConfig($query, $key, $operator = null, $value = null, $boolean = 'and')
    {
        $key = str_replace('.', '->', $key);

        return $query->where("config->$key", $operator, $value, $boolean);
    }

}
