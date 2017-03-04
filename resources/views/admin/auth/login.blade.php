@extends('admin.templates.main')

@section('title','Iniciar Sesión')

@section('content')

	
	{!! Form::open(['route' => 'admin.auth.login', 'method' => 'POST']) !!}

		<div class="form-group">
			{!! Form::label('email', 'Correo Electrónico') !!}
			{!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'example@mail.com']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('password', 'Contraseña') !!}
			{!! Form::password('password', ['class' => 'form-control', 'placeholder' => '******']) !!}
		</div>
	
		<div class="form-group">
			{!! Form::submit('Iniciar Sesión', ['class' => 'btn btn-primary']) !!}	
		</div>
		

	{!! Form::close() !!}



@endsection
