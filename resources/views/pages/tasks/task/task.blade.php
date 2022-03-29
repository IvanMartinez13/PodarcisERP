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
            <a href="{{ route('tasks.project.details', $project->token) }}"
                class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
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
                                <span id="stateLabel" onclick="changeState()" style="cursor: pointer"
                                    class="label  @if ($task->is_done == 1) label-primary @else label-danger @endif ">
                                    @if ($task->is_done == 1)
                                        Finalizado
                                    @else
                                        Activo
                                    @endif
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
                                    <div id="progress" style="width: {{ $progress }}%;"
                                        class="progress-bar progress-bar-striped progress-bar-animated"></div>
                                </div>
                                <small>Completado en un <strong id="progress_text">{{ $progress }}%</strong>.</small>
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
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#files">{{ __('modules.files') }}
                                </a>
                            </li>
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

                                                            <textarea id="comment" name="comment" class="form-control"></textarea>

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
                                    <subtasks task={{ json_encode($task->token) }}
                                        store="{{ auth()->user()->can('store Tareas') }}"
                                        update="{{ auth()->user()->can('update Tareas') }}"
                                        delete="{{ auth()->user()->can('delete Tareas') }}"></subtasks>
                                </div>
                            </div>

                            {{-- TAB FILES --}}
                            <div role="tabpanel" id="files" class="tab-pane">
                                <div class="panel-body">
                                    <form action="{{ route('tasks.project.addFiles') }}" method="POST"
                                        class="dropzone  mb-5" id="add-files">
                                        @csrf

                                        <input name="token" type="hidden" value="{{ $task->token }}">

                                        <div class="dz-message" style="height:200px;">
                                            {{ __('forms.files') }}
                                        </div>

                                        <div class="dropzone-previews"></div>

                                    </form>

                                    <table class="table table-striped table-hover table-bordered js_datatable">
                                        <thead>
                                            <tr>
                                                <th>{{ __('columns.name') }}</th>
                                                <th>{{ __('columns.actions') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody id="files_list">
                                            @foreach ($tasks_files as $file)
                                                <tr>
                                                    <td class="align-middle">
                                                        {{ $file->name }}
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <div class="btn-group-vertical">

                                                            @can('update Tareas')
                                                                <button class="btn btn-link" data-toggle="modal"
                                                                    data-target="#updateFile_{{ $file->token }}">
                                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                                </button>
                                                            @endcan


                                                            <a class="btn btn-link" target="_BLANK"
                                                                href="{{ url('/storage') . $file->path }}">
                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                            </a>

                                                            @can('delete Tareas')
                                                                <button onclick="remove('{{ $file->token }}')"
                                                                    class="btn btn-link">
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

    @foreach ($tasks_files as $file)
        <div class="modal fade" id="updateFile_{{ $file->token }}" tabindex="-1"
            aria-labelledby="updateFile_{{ $file->token }}Label" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-primary">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateFile_{{ $file->token }}Label">{{ __('forms.update') }}
                            {{ __('modules.files') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('tasks.file.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        <input name="token" type="hidden" value="{{ $file->token }}">
                        <div class="modal-body bg-white text-dark">
                            <div class="form-group">
                                <label for="name_{{ $file->token }}">{{ __('forms.name') }}:</label>
                                <input type="text" name="name" id="name_{{ $file->token }}" class="form-control"
                                    placeholder="{{ __('forms.name') }}..." value="{{ $file->name }}">
                            </div>

                            <div class="form-group">
                                <label for="name_{{ $file->token }}">{{ __('forms.fileLabel') }}:</label>
                                <div class="custom-file">
                                    <input id="file{{ $file->token }}" name="file" type="file" class="custom-file-input">
                                    <label for="file{{ $file->token }}"
                                        class="custom-file-label">{{ __('forms.file') }}</label>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer bg-white text-dark">

                            <button type="submit" class="btn btn-primary">{{ __('forms.update') }}</button>
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ __('forms.close') }}</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>

        <form id="delete_{{ $file->token }}" action="{{ route('tasks.project.deleteFile') }}" method="post">
            @csrf
            @method('put')
            <input name="token" type="hidden" value="{{ $file->token }}" />
        </form>
    @endforeach
@endsection

@push('scripts')
    <script src="{{ url('/') }}/js/tables.js"></script>



    <script>
        $(document).ready(() => {
            $('#comment').summernote({
                placeholder: "{{ __('forms.comment') }}...",
                height: 100
            });

            bsCustomFileInput.init();
        });


        Dropzone.options.addFiles = {
            autoProcessQueue: true,
            uploadMultiple: true,
            maxFilezise: 10,
            maxFiles: 100,

            init: function() {

                myDropzone = this;

                this.on("addedfile", function(file) {
                    console.log(file)

                    var data = new FileReader;
                    data.readAsDataURL(file);

                    $(data).on("load", function(event) {

                        var path = event.target.result;

                        $("#imgUser").attr("src", path);

                    })
                });

                this.on("complete", function(file) {
                    myDropzone.removeFile(file);

                });

                this.on("successmultiple", (file, response) => {
                    toastr.success(response.message)
                    myDropzone.processQueue.bind(myDropzone)
                    //ADD ROW TO TABLE
                    response.task_files.map((task_file) => {
                        $('#files_list').append(
                            `<tr>
                            <td class="align-middle">
                                ${task_file.name}
                            </td>
                            <td class="align-middle text-center">
                                <div class="btn-group-vertical">

                                    
                                    <button class="btn btn-link" data-toggle="modal" data-target="#updateFile_${task_file.token}">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </button>

                                    <a class="btn btn-link" target="_BLANK" href="/storage/${task_file.path}">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>

                                    <button class="btn btn-link">
                                        <i class="fa fa-trash-alt" aria-hidden="true"></i>
                                    </button>

                                    
                                </div>
                            </td>
                         </tr>`
                        );

                        $('body').append(
                            `
                        <div class="modal fade" id="updateFile_${task_file.token}" tabindex="-1" aria-labelledby="updateFile_${task_file.token}Label" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                            <div class="modal-content bg-primary">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateFile_${task_file.token}Label">{{ __('forms.update') }} {{ __('modules.files') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="/tasks/project/task/file/update" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')

                                    <input name="token" type="hidden" value="${task_file.token}">
                                    <div class="modal-body bg-white text-dark">
                                        <div class="form-group">
                                        <label for="name_${task_file.token}">{{ __('forms.name') }}:</label>
                                        <input type="text" name="name" id="name_${task_file.token}" class="form-control" placeholder="{{ __('forms.name') }}..." value="${task_file.name}">
                                        </div>
                    
                                        <div class="form-group">
                                            <label for="name_${task_file.token}">{{ __('forms.fileLabel') }}:</label>
                                            <div class="custom-file">
                                                <input id="file${task_file.token}" name="file" type="file" class="custom-file-input">
                                                <label for="file${task_file.token}" class="custom-file-label">{{ __('forms.file') }}</label>
                                            </div> 
                                        </div>
                    
                                    </div>

                                    <div class="modal-footer bg-white text-dark">
                                
                                        <button type="submit" class="btn btn-primary">{{ __('forms.update') }}</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('forms.close') }}</button>
                                    </div>
                                </form>


                            </div>
                            </div>
                        </div>
                        `
                        );
                    })


                });
            }
        }

        function changeState() {
            axios.post('/tasks/project/task/changeState', {
                token: '{{ $task->token }}'
            }).then((response) => {
                toastr.success(response.data.message);

                if (response.data.close == 1) {

                    $('#stateLabel').text('Finalizado');

                    document.getElementById('stateLabel').classList.remove('label-danger');
                    document.getElementById('stateLabel').classList.add('label-primary');

                    $('#progress').css({
                        'width': response.data.progress + "%"
                    });

                    $('#progress_text').text(response.data.progress + "%");

                } else {
                    $('#stateLabel').text('Activo');

                    document.getElementById('stateLabel').classList.remove('label-primary');
                    document.getElementById('stateLabel').classList.add('label-danger');

                    $('#progress').css({
                        'width': response.data.progress + "%"
                    });

                    $('#progress_text').text(response.data.progress + "%");

                }


            })
        }

        function remove(token) {

            swal({
                title: "{{ __('Are you sure?') }}",
                text: "{{ __('You will not be able to recover this subtask!') }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ed5565",
                confirmButtonText: "Si, deseo eliminarla",
                closeOnConfirm: false,
                cancelButtonColor: "#ed5565",
                cancelButtonText: "Cancelar",
            }, function() {
                $('#delete_' + token).submit();

            });

        }
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
