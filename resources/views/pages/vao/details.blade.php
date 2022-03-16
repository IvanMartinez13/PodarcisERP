@extends('layouts.app')

@section('content')


    <div class="row mb-2">

        <div class="col-10 my-auto">
            <h2>{{ $vao->title }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('vao.index') }}">{{ __('modules.vao') }}</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>{{ $vao->title }}</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('vao.index') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <div id="map" style="height: 75vh" class="bg-danger">
                
            </div>
        </div>

        <div class="col-lg-6">

            <div class="row">
                {{-- DETAILS --}}
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title bg-primary">
                            <h5>{{$vao->title}}</h5>
        
                            <div class="ibox-tools">
                                <a role="button" class="collapse-link">
                                    <i class="fa fa-chevron-up text-white" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
        
                        <div class="ibox-content">
                            <div class="row">
        
                                <div class="col-lg-12 mb-3 mb-lg-0">
                                    <strong>{{__('columns.description')}}: </strong>
                                    {!! $vao->description !!}
                                </div>
        
                                
                                <div class="col-lg-4 mb-3 mb-lg-0">
                                    <strong>{{__('columns.direction')}}: </strong>
                                    <br />
                                    {{ $vao->direction }}
                                </div>
        
                                <div class="col-lg-4 mb-3 mb-lg-0">
                                    <strong>{{__('columns.code')}}: </strong>
                                    <br />
                                    {{ $vao->code }}
                                </div>
        
        
                                <div class="col-lg-4 mb-3 mb-lg-0">
                                    <strong class="w-100 pb-5">{{__('columns.state')}}: </strong>
                                    <h4>
                                        @switch($vao->state)
                                            @case('pending')
                                                <span class="p-2 badge badge-success">{{__('Start pending')}}</span>
                                                @break
                                            @case('process')
                                                <span class="p-2 badge badge-warning">{{__('In process')}}</span>
                                                @break
        
                                            @case('stopped')
                                                <span class="p-2 badge badge-danger">{{__('Stopped')}}</span>
                                                @break
        
                                            @case('finished')
                                                <span class="p-2 badge badge-primary">{{__('Finished')}}</span>
                                                @break
                                            @default
                                                <span class="p-2 badge badge-dark">{{__('Not defined')}}</span>
                                                @break
                                        @endswitch
                                    </h4>
         
                                </div>
                            </div>
        
                        </div>
        
                        <div class="ibox-footer">
                            Podarcis SL. &copy; {{date('Y')}}
                        </div>
                    </div>
                </div>

                {{-- KMZ --}}
                <div class="col-lg-6">
                    <div class="ibox">
                        <div class="ibox-title bg-primary">
                            <h5>{{__('Admin kmz')}}</h5>

                            <div class="ibox-tools">
                                <a role="button" class="collapse-link">
                                    <i class="fa fa-chevron-up text-white" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>

                        <div class="ibox-content">

                        </div>

                        <div class="ibox-footer">
                            Podarcis SL. &copy; {{date('Y')}}
                        </div>
                    </div>
                </div>

                {{-- GRAPHS --}}
                <div class="col-lg-6">
                    <div class="ibox">
                        <div class="ibox-title bg-primary">
                            <h5>{{__('% Compliance')}}</h5>

                            <div class="ibox-tools">
                                <a role="button" class="collapse-link">
                                    <i class="fa fa-chevron-up text-white" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>

                        <div class="ibox-content">

                        </div>

                        <div class="ibox-footer">
                            Podarcis SL. &copy; {{date('Y')}}
                        </div>
                    </div>
                </div>

                
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title bg-primary">
                            <h5>{{__('Incidents and notices')}}</h5>

                            <div class="ibox-tools">
                                <a role="button" class="collapse-link">
                                    <i class="fa fa-chevron-up text-white" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>

                        <div class="ibox-content">

                        </div>

                        <div class="ibox-footer">
                            Podarcis SL. &copy;
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>
@endsection