
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

@section('title', 'Página Principal del Usuario')

@section('content')

		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
	  <!-- Indicators -->
	  <ol class="carousel-indicators">
	    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
	    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
	    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
	  </ol>

	  <!-- Wrapper for slides -->
	  <div class="carousel-inner" role="listbox">
	    <div class="item active">
	      <img src="{{ asset('mis-imagenes/carrusel-1.jpg') }}" alt="banco2" width="560" height="245" class="center-block">
	      <div class="carousel-caption">
	       <h3 class="">Banco RFA Estamos para servirle.</h3 class="">
	      </div>
	    </div>
	    <div class="item">
	      <img src="{{ asset('mis-imagenes/carrusel-2.jpg') }}" alt="banco" width="560" height="245" class="center-block">
	      <div class="carousel-caption">
	        <h3 class="">Banco RFA Estamos para servirle.</h3 class="">
	      </div>
	    </div>

	     <div class="item">
	      <img src="{{ asset('mis-imagenes/carrusel-3.png') }}" alt="banco" width="560" height="245" class="center-block">
	      <div class="carousel-caption">
	        <h3 class="">Banco RFA Estamos para servirle.</h3 class="">
	      </div>
	    </div>
	   
	  </div>

	  <!-- Controls -->
	  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
	    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	    <span class="sr-only">Previous</span>
	  </a>
	  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
	    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
	    <span class="sr-only">Next</span>
	  </a>
	</div>
		
@endsection