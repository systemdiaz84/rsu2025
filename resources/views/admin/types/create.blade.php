{!! Form::open(['route' => 'admin.vehicletypes.store']) !!}
@include('admin.types.template.form')
<!--{!! Form::submit('Registrar', ['class' => 'btn btn-success']) !!}-->
<button type="submit" class="btn btn-success"><i class="fas fa-save"></i></button>
{!! Form::close() !!}
