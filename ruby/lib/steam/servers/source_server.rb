# This code is free software; you can redistribute it and/or modify it under the
# terms of the new BSD License.
#
# Copyright (c) 2008, Sebastian Staudt
#
# $Id$

require "exceptions/rcon_no_auth_exception"
require "steam/packets/rcon/rcon_auth_request"
require "steam/packets/rcon/rcon_auth_response"
require "steam/packets/rcon/rcon_exec_request"
require "steam/servers/game_server"
require "steam/sockets/rcon_socket"
require "steam/sockets/source_socket"

class SourceServer < GameServer
  
  def initialize(ip_address, port_number = 27015)
    super port_number
    @rcon_socket = RCONSocket.new ip_address, port_number
    @socket = SourceSocket.new ip_address, port_number
  end
  
  def rcon_auth(password)
    @rcon_request_id = rand 2**16
    
    @rcon_socket.send RCONAuthRequest.new(@rcon_request_id, password)
    @rcon_socket.get_reply
    reply = @rcon_socket.get_reply
    return reply.get_request_id == @rcon_request_id
  end
  
  def rcon_exec(command)
    @rcon_socket.send RCONExecRequest.new(@rcon_request_id, command)
    reply = @rcon_socket.get_reply
    if reply.is_a? RCONAuthResponse
      raise RCONNoAuthException.new
    end
    
    return reply.get_response
  end
  
end