<?php
/**
 * This code is free software; you can redistribute it and/or modify it under
 * the terms of the new BSD License.
 *
 * Copyright (c) 2008-2009, Sebastian Staudt
 *
 * @author Sebastian Staudt
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package Steam Condenser (PHP)
 * @subpackage TCPSocket
 */

require_once "InetAddress.php";
require_once "Socket.php";

/**
 * This class represents a TCP socket
 *
 * It can connect to a remote host, send and receive packets
 *
 * @package Steam Condenser (PHP)
 * @subpackage TCPSocket
 */
class TCPSocket extends Socket
{
	/**
	 * Connects the TCP socket to the host with the given IP address and port number
	 */
	public function connect(InetAddress $ipAddress, $portNumber)
	{
		$this->ipAddress = $ipAddress;
		$this->portNumber = $portNumber;

		if($this->socketsEnabled)
		{
			if(!$this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP))
			{
				$errorCode = socket_last_error($this->socket);
				throw new Exception("Could not create socket: " . socket_strerror($errorCode));
			}
			if(@!socket_connect($this->socket, $ipAddress, $portNumber))
			{
				$errorCode = socket_last_error($this->socket);
				throw new Exception("Could not connect socket: " . socket_strerror($errorCode));
			}

			if($this->isBlocking)
			{
				socket_set_block($this->socket);
			}
			else
			{
				socket_set_nonblock($this->socket);
			}
		}
		else
		{
			if(!$this->socket = fsockopen("tcp://$ipAddress", $portNumber, $socketErrno, $socketErrstr, 2))
			{
				throw new Exception("Could not create socket.");
			}
			stream_set_blocking($this->socket, $this->isBlocking);
		}
	}
}
?>