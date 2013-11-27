<?php

namespace i3or1s\Request;

class Get{

    const IMG = '#(?P<img>\.png|\.ico|\.jpg|\.jpeg|\.gif)#';

	public function __construct($uri = null, $config = null, $body = null){
        $this->_uri = $uri;
        $this->_config = $config;
	}

	public function getResponse(){
        preg_match(self::IMG, $this->_uri, $matches);
        if(isset($matches['img'])){
            return $this->_imgResponse();
        }
        return $this->_htmlResponse();
    }

    private function _imgResponse(){
        return 'asd';
    }

    private function _htmlResponse(){
        $location = $this->_config['location'];
        ob_start();
        ob_clean();
        system('php ' . $location . $this->_uri . 'index.php');
        $output = ob_get_contents();
        ob_end_clean();
        $header = <<<TEXT
HTTP/1.1 200 OK
Server: php/0.1
Content-Type: text/html; charset=utf-8
TEXT;

        return $header . PHP_EOL . PHP_EOL . $output . '<br/><hr/><u>Response</u><br/><textarea cols="130" rows="20">' . $header . PHP_EOL . PHP_EOL . $output . '</textarea>';
    }
}