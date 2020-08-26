<!doctype html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, instal-scale=1.0">
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet" type="text/css">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<header class="bg-white" style="height: 100px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-2">
                <!-- лого -->
                <div class="page_head_logo" style="width: 240px; background-color: #fff; position: absolute; padding: 13px 20px; z-index: 1;">
                    <a href="/"><img src="/img/logo.png" alt="Rosneft logo" style="width: 100%;"></a>
                </div>
            </div>
            <div class="col-9">
                <!-- заголовок -->
                <div class="page_head_title" style="font-size: 28px;height: 100px;padding-top: 30px;">
                    Портал управления портфелем ИТ-проектов
                </div>
            </div>
            <div class="col-1">
                <!-- информация о пользователе -->
                <div class="page_head_user" style="height: 100px;padding-top: 30px;">
                    <a href='#'>Тамочкин А.В.</a>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- панель меню -->
<?php echo $__env->make('layouts/nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<body>
    <div class="container-fluid pt-2 pb-5 bg-white">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
    <?php echo $__env->make('layouts/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js')); ?>" type="text/javascript"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\OSPanel\domains\BPM\resources\views/layout.blade.php ENDPATH**/ ?>