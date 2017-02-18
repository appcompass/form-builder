# Storage

##How it works
* P3in\Storage extends Laravel's Illuminate\Support\Facades\Storage class.
* Instead of using app config to set disk instances, we use the a StorageConfig Model for storing the configuration.
* Each configuration has a StorageType (i.e. local, ftp, rackspace, s3) so as we add drivers (sftp, youtube, wistia, etc) we can maintain database relatiohships between the models that use storage (Website, Photos, Videos, etc) and the storage disk instances.
* Calling: `Storage::disk('disk_name')` will:
    * check the app config if there is a disk by that name.
        * if has no config, then we `StorageConfig::byName('disk_name')->firstOrFail()` and set the stroage config in app memory.
    * calls `Illuminate\Support\Facades\Storage::disk('disk_name')` since we set the config if it's not already set.

###Programmatic Syntax

    Storage::disk('disk_name')
    Website::first()->storage->getDisk()
    StorageConfig::first()->getDisk()

    All three of the above return an instance of \Illuminate\Contracts\Filesystem\Filesystem


# FieldSource

##How it works
* When Form->render() is called we eager load each Form->field() 'source', which is either linked or not to a FieldSoruce
for the fields that has a FieldSource linked.
* Form->render() returns an Array or Json, calling toArray() on FieldSource triggers the actual SourceBuilder
* SourceBuilder parses FieldSource's instance __data__ or __criteria__ (in this order). The following conditions are evaluated:
    * FieldSource->data is set, we return that
    * FieldSource->sourceable_type and FieldSource->sourceable_id are both set: return that specific Model instance
    * FieldSource->sourceable_type but NO sourceable_id: fire a query builder and use it to query that model, following any criteria present

###Programmatic Syntax

    Field->dynamic(Source, Closure)

    * Source

        Field->dynamic(Namespace\ClassName::class, Closure)
        source will be the specific class, this receives a closure

        Field->dynamic(ClassName::find(#))
        assigns a specific record, conditions: instanceOf Model && isset(Model->getKeyName)

        Field->dynamic(array [])
        stores the data being passed as a "static/dynamic" data-source,

    * Closure

        injected into the closure is a FieldSource object, which exposes the following API
            __setData(array)__ sets a static data-source
            __select([string field1, string field2])__  list of fields to be returned
            __where(string key, int/string value)__ simple where '=' proxy
            __sort(string key, string direction)__
            __limit(int limit)__
            __join(string dest_table, string origin_field, dest_field)__ join(dest_table, (auto) origin_table.origin_field, '=', dest_table.dest_field)