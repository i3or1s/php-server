<?php
/**
 * @desc
 * @author Ostojić Aleksandar <ao@boutsourcing.com> 11/26/13
 */

namespace i3or1s\Request;


class Post {

    public function __construct($uri = null, $config = null, $body = null){
        $this->_uri = $uri;
        $this->_config = $config;
        $this->_body = $body;
    }

    public function getResponse(){
        $output = $this->_htmlResponse();
        return $output;

    }

    public function buildPost(){
        $post = array();
        $list = explode('&', $this->_body);
        foreach($list as $line){
            list($name, $value) = explode('=', $line);
            $post[$name] = $value;
        }
        return $post;
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