<?php


namespace App\Models;


class User extends \App\Core\Model
{
    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM users');
        return $stmt->fetchAll();
    }

    public static function checkAuth($session)
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM users where session = "'.$session.'"');
        return $stmt->fetch();
    }

    public static function getUser($nick)
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM users where nick = "'.$nick.'"');
        return $stmt->fetch();
    }

    public static function Register($nick, $password, $session)
    {
        $db = static::getDB();
        return $db->query('insert into users (nick,password,session) values ("'.$nick.'","'.$password.'","'.$session.'")');
    }

    public static function getUserFromId($id)
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM users where id = "'.$id.'"');
        return $stmt->fetch();
    }

    public static function authSuccess($id,$new_session)
    {
        $db = static::getDB();
        $stmt = $db->query('update users set session = "'.$new_session.'" where id='.$id);
        return $stmt;
    }
    public static function logout($session)
    {
        $db = static::getDB();
        $stmt = $db->query('update users set session = "" where session = "'.$session.'"');
        return $stmt;
    }


}