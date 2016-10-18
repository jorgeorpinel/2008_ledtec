This file was created in 2016 to document this old project.
This is a CakePHP application.

# LedTec
© 2008 Jorge Orpinel  
**Version 1.0.1**  
Single-page, semi responsive web application -- back when these concepts didn't exist in mainstream: online catalog system for LED manufacturer.

## Requires

* [CakePHP 1.2.0](http://book.cakephp.org/1.2/en/) ([download](https://github.com/cakephp/cakephp/releases?after=1.2.1)) in `cake/`  
(Tested with PHP 5.4)
* [My Authentication Component](https://github.com/jorgeorpinel/cakephp-authentication) in `app/controllers/components/`


* Prototype.js 1.5.1
* Scriptaculous.js 1.7.1

## Installation

Populate the database with a dump (in parent directory) and configure connection in [database.php](app/config/database.php).
Configure web server to serve `app/webroot`; Make sure `tmp/` dir is writeable by the web server.

## Config

Make sure the values in [core.php](app/config/core.php) are correct (DEBUG and $cakeCache).

Search project for "XXX" and "TODO" for remaining questions and tasks, respectively.
