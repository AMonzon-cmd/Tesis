@extends('layouts/layout')

@section('menu-dashboard')
    active
@endsection


@section('contenido')

    <!-- Migas de pan -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="javascript:;">Panel de Administración</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <!-- /Migas de pan-->

    @csrf
    <!-- Titulo Pagina -->
    <h1 class="page-header">Dashboard</h1>
    <!-- /Titulo Pagina -->

    <div class="row">
        <div class="col-3">
            <div class="widget widget-stats bg-gradient-green m-b-10">
                <div class="stats-icon stats-icon-lg"><i class="fas fa-comment-dollar"></i></div>
                <div class="stats-content">
                    <div class="stats-title font-weight-bold">PAGOS DEL DIA</div>
                    <br/>
                    <div class="stats-number"><span data-animation="number" data-value="{{$dashboard->pagosDelDia}}">0</span></div>
                    <div class="stats-desc"><a class="text-white" href="{{route('ListadoPagos')}}">Ver mas -></a></div>
                </div>
            </div>
        </div>

        <div class="col-3">
            <div class="widget widget-stats bg-gradient-purple m-b-10">
                <div class="stats-icon stats-icon-lg"><i class="fas fa-comment-dollar"></i></div>
                <div class="stats-content">
                    <div class="stats-title font-weight-bold">PAGOS TOTALES</div>
                    <br/>
                    <div class="stats-number"><span data-animation="number" data-value="{{$dashboard->pagosTotales}}">0</span></div>
                    <div class="stats-desc"><a class="text-white" href="{{route('ListadoPagos')}}">Ver mas -></a></div>
                </div>
            </div>
        </div>

        <div class="col-3">
            <div class="widget widget-stats bg-gradient-red m-b-10">
                <div class="stats-icon stats-icon-lg"><i class="fas fa-receipt"></i></div>
                <div class="stats-content">
                    <div class="stats-title font-weight-bold">PAGOS ANULADOS</div>
                    <br/>
                    <div class="stats-number"><span data-animation="number" data-value="{{$dashboard->pagosAnulados}}">0</span></div>
                    <div class="stats-desc"><a class="text-white" href="{{route('ListadoPagos')}}">Ver mas -></a></div>
                </div>
            </div>
        </div>

        <div class="col-3">
            <div class="widget widget-stats bg-gradient-blue m-b-10">
                <div class="stats-icon stats-icon-lg"><i class="fas fa-user-plus"></i></div>
                <div class="stats-content">
                    <div class="stats-title font-weight-bold">NUEVOS CLIENTES</div>
                    <br/>
                    <div class="stats-number"><span data-animation="number" data-value="{{$dashboard->clientesNuevos}}">0</span></div>
                    <div class="stats-desc"><a class="text-white" href="{{route('ListadoClientes')}}">Ver mas -></a></div>
                </div>
            </div>
        </div>
    </div>



    <div class="row">

    </div>

@endsection