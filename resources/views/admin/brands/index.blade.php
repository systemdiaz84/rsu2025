@extends('adminlte::page')

@section('title', 'Marcas')

@section('content')
    <div class="p-2"></div>

    <div class="card">
        <div class="card-header">
            <button class="btn btn-secondary float-right" id="btnNuevo">Nuevo</button>
            <h3>Marcas</h3>
        </div>

        <div class="card-body" >
            <table class="display" id="table">
                <thead>
                    <tr>
                        <th>Logo</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Creación</th>
                        <th></th>
                        <th></th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($brands as $brand)
                        <tr>
                            <td></td>
                            <td>{{ $brand->name }}</td>
                            <td>{{ $brand->description }}</td>
                            <td><button class="btn btn-success btn-sm btnEditar" id="{{ $brand->id }}"><i
                                        class="fas fa-pen"></i></button></td>
                            <td>
                                <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST"
                                    class="frmEliminar">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                            class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
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
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                "ajax": "{{ route('admin.brands.index') }}",
                "columns": [{
                        "data": "logo",
                        "orderable": false,
                        "searchable": false,
                    },
                    {
                        "data": "name",
                    },
                    {
                        "data": "description",
                    },
                    {
                        "data": "created_at",
                    },
                    {
                        "data": "edit",
                        "orderable": false,
                        "searchable": false,
                        "width": "5%"
                    },
                    {
                        "data": "delete",
                        "orderable": false,
                        "searchable": false,
                        "width": "5%"
                    }
                ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                }
            });
        });


        $('#btnNuevo').click(function() {
            $.ajax({
                url: "{{ route('admin.brands.create') }}",
                type: "GET",
                success: function(response) {
                    $("#exampleModalLabel").html("Nueva marca");
                    $("#formModal .modal-body").html(response);
                    $('#formModal').modal('show');

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
            })

        });

        $(document).on('click', '.btnEditar', function() {
            var id = $(this).attr("id");
            $.ajax({
                url: "{{ route('admin.brands.edit', 'id') }}".replace('id', id),
                type: "GET",
                success: function(response) {
                    $("#exampleModalLabel").html("Modificar marca");
                    $("#formModal .modal-body").html(response);
                    $('#formModal').modal('show');

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
            })
        });

        $(document).on('submit', '.frmEliminar', function(e) {
            e.preventDefault();
            const form = $(this);

            Swal.fire({
                title: "¿Seguro de eliminar?",
                text: "Esta acción es irreversible",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, eliminar"
            }).then((result) => {
                if (result.isConfirmed) {
                    //this.submit();
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

        function refreshTable() {
            var table = $('#table').DataTable();
            table.ajax.reload(null, false);
        }
    </script>
    <!--
        @if (session('success') !== null)
    <script>
        Swal.fire({
            title: "Proceso exitoso",
            text: "{{ session('success') }}",
            icon: "success"
        });
    </script>
    @endif
        @if (session('error') !== null)
    <script>
        Swal.fire({
            title: "Error de proceso",
            text: "{{ session('error') }}",
            icon: "error"
        });
    </script>
    @endif-->

@stop
