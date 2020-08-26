<?php

namespace App\Http\Controllers;

use App\Catalog\ConversionMetrics;
use App\Catalog\Transliteral;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class FileStorageController extends Controller
{
    public function index()
    {
        $folder = '';
        return $this->show($folder);
    }

    public function show($folder)
    {
        if($folder){
            $folder = str_replace("-", "/", $folder);
        }
        /** Получаем список директорий относительно папки storage/app/public */
        $directories = Storage::directories('public/' . $folder);

        /** Получаем список файлов находящихся в директории */
        $files = Storage::files('public/' . $folder);

        /** Создаем пустую коллекцию для метаданных файлов и их url */
        $dataFiles = collect();

        /** Создаем пустую коллекцию для папок и их url */
        $dataDirectories = collect();

        /** Заполняем коллекцию ссылками */
        foreach ($files as $key => $file) {
            if($file != 'public/' . $folder . '/folderIcon.jpg') {
                $fileInfo = pathinfo($file);

                $fileNameRefactor = preg_replace('|_+|', ' ', $fileInfo['filename'], 1);
                $fileName = Transliteral::transliterateen($fileNameRefactor);

                if ($folder) {
                    $path = str_replace("/", "-", $folder) . '-' . $fileInfo['basename'];
                } else {
                    $path = $fileInfo['basename'];
                }

                $dataFiles = $dataFiles->push([
                    'path' => $path,
                    'size' => ConversionMetrics::bytesToMegabytes(Storage::size($file)),
                    'fileName' => $fileName,
                    'basename' => $fileInfo['filename'],
                    'extension' => $fileInfo['extension'],
                ]);
            }
        }

        foreach ($directories as $directory){
            $directoryInfo = pathinfo($directory);

            $folderNameRefactor = preg_replace('|_+|', ' ', $directoryInfo['filename'], 1);
            $folderName = Transliteral::transliterateen($folderNameRefactor);

            $folderIcon = Storage::disk()->exists($directory . '\folderIcon.jpg');

            if($folder){
                $path = str_replace("/", "-", $folder) . '-' . $directoryInfo['basename'];
            }else{
                $path = $directoryInfo['basename'];
            }

            $url = str_replace("-", "/", $path);

            $dataDirectories = $dataDirectories->push([
                'url' => $url,
                'path' => $path,
                'name' => $folderName,
                'icon' => $folderIcon,
            ]);
        }

        $breadcrumb = [];
        $folderLink = '';

        if ($folder){
            foreach (explode("/", $folder) as $item){
                if($folderLink){
                    $folderLink .= '-' . $item;
                }else{
                    $folderLink .= $item;
                }
                $breadcrumb[] = [
                    'name' => Transliteral::transliterateen($item),
                    'basename' => $item,
                    'link' => $folderLink
                ];
            }
        }

        if (Session::has('success')){
            $status = [
                'message' => Session::get('success'),
                'alert' => 'success'
            ];
        }else if(Session::has('danger')){
            $status = [
                'message' => Session::get('danger'),
                'alert' => 'danger'
            ];
        }else{
            $status = '';
        }

        /** Возвращаем представление */
        return view('pmo.files.index', [
            'title' => 'Методология',
            'dataFiles' => $dataFiles,
            'dataDirectories' => $dataDirectories,
            'folder' => $folder,
            'breadcrumb' => $breadcrumb,
            'status' => $status,
        ]);
    }

    /**
     * Загрузка файла
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function load(Request $request)
    {
        /** Создаем паттерн, где есть список запрещенных файлов по расширению */
        $blacklist = '/.(com|bat|exe|cmd|vbs|msi|jar|php(\d?)|phtml|access|js)$/i';

        /** Если файл содержит запрещенное разрешение - выход с уведомлением*/
        if (preg_match($blacklist, $_FILES['loadFile']['name']))
        {
            return back()->with('danger', 'Файл с данным расширением запрещен к загрузке');
        }

        $path = $request->path;
        /** Проверка выбран ли файл для загрузки, если файл не выбран вернется сообщение в блоке */
        if ($_FILES['loadFile']['name'] == '') {
            return back()->with('danger', 'Выберите файл для загрузки');
        } else {
            $file = $request->file('loadFile');

            $originalFileName = preg_replace('| +|', '_', Transliteral::transliterate($_FILES['loadFile']['name']));

            Storage::disk('public')->putFileAs($path, $file, $originalFileName);

            return back();
        }
    }

    /**
     * Скачивание файла
     *
     */
    public function download($path)
    {
        $pathToFile = 'storage/' . str_replace("-", "\\", $path);

        return response()->download($pathToFile);
    }

    public function createFolder(Request $request)
    {
        $currentDirectory = iconv("utf-8", "windows-1251", $request->currentDirectory);

        /** Создаем паттерн, где есть список разрешенных файлов по расширению (изображений)*/
        $blacklist = '/.(jpg|jpeg|png)$/i';

        /** Проверяем при создании папки выбрано ли изображение */
        if(!empty($_FILES['folderImage']['name'])){

            /** Если файл выбран и это изображение и в названии только русские буквы, цифры и пробелы то продолжаем*/
            if (preg_match($blacklist, $_FILES['folderImage']['name']) && preg_match('/[[А-Яа-яёЁ0-9\s]+/',$request->folderName)) {

                /** Заменяем пробел в имени папки на нижнее подчеркивание */
                $folderName = str_replace(" ", "_", $request->folderName);

                if($currentDirectory){
                    $newDirectory = $currentDirectory . '/' . Transliteral::transliterate($folderName);
                }else{
                    $newDirectory = Transliteral::transliterate($folderName);
                }

                Storage::disk('public')->makeDirectory(Transliteral::transliterate($newDirectory));

                $file = $request->file('folderImage');

                $originalFileName = 'folderIcon.jpg';
                Storage::disk('public')->putFileAs(Transliteral::transliterate($newDirectory), $file, $originalFileName);

                /** Форматируем строку директории заменяем "-" на "/" */
                $folder = str_replace("/", "-", Transliteral::transliterate($newDirectory));

                if ($folder == '') {
                    return redirect()->route('fileStorageIndex');
                } else {
                    return redirect()->route('fileStorageShow', ['folder' => $folder]);
                }

            } else {
                /** Форматируем строку директории заменяем "-" на "/" */
                $folder = str_replace("/", "-", $currentDirectory);

                if ($folder == '') {
                    return redirect()
                        ->route('fileStorageIndex')
                        ->with('danger', 'Файл с данным расширением запрещен к загрузке или название папки содержит запрещенные символы');
                } else {
                    return redirect()
                        ->route('showFolder', ['folder' => $folder])
                        ->with('danger', 'Файл с данным расширением запрещен к загрузке или название папки содержит запрещенные символы');
                }
            }
        } else {
            /** Проверяем название так как без изображения можем сохранить только название директории */
            if (preg_match('/[А-Яа-яёЁ0-9\s]+/',$request->folderName)){
                /** Заменяем пробел в имени папки на нижнее подчеркивание */
                $folderName = str_replace(" ", "_", $request->folderName);

                if($currentDirectory){
                    $newDirectory = $currentDirectory . '/' . Transliteral::transliterate($folderName);
                }else{
                    $newDirectory = Transliteral::transliterate($folderName);
                }

                Storage::disk('public')->makeDirectory(Transliteral::transliterate($newDirectory));

                /** Форматируем строку директории заменяем "-" на "/" */
                $folder = str_replace("/", "-", $newDirectory);

                if ($folder == '') {
                    return redirect()->route('fileStorageIndex');
                } else {
                    return redirect()->route('fileStorageShow', ['folder' => $folder]);
                }
            } else {
                /** Форматируем строку директории заменяем "-" на "/" */
                $folder = str_replace("/", "-", $currentDirectory);

                if ($folder == '') {
                    return redirect()
                        ->route('fileStorageIndex')
                        ->with('danger', 'Название папки содержит запрещенные символы');
                } else {
                    return redirect()
                        ->route('showFolder', ['folder' => $folder])
                        ->with('danger', 'Название папки содержит запрещенные символы');
                }
            }
        }
    }

    public function editFolder(Request $request)
    {
        $currentDirectory = iconv("utf-8", "windows-1251", $request->currentDirectory);

        /** Создаем паттерн, где есть список разрешенных файлов по расширению (изображений)*/
        $blacklist = '/.(jpg|jpeg|png)$/i';

        /** Проверяем при создании папки выбрано ли изображение */
        if(!empty($_FILES['editFolderImage']['name'])){
            /** Если файл выбран и это изображение и в названии только русские буквы, цифры и пробелы то продолжаем*/
            if (preg_match($blacklist, $_FILES['editFolderImage']['name']) && preg_match('/[[А-Яа-яёЁ0-9\s]+/',$request->editFolderName)) {
                /** Заменяем пробел в имени папки на нижнее подчеркивание */
                $folderName = str_replace(" ", "_", $request->editFolderName);
                $oldFolderName = str_replace(" ", "_", $request->oldFolderName);

                if($currentDirectory){
                    $newDirectory = $currentDirectory . '/' . Transliteral::transliterate($folderName);
                    $oldDirectory = $currentDirectory . '/' . Transliteral::transliterate($oldFolderName);
                }else{
                    $newDirectory = Transliteral::transliterate($folderName);
                    $oldDirectory = Transliteral::transliterate($oldFolderName);
                }

                if($oldDirectory != $newDirectory){
                    Storage::disk('public')->move($oldDirectory, $newDirectory);
                }

                $file = $request->file('editFolderImage');

                $originalFileName = 'folderIcon.jpg';
                Storage::disk('public')->delete($oldDirectory . '/' . $originalFileName);
                Storage::disk('public')->putFileAs(Transliteral::transliterate($newDirectory), $file, $originalFileName);


                /** Форматируем строку директории заменяем "-" на "/" */
                $folder = str_replace("/", "-", Transliteral::transliterate($newDirectory));

                if ($folder == '') {
                    return redirect()->route('fileStorageIndex');
                } else {
                    return redirect()->route('fileStorageShow', ['folder' => $folder]);
                }
            }else{
                /** Форматируем строку директории заменяем "-" на "/" */
                $folder = str_replace("/", "-", $currentDirectory);

                if ($folder == '') {
                    return redirect()
                        ->route('fileStorageIndex')
                        ->with('danger', 'Файл с данным расширением запрещен к загрузке или название папки содержит запрещенные символы');
                } else {
                    return redirect()
                        ->route('showFolder', ['folder' => $folder])
                        ->with('danger', 'Файл с данным расширением запрещен к загрузке или название папки содержит запрещенные символы');
                }
            }
        }else{
            if (preg_match('/[А-Яа-яёЁ0-9\s]+/',$request->editFolderName)){
                /** Заменяем пробел в имени папки на нижнее подчеркивание */
                $folderName = str_replace(" ", "_", $request->editFolderName);
                $oldFolderName = str_replace(" ", "_", $request->oldFolderName);

                if($currentDirectory){
                    $newDirectory = $currentDirectory . '/' . Transliteral::transliterate($folderName);
                    $oldDirectory = $currentDirectory . '/' . Transliteral::transliterate($oldFolderName);
                }else{
                    $newDirectory = Transliteral::transliterate($folderName);
                    $oldDirectory = Transliteral::transliterate($oldFolderName);
                }

                Storage::disk('public')->move($oldDirectory, $newDirectory);

                /** Форматируем строку директории заменяем "-" на "/" */
                $folder = str_replace("/", "-", Transliteral::transliterate($newDirectory));

                if ($folder == '') {
                    return redirect()->route('fileStorageIndex');
                } else {
                    return redirect()->route('fileStorageShow', ['folder' => $folder]);
                }
            }else{
                /** Форматируем строку директории заменяем "-" на "/" */
                $folder = str_replace("/", "-", $currentDirectory);

                if ($folder == '') {
                    return redirect()
                        ->route('fileStorageIndex')
                        ->with('danger', 'Название папки содержит запрещенные символы');
                } else {
                    return redirect()
                        ->route('showFolder', ['folder' => $folder])
                        ->with('danger', 'Название папки содержит запрещенные символы');
                }
            }
        }
    }

    public function deleteFolder($path)
    {
        $pathToFolder = str_replace("-", "\\", $path);
        Storage::disk('public')->deleteDirectory($pathToFolder);
        return redirect()->route('fileStorageIndex')->with('success', 'Папка успешно удалена');
    }

    public function editFile(Request $request)
    {
        $currentDirectory = iconv("utf-8", "windows-1251", $request->currentDirectory);

        if (preg_match('/[А-Яа-яёЁ0-9\s]+/',$request->editFileName)) {
            /** Заменяем пробел в имени папки на нижнее подчеркивание */
            $fileName = str_replace(" ", "_", $request->editFileName);
            $oldFileName = $request->oldFileName;

            if ($currentDirectory) {
                $newDirectory = $currentDirectory . '/' . Transliteral::transliterate($fileName) . '.' . $request->extension;
                $oldDirectory = $currentDirectory . '/' . $oldFileName . '.' . $request->extension;
            } else {
                $newDirectory = Transliteral::transliterate($fileName) . '.' . $request->extension;
                $oldDirectory = $oldFileName . '.' . $request->extension;
            }

            Storage::disk('public')->move($oldDirectory, $newDirectory);

            return back()->with('success', 'Название файла успешно изменено');
        }else{
            return back()->with('danger', 'Название файла содержит запрещенные символы');
        }
    }

    public function deleteFile($path)
    {
        $pathToFile = str_replace("-", "\\", $path);
        Storage::disk('public')->delete($pathToFile);
        return back()->with('success', 'Файл успешно удален');
    }
}
