<?php


namespace App\Models;


class User extends \App\Core\Model
{
    public static function checkAuth($session)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM users where session = :session ');
        $stmt->execute([':session' => $session]);
        return $stmt->fetch();
    }

    public static function getUser($nick)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM users where nick = :nick');
        $stmt->execute([':nick' => $nick]);
        return $stmt->fetch();
    }

    public static function Register($nick, $password, $session)
    {
        $db = static::getDB();
        $stmt = $db->prepare('insert into users (nick, password, session) values (:nick, :password, :session)');
        $stmt->execute([':nick' => $nick, ':password' => $password, 'session' => $session]);
        return $stmt;
    }

    public static function getUserFromId($id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM users where id = :id');
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public static function authSuccess($id, $new_session)
    {
        $db = static::getDB();
        $stmt = $db->prepare('update users set session = :session where id = :id');
        $stmt->execute([':session' => $new_session, ':id' => $id]);
        return $stmt;
    }

    public static function logout($session)
    {
        $db = static::getDB();
        $stmt = $db->prepare('update users set session = "" where session = :session ');
        $stmt->execute([':session' => $session]);
        return $stmt;
    }

}
