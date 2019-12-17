<?php


namespace App\Controllers;

use App\Models;

class LoadFile extends \App\Core\Controller
{
    private $messages;
    private $user;

    public function __construct($params)
    {
        parent::__construct($params);

        $this->messages = new Models\Messages();
        $this->user = new Models\User();
    }


    private function getExtension($path){
        $ext = '';
        $mime_type=mime_content_type($path);
        if($mime_type === 'image/gif') $ext = '.gif';
        if($mime_type === 'image/jpeg') $ext = '.jpg';
        if($mime_type === 'image/png') $ext = '.png';
        if($mime_type === 'image/webp') $ext = '.webp';
        return $ext;
    }

    public function load()
    {
        if (empty($this->cookies->session))
            return;


        $user = $this->user->checkAuth($this->cookies->session);
        if (!$user)
            return;


        $tmp_path = $_FILES['file']['tmp_name'];
        $filename = $_FILES['file']['name'];
        if (!($extension = $this->getExtension($tmp_path)))
            die('Неподдерживаемый тип файла');

        $hash = md5_file($tmp_path);
        $short_hash = substr($hash, 0,2);
        $upload_dir = $_SERVER['DOCUMENT_ROOT'].'/user_images/'.$short_hash;
        $upload_path = $upload_dir.'/'.$hash.$extension;


        if (filesize($tmp_path)>3*1024*1024)
            die('Размер загружаемого файла слишком велик!');

        if (!is_dir($upload_dir))
            mkdir($upload_dir);


        if (!file_exists($upload_path))
          if (!move_uploaded_file($tmp_path, $upload_path))
              die('Какая-то ошибка! Повторите позже...');


        $id = $this->messages->uploadFile($user['id'], $filename, $hash, $extension, time());

        print json_encode(['result' => 'ok', 'id' => $id, 'hash' => $hash, 'type' => $extension, 'name' => $filename]);
    }

}
