<?php	
// Directory structure
defined('DS')? null :define('DS','/');
defined('WEB_ROOT') ? null :define('WEB_ROOT', $_SERVER['DOCUMENT_ROOT']);
defined('LAYOUT') ? null :define('LAYOUT', WEB_ROOT.'/templates'.DS);
defined('CONTENT') ? null :define('CONTENT', WEB_ROOT.'/includes'.DS);
defined('LIB') ? null :define('LIB', WEB_ROOT.'/lib'.DS);
defined('ADMIN') ? null :define('ADMIN', WEB_ROOT.'/admin'.DS);

// Database details
defined('DB_SERVER') ? null :define("DB_SERVER", "localhost");
defined('DB_NAME') ? null :define("DB_NAME", "schema_frm");
defined('DB_USER') ? null :define("DB_USER", "postgres");
defined('DB_PASS') ? null :define("DB_PASS", "root");
defined('DB_PORT') ? null :define("DB_PORT", "5432");


// Hosting details
defined('DOMAIN') ? null :define("DOMAIN", "http://test");

?>
