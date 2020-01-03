<?php

namespace App\Helper\ValidationForm;

class Hash
{
    public static function make($string, $salt)
    {
        return hash_hmac('sha256', $string, $salt);
    }

    public static function salt($length)
    {
        return bin2hex(random_bytes($length));
    }

    public static function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return bin2hex($randomString);
    }

    public static function hash($input)
    {
        return hash('sha256', $input);
    }

    public static function hashCheck($known, $user)
    {
        return hash_equals($known, $user);
    }
}
