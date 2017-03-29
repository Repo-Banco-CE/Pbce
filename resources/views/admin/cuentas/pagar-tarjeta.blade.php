
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

@section('title', 'Pago de Tarjetas')

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
			
		{!! Form::open(['route' => 'postcuenta.pagar-tarjeta', 'method' => 'POST']) !!}

	<div class="form-group">
		{!! Form::label('numero','Número de Cuenta a Debitar') !!}
	@foreach($cuentas as $cuenta)
					@if($cuenta->id == Auth::user()->id)
		{!! Form::select('numero_cuenta', [$cuenta->numero  => $cuenta->numero ], null,['class' => 'form-control','required', 'placeholder' => 'Indique su Número de Cuenta']) !!}
					@endif
	@endforeach
	</div>

	<div class="form-group">
		{!! Form::label('numero_tarjeta','Número de Tarjeta a pagar') !!}
	@foreach($cuentas as $cuenta)
					@if($cuenta->id == Auth::user()->id)
		{!! Form::select('numero_tarjeta', [$cuenta->numero_tarjeta  => $cuenta->numero_tarjeta ], null,['class' => 'form-control','required', 'placeholder' => 'Indique el Número de su Tarjeta']) !!}
					@endif
	@endforeach
	</div>

	<div class="form-group">
		{!! Form::label('monto','Monto a Pagar:') !!}
		{!! Form::text('monto',null,['class' =>'form-control', 'placeholder'=> 'Introduzca el monto que desea cancelar','required']) !!}
	</div>
	
	<div class="form-group">
		{!! Form::submit('Pagar',['class' => 'btn btn-primary']) !!}
	</div>


{!! Form::close() !!}



@endsection