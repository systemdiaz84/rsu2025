{!! Form::model($brand, ['route' => ['admin.brands.update', $brand], 'method' => 'put']) !!}
@include('admin.brands.template.form')
<!-- {!! Form::submit('Actualizar', ['class' => 'btn btn-success']) !!} -->
<button type="submit" class="btn btn-success"><i class="fas fa-save"></i></button>
{!! Form::close() !!}
