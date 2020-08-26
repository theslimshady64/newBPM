@extends('layout')

@section('content')
    <h1 class="mt-3">{{ $title }}</h1><hr>
    @if($status)
        <div class="alert alert-{{ $status['alert'] }}">
            {{ $status['message'] }}
        </div>
    @endif
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('fileStorageIndex') }}">Методология</a></li>
            @foreach($breadcrumb as $item)
                @if($item === end($breadcrumb))
                    <li class="breadcrumb-item active" aria-current="page">{{ $item['name'] }}</li>
                @else
                    <li class="breadcrumb-item"><a href="{{ $item['link'] }}">{{ $item['name'] }}</a></li>
                @endif
            @endforeach
        </ol>
    </nav>
    <button class="btn btn-primary" data-toggle="modal" data-target="#createFolderModal">Создать папку</button><hr>
    <form class="upload-file-form" method="post" action="{{ route('fileStorageLoad') }}" enctype="multipart/form-data">
        @csrf
        <div class="input-group">
            <input type="text" value="{{ $folder }}" name="path" hidden>
            <div class="custom-file">
                <input id="logo" type="file" class="custom-file-input" name="loadFile">
                <label for="logo" class="custom-file-label text-truncate">Выберите файл...</label>
            </div>
            <span class="input-group-btn">
            <button class="btn btn-primary ml-2"
                    type="submit"
                    data-toggle="tooltip"
                    data-placement="top"
                    data-original-title="Tooltip on top">
                Загрузить
            </button>
        </span>
        </div>
        <div id="e-fileinfo"></div>
    </form>
    @if(!$dataDirectories->isEmpty())
        <hr>
        <h4>Список папок</h4>
        <div class="container-fluid">
            <div class="row">
                @foreach($dataDirectories as $directory)
                    <div class="col-md-2 text-center fileStorageBlock">
                        <a
                            href="{{ route('fileStorageShow', ['folder' => $directory['path']]) }}"
                            class="fileStorageLink"
                            role="button">
                            @if($directory['icon'])
                                <div class="fileStorageImg" style="background-image:url({{ asset('storage/' . $directory['url'] . '/folderIcon.jpg') }})"></div>
                            @else
                                <div class="fileStorageImg" style="background-image:url({{ asset('img/icons/files/folder_icon-icons.com_55318.svg') }})"></div>
                            @endif
                                <h4 class="fileStorageText">{{ $directory['name'] }}</h4>
                        </a>
                        <a class="edit-folder-modal"
                           data-name="{{ $directory['name'] }}"
                        >
                            <img class="edit-icon"
                             src="{{ __('icons.officeIcons.edit') }}"
                             role="button"
                            >
                        </a>
                        <a href="{{ route('deleteFolder', ['path' => $directory['path']]) }}">
                            <img class="delete-icon"
                                 src="{{ __('icons.officeIcons.delete') }}"
                                 role="button"
                            >
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    @if(!$dataFiles->isEmpty())
    <hr>
    <h4>Список файлов</h4>
    <div class="container-fluid">
        <div class="row">
            @foreach($dataFiles as $file)
                <div class="col-md-2 text-center fileStorageBlock">
                    <a
                        href="{{ route('fileStorageDownload', ['path' => $file['path']]) }}"
                        class="fileStorageLink"
                        role="button">
                        <div class="fileStorageImg" style="background-image:url({{ __('icons.fileIcons.' . $file['extension']) }})"></div>
                        <h4 class="fileStorageText">{{ $file['fileName'] }} {{ $file['extension'] }}<br>[{{ $file['size'] }}]</h4>
                    </a>
                    <a class="edit-file-modal"
                       data-name="{{ $file['fileName'] }}"
                       data-basename="{{ $file['basename'] }}"
                       data-extension="{{ $file['extension'] }}"
                    >
                        <img class="edit-icon"
                             src="{{ __('icons.officeIcons.edit') }}"
                             role="button"
                        >
                    </a>
                    <a href="{{ route('deleteFile', ['path' => $file['path']]) }}">
                        <img class="delete-icon"
                             src="{{ __('icons.officeIcons.delete') }}"
                             role="button"
                        >
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    @endif
    <!-- Modal -->
    @include('pmo.files.createFolder')
    @include('pmo.files.editFolder')
    @include('pmo.files.editFile')
@endsection
@push('styles')
    <style>
        .fileStorageImg {
            width: 150px;
            height: 200px;
            background-size: 100%;
            background-position: 50%;
            background-repeat: no-repeat;
            margin: auto;
        }
        .fileStorageBlock .edit-icon {
            position: absolute;
            top: 0;
            right: 35px;
            width: 30px;
            display: none;
        }
        .fileStorageBlock .delete-icon {
            position: absolute;
            top: 0;
            right: 0;
            width: 30px;
            display: none;
        }
        .fileStorageBlock:hover {
            box-shadow: 0px 0px 0px 1px #777;
            border-radius: 5px;
        }
        .fileStorageBlock:hover .edit-icon,
        .fileStorageBlock:hover .delete-icon {
            display: block;
        }
    </style>
@endpush
@push('scripts')
    <script>
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        $('.edit-folder-modal').click(function(){
            let name = $(this).data('name');
            $('#editFolderName').val(name);
            $('#oldFolderName').val(name);
            $('#editFolderModal').modal('show');
        });

        $('.edit-file-modal').click(function(){
            let name = $(this).data('name');
            let basename = $(this).data('basename');
            let extension = $(this).data('extension');
            $('#editFileName').val(name);
            $('#oldFileName').val(basename);
            $('#extension').val(extension);
            $('#editFileModal').modal('show');
        });
    </script>
@endpush
