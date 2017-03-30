
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

@section('title', 'Transferencias hacia el mismo banco')

@section('content')

	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-body">
			@foreach($cuentas as $cuenta)
					@if($cuenta->id == Auth::user()->id)
				<p> <span class="glyphicon glyphicon-euro"></span> Disponible: {{ $cuenta->saldo_cuenta}}</p>
					@endif
			@endforeach
			</div>
		</div>
	</div>
			
		{!! Form::open(['route' => 'cuenta.posttransferencia', 'method' => 'POST']) !!}

	<div class="form-group">
		{!! Form::label('numero','Número de Cuenta a Debitar') !!}
	@foreach($cuentas as $cuenta)
					@if($cuenta->id == Auth::user()->id)
		{!! Form::select('cuenta_origen', [$cuenta->numero  => $cuenta->numero ], null,['class' => 'form-control','required', 'placeholder' => ' ']) !!}
					@endif
	@endforeach
	</div>

	<div class="form-group">
		{!! Form::label('cuenta_destino','Número de Cuenta a Transferir') !!}

		{!! Form::text('cuenta_destino', null,['class' => 'form-control','required', 'placeholder' => 'Indique el número de cuenta al cual desea transferir']) !!}
	
	</div>

	<div class="form-group">
		{!! Form::label('monto','Monto a transferir:') !!}
		{!! Form::text('monto',null,['class' =>'form-control', 'placeholder'=> 'Introduzca el monto que desea transferir','required']) !!}
	</div>
	
	<div class="form-group">
		{!! Form::submit('Pagar',['class' => 'btn btn-primary']) !!}
	</div>

	{{ Form::hidden('tipo', 'local') }}	


{!! Form::close() !!}



@endsection