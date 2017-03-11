<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title> @yield ('title','Default') </title>
	<link rel="stylesheet" href={{ asset('plugins/bootstrap/css/bootstrap.css') }}>
</head>
<body>
	
	@include('admin.templates.partial.nav')

	<section>

		<div class="container">
			<div class="row">
				<div class="col-md-12">
						
						<div class="col-md-6">
							
							<div class="col-md-5">
									<img src="{{ asset('mis-imagenes/Registro.jpg') }}" alt="registro" class="img-responsive">
							</div>
							
							<div class="col-md-1">
									<div class="col-md-12">
											<br>
											<div class="input-group">
												<span class="input-group-addon ">Personal</span>
												<a href="{{ route('admin.auth.login') }}" class="btn btn-primary">Entrar</a>
											</div>
											
											<div>
												<a href="{{ route('admin.user.create-natural') }}" class="">Registrarse</a>	
											</div>
												
									</div>

									<div class="col-md-12">
											<br>
											<div class="input-group">
												<span class="input-group-addon ">Empresarial</span>
												<a href="{{route('admin.auth.login')}}" class="btn btn-primary">Entrar</a>
											</div>	

											<div>
												<a href="{{ route('admin.user.create-juridico') }}">Registrarse</a>	
											</div>
									</div>
				
									
								
							</div>
							
						</div>
							
						<div class="col-md-6">
								<div class="col-md-12">
									<img src="{{ 'mis-imagenes/Banco.jpg'}}" alt="Banco" class="img-responsive">
								</div>
								
						</div>

					
				</div>


			</div>
		</div>
		

	</section>

<footer>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<p class="text-center"> Banco RFA. C.A Copyright 2017.  Todo los derechos reservados</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>

	<script src={{ asset('plugins/jquery/js/jquery-3.1.1.min.js') }} ></script>
	<script src={{ asset('plugins/bootstrap/js/bootstrap.js') }} ></script>
</body>
</html>