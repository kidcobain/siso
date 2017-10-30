@extends('layouts.app')

@section('title', '| Roles')

@section('content')
@if (session('success'))
        <div class="alert alert-success col-sm-offset-2 col-sm-8 mensaje">
            {{ session('success') }}
        </div>
@endif
<div class="col-lg-10 col-lg-offset-1">
    <h1><i class="fa fa-key"></i> Roles

    <a href="{{ route('users.index') }}" class="btn btn-default pull-right">Usuarios</a>
    <a href="{{ route('permissions.index') }}" class="btn btn-default pull-right">Permisos</a></h1>
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Rol</th>
                    <th>Permisos</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($roles as $role)
                <tr>

                    <td>{{ $role->name }}</td>

                    <td>{{  $role->permissions()->pluck('name')->implode(' ') }}</td>{{-- Retrieve array of permissions associated to a role and convert to string --}}
                    <td>
                    <a href="{{ URL::to('roles/'.$role->id.'/edit') }}" class="btn btn-info pull-left" style="margin-right: 3px;">Editar</a>

                    {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id] ]) !!}
                    {!! Form::submit('Eliminar', ['class' => 'btneliminar btn btn-danger']) !!}
                    {!! Form::close() !!}

                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    <a href="{{ URL::to('roles/create') }}" class="btn btn-success">Añadir rol</a>

</div>
<script src="js/sweetalert2.all.min.js"></script>
<script>
    $('.btneliminar').on('click', function(e){
        var $_this = $(this).parent('form');
        e.preventDefault();

      swal({
        title: 'Confirmación',
        text: "¿Desea borrar la fila?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, borrar',
        cancelButtonText: 'No, cancelar!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
      }).then(function () {
        swal(
          'Borrado!',
          'La fila fue borrada',
          'success'
        )
         $_this.submit();
      }, function (dismiss) {
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {
          swal(
            'Cancelado',
            'No se ha borrado la fila',
            'error'
          )
        }
      })
    })
</script>
@endsection