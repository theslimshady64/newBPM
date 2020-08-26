<div class="modal fade" id="editFolderModal" tabindex="-1" role="dialog" aria-labelledby="editFolderLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFolderLabel">Редактирование папки</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('editFolder') }}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="folderName">Наименование</label>
                        <input class="form-control" type="text" id="editFolderName" name="editFolderName" required>
                        <small id="emailHelp" class="form-text text-muted">Введите название для папки</small>
                    </div>
                    <div class="form-group">
                        <label for="folderImage">Изображение</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="editFolderImage" name="editFolderImage" value="">
                            <label for="folderImage" class="custom-file-label text-truncate">Выберите файл...</label>
                        </div>
                        <small id="emailHelp" class="form-text text-muted">Выберите изображение для папки</small>
                    </div>

                    <input type="text" name="currentDirectory" hidden
                           @if (isset($folder))
                           value="{{ $folder }}">
                    @else
                        >
                    @endif

                    <input type="text" id="oldFolderName" name="oldFolderName" hidden value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
