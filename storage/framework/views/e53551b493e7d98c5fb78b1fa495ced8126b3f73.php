<?php $__env->startSection('content'); ?>
    <h1 class="mt-3"><?php echo e($title); ?></h1><hr>
    <?php if($status): ?>
        <div class="alert alert-<?php echo e($status['alert']); ?>">
            <?php echo e($status['message']); ?>

        </div>
    <?php endif; ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('fileStorageIndex')); ?>">Методология</a></li>
            <?php $__currentLoopData = $breadcrumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($item === end($breadcrumb)): ?>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo e($item['name']); ?></li>
                <?php else: ?>
                    <li class="breadcrumb-item"><a href="<?php echo e($item['link']); ?>"><?php echo e($item['name']); ?></a></li>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ol>
    </nav>
    <button class="btn btn-primary" data-toggle="modal" data-target="#createFolderModal">Создать папку</button><hr>
    <form class="upload-file-form" method="post" action="<?php echo e(route('fileStorageLoad')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="input-group">
            <input type="text" value="<?php echo e($folder); ?>" name="path" hidden>
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
    <?php if(!$dataDirectories->isEmpty()): ?>
        <hr>
        <h4>Список папок</h4>
        <div class="container-fluid">
            <div class="row">
                <?php $__currentLoopData = $dataDirectories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $directory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-2 text-center fileStorageBlock">
                        <a
                            href="<?php echo e(route('fileStorageShow', ['folder' => $directory['path']])); ?>"
                            class="fileStorageLink"
                            role="button">
                            <?php if($directory['icon']): ?>
                                <div class="fileStorageImg" style="background-image:url(<?php echo e(asset('storage/' . $directory['url'] . '/folderIcon.jpg')); ?>)"></div>
                            <?php else: ?>
                                <div class="fileStorageImg" style="background-image:url(<?php echo e(asset('img/icons/files/folder_icon-icons.com_55318.svg')); ?>)"></div>
                            <?php endif; ?>
                                <h4 class="fileStorageText"><?php echo e($directory['name']); ?></h4>
                        </a>
                        <a class="edit-folder-modal"
                           data-name="<?php echo e($directory['name']); ?>"
                        >
                            <img class="edit-icon"
                             src="<?php echo e(__('icons.officeIcons.edit')); ?>"
                             role="button"
                            >
                        </a>
                        <a href="<?php echo e(route('deleteFolder', ['path' => $directory['path']])); ?>">
                            <img class="delete-icon"
                                 src="<?php echo e(__('icons.officeIcons.delete')); ?>"
                                 role="button"
                            >
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if(!$dataFiles->isEmpty()): ?>
    <hr>
    <h4>Список файлов</h4>
    <div class="container-fluid">
        <div class="row">
            <?php $__currentLoopData = $dataFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-2 text-center fileStorageBlock">
                    <a
                        href="<?php echo e(route('fileStorageDownload', ['path' => $file['path']])); ?>"
                        class="fileStorageLink"
                        role="button">
                        <div class="fileStorageImg" style="background-image:url(<?php echo e(__('icons.fileIcons.' . $file['extension'])); ?>)"></div>
                        <h4 class="fileStorageText"><?php echo e($file['fileName']); ?> <?php echo e($file['extension']); ?><br>[<?php echo e($file['size']); ?>]</h4>
                    </a>
                    <a class="edit-file-modal"
                       data-name="<?php echo e($file['fileName']); ?>"
                       data-basename="<?php echo e($file['basename']); ?>"
                       data-extension="<?php echo e($file['extension']); ?>"
                    >
                        <img class="edit-icon"
                             src="<?php echo e(__('icons.officeIcons.edit')); ?>"
                             role="button"
                        >
                    </a>
                    <a href="<?php echo e(route('deleteFile', ['path' => $file['path']])); ?>">
                        <img class="delete-icon"
                             src="<?php echo e(__('icons.officeIcons.delete')); ?>"
                             role="button"
                        >
                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>
    <!-- Modal -->
    <?php echo $__env->make('pmo.files.createFolder', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('pmo.files.editFolder', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('pmo.files.editFile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('styles'); ?>
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
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\OSPanel\domains\BPM\resources\views/pmo/files/index.blade.php ENDPATH**/ ?>