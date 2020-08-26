<nav class="navbar navbar-expand navbar-light bg-primary">
    <div class="col-2"></div>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item <?php echo e(Route::currentRouteName() == 'budget' ? 'active' : ''); ?>">
                <a class="nav-link" href="<?php echo e(route('budget')); ?>">Бюджет ИТ</a>
            </li>
            <li class="nav-item <?php echo e(Route::currentRouteName() == 'project' ? 'active' : ''); ?>">
                <a class="nav-link" href="<?php echo e(route('project')); ?>">Проекты</a>
            </li>
            <li class="nav-item <?php echo e(Route::currentRouteName() == 'contract' ? 'active' : ''); ?>">
                <a class="nav-link" href="<?php echo e(route('contract')); ?>">Договоры</a>
            </li>
            <li class="nav-item <?php echo e(Route::currentRouteName() == 'library' ? 'active' : ''); ?>">
                <a class="nav-link" href="<?php echo e(route('library')); ?>">Справочники</a>
            </li>
            <li class="nav-item <?php echo e(Route::currentRouteName() == 'maintenance' ? 'active' : ''); ?>">
                <a class="nav-link" href="<?php echo e(route('maintenance')); ?>">Программы поддержания</a>
            </li>
            <li class="nav-item <?php echo e(Route::currentRouteName() == 'scenario' ? 'active' : ''); ?>">
                <a class="nav-link" href="<?php echo e(route('scenario')); ?>">Сценарии</a>
            </li>
            <li class="nav-item <?php echo e(Route::currentRouteName() == 'report' ? 'active' : ''); ?>">
                <a class="nav-link" href="<?php echo e(route('report')); ?>">Отчетность</a>
            </li>
            <li class="nav-item <?php echo e(Route::currentRouteName() == 'document' ? 'active' : ''); ?>">
                <a class="nav-link" href="<?php echo e(route('document')); ?>">Документы</a>
            </li>
            <li class="nav-item <?php echo e(Route::currentRouteName() == 'integration' ? 'active' : ''); ?>">
                <a class="nav-link" href="<?php echo e(route('integration')); ?>">Интеграции</a>
            </li>
            <li class="nav-item <?php echo e(Route::currentRouteName() == 'fileStorageIndex' ? 'active' : ''); ?>">
                <a class="nav-link" href="<?php echo e(route('fileStorageIndex')); ?>">Методология</a>
            </li>
        </ul>
    </div>
</nav>
<?php /**PATH D:\OSPanel\domains\BPM\resources\views/layouts/nav.blade.php ENDPATH**/ ?>