<?php

namespace App\Helper\ValidationForm;

class Session
{
    public static function exists($name)
    {
        return (isset($_SESSION[$name])) ? true : false;
    }
    public static function put($name, $value)
    {
        return $_SESSION[$name] = $value;
    }

    public static function get($name)
    {
        return $_SESSION[$name];
    }

    public static function delete($name)
    {
        if (self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    /*

    public static function sessionStart()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }
     */

    /*
     * return session and remove it so next time it won't run.
     * echo $string but won't by refreshing the page
     * flashing/flash a message (just appear once)
     */
    public static function flash($name, $string = '')
    {
        if (self::exists($name)) {
            $session = self::get($name);
            self::delete($name);
            return $session;
        } else {
            self::put($name, $string);
        }
    }
}
