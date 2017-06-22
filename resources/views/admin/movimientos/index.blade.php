
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

@section('title', 'Movimientos Cuenta')

@section('content')

		<table class="table table-striped">
			<thead>
				<tr>
					<th>Descripción</th>
					<th>Monto</th>
					<th>DC</th>
					<th>Saldo</th>
					<th>Fecha</th>
				</tr>
			</thead>
			<tbody>

				@foreach($user_mov as $mov)

				@if($mov->descripcion == 'Transferencia' || $mov->descripcion == 'Pago a Proveedor' || $mov->descripcion =='Conciliacion Pago con tarjeta')
					<tr>
						<td>{{ $mov->descripcion }}</td>
						<td>{{ $mov->monto }}</td>
						<td>{{ $mov->dc }}</td>
						<td>{{ $mov->saldo }}</td>
						<td>{{ $mov->created_at }}</td>
					
					</tr>
				@endif

				@endforeach
			</tbody>
		</table>



@endsection