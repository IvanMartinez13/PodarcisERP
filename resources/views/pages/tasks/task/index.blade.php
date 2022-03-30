@extends('layouts.app')

@section('content')
    <div class="row mb-2">
        <div class="col-10 my-auto">
            <h2>{{ $project->name }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('tasks.index') }}">{{ __('modules.projects') }}</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>{{ $project->name }}</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('tasks.index') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>

    </div>

    <tasks project="{{ json_encode($project) }}" tasks="{{ json_encode($tasks) }}"
        store="{{ auth()->user()->can('store Tareas') }}" update="{{ auth()->user()->can('update Tareas') }}"
        delete="{{ auth()->user()->can('delete Tareas') }}"></tasks>
@endsection

@push('scripts')
    <script src="{{ url('/') }}/js/tables.js"></script>
@endpush
