<?php
namespace App\Config;


class Config
{
    const
        DB_HOST = 'localhost',
        DB_NAME = 'chat',
        DB_USER = 'root',
        DB_PASSWORD = '',

        CLIENT_URL = 'localhost:8080',

        SHOW_ERRORS = true;

        public static function CLIENT_FULL_URL(){
            return (!empty($_SERVER['HTTPS']) ? 'https://' : 'http://').self::CLIENT_URL;
        }
}