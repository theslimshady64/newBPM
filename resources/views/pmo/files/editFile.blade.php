<div class="modal fade" id="editFileModal" tabindex="-1" role="dialog" aria-labelledby="editFileLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFileLabel">Редактирование файла</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('editFile') }}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="folderName">Наименование</label>
                        <input class="form-control" type="text" id="editFileName" name="editFileName" required>
                        <small id="emailHelp" class="form-text text-muted">Введите название для файла</small>
                    </div>

                    <input type="text" name="currentDirectory" hidden
                           @if (isset($folder))
                           value="{{ $folder }}">
                    @else
                        >
                    @endif

                    <input type="text" id="oldFileName" name="oldFileName" hidden>
                    <input type="text" id="extension" name="extension" hidden>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
