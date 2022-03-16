@extends('layouts.app')

@section('content')

    <div class="row mb-2">

        <div class="col-10 my-auto">
            <h2>{{ __('modules.vao') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('vao.index') }}">{{ __('modules.vao') }}</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>{{ __('forms.create') }}</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('vao.index') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>

    </div>

    <div class="ibox">

        <div class="ibox-title">
            <h5>{{ __('forms.create') }} {{ __('modules.vao') }}</h5>

            <div class="ibox-tools">
                <a href="" class="collapse-link">
                    <i class="fa fa-chevron-up" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        <div class="ibox-content">

            <form action="{{route('vao.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')

                <input name="token" type="hidden" value="{{$vao->token}}">
                
                <div class="row">

                    <div class="col-lg-6 mb-3  @error('title') has-error @enderror">
                        <label for="title">{{__('forms.title')}}:</label>
                        <input id="title" name="title" type="text" class="form-control" placeholder="{{__('forms.title')}}..." value="{{ $vao->title }}">
                    </div>
    
                    <div class="col-lg-3 mb-3 @error('starts_at') has-error @enderror">
                        <label for="starts_at">{{__('forms.starts_at')}}:</label>
                        <input id="starts_at" name="starts_at" type="date" class="form-control" placeholder="{{__('forms.starts_at')}}..." value="{{ $vao->starts_at }}">
                    </div>
    
                    <div class="col-lg-3 mb-3 @error('code') has-error @enderror">
                        <label for="code">{{__('forms.code')}}:</label>
                        <input id="code" name="code" type="text" class="form-control" placeholder="{{__('forms.code')}}..." value="{{ $vao->code }}">
                    </div>
    
                    <div class="col-lg-12 mb-3 @error('description') has-error @enderror">
                        <label for="description">{{__('forms.description')}}:</label>
                        <textarea id="description" name="description" class="form-control" placeholder="{{__('forms.description')}}...">{{ $vao->description }}</textarea>
                    </div>
    
                    <div class="col-lg-12 mb-3">
                        <label for="state">{{__('forms.state')}}:</label>
                        <br />
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">


                            <label class="btn btn-outline btn-success mx-1 rounded @if($vao->state == 'pending')  active  @endif" >
                              <input type="radio" name="state" id="pending" value="pending" @if($vao->state == 'pending') checked @endif> {{__('Start pending')}}
                            </label>
    
                            <label class="btn btn-warning btn-outline mx-1 rounded @if($vao->state == 'process')  active  @endif">
                              <input type="radio" name="state" id="process" value="process" @if($vao->state == 'process') checked @endif > {{__('In process')}}
                            </label>
    
                            <label class="btn btn-danger btn-outline mx-1 rounded @if($vao->state == 'stopped')  active  @endif">
                              <input type="radio" name="state" id="stopped" value="stopped" @if($vao->state == 'stopped') checked @endif> {{__('Stopped')}}
                            </label>
    
                            <label class="btn btn-primary btn-outline mx-1 rounded @if($vao->state == 'finished')  active  @endif">
                                <input type="radio" name="state" id="finished" value="finished" @if($vao->state == 'finished') checked @endif> {{__('Finished')}}
                            </label>
                        </div>
                    </div>
    
                    <div class="col-lg-12 mb-3">
                        <div class="row">
    
                            <div class="col-lg-6 mb-3">
                                <div id="map" style="height: 600px"></div>
                            </div>
    
                            <div class="col-lg-6 mb-3">
    
                                <div class="row">
                                    <div class="col-lg-12 mb-3 @error('direction') has-error @enderror">
                                        <label for="direction">{{__('forms.direction')}}:</label>
                                        <input name="direction" id="direction" class="form-control" placeholder="{{__('forms.direction')}}..." value="{{ $vao->direction }}">
                                    </div>
                                    
                    
                                    <div class="col-lg-12 mb-3  @error('location') has-error @enderror">
                                        <label for="coordinates">{{ __('forms.coordinates') }}:</label>
                                        <input type="text" name="location" id="coordinates" class="form-control"
                                        value="{{ $vao->location }}" placeholder="{{ __('forms.coordinates') }}...">
                                    </div>
    
                                    <div class="col-lg-12 mb-3">
                                        <label for="file">{{__('forms.image')}}:</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input id="image" type="file" class="custom-file-input" name="image">
                                                <label class="custom-file-label" for="image">{{__('forms.image')}}...</label>
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <a class="btn btn-link" href="{{url('/storage').$vao->image}}" target="_BLANK">
                                                Ver imagen actual...
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
    
                    
                </div>
    
                <div class="text-right">
                    <button class="btn btn-primary">{{__('forms.update')}}</button>
                </div>
            </form>

        </div>

        <div class="ibox-footer">
            Podarcis SL. &copy; {{date('Y')}}
        </div>
    </div>


@endsection

@push('scripts')
    <script src="{{ url('/') }}/js/maps/mapCreate.js"></script>

    <script>

        $('#description').summernote({

            placeholder: 'Descripción...',
            height: 150,
        });

        $(document).ready(function () {
            bsCustomFileInput.init();


            addPin('{{ $vao->location }}')
        })

        

    </script>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                $(document).ready(() => {
                    toastr.error("{{ $error }}")
                })
            </script>
        @endforeach
    @endif

@endpush