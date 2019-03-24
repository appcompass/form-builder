<?php

namespace AppCompass\FormBuilder\Traits;

use AppCompass\FormBuilder\Models\FieldSource;
use Illuminate\Database\Eloquent\Model;

trait HasDynamicContent
{
    /**
     * Link to FieldSource
     *
     * @return     morphOne
     */
    public function source()
    {
        // @TODO @jubair can we make this ->load() to cut queries #
        return $this->morphOne(FieldSource::class, 'sourceable');
    }

    /**
     * Make Content dynamic
     *
     * @param      <type>    $source    The source
     * @param      Function $callback the FieldSource instance will be injected into (if applicable)
     *
     * @return     calling class
     */
    public function dynamic($source, $callback)
    {
        $this->source()->delete();

        $field_source = $this->source()->create([
            'data'     => is_array($source) ? $source : [],
            'criteria' => [],
        ]);

        // @TODO: This overwrites the above, so can't be right? look into it.
        if (is_string($source) && class_exists($source)) {
            $field_source->sourceable_type = $source;
        } elseif ($source instanceof Model) {
            $field_source->sourceable_type = $source;

            if (isset($source->{$source->getKeyName()}) && !is_null($source->{$source->getKeyName()})) {
                $field_source->sourceable_id = $source->{$source->getKeyName()};
            }
        }

        if ($callback) {
            $callback($field_source);
        }

        return $this;
    }
}
