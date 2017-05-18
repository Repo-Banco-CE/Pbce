
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

@section('title', 'Pago de Facturas Activas')

@section('content')
		
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Nombre del Comercio</th>
					<th>Fecha de Emisión</th>
					<th>Fecha de Vencimiento</th>
					<th>Monto</th>
					<th>Estado</th>
					<th>Referencia</th>
					<th>Pagar</th>
				</tr>
			</thead>
			<tbody>

				 @foreach($facturas as $factura) 

					@if($factura->rif_comercio == Auth::user()->juridica->rif && $factura->estado == 'activa') 
						<tr>
							<td>{{ $factura->nombre_comercio }}</td>
							<td>{{ $factura->fecha_emision }}</td>
							<td>{{ $factura->fecha_vencimiento }}</td>
							<td>{{ $factura->monto }}</td>
							<td>{{ $factura->estado }}</td>
							<td>{{ $factura->ref_factura }}</td>
							<td> <a href="{{ route('pagar.factura', $factura) }}" class="btn btn-primary"> <span class="glyphicon glyphicon-euro" aria-hidden="true"></span></a></td>
						
						</tr>
					@endif 

				@endforeach 
			</tbody>
		</table>



@endsection