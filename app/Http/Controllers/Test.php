<?php

namespace App\Http\Controllers;


class Test extends Controller
{
    public function budget()
    {
        return view('index', [
            'title' => 'Бюджет ИТ'
        ]);
    }

    public function project()
    {
        return view('index', [
            'title' => 'Проекты'
        ]);
    }

    public function contract()
    {
        return view('index', [
            'title' => 'Договоры'
        ]);
    }

    public function library()
    {
        return view('index', [
            'title' => 'Справочники'
        ]);
    }

    public function maintenance()
    {
        return view('index', [
            'title' => 'Программы поддержания'
        ]);
    }

    public function scenario()
    {
        return view('index', [
            'title' => 'Сценарии'
        ]);
    }

    public function report()
    {
        return view('index', [
            'title' => 'Отчетность'
        ]);
    }

    public function document()
    {
        return view('index', [
            'title' => 'Документы'
        ]);
    }

    public function integration()
    {
        return view('index', [
            'title' => 'Интеграции'
        ]);
    }
}
