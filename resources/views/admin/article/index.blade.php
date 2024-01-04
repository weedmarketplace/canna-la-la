@extends('admin.layouts.app')
@section('content')
    @include('admin.blocks.uploader')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="folder"></i></div>
                                Articles
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="container mt-n10">
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Page name</th>
                                <th>Edit</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th>Page name</th>
                                <th>Edit</th>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main page content-->
    </main>
    @push('css')
        <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    @endpush
    @push('script')
        @include('admin.blocks.ui')
        <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="{!! asset('backend/plugins/tinymce/tinymce.min.js') !!}" type="text/javascript"></script>
        <script>
            $(document).ready(function() {
                // initTinymce();
                // const capitalize = (s) => {
                //     if (typeof s !== 'string') return ''
                //     return s.charAt(0).toUpperCase() + s.slice(1)
                // }

                var dataTable =  $('#dataTable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    'searching': false,
                    "ajax": {
                        "url": "{{ route('aArticlesData') }}",
                        "data": function(data){
                            data['sort_field'] = data.columns[data.order[0].column].name;
                            data['sort_dir'] =  data.order[0].dir;

                            delete data.columns;
                            delete data.order;
                        }
                    },
                    "fnDrawCallback": function( oSettings ) {
                        feather.replace();
                    },
                    "columns": [
                        { "data": "page_name", "name":'page_name', "orderable": false },
                        { "data": "id", "name":'edit', "orderable": false, "sClass": "content-middel selectOff",
                            render: function ( data, type, row, meta) {
                                return '<a href="javascript:;" edit_item_id="'+row.id+'" class="item_edit"><button class="btn btn-datatable btn-icon btn-transparent-dark"><i data-feather="edit"></i></button></a>';
                            }},
                    ],
                    "columnDefs": [
                        {"width": "80%", "targets": 0},
                        {"width": "20%", "targets": 1},
                    ],
                    "lengthMenu": [
                        [10, 20, 50, 100, -1],
                        [10, 20, 50, 100, "All"] // change per page values here
                    ],
                    "order": [
                        ['0', "desc"]
                    ],
                });

                window.datatable = dataTable;

                $("[name='dataTable_length']").change(function(){
                    dataTable.draw();
                });

                var itemPopup = new Popup;
                itemPopup.init({
                    size:'modal-xl',
                    identifier:'edit-item',
                    class: 'modal close-tiny',
                    minHeight: '200',
                })
                window.itemPopup = itemPopup;

                $('#dataTable').on('click', '.item_edit', function (e) {
                    editId = $(this).attr('edit_item_id');
                    itemPopup.setTitle('Edit Article');
                    itemPopup.load("{{route('aGetArticle')}}?id="+editId, function () {
                        this.open();
                    });
                });
            });
        </script>
    @endpush
@endsection
