@extends('layouts.app')

@section('content')
    @if (auth()->user()->hasRole('super-admin'))
        <div class="row">
            <div class="col-md-3">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Clientes</h5>
                    </div>
                    <div class="ibox-content" style="height: 120px;">

                        <h2> {{ count($customers) }} </h2>
                        <div class="m-t-sm small">Total de clientes.</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Módulos</h5>
                    </div>
                    <div class="ibox-content" style="height: 120px;">
                        <h2> {{ count($modules) }}</h2>
                        <div class="m-t-sm small">Total de modulos.</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Espacio en disco</h5>
                    </div>
                    <div class="ibox-content" style="height: 120px;">

                        <h2> {{ $size }} usados.</h2>

                        <div class="progress progress-mini">
                            <div style="width: {{ 100 - $restante * 100 }}%;" class="progress-bar"></div>
                        </div>

                        <div class="m-t-sm small">Espacio restante {{ ($restante * 100 * 1024) / 100 }} GB</div>

                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Mensajes</h5>
                    </div>
                    <div class="ibox-content" style="height: 120px;">
                        No disponible
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>In box</h5>
                    </div>

                    <div class="ibox-content">
                        <h5>Tabla con incidencias de los usuarios</h5>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Blog</h5>
                    </div>

                    <div class="ibox-content">
                        <h5>Entrads del blog</h5>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
