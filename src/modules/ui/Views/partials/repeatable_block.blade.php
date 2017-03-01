@foreach($records as $key => $val)
<div class="panel repeatable-container">
    <div class="panel-heading">
        <span class="heading-label">{{ $field->label }} Item #<span class="repeatable-number">{{ ($key+1) }}</span></span>
        <span class="tools pull-right">
            <a href="javascript:;" class="fa fa-arrows no-link"></a>
            <a href="javascript:;" class="fa fa-chevron-down no-link"></a>
            <a href="javascript:;" class="fa fa-times text-danger no-link"></a>
        </span>
    </div>
    <div class="panel-body">
        @include('ui::partials.form_fields', ['fields' => $field->data, 'repeatable' => true, 'index' => $key])
    </div>
</div>
@endforeach
<div class="text-right">
    <a href="javascript:;" class="btn btn-sm btn-white form-repeatable-add no-link">
        <i class="fa fa-plus"></i>
        Add Item
    </a>
</div>
