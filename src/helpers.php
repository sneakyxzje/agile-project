<?php

use eftec\bladeone\BladeOne;

function view($view, $data = [])
{
    $views = APP_DIR . '/resources/views/';
    $cache = APP_DIR . '/storage/cache';
    $blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG); 
    echo $blade->run($view, $data); 
}

function dd(...$data)
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    die;
}

function route($route)
{
    return APP_URL . $route;
}

function redirect($path)
{
    header("location: " . route($path));
    die;
}

function redirect404()
{
    redirect('404');
}

function upload_file(array $file, $folder = null)
{
    $fileTmpPath = $file['tmp_name']; 
    $fileName = time() . '-' . $file['name']; 

    $uploadDir = 'storage/' . $folder . '/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $destPath = $uploadDir . $fileName;

    if (move_uploaded_file($fileTmpPath, $destPath)) {
        return $destPath;
    }

    throw new Exception('Lỗi upload file!');
}

function file_url($file)
{
    return APP_URL . $file;
}

function is_upload($key)
{
    return isset($_FILES[$key]) && $_FILES[$key]['size'] > 0;
}

function session_flash($key, $value = null)
{
    if ($value !== null) {
        $_SESSION['_flash'][$key] = $value;
    } else {
        if (isset($_SESSION['_flash_old'][$key])) {
            $value = $_SESSION['_flash_old'][$key];
            unset($_SESSION['_flash_old'][$key]);
            return $value;
        }
    }
    return null;
}

function flash_next_request()
{
    $_SESSION['_flash_old'] = $_SESSION['_flash'] ?? [];
    unset($_SESSION['_flash']);
}

function getUserDiamond() {
    if (isset($_SESSION['user']['id'])) {
        $user = \App\models\User::find($_SESSION['user']['id']);
        return $user ? $user->diamond : 0;
    }
    return 0;
}