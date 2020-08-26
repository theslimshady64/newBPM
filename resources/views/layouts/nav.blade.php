<nav class="navbar navbar-expand navbar-light bg-primary">
    <div class="col-2"></div>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item {{ Route::currentRouteName() == 'budget' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('budget') }}">Бюджет ИТ</a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'project' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('project') }}">Проекты</a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'contract' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('contract') }}">Договоры</a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'library' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('library') }}">Справочники</a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'maintenance' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('maintenance') }}">Программы поддержания</a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'scenario' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('scenario') }}">Сценарии</a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'report' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('report') }}">Отчетность</a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'document' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('document') }}">Документы</a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'integration' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('integration') }}">Интеграции</a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'fileStorageIndex' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('fileStorageIndex') }}">Методология</a>
            </li>
        </ul>
    </div>
</nav>
