@extends('layouts.template')



    @push('boton_accion')
    <a href="{{ url('/grupo/add') }}" class="btn btn-primary">
        <span class="glyphicon glyphicon-plus"></span>
        Nuevo Grupo
    </a>
    @endpush



@push('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/plugins/dataTables/dataTables.min.css') }}">
@endpush

@section('title', 'Grupos')

@section('content')

    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))

                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
            @endif
        @endforeach
    </div> <!-- end .flash-message -->


    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped" id="users-table">

            <thead>
            <tr>
                <th>Id</th>
                <th>Nombre </th>
                <th>Descripción</th>
                <th>Activo</th>
                <th>Action</th>
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
            ajax: 'grupo/data',
            "order": [[ 0, "desc" ]],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'nombre', name: 'nombre'},
                {data: 'descripcion', name: 'descripcion'},
                {data: 'activo', name: 'activo'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                { extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'Reporte de Grupos',  exportOptions: {
                    columns: [ 0, 1, 2,3 ]
                }},
                {extend: 'pdf', title: 'Reporte de Grupos', exportOptions: {
                    columns: [ 0, 1, 2, 3 ]
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




</script>

@endpush