
@extends('admin.templates.main')

@section('title-coment')

	<div class="col-md-5">
		<div class="panel panel-default">
			<div class="panel-body">
				<p> <span class="glyphicon glyphicon-book"></span> Bienvenido {{ Auth::user()->nombre}}. <br> <span class="glyphicon glyphicon-tags"></span>  Para mayor información comunicarse con el 0-500-AYUDA-00.</p>
			</div>
		</div>
	</div>
	

@endsection

@section('title', 'Página de Cuenta del Usuario')

@section('content')

		{!! Form::open(['route' => 'admin.users.store-juridico', 'method' => 'POST']) !!}

	<div class="form-group">
		{!! Form::label('tareta','Numero de Tarjeta') !!}
		{!! Form::text('tarjeta',null,['class' =>'form-control', 'placeholder'=> 'Nombre Completo','required']) !!}
	</div>

	<div class="form-group">
		{!! Form::label('monto','Monto a Pagar:') !!}
		{!! Form::text('monto',null,['class' =>'form-control', 'placeholder'=> 'Lugar donde vive actualmente','required']) !!}
	</div>


{!! Form::close() !!}



@endsection