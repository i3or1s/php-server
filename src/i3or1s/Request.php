<?php

namespace i3or1s;

use Symfony\Component\Yaml\Parser;

class Request{
	
	const METHOD = '#(?P<method>OPTIONS|GET|POST|PUT|DELETE|HEAD|TRACE|CONNECT)#';

	private $_input = '';
    private $_config = '';

	private $_method = '';
    private $_uri = '';
    private $_http = '';
    private $_host = '';

	public function __construct($input){
		$this->_input = $input;
        $this->_parseConfig();
	}

	public function processRequest(){
        list($header, $body) = explode("\r\n\r\n", $this->_input);
        $segmentedRequestHeader = explode("\r\n", $header);
        list($this->_method, $this->_uri, $this->_http) = explode(' ', $segmentedRequestHeader[0]);
        $this->_host = str_replace('Host: ', '', $segmentedRequestHeader[1]);
        $class = '\\i3or1s\\Request\\' . ucfirst(strtolower($this->_method));
        $request = new $class($this->_uri, $this->_config["{$this->_host}"], $body);
        return $request->getResponse() . '<br/><hr/><u>Request</u><br/><textarea cols="130" rows="20">' . $this->_input . '</textarea>';
	}

    private function _parseConfig(){
        $yaml = new Parser();
        $this->_config = $yaml->parse(file_get_contents('config/sites.yml'));
    }

}