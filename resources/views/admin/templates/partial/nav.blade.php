<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    @if(Auth::user())
      <a class="navbar-brand" href="{{ route('users.index') }}">Banco RFA</a>
    @else
      <a class="navbar-brand" href="{{ route('admin.welcome') }}">Banco RFA</a>
    @endif  
      
      
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    @if(Auth::user())
      <ul class="nav navbar-nav">
        

        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Consultar Cuenta<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('cuentas.index')}}">Consultar Saldo</a></li>
            <li><a href="{{ route('cuenta.afiliacion') }}">Afiliación Comercial</a></li>
          </ul>
        </li>
          
                 
      @if(Auth::user()->tipo == 'natural')
        <li><a href="{{ route('cuentas.show', Auth::user()) }}">Consultar Tarjeta</a></li> 
        <li><a href="{{ route('cuenta.pagar-tarjeta') }}">Pagar Tarjeta</a></li>
      @endif   
        

        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            Movimientos <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
           <li><a href="{{ route('cuenta.movimientos') }}">Cuenta</a></li>
            <li><a href="{{ route('cuenta.movimientos.tarjeta') }}" >Tarjeta</a></li>
          </ul>
        </li>

      @if(Auth::user()->tipo == 'juridico')
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            Facturas por Cobrar <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('facturas.activas')}}" >Activas</a></li>
            <li><a href="{{ route('facturas.vencidas')}}" >Vencidas</a></li>
            <li><a href="{{ route('facturas.pagadas')}}" >Pagadas</a></li>
          </ul>
        </li>

        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            Facturas por Pagar <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('pagarfacturas.activas')}}" >Activas</a></li>
            <li><a href="{{ route('pagarfacturas.vencidas')}}" >Vencidas</a></li>
            <li><a href="{{ route('pagarfacturas.pagadas')}}" >Pagadas</a></li>
          </ul>
        </li>
      @endif
        <li>
            <a href="{{ route("cuenta.transferencia")}}" class="dropdown-toggle" >Transferencias</a>
           
        </li>
        
      </ul>
      
      <ul class="nav navbar-nav navbar-right">
        <li><a href="{{ route('users.index')}}">Página principal</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> 
          <span class="glyphicon glyphicon-user" aria-hidden="true">{{ Auth::user()->nombre }} </span> 
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('admin.auth.logout') }}"> Salir</a></li>
          </ul>
        </li>
      </ul>
    @endif
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>