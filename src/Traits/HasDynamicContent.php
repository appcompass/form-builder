<?php

namespace P3in\Traits;

use P3in\Models\FieldSource;
use Illuminate\Database\Eloquent\Model;

trait HasDynamicContent
{

    /**
     * Make Content dynamic
     *
     * @param      <type>    $source    The source
     * @param      Function  $callback  the FieldSource instance will be injected into (if applicable)
     *
     * @return     calling class
     */
    public function dynamic($source, $callback)
    {
        FieldSource::whereLinkedId($this->id)->whereLinkedType(get_class($this))->delete();

        $field_source = FieldSource::create([
            'linked_id' => $this->id,
            'linked_type' => get_class($this),
            'data' => is_array($source) ? $source : [],
            'criteria' => []
        ]);

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
