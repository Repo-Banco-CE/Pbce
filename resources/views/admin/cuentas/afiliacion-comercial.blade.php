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

@section('title', 'Página de Afiliación Comercial')

@section('content')

		<table class="table table-striped">
			<thead>
				<tr>
					<th>Dueño de la Cuenta</th>
					<th>Estado de Afiliación</th>
					<th>Afiliar</th>
				</tr>
			</thead>
			<tbody>
					@foreach($cuentas as $cuenta)

						@if($cuenta->id == Auth::user()->id)
							<tr>
								<td>{{ Auth::user()->nombre }}</td>
								@if( Auth::user()->afiliacion_comercial == 0)
									<td> Esta cuenta no se encuentra afiliada</td>
									<td> <a href="{{ route('cuenta.afiliar', Auth::user()->id) }}" class="btn btn-primary"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a></td>
								@else
									<td>Esta cuenta se encuentra afiliada</td>
									<td> <a href="{{ route('cuenta.retirar', Auth::user()->id) }}" class="btn btn-danger"> <span class="glyphicon glyphicon-minus" aria-hidden="true"></span></a></td>
								@endif


								
							</tr>
						@endif

					@endforeach
				
			</tbody>
		</table>



@endsection