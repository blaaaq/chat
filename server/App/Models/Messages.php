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

}