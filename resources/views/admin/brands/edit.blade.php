{!! Form::model($brand, ['route' => ['admin.brands.update', $brand], 'method' => 'put']) !!}
@include('admin.brands.template.form')
{!! Form::submit('Actualizar', ['class' => 'btn btn-success']) !!}
{!! Form::close() !!}
