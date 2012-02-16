<?php
/** doc voter config file **/

session_start();

// ** Paths ** //
date_default_timezone_set('GMT');
define('ABSPATH', dirname(__FILE__).'/');
define('UPLOADS_DIR', ABSPATH.'uploads/');
define('BASE_URL','http://localhost/docvoter/');
define('UPLOADS_URL', BASE_URL.'uploads/');
define('VIEW_PATH', ABSPATH.'views/');
// ** API settings ** //
define('BASE_API', 'http://api.driversofchange.com/api/'); //http://api.driversofchange.com/api/
define('ADMIN_EMAIL','');
define('PRIVATE_KEY', '');
define('SECRET','');
// ** App settings ** //
define('DEFAULT_PAGE','about');
define('DEFAULT_EVENT_ID',1);
define('SUPERADMIN_GROUP_ID',1);
define('ADMIN_GROUP_ID',2);
define('USER_GROUP_ID',3);
?>