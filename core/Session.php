<?php


namespace app\core; 

class Session{

    protected const FLASH_KEY = 'flash_messages';

    public function __construct()
    {
        session_start();
        $flash_messages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach($flash_messages as $key => &$flash_message){
            //Marked to be removed
            $flash_message['remove'] = true;
        }

        $_SESSION[self::FLASH_KEY] = $flash_messages;
    }

    public function setFlash($key,$message){
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value' => $message
        ];
    }

    public function getFlash($key){
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    public function set($key, $value)
    {
        return $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public function __destruct()
    {
        $flash_messages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach($flash_messages as $key => &$flash_message){
            if($flash_message['remove']){
                unset($flash_messages[$key]);
            }
        }
        $_SESSION[self::FLASH_KEY] = $flash_messages;
    }
}