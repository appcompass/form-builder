<section class="panel">
    <header class="panel-heading">
        {{ $meta->index->heading }}
    </header>
    <div class="panel-body">
        <div class="clearfix">
            <div class="btn-group">
                @can('create', $meta->classname)
                    @if(empty($meta->no_create))
                        <a id="editable-sample_new" class="btn btn-primary" href="#{{ $meta->base_url }}/create" data-click="{{ $meta->base_url }}/create" data-target="{{ $meta->data_target }}">
                            Add New <i class="fa fa-plus"></i>
                        </a>
                    @endif
                @endcan
            </div>
        </div>
        <div class="space15"></div>

        @if(isset($meta->index->filter_view))
            @include($meta->index->filter_view)
        @endif
        <table class="table table-hover general-table dataTable" id="dynamic-table">
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

                        @if($row_data->type == 'link_by_id')
                            <td>
                                @can('edit', $record)
                                    <a href="{{ $meta->base_url }}/{{ $record->getKey() }}/edit" data-click="{{ $meta->base_url }}/{{ $record->getKey() }}" data-target="{{ $meta->data_target }}">
                                @endcan
                                    {{ $record->$row_key }}
                                @can('edit', $record)
                                    </a>
                                @endcan
                            </td>

                        @elseif($row_data->type == 'action_buttons')
                            <td>
                                @foreach($row_data->data as $action)
                                    @if ($action == 'edit')
                                    @can('edit', $record)
                                        <a
                                            data-action="link"
                                            href="{{ $meta->base_url }}/{{ $record->getKey() }}/edit"
                                            data-click="{{ $meta->base_url }}/{{ $record->getKey() }}"
                                            data-target="{{ $meta->data_target }}"
                                            class="btn btn-primary"
                                        >
                                            Edit
                                        </a>
                                    @endcan
                                    @elseif($action == 'clone')
                                        <a
                                            data-action="clone"
                                            href=""
                                            data-click="/clone-resource"
                                            data-object-name="{{ get_class($record) }}"
                                            data-object-id="{{ $record->getKey() }}"
                                            data-object-redirect="{{ $meta->base_url }}"
                                            class="btn btn-info"
                                        >
                                            Clone
                                        </a>
                                    @elseif($action == 'delete')
                                        @can('destroy', $record)
                                        <a
                                            data-action="modal-delete"
                                            href="#modal-edit"
                                            data-toggle="modal"
                                            data-delete="{{ $meta->base_url }}/{{ $record->getKey() }}"
                                            data-click="/delete-modal"
                                            data-inject-area="#modal-body"
                                            class="btn btn-danger"
                                        >
                                            Delete
                                        </a>
                                        @endcan
                                    @endif
                                @endforeach
                            </td>
                        @elseif($row_data->type == 'link_to_blank')
                            <td><a href="http://{{ $record->$row_key }}" target="_blank" class="no-link">{{ $record->$row_key }}</a></td>
                        @elseif($row_data->type == 'datetime')
                            <td>{{ $record->$row_key }}</td>
                        @elseif($row_data->type == 'image')
                            <td><img src="{{ $record->path }}" width="120" alt=""></td>
                        @elseif($row_data->type == 'option')
                            <td>{{ $record->getOption($row_key, $row_data->option_name) }}</td>
                        @else
                            <td>{{ $record->$row_key }}</td>
                        @endif
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
        @if(method_exists($records , 'links'))
        <div class="dataTables_paginate paging_bootstrap pagination">
            {!! $records->links() !!}
        </div>
        @endif
    </div>
</section>

<script type="text/javascript" language="javascript" src="/assets/ui/js/advanced-datatable/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="/assets/ui/js/data-tables/DT_bootstrap.js"></script>

<script>
    $(document).ready(function() {

        @if(!isset($meta->index->filter_view))
            /*
             * Initialize DataTable
             */
            $('#dynamic-table').dataTable( {

            } );
            /*
             * Initialse DataTables, with no sorting on the 'details' column
             */
            var oTable = $('#hidden-table-info').dataTable( {
                "aoColumnDefs": [
                    { "bSortable": false, "aTargets": [ 0 ] }
                ],
                "aaSorting": [[1, 'asc']]
            });
        @endif

        /*
         * Insert a 'details' column to the table
         */
        var nCloneTh = document.createElement( 'th' );
        var nCloneTd = document.createElement( 'td' );
        nCloneTd.innerHTML = '<img src="/assets/ui/images/details_open.png">';
        nCloneTd.className = "center";

        $('#hidden-table-info thead tr').each( function () {
            this.insertBefore( nCloneTh, this.childNodes[0] );
        } );

        $('#hidden-table-info tbody tr').each( function () {
            this.insertBefore(  nCloneTd.cloneNode( true ), this.childNodes[0] );
        } );

        /* Add event listener for opening and closing details
         * Note that the indicator for showing which row is open is not controlled by DataTables,
         * rather it is done here
         */
        $(document).on('click','#hidden-table-info tbody td img',function () {
            var nTr = $(this).parents('tr')[0];
            if ( oTable.fnIsOpen(nTr) )
            {
                /* This row is already open - close it */
                this.src = "images/details_open.png";
                oTable.fnClose( nTr );
            }
            else
            {
                /* Open this row */
                this.src = "images/details_close.png";
                oTable.fnOpen( nTr, fnFormatDetails(oTable, nTr), 'details' );
            }
        });
    });
</script>
