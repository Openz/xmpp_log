xmpp_log
=======

View a chat-room history.

Using MCABBER log archive.

Example
-------------

OpenUDC chatroom: chat.openudc.org

Requirement
-------------

- A web server with php.
- MCABBER xmpp client

Install
-------------

- Install and configure a MCABBER client for your chat-room. Choose a log storage type by date: YEAR(directory)/MOUNT(directory)/DAY(text file). Note: actually this type is only available on a patch: https://github.com/jbar/mcabber/commits/master
- Go to the web site directory and create a symbolic link to the log directory
- Edit bin/init.php

Tool 
-------------

Awk script to harmonize older logs, to adapt.



