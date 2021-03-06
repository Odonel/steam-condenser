<?php
/**
 * This code is free software; you can redistribute it and/or modify it under
 * the terms of the new BSD License.
 *
 * @author     Sebastian Staudt
 * @license    http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package    Steam Condenser (PHP)
 * @subpackage Packets
 */

require_once "ByteBuffer.php";

/**
 * @package Steam Condenser (PHP)
 * @subpackage Packets
 */
abstract class SteamPacket
{
	const S2A_INFO_DETAILED_HEADER = 0x6D;
	const A2S_INFO_HEADER = 0x54;
	const S2A_INFO2_HEADER = 0x49;
	const A2A_PING_HEADER = 0x69;
	const A2A_ACK_HEADER = 0x6A;
	const A2S_PLAYER_HEADER = 0x55;
	const S2A_PLAYER_HEADER = 0x44;
	const A2S_RULES_HEADER = 0x56;
	const S2A_RULES_HEADER = 0x45;
	const A2S_SERVERQUERY_GETCHALLENGE_HEADER = 0x57;
	const S2C_CHALLENGE_HEADER = 0x41;
	const A2M_GET_SERVERS_BATCH2_HEADER = 0x31;
	const M2A_SERVER_BATCH_HEADER = 0x66;
	const RCON_GOLDSRC_CHALLENGE_HEADER = 0x63;
    const RCON_GOLDSRC_NO_CHALLENGE_HEADER = 0x39;
	const RCON_GOLDSRC_RESPONSE_HEADER = 0x6C;

	/**
	 * This variable stores the content of the package
	 * @var mixed
	 */
	protected $contentData;

	/**
	 * This byte stores the type of the packet
	 * @var byte
	 */
	protected $headerData;

	/**
	 * @param byte $headerData
	 * @param byte[] $contentData
	 * @param bool $splitPacket
	 */
	public function __construct($headerData, $contentData = null)
	{
		$this->headerData = $headerData;
		$this->contentData = ByteBuffer::wrap($contentData);
	}

	/**
	 * @return byte[]
	 */
	public function getData()
	{
		return $this->contentData;
	}

	/**
	 * @return byte
	 */
	public function getHeader()
	{
		return $this->headerData;
	}

	/**
	 * @return String
	 */
	public function __toString()
	{
		$packetData = pack("cccc", 0xFF, 0xFF, 0xFF, 0xFF);
		$packetData .= pack("ca*", $this->headerData, $this->contentData->_array());

		return $packetData;
	}
}
?>
