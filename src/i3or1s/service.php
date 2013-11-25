<?php

namespace i3or1s;

class Service {

	private $_port = 8080;
	private $_address = '127.0.0.1';
	private $_socket = null;
	private $_client = null;
	private $_running = false;
	
	public function __construct($address = '127.0.0.1', $port = 80){
		$this->_port = $port;
		$this->_address = $address;
	}

	public function run(){
		$this->openSocket();
		$this->_running = true;
		while($this->_running){
			$this->readRequest();
		}
		socket_close($this->_socket);
	}

	public function stop(){
		$thi->_running = false;
	}

	private function openSocket(){
		$this->_socket = socket_create(AF_INET, SOCK_STREAM, 0);
		socket_bind($this->_socket, $this->_address, $this->_port) or die('Could not bind to address');
		socket_listen($this->_socket);
	}

	private function readRequest(){
		$this->_client = socket_accept($this->_socket);
		$input = socket_read($this->_client, 1024);
		$req = new Request($input);
		socket_write($this->_client, $req->processRequest());	
		socket_close($this->_client);
	}
}