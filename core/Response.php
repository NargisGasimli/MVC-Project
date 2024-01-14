<?php

namespace app\core;

class Response{
    public function ResponseCode($code){
        http_response_code($code);
    }
}