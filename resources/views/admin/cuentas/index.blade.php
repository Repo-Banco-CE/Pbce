
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

		<table class="table table-striped">
			<thead>
				<tr>
					<th>Numero de Cuenta</th>
					<th>Saldo Disponible de la Cuenta</th>
				</tr>
			</thead>
			<tbody>

				@foreach($cuentas as $cuenta)

					@if($cuenta->id == Auth::user()->id)
					<tr>
						<td>{{ $cuenta->numero }}</td>
						<td>{{ $cuenta->saldo_cuenta }}</td>
					
					</tr>
					@endif

				@endforeach
			</tbody>
		</table>



@endsection