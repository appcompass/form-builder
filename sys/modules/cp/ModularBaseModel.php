<?php

namespace P3in;

use Exception;
use File;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class ModularBaseModel extends Model
{
    public function getRules()
    {
        return isset($this->rules) ? $this->rules : [];
    }

    /**
     * Method used to replicate models with the specified relationships to be cloned as well.
     *
     * @return void
     * @author
     **/
    public function replicateWithRelations()
    {
        $clone = $this->replicate();
        foreach ($this->getRelations() as $relationName => $relation) {
            $rel = $this->$relationName();
            switch (true) {
                case $rel instanceof HasMany:
                    $newRelation = [];
                    foreach ($relation as $row) {
                        if ($row) {
                            $newRelation[] = $row->replicateWithRelations();
                        }
                    }
                    $clone->save();
                    $clone->$relationName()->saveMany($newRelation);
                break;
            }
        }

        return $clone;
    }

    /**
     * Used as a base starting point for route chain validation of models.
     *
     * @return Builder
     * @author
     **/
    public function scopeFromRoute($query, $params)
    {
        $last = null;
        foreach ($params as $key => $model) {
            $last = $model;
        }
        if ($last) {
            return $last;
        }
        return $query;
    }

    /**
     * Used to allow us to filter results by their parent/child relationships.
     *
     * @return Builder
     * @author
     **/
    public function scopeOf($query, $relationship, $model)
    {
        return $query->whereHas($relationship, function ($q) use ($model) {
            if ($key = $model->getKey()) {
                $q->where($model->getKeyName(), $key);
            }
        });
    }

/* work to convert.
|==========================================|==================|=============================================================|================================================|======================|
|                 Function                 |   Return Type    |                         Description                         |                    Example                     |    Example Result    |
|==========================================|==================|=============================================================|================================================|======================|
| array_to_json(anyarray                   | json             | Returns the array as JSON. A PostgreSQL multidimensional    | array_to_json('{{1,5},{99,100}}'::int[])       | [[1,5],[99,100]]     |
| [, pretty_bool])                         |                  | array becomes a JSON array of arrays. Line feeds will be    |                                                |                      |
|                                          |                  | added between dimension 1 elements if pretty_bool is true.  |                                                |                      |
|                                          |                  |                                                             |                                                |                      |
|------------------------------------------|------------------|-------------------------------------------------------------|------------------------------------------------|----------------------|
| row_to_json(record                       | json             | Returns the row as JSON. Line feeds will be added between   | row_to_json(row(1,'foo'))                      | {"f1":1,"f2":"foo"}  |
| [, pretty_bool])                         |                  | level 1 elements if pretty_bool is true.                    |                                                |                      |
|                                          |                  |                                                             |                                                |                      |
|------------------------------------------|------------------|-------------------------------------------------------------|------------------------------------------------|----------------------|
| to_json(anyelement)                      | json             | Returns the value as JSON. If the data type is not built    | to_json('Fred said "Hi."'::text)               | "Fred said \"Hi.\""  |
|                                          |                  | in, and there is a cast from the type to json, the cast     |                                                |                      |
|                                          |                  | function will be used to perform the conversion.            |                                                |                      |
|                                          |                  | Otherwise, for any value other than a number, a Boolean     |                                                |                      |
|                                          |                  | or a null value, the text representation will be used,      |                                                |                      |
|                                          |                  | escaped and quoted so that it is legal JSON.                |                                                |                      |
|                                          |                  |                                                             |                                                |                      |
|------------------------------------------|------------------|-------------------------------------------------------------|------------------------------------------------|----------------------|
| json_array_length(json)                  | int              | Returns the number of elements in the outermost JSON array. | json_array_length('[1,2,3,{"f1":1,             | 5                    |
|                                          |                  |                                                             | "f2":[5,6]},4]')                               |                      |
|------------------------------------------|------------------|-------------------------------------------------------------|------------------------------------------------|----------------------|
| json_each(json)                          | SETOF key text   | Expands the outermost JSON object into a set of             | select * from json_each('{"a":"foo",           | key / value          |
|                                          | value json       | key/value pairs.                                            | "b":"bar"}')                                   | ----/-------         |
|                                          |                  |                                                             |                                                | a   / "foo"          |
|                                          |                  |                                                             |                                                | b   / "bar"          |
|------------------------------------------|------------------|-------------------------------------------------------------|------------------------------------------------|----------------------|
| json_each_text(from_json json)           | SETOF key text,  | Expands the outermost JSON object into a set of             | select * from json_each_text('{"a":"foo",      | key / value          |
|                                          | value text       | key/value pairs. The returned value will be of type text.   | "b":"bar"}')                                   | ----/-------         |
|                                          |                  |                                                             |                                                | a   / foo            |
|                                          |                  |                                                             |                                                | b   / bar            |
|------------------------------------------|------------------|-------------------------------------------------------------|------------------------------------------------|----------------------|
| json_extract_path(from_json json,        | json             | Returns JSON object pointed to by path_elems.               | json_extract_path('{"f2":{"f3":1},"f4":        | {"f5":99,"f6":"foo"} |
| VARIADIC path_elems text[])              |                  |                                                             | {"f5":99,"f6":"foo"}}','f4')                   |                      |
|                                          |                  |                                                             |                                                |                      |
|------------------------------------------|------------------|-------------------------------------------------------------|------------------------------------------------|----------------------|
| json_extract_path_text(from_json json,   | text             | Returns JSON object pointed to by path_elems.               | json_extract_path_text('{"f2":{"f3":1},"f4":   | foo                  |
| VARIADIC path_elems text[])              |                  |                                                             | {"f5":99,"f6":"foo"}}','f4', 'f6')             |                      |
|                                          |                  |                                                             |                                                |                      |
|------------------------------------------|------------------|-------------------------------------------------------------|------------------------------------------------|----------------------|
| json_object_keys(json)                   | SETOF text       | Returns set of keys in the JSON object. Only the "outer"    | json_object_keys('{"f1":"abc","f2":            | json_object_keys     |
|                                          |                  | object will be displayed.                                   | {"f3":"a", "f4":"b"}}')                        | -----------------    |
|                                          |                  |                                                             |                                                | f1                   |
|                                          |                  |                                                             |                                                | f2                   |
|                                          |                  |                                                             |                                                |                      |
|------------------------------------------|------------------|-------------------------------------------------------------|------------------------------------------------|----------------------|
| json_populate_record(base anyelement,    | anyelement       | Expands the object in from_json to a row whose columns      | select * from json_populate_record(null::x,    | a / b                |
| from_json json, [, use_json_as_text      |                  | match the record type defined by base. Conversion will      | '{"a":1,"b":2}')                               | --/---               |
| bool=false])                             |                  | be best effort; columns in base with no corresponding       |                                                | 1 / 2                |
|                                          |                  | key in from_json will be left null. If a column is          |                                                |                      |
|                                          |                  | specified more than once, the last value is used.           |                                                |                      |
|                                          |                  |                                                             |                                                |                      |
|------------------------------------------|------------------|-------------------------------------------------------------|------------------------------------------------|----------------------|
| json_populate_recordset(base anyelement, | SETOF anyelement | Expands the outermost set of objects in from_json           | select * from json_populate_recordset(null::x, | a / b                |
| from_json json,                          |                  | to a set whose columns match the record type defined        | '[{"a":1,"b":2},{"a":3,"b":4}]')               | --/---               |
| [, use_json_as_text bool=false])         |                  | by base. Conversion will be best effort; columns            |                                                | 1 / 2                |
|                                          |                  | in base with no corresponding key in from_json will         |                                                | 3 / 4                |
|                                          |                  | be left null. If a column is specified more than            |                                                |                      |
|                                          |                  | once, the last value is used.                               |                                                |                      |
|                                          |                  |                                                             |                                                |                      |
|------------------------------------------|------------------|-------------------------------------------------------------|------------------------------------------------|----------------------|
| json_array_elements(json)                | SETOF json       | Expands a JSON array to a set of JSON elements.             | json_array_elements('[1,true, [2,false]]')     | value                |
|                                          |                  |                                                             |                                                | -----------          |
|                                          |                  |                                                             |                                                | 1                    |
|                                          |                  |                                                             |                                                | true                 |
|                                          |                  |                                                             |                                                | [2,false]            |
|==========================================|==================|=============================================================|================================================|======================|
*/
    /**
     * @var $field = json field name
     * @var $outKey = what the key should be set to
     * @var $search = string or array traversion the json elements for it's value
     * @return json
     **/
    public function scopeWithJson($query, $field, $outKey, $search)
    {
        $chain = is_array($search) ? implode("','", $search) : $search;
        return $query->selectRaw("*, json_extract_path_text({$field}, '{$chain}') as {$outKey}");
    }

    public function scopeWhereJson($query, $field, $search, $operator, $value)
    {
        $chain = is_array($search) ? implode("','", $search) : $search;
        return $query->whereRaw("json_extract_path_text({$field}, '{$chain}') {$operator} '{$value}'");
    }
}
