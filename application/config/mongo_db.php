<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------------
| This file will contain the settings needed to access your Mongo database.
|
|
| ------------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| ------------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['write_concerns'] Acknowledge write operations.  ref(http://php.net/manual/en/class.mongodb-driver-writeconcern.php)
|	['write_concerns_timeout'] Set the time limit for the write concern. ref(http://php.net/manual/en/class.mongodb-driver-writeconcern.php) 
|	['journal'] Default is TRUE : journal flushed to disk. ref(http://php.net/manual/en/class.mongodb-driver-writeconcern.php)
|	['read_concern'] New in version 3.2: For the WiredTiger storage engine. ref(http://php.net/manual/en/class.mongodb-driver-readconcern.php) 
|	['read_preference'] Set the read preference for this connection. ref(http://php.net/manual/en/class.mongodb-driver-readpreference.php)
|	['read_preference_tags'] Set the read preference for this connection.  ref (http://php.net/manual/en/class.mongodb-driver-readpreference.php)
|	['return_as'] Set return value of cursor.
|
| The $config['mongo_db']['active'] variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
*/

$config['mongo_db']['active'] = 'default';

$config['mongo_db']['default']['auth'] = TRUE;
$config['mongo_db']['default']['hostname'] = 'localhost';
$config['mongo_db']['default']['port'] = '27017';
$config['mongo_db']['default']['username'] = 'admin';
$config['mongo_db']['default']['password'] = 'Z33shan123';
$config['mongo_db']['default']['database'] = 'zcidb';
$config['mongo_db']['default']['db_debug'] = TRUE;
$config['mongo_db']['default']['return_as'] = 'array';
$config['mongo_db']['default']['write_concerns'] = "MAJORITY";
$config['mongo_db']['default']['write_concerns_timeout'] = (int)1000;
$config['mongo_db']['default']['journal'] = TRUE;
$config['mongo_db']['default']['read_concern'] = "NULL";
$config['mongo_db']['default']['read_preference'] = "PRIMARY";
$config['mongo_db']['default']['read_preference_tags'] = NULL;

$config['mongo_db']['test']['auth'] = FALSE;
$config['mongo_db']['test']['hostname'] = 'localhost';
$config['mongo_db']['test']['port'] = '27017';
$config['mongo_db']['test']['username'] = 'username';
$config['mongo_db']['test']['password'] = 'password';
$config['mongo_db']['test']['database'] = 'database';
$config['mongo_db']['test']['db_debug'] = TRUE;
$config['mongo_db']['test']['return_as'] = 'array';
$config['mongo_db']['test']['write_concerns'] = (int)1;
$config['mongo_db']['test']['write_concerns_timeout'] = (int)1000;
$config['mongo_db']['test']['journal'] = TRUE;
$config['mongo_db']['test']['read_concern'] = NULL;
$config['mongo_db']['test']['read_preference'] = NULL;
$config['mongo_db']['test']['read_preference_tags'] = NULL;

/* End of file database.php */
/* Location: ./application/config/database.php */