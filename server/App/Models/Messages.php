<?php


namespace App\Models;


class Messages extends \App\Core\Model
{
    public static function getMessage($id)
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM messages where id='.$id);
        return $stmt->fetch();
    }

    public static function getLastMessages($count)
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM messages order by id desc limit '.$count);
        return $stmt->fetchAll();
    }

    public static function getMessagesFromId($id,$count)
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM messages where id<'.$id.' order by id desc limit '.$count);
        return $stmt->fetchAll();
    }

    public static function addMessage($id,$text,$time)
    {
        $db = static::getDB();
        $db->query('insert into messages (id_sender,text,time) values ('.$id.',"'.$text.'",'.$time.')');
        return $db->lastInsertId();
    }

}