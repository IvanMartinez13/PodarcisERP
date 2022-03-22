@extends('layouts.app')

@section('content')
    <div class="row mb-2">

        <div class="col-10 my-auto">
            <h2>{{ $layer->name }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('vao.index') }}">{{ __('modules.vao') }}</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('vao.details', $vao->token) }}">{{ $vao->title }}</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>{{ $layer->name }}</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('vao.details', $vao->token) }}"
                class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>

    </div>

    <div class="ibox">
        <div class="ibox-title">
            <h5>
                {{ __('forms.update') . ' ' . $layer->name }}
            </h5>

            <div class="ibox-tools">
                <a role="button" class="collapse-link">
                    <i class="fa fa-chevron-up" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        <div class="ibox-content ">

            <div class="mx-5">
                <form action="{{ route('vao.update.layer') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <input name="token" type="hidden" value="{{ $layer->token }}">
                    <div class="row">
                        <div class="col-lg-6 mb-3  @error('name') has-error @enderror">
                            <label for="name">{{ __('forms.name') }}:</label>
                            <input id="name" name="name" type="text" value="{{ $layer->name }}"
                                placeholder="{{ __('forms.name') }}..." class="form-control">
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="file">{{ __('forms.fileLabel') }}:</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input id="file" type="file" name="file" class="custom-file-input">
                                    <label class="custom-file-label" for="file">{{ __('forms.file') }}</label>
                                </div>
                            </div>

                        </div>


                        <div class="col-lg-6 mb-3">
                            <label for="typeSelector">{{ __('forms.type') }}:</label>
                            <select id="typeSelector" name="type" class="form-control">
                                <option></option>
                                <option value="shape" @if ($layer->type == 'shape') selected @endif>ShapeFile</option>
                                <option value="kml" @if ($layer->type == 'kml') selected @endif>KML</option>
                            </select>
                        </div>


                        <div class="col-lg-6 mb-3">
                            <label for="group">{{ __('forms.group') }}:</label>
                            <select id="groupSelector" name="group" class="form-control">
                                <option></option>
                                @foreach ($layer_groups as $group)
                                    <option value="{{ $group->token }}"
                                        @if ($layer->group->id == $group->id) selected @endif>
                                        {{ $group->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="text-right">
                        <button class="btn btn-primary">
                            {{ __('forms.update') }}
                        </button>
                    </div>

                </form>
            </div>


        </div>

        <div class="ibox-footer">
            Podarcis SL. &copy; {{ date('Y') }}
        </div>
    </div>
@endsection

@push('scripts')

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                $(document).ready(() => {
                    toastr.error("{{ $error }}")
                })
            </script>
        @endforeach
    @endif

    <script>
        $(document).ready(() => {
            bsCustomFileInput.init();

            $('#typeSelector').select2({
                theme: "bootstrap4",
                placeholder: "{{ __('forms.type') }}..."
            });

            $('#groupSelector').select2({
                theme: "bootstrap4",
                placeholder: "{{ __('forms.group') }}..."
            })


        })
    </script>
@endpush
