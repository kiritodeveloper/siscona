@extends('layouts.template')



    @push('boton_accion')
    <a href="{{ url('/personal/add') }}" class="btn btn-primary">
        <span class="glyphicon glyphicon-plus"></span>
        Nuevo Personal
    </a>
    @endpush



@push('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/plugins/dataTables/dataTables.min.css') }}">
@endpush

@section('title', 'Personal')

@section('content')

    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))

                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
            @endif
        @endforeach
    </div> <!-- end .flash-message -->




    <div class="table-responsive">
    <table class="table table-bordered table-hover table-striped table-center" id="users-table">

        <thead>
        <tr>
            <th>ID dispositivo</th>
            <th>Usuario Nro.</th>
            <th>C&eacute;dula</th>
            <th>Nombre</th>
            <th>Grupo</th>
            <th>Sub Grupo</th>
            <th>Huella 1</th>
            <th>Huella 2</th>
            <th>PIN</th>
            <th>Horario</th>
            <th>Action</th>
            <th>Eliminar</th>
        </tr>
        </thead>
    </table>

    </div>
@stop

@push('scripts')


<script src="{{ URL::asset('assets/js/plugins/dataTables/datatables.min.js') }}"></script>
<script>
    $(function() {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
            },
            ajax: 'personal/data',
            "order": [[ 0, "desc" ]],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            columns: [
                {data: 'Userid', name: 'Userid'},
                {data: 'UserCode', name: 'UserCode'},   
                 {data: 'cedula', name: 'cedula'},    
                {data: 'Name', name: 'Name'},
                {data: 'grupo_nombre', name: 'grupo_personal.nombre'},
                {data: 'sub_grupo_nombre', name: 'sub_grupo_personal.nombre'},
                {data: 'huella1', name: 'huella1'},
                {data: 'huella2', name: 'huella2'},
                {data: 'Pwd', name: 'Pwd'},
                {data: 'horario', name: 'horario', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
                 {data: 'delete', name: 'delete', orderable: false, searchable: false}
            ],
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                { extend: 'copy', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7,8 ]
                }},
                {extend: 'csv', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7,8 ]
                }},
                {extend: 'excel', title: 'Reporte de Personal', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7,8 ]
                }},
                {extend: 'pdf', title: 'Reporte de Personal',  exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7,8 ]
                },

            @if (Session::get('prioridad')==2) 
                    customize: function ( doc ) {

                    doc.content.splice( 1, 0, {
                        margin: [ 0, -50, 0, 12 ],
                         width: 60,
                        height: 60,
                        alignment: 'left',
                                                image: '{{Session::get('logo_base64')}}'

                       
                    } );
                }
            @endif},

                {extend: 'print',
                    customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                    }
                }
            ]
        });
    });




$(document).ready(function() {

var table = $('#users-table').DataTable();
 
    $('#users-table tbody').on( 'click', '.delete', function (event) {

        if(confirm("¿Esta seguro que deseas eliminar esto?"))
        {
            event.preventDefault();
            var row = $(this).closest("tr").get(0);
            var id=$(row).find( ".delete" ).data("eliminar");

            $.get("personal/delete/"+id, function(data, status){
                alert("Eliminado con exito!!");
                location.reload();
            });
        }

    });
 
});
</script>

@endpush