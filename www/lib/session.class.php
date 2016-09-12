<?php

class Session
{

    private static $key = 'flash';

    public static function flash( $key, $value=null ){
        # Если значение не указано
        if( is_null( $value ) ){
            # Если такой ключ в сессии есть
            if( isset( $_SESSION[self::$key][$key] ) ){
                # Получаем значение
                $value = $_SESSION[self::$key][$key];

                # Уничтожаем значение сессии
                unset( $_SESSION[self::$key][$key] );

                # Возвращаем значение
                return $value;
            }
            # По умолчанию
            return false;
        }

        # Записываем значение в сессию
        $_SESSION[self::$key][$key] = $value;
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return null;

    }

    public static function delete($key)
    {
        if (isset($_SESSION[$key])) {
            unset ($_SESSION[$key]);
        }
    }

    public static function destroy()
    {
        session_destroy();
    }
}