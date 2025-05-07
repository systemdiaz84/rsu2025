{!! Form::open(['route' => 'admin.brands.store', 'files' => true]) !!}
@include('admin.brands.template.form')
{!! Form::submit('Registrar', ['class' => 'btn btn-success']) !!}
{!! Form::close() !!}
