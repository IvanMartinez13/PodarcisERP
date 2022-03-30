@extends('layouts.app')

@section('content')
    <div class="row mb-2">
        <div class="col-10 my-auto">
            <h2>{{ __('modules.tasks') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>{{ __('modules.projects') }}</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('dashboard') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>

    </div>

    <div class="ibox">
        <div class="ibox-title">
            <h5>{{ __('modules.projects') }}</h5>
            <a href="{{ route('tasks.project.create') }}" class="btn btn-primary">
                {{ __('forms.create') }}
            </a>

            <div class="ibox-tools">
                <a href="" class="collapse-link">
                    <i class="fa fa-chevron-up" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        <div class="ibox-content">
            <div class="container-fluid table-responsive">
                <table class="table table-striped table-hover table-bordered js_datatable">
                    <thead>
                        <tr>
                            <th style="width: 20%">{{ __('columns.name') }}</th>
                            <th style="width: 50%">{{ __('columns.description') }}</th>
                            <th style="width: 20%">{{ __('columns.color') }}</th>
                            <th style="width: 10%">{{ __('columns.actions') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($projects as $key => $project)
                            <tr>
                                <td class="align-middle">
                                    {{ $project->name }}
                                </td>
                                <td class="align-middle">
                                    {!! $project->description !!}
                                </td>
                                <td class="align-middle">
                                    <div class="rounded text-center p-1"
                                        style="background-color: {{ $project->color }};">
                                        {{ $project->color }}
                                    </div>
                                </td>
                                <td class="text-center align-middle">
                                    <div class="btn-group-vertical">


                                        @can('update Tareas')
                                            <a href="{{ route('tasks.project.edit', $project->token) }}"
                                                class="btn btn-link">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                            </a>

                                            <a href="{{ route('tasks.project.details', $project->token) }}"
                                                class="btn btn-link">
                                                <i class="fa-solid fa-clipboard-check"></i>
                                            </a>
                                        @endcan

                                        @can('delete Tareas')
                                            <button onclick="remove('{{ $project->token }}')" class="btn btn-link">
                                                <i class="fa fa-trash-alt" aria-hidden="true"></i>
                                            </button>
                                        @endcan

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="ibox-footer">
            Podarcis SL. &copy; {{ date('Y') }}
        </div>
    </div>

    @foreach ($projects as $project)
        <form action="{{ route('tasks.project.delete') }}" id="delete_{{ $project->token }}" method="POST">
            @csrf
            @method('put')
            <input name="token" type="hidden" value="{{ $project->token }}">
        </form>
    @endforeach
@endsection

@push('scripts')

    <script src="{{ url('/') }}/js/tables.js"></script>

    <script>
        function remove(token) {
            swal({
                title: "{{ __('Are you sure?') }}",
                text: "{{ __('You will not be able to recover this project!') }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ed5565",
                confirmButtonText: "Si, deseo eliminarlo",
                closeOnConfirm: false,
                cancelButtonColor: "#ed5565",
                cancelButtonText: "Cancelar",
            }, function() {
                $('#delete_' + token).submit();

            });
        }
    </script>

    @if (session('status') == 'error')
        <script>
            $(document).ready(() => {
                toastr.error("{{ session('message') }}")
            })
        </script>
    @endif

    @if (session('status') == 'success')
        <script>
            $(document).ready(() => {
                toastr.success("{{ session('message') }}")
            })
        </script>
    @endif
@endpush
