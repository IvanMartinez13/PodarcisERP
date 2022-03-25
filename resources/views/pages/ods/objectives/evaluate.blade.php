@extends('layouts.app')

@section('content')
    <div class="row mb-2">
        <div class="col-10 my-auto">
            <h2>{{ $strategy->title }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="{{ route('ods.index') }}">{{ __('modules.targets') }}</a>
                </li>

                <li class="breadcrumb-item active">
                    <a href="{{ route('ods.strategy.index', $objective->token) }}">{{ $objective->title }}</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>{{ __('forms.evaluate') }}</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('ods.strategy.index', $objective->token) }}"
                class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>


    </div>

    <evaluation objective="{{ json_encode($objective) }}" strategy="{{ json_encode($strategy) }}"
        update="{{ Auth::user()->can('update Ods') }}" delete="{{ Auth::user()->can('delete Ods') }}"></evaluation>
@endsection
