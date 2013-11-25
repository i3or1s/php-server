<?php

namespace i3or1s;

class Request{
	
	const METHOD = '#(?P<method>OPTIONS|GET|POST|PUT|DELETE|HEAD|TRACE|CONNECT) (?P<uri>.*? )#is';

	private $_input = '';
	private $_method = '';

	public function __construct($input){
		preg_match_all(self::METHOD, $input, $matches);
		$this->_method = $matches['method'][0];
		
	}

	public function processRequest(){
		$req = '\\i3or1s\\Request\\'.ucfirst(strtolower($this->_method));
		$request = new $req;
		return $request->doSomething();
	}

}