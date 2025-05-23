@extends('adminlte::page')

@section('title', 'ReciclaUSAT')

@section('content')
    <div class="p-2"></div>
    <div class="card">
        <div class="card-header">
            <button class="btn btn-success float-right" id="btnNuevo"><i class="fas fa-plus"></i></button>
            <h3>Vehículos</h3>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped" id="datatable">
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Tipo</th>
                        <th>Placa</th>
                        <th>Estado</th>
                        <th>Ocupantes</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Formulario de vehículo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('dist/custom.css') }}">
@stop
@section('js')
    <script>
        $(document).ready(function() {
            var table = $('#datatable').DataTable({
                "ajax": "{{ route('admin.vehicles.index') }}",
                responsive: true,
                autoWidth: false,
                "columns": [{
                        "data": "id",
                    },
                    {
                        "data": "image",
                        "orderable": false,
                        "searchable": false,
                    }, {
                        "data": "name",
                    },
                    {
                        "data": "brand",
                    },
                    {
                        "data": "model",
                    },
                    {
                        "data": "vtype",
                    },
                    {
                        "data": "plate",
                    },
                    {
                        "data": "status",
                    },
                    {
                        "data": "ocuppants",
                        "orderable": false,
                        "searchable": false,
                    },
                    {
                        "data": "actions",
                        "orderable": false,
                        "searchable": false,
                    }
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                }
            });
        });


        $('#btnNuevo').click(function() {

            $.ajax({
                url: "{{ route('admin.vehicles.create') }}",
                type: "GET",
                success: function(response) {
                    $("#formModal #exampleModalLabel").html("Registrar Vehículo");
                    $("#formModal .modal-body").html(response);
                    $("#formModal").modal("show");
                    $("#formModal form").on("submit", function(e) {
                        e.preventDefault();

                        var form = $(this);
                        var formData = new FormData(this);

                        $.ajax({
                            url: form.attr('action'),
                            type: form.attr('method'),
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                $("#formModal").modal("hide");
                                refreshTable();
                                Swal.fire('Proceso existoso', response.message,
                                    'success');
                            },
                            error: function(xhr) {
                                var response = xhr.responseJSON;
                                Swal.fire('Error', response.message, 'error');
                            }
                        })

                    })

                }
            });
        });

        $(document).on('click', '.btnEditar', function() {
            var id = $(this).attr("id");

            $.ajax({
                url: "{{ route('admin.vehicles.edit', 'id') }}".replace('id', id),
                type: "GET",
                success: function(response) {
                    $("#formModal #exampleModalLabel").html("Modificar Vehículo");
                    $("#formModal .modal-body").html(response);
                    $("#formModal").modal("show");
                    $("#formModal form").on("submit", function(e) {
                        e.preventDefault();

                        var form = $(this);
                        var formData = new FormData(this);

                        $.ajax({
                            url: form.attr('action'),
                            type: form.attr('method'),
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                $("#formModal").modal("hide");
                                refreshTable();
                                Swal.fire('Proceso existoso', response.message,
                                    'success');
                            },
                            error: function(xhr) {
                                var response = xhr.responseJSON;
                                Swal.fire('Error', response.message, 'error');
                            }
                        })

                    })
                }
            });
        })

        $(document).on('submit', '.frmEliminar', function(e) {
            e.preventDefault();
            var form = $(this);
            Swal.fire({
                title: "Está seguro de eliminar?",
                text: "Está acción no se puede revertir!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, eliminar!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: form.attr('action'),
                        type: form.attr('method'),
                        data: form.serialize(),
                        success: function(response) {
                            refreshTable();
                            Swal.fire('Proceso existoso', response.message, 'success');
                        },
                        error: function(xhr) {
                            var response = xhr.responseJSON;
                            Swal.fire('Error', response.message, 'error');
                        }
                    });
                }
            });
        });


        $(document).on('click', '.btnImagenes', function() {
            var id = $(this).attr("id");

            $.ajax({
                url: "{{ route('vehicles.images', 'id') }}".replace('id', id),
                type: "GET",
                success: function(response) {
                    $("#formModal #exampleModalLabel").html("Imágenes del Vehículo");
                    $("#formModal .modal-body").html(response);
                    $("#formModal").modal("show");
                    $("#formModal form").on("submit", function(e) {
                        e.preventDefault();

                        var form = $(this);

                        Swal.fire({
                            title: "Está seguro de eliminar?",
                            text: "Está acción no se puede revertir!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Si, eliminar!"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: form.attr('action'),
                                    type: form.attr('method'),
                                    data: form.serialize(),
                                    success: function(response) {
                                        $("#formModal").modal("hide");

                                        refreshTable();
                                        Swal.fire('Proceso existoso',
                                            response.message, 'success');
                                    },
                                    error: function(xhr) {
                                        var response = xhr.responseJSON;
                                        Swal.fire('Error', response.message,
                                            'error');
                                    }
                                });
                            }
                        });

                    })
                }
            });
        })


        $(document).on('click', '.btnimageprofile', function(e) {

            var id = $(this).attr("id");
            var vehicle_id = $(this).attr("data-id");
            var url =
                "{{ route('admin.imageprofile', ['id' => ':id', 'vehicle_id' => ':vehicle_id']) }}"
                .replace(':id', id).replace(':vehicle_id', vehicle_id);
            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {

                    //$("#formModal").modal("hide");
                    refreshTable();
                    Swal.fire('Proceso existoso', response.message,
                        'success');
                },
                error: function(xhr) {
                    var response = xhr.responseJSON;
                    Swal.fire('Error', response.message, 'error');
                }
            });
        })


        function refreshTable() {
            var table = $('#datatable').DataTable();
            table.ajax.reload(null, false); // Recargar datos sin perder la paginación
        }
    </script>

@endsection
