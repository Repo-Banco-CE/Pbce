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

@section('title', 'Página de Información de la Tarjeta')

@section('content')

		<table class="table table-striped">
			<thead>
				<tr>
					<th>Numero de Tarjeta</th>
					<th>Limite</th>
					<th>Saldo</th>
					<th>Cupo Disponible</th>
					<th>Fecha de Corte</th>
				</tr>
			</thead>
			<tbody>						
						<tr>
							<td>{{ $cuenta->numero_tarjeta }}</td>
							<td>{{ $cuenta->limite }}</td>
							<td>{{ $cuenta->saldo }}</td>
							<td>{{ $cuenta->cupo_disponible }}</td>
							<td>{{ $cuenta->fecha_corte }}</td>
						</tr>

				
			</tbody>
		</table>

@endsection