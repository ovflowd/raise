<?php

class Request
{
	private $protocol;
	private $method;
	private $path;
	private $parameters;
	private $body;
	private $sender;
	private $responses;

	public function __construct($protocol, $method, $path, $parameters, $body, $sender)
	{
		$this->setProtocol($protocol);
		$this->setMethod($method);
		$this->setPath($path);
		$this->setParameters($parameters);
		$this->setBody($body);
		$this->setSender($sender);
	}


}