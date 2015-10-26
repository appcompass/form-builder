        <section class="wrapper">
        <!-- page start-->
            <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        {{ $meta->index->heading }}
                    </header>
                    <div class="panel-body">
                            <div class="clearfix">
                                <div class="btn-group">
                                    <a id="editable-sample_new" class="btn btn-primary" href="#" data-click="{{ $meta->base_url }}/create" data-target="#main-content">
                                        Add New <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="space15"></div>
                        <table class="table  table-hover general-table">
                            <thead>
                            <tr>
                                @foreach($meta->index->table->headers as $header)
                                    <th>{{ $header }}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($records as $record)
                            <tr>
                                @foreach($meta->index->table->rows as $row_key => $row_data)
                                    @if ($row_data->type == 'link_by_id')
                                        <td><a href="javascript:;" data-click="{{ $meta->base_url }}/{{ $record->id }}" data-target="#main-content">{{ $record->$row_key }}</a></td>
                                    @elseif($row_data->type == 'link_to_blank')
                                        <td><a href="{{ $record->$row_key }}" target="_blank">{{ $record->$row_key }}</a></td>
                                    @elseif($row_data->type == 'datetime')
                                        <td>{{ $record->$row_key }}</td>
                                    @else
                                        <td>{{ $record->$row_key }}</td>
                                    @endif
                                @endforeach
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>