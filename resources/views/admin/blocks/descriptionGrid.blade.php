<script type="text/javascript">
    jQuery(document).ready(function() {
        // $( "#dataTableDescription" ).sortable( "disable" );
        

        var descriptionDataTable =  $('#dataTableDescription').DataTable({
            "processing": true,
            "serverSide": true,
            'searching': true,
            "ajax": {
                "url": "{{ route('productDescriptions') }}?product_id={{$product_id}}",
                "data": function(data){
                    console.log(data);
                    data['sort_field'] = data.columns[data.order[0].column].name;
                    data['sort_dir'] =  data.order[0].dir;
                    data['search'] = data.search.value;

                    // delete data.columns;
                    // delete data.order;
                    // delete data.search;

                    var filter_position = $('#filter_position').val();
                    data.filter_position = filter_position;

                    // var filter_collection = $('#filter_collection').val();
                    // data.filter_collection = filter_collection;

                    // if(filter_collection && filter_collection != ''){
                    //     dataTable.page.len(-1)
                    //     data['length'] = -1
                    //     $( "#dataTable" ).sortable( "enable" );
                    // }else{
                    //     $( "#dataTable" ).sortable( "disable" );
                    // }
                }
            },
            "fnDrawCallback": function( oSettings ) {
                feather.replace();
                $('[data-toggle="popover"]').popover();
            },
            "columns": [
                { "data": 'ordering', "name":"ordering", "orderable": true},    
                { "data": 'id', 'name': 'id',"orderable": true},
                { "data": 'title', 'name': 'title',"orderable": true},
                { "data": "position", "name":'position', "orderable": true,
                    render: function ( data, type, row, meta) {
                    return row.position + '-ին սունյակ';
                }},
                { "data": "id", "name":'edit', "orderable": false, "sClass": "content-middel selectOff",
                    render: function ( data, type, row, meta) {
                    return '<a href="javascript:;" edit_description_id="'+row.id+'" class="description_edit"><button class="btn btn-datatable btn-icon btn-transparent-dark"><i data-feather="edit"></i></button></a>';
                }},
            ],
            "columnDefs": [
                {"visible": false, "targets": 0},
                {"visible": false, "targets": 1},
                {"width": "80%", "targets": 2},
                {"width": "10%", "targets": 3},
                {"width": "10%", "targets": 4},
            ],
            "lengthMenu": [
                [10, 20, 50, 100, -1],
                [10, 20, 50, 100, "All"] // change per page values here
            ],
            "order": [
                ['0', "desc"]
            ]
        });
        window.descriptionDataTable = descriptionDataTable;

        $('#dataTableDescription tbody').on('click', 'tr td:not(.selectOff)', function (e) {
            $(this).parent('tr').toggleClass('selected');
        });

        $("#removeDescription").on('click', function (e) {
            if(descriptionDataTable.rows('.selected').data().length <= 0){
                toastr['info']("Please select item", 'Information');
            }else{
                var rows = [];
                descriptionDataTable.rows('.selected').data().each(function (row) {
                    rows.push(row.id);
                })
                if(rows.length <= 0){
                    toastr['info']("Please select item", 'Information');
                    return
                }
                bootbox.confirm("Are you sure?", function(result) {
                    if(result){
                        $.ajax({
                        type: "POST",
                        url: "{{route('aRemoveDescription')}}",
                        dataType: 'JSON',
                        data:{_token: "<?php echo csrf_token(); ?>", ids:rows},
                            success: function(response){
                                if(response.status == 1){
                                    descriptionDataTable.ajax.reload(null, false);
                                }else{
                                    toastr['error'](response.message, 'Error');
                                }
                            }
                        });
                    }
                });
            }
        });




            
            $("[name='dataTableDescription_length']").change(sortingData);
            $("#filter_position").change(sortingData);

            function sortingData(){
                var info = descriptionDataTable.page.info();
                var position = $('#filter_position').val();
                
                if(info.length == -1 && position != ""){
                    $( "#dataTableDescription" ).sortable( "enable" );
                }else{
                    $( "#dataTableDescription" ).sortable( "disable" );
                }
                descriptionDataTable.draw();
            }


            $('#dataTableDescription').sortable({
                items: "tbody tr",
                opacity: 0.8,
                coneHelperSize: true,
                tolerance: "pointer",
                helper: "clone",
                revert: 250, // animation in milliseconds
                update: function(event, ui) {
                    var ids = new Array();
                    $('tbody tr', '#dataTableDescription').each(function(index) {
                        ids.push($(this).attr('id'));
                    });
                    console.log(ids);
                    $.ajax({
                        type: "POST",
                        url: "{{ route('descriptionSort') }}",
                        dataType: 'JSON',
                        data:{_token: "<?php echo csrf_token(); ?>", ids:ids}
                    });
                },
            });
            $( "#dataTableDescription" ).sortable("disable");

    });
</script>