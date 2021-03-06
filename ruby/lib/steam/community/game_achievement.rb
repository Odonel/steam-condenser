# This code is free software; you can redistribute it and/or modify it under the
# terms of the new BSD License.
#
# Copyright (c) 2008-2009, Sebastian Staudt

# The GameAchievement class represents a specific achievement for a single game
# and for a single user
class GameAchievement

  attr_reader :app_id, :name, :steam_id
  
  # Creates the achievement with the given name for the given user and game and
  # marks it as already done if set to true
  def initialize(steam_id, app_id, name, done)
    @app_id   = app_id
    @done     = done
    @name     = name
    @steam_id = steam_id
  end
  
  # Returns whether this achievement has been done by its owner
  def done?
    @done
  end
  
end
