@extends('admin.templates.main')

@section('title-coment')

	<div class="panel panel-default">
		<div class="panel-heading">
			<p> Estimado usuario, complete los campos requeridos para procesar su solicitud.</p>
		</div>
	</div>

@endsection


@section('title', 'Formulario para cuentas de usuarios naturales') 


@section('content')

	

{!! Form::open(['route' => 'admin.users.store-juridico', 'method' => 'POST']) !!}

	<div class="form-group">
		{!! Form::label('nombre','Nombre') !!}
		{!! Form::text('nombre',null,['class' =>'form-control', 'placeholder'=> 'Nombre Completo','required']) !!}
	</div>

	<div class="form-group">
		{!! Form::label('direccion','Dirección') !!}
		{!! Form::text('direccion',null,['class' =>'form-control', 'placeholder'=> 'Lugar donde vive actualmente','required']) !!}
	</div>

	<div class="form-group">
		{!! Form::label('telefono','Telefono') !!}
		{!! Form::text('telefono',null,['class' =>'form-control', 'placeholder'=> 'XXXX-XXX-XX-XX','required']) !!}
	</div>

	<div class="form-group">
		{!! Form::label('email','Email') !!}
		{!! Form::email('email',null,['class' =>'form-control', 'placeholder'=> 'example@mail.com','required']) !!}
	</div>

	<div class="form-group">
		{!! Form::label('password','Contraseña') !!}
		{!! Form::password('password',['class' =>'form-control', 'placeholder'=> '*******','required']) !!}
	</div>	

	<div class="form-group">
		{!! Form::label('password_confirmation','Confirme Contraseña') !!}
		{!! Form::password('password_confirmation',['class' =>'form-control', 'placeholder'=> '*******','required']) !!}
	</div>	

	<div class="form-group">
		{!! Form::label('cedula','Cedula') !!}
		{!! Form::text('cedula',null,['class' =>'form-control', 'placeholder'=> 'Introduzca su número de cedula','required']) !!}
	</div>

	{{ Form::hidden('tipo_usuario', 'natural') }}	

	<div class="form-group">
		{!! Form::submit('Siguiente',['class' => 'btn btn-primary']) !!}
	</div>

{!! Form::close() !!}

@endsection