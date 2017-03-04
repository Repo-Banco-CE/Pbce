@extends('admin.templates.main')


@section('title', 'Crear Usuario Juridico') 


@section('content')

	

{!! Form::open(['route' => 'users.store', 'method' => 'POST']) !!}

	<div class="form-group">
		{!! Form::label('name','Nombre') !!}
		{!! Form::text('name',null,['class' =>'form-control', 'placeholder'=> 'Nombre Completo','required']) !!}
	</div>

	<div class="form-group">
		{!! Form::label('email','Email') !!}
		{!! Form::email('email',null,['class' =>'form-control', 'placeholder'=> 'example@gmail.com','required']) !!}
	</div>

	<div class="form-group">
		{!! Form::label('password','Contraseña') !!}
		{!! Form::password('password',['class' =>'form-control', 'placeholder'=> '*******','required']) !!}
	</div>			

	<div class="form-group">
		{!! Form::label('type','Tipo de Usuario') !!}
		{!! Form::select('type',['juridico' => 'Usuario Juridico'] , 'juridico', ['class' =>'form-control']) !!}
	</div>

	<div class="form-group">
		{!! Form::submit('Registrar',['class' => 'btn btn-primary']) !!}
	</div>

{!! Form::close() !!}

@endsection