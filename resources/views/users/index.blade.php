@extends('layouts.app')

@section('title', '| Users')

@section('content')
@if (session('success'))
        <div class="alert alert-success col-sm-offset-2 col-sm-8 mensaje">
            {{ session('success') }}
        </div>
@endif
<div class="col-lg-10 col-lg-offset-1">
    <h1><i class="fa fa-users"></i> Administración de usuarios <a href="{{ route('roles.index') }}" class="btn btn-default pull-right">Roles</a>
    <a href="{{ route('permissions.index') }}" class="btn btn-default pull-right">Permisos</a></h1>
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">

            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Registrado en:</th>
                    <th>Roles</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)
                <tr>

                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('F d, Y h:ia') }}</td>
                    <td>{{  $user->roles()->pluck('name')->implode(' ') }}</td>{{-- Retrieve array of roles associated to a user and convert to string --}}

                    <td>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info pull-left" style="margin-right: 3px;">Editar</a>

                    {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id] ]) !!}
                    {!! Form::submit('Eliminar', ['class' => 'btneliminar btn btn-danger']) !!}
                    {!! Form::close() !!}

                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    <a href="{{ route('users.create') }}" class="btn btn-success">Añadir usuario</a>

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