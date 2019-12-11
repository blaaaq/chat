<?php


namespace App\Models;


class Messages extends \App\Core\Model
{
    public static function getMessage($id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM messages where id = :id');
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public static function getLastMessages($count)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM messages order by id desc limit :limit');
        $stmt->bindValue(':limit', $count, $db::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getMessagesFromId($id,$count)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM messages where id < :id order by id desc limit :limit');
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':limit', $count, $db::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function addMessage($id,$text,$time)
    {
        $db = static::getDB();
        $stmt = $db->prepare('insert into messages (id_sender, text, time) values (:id_sender, :text, :time)');
        $stmt->execute([':id_sender' => $id, ':text' => $text, ':time' => $time]);
        return $db->lastInsertId();
    }


    public static function addMessageFiles($files)
    {
        $db = static::getDB();
        $stmt = $db->prepare('insert into message_files (id_message, hash, type) values (:id_message, :hash, :type)');
        foreach ($files as $file)
            $stmt->execute([':id_message' => $file['id_message'], ':hash' => $file['hash'], ':type' => $file['type']]);
    }


    public static function getMessageFiles($id_message)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM message_files where id_message = :id_message');
        $stmt->execute(['id_message' => $id_message]);

        $files = [];
        while($file = $stmt->fetch())
            $files[]=[$file['hash'], $file['type']];
        return $files;
    }


    public static function uploadFile($id_user,$name,$hash,$type,$time)
    {
        $db = static::getDB();
        $stmt = $db->prepare('insert into files (id_user, name, hash, type, time) values (:id_user, :name, :hash, :type, :time)');
        $stmt->execute([':id_user' => $id_user, ':name' => $name, ':hash' => $hash, ':type' => $type, ':time' => $time]);
        return $db->lastInsertId();
    }

}