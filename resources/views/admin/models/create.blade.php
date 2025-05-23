{!! Form::open(['route' => 'admin.models.store']) !!}
@include('admin.models.template.form')
<!--{!! Form::submit('Registrar', ['class' => 'btn btn-success']) !!}-->
<button type="submit" class="btn btn-success"><i class="fas fa-save"></i></button>
{!! Form::close() !!}
