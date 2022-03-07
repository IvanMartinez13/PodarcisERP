@extends('layouts.app')

@section('content')
    <div class="row mb-2">
        <div class="col-10 my-auto">
            <h2>{{ $task->name }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('tasks.index') }}">{{ __('modules.projects') }}</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('tasks.project.details', $project->token) }}">{{ $project->name }}</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>{{ $task->name }}</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('tasks.project.details', $project->token) }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-9">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>{{ $task->name }}</h5>

                    <div class="ibox-tools">
                        <a role="button" class="collapse-link">
                            <i class="fa fa-chevron-up" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    <div class="row mb-3">
                        <div class="col-sm-2 text-right">
                            <dt>{{ __('columns.status') }}:</dt>
                        </div>

                        <div class="col-sm-10 text-left">
                            <dd>
                                <span class="label {{ $task->id_done ? 'label-primary' : 'label-danger' }}">
                                    {{ $task->id_done ? 'Finalizado' : 'Activo' }}
                                </span>
                            </dd>
                        </div>

                        <div class="col-sm-2 text-right">
                            <dt>{{ __('columns.departaments') }}:</dt>
                        </div>

                        <div class="col-sm-10 text-left">
                            <dd>
                                @foreach ($task->departaments as $key => $departament)
                                    @if ($key + 1 == count($task->departaments))
                                        {{ $departament->name }}
                                    @else
                                        {{ $departament->name }},
                                    @endif
                                @endforeach
                            </dd>
                        </div>

                        <div class="col-sm-2 text-right">
                            <dt>{{ __('columns.description') }}:</dt>
                        </div>

                        <div class="col-sm-10 text-left">
                            <dd>
                                {!! $task->description !!}
                            </dd>
                        </div>

                        <div class="col-sm-2 text-right">
                            <dt>{{ __('columns.progress') }}:</dt>
                        </div>

                        <div class="col-sm-10 text-left">
                            <dd>
                                <div class="progress m-b-1">
                                    <div id="progress" style="width: {{$progress}}%;"
                                        class="progress-bar progress-bar-striped progress-bar-animated"></div>
                                </div>
                                <small>Completado en un <strong id="progress_text">{{$progress}}%</strong>.</small>
                            </dd>
                        </div>
                    </div>

                    {{-- TAB-CONTAINER --}}
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li><a class="nav-link active" data-toggle="tab"
                                    href="#comments">{{ __('modules.comments') }}</a></li>
                            <li><a class="nav-link" data-toggle="tab"
                                    href="#sub_tasks">{{ __('modules.sub_tasks') }}</a></li>
                        </ul>
                        <div class="tab-content">
                            {{-- TAB COMMENTS --}}
                            <div role="tabpanel" id="comments" class="tab-pane active">
                                <div class="panel-body">
                                    <div class="animated fadeIn">
                                        {{-- CONTENIDO DE LOS COMENTARIOS --}}

                                        <div class="feed-activity-list">
                                            @can('update Tareas')
                                                <div class="feed-element">
                                                    <a href="#" class="float-left">

                                                        @if (auth()->user()->profile_photo)
                                                            <img class="rounded-circle"
                                                                src="{{ url('/storage') . auth()->user()->profile_photo }}"
                                                                alt="" width="38px">
                                                        @else
                                                            <img class="rounded-circle"
                                                                src="{{ url('/img/user_placeholder.png') }}" alt=""
                                                                width="38px">
                                                        @endif

                                                    </a>

                                                    <div class="media-body ">
                                                        <small class="float-right">{{ date('d/m/Y H:i') }}</small>
                                                        <strong>{{ auth()->user()->name }}</strong>:
                                                        <form action="{{ route('tasks.project.task_comment') }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('put')
                                                            <input name="token" type="hidden" value="{{ $task->token }}">

                                                            <textarea id="comment" name="comment"
                                                                class="form-control"></textarea>

                                                            <div class="text-right mt-3">
                                                                <button type="submit" class="btn btn-primary">
                                                                    {{ __('forms.send') }}
                                                                </button>
                                                            </div>

                                                        </form>

                                                    </div>
                                                </div>
                                            @endcan
                                            {{-- COMMENT LIST --}}

                                            @foreach ($comments as $comment)
                                                <div class="feed-element">
                                                    <a href="#" class="float-left">
                                                        @if ($comment->user->profile_photo)
                                                            <img class="rounded-circle"
                                                                src="{{ url('/storage') . $comment->user->profile_photo }}"
                                                                alt="" width="38px">
                                                        @else
                                                            <img class="rounded-circle"
                                                                src="{{ url('/img/user_placeholder.png') }}" alt=""
                                                                width="38px">
                                                        @endif

                                                    </a>

                                                    <div class="media-body ">
                                                        <small
                                                            class="float-right">{{ date('d/m/Y H:i', strtotime($comment->created_at)) }}</small>
                                                        <strong>{{ $comment->user->name }}</strong>:

                                                        <div class="well">
                                                            {!! $comment->comment !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach


                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- TAB SUB TASKS --}}
                            <div role="tabpanel" id="sub_tasks" class="tab-pane">
                                <div class="panel-body">
                                    <subtasks task={{ json_encode($task->token) }}></subtasks>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="ibox-footer">
                    Podarcis SL. &copy; {{ date('Y') }}
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <h4>{{ $project->name }}</h4>

            @if ($project->image)
                <img src="{{ url('/storage') . $project->image }}" alt="{{ $project->name }}" class="img-fluid mb-3">
            @endif

            {!! $project->description !!}

            <small>
                <i class="fa fa-circle" aria-hidden="true" style="color: {{ $project->color }}"></i>
                {{ $project->color }}
            </small>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(() => {
            $('#comment').summernote({
                placeholder: "{{ __('forms.comment') }}...",
                height: 100
            })
        })
    </script>

    @foreach ($errors->all() as $error)
        <script>
            $(document).ready(() => {
                toastr.error("{{ $error }}")
            })
        </script>
    @endforeach

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
