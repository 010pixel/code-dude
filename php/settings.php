<?php
	// Protocal
	// http/https
	if ( !defined('PROTOCOL') )
		define('PROTOCOL', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http' );

	// HOST
	// localhost
	if ( !defined('HOST_NAME') )
		define('HOST_NAME', $_SERVER['HTTP_HOST'] );

	// Base File Name
	// index.php
	if ( !defined('BASE_FILE') )
		define('BASE_FILE', basename($_SERVER['SCRIPT_NAME']) );

	// Base Directory URL from Server Root
	// /folder-name/ OR /
	if ( !defined('REL_DIR_URL') ) {
		if (dirname($_SERVER['SCRIPT_NAME']) == '/') {
			define('REL_DIR_URL', dirname($_SERVER['SCRIPT_NAME']) );
		} else {
			define('REL_DIR_URL', dirname($_SERVER['SCRIPT_NAME']) . '/' );
		}
	}

	// Server Root URL
	// http://localhost
	if ( !defined('SERVER_ROOT_URL') )
		define('SERVER_ROOT_URL', PROTOCOL . '://' . HOST_NAME );

	// Base Directory URL
	// http://localhost/folder-name/
	if ( !defined('ROOT_DIR_URL') )
		define('ROOT_DIR_URL', SERVER_ROOT_URL . REL_DIR_URL );

	// Base File Name
	// http://localhost/folder-name/index.php
	if ( !defined('BASE_FILE_URL') )
		define('BASE_FILE_URL', ROOT_DIR_URL . BASE_FILE );

	// Full Absolute URL
	// http://localhost/folder-name/index.php/page-name
	if ( !defined('ABSURL') )
		define('ABSURL', sprintf( "%s%s", SERVER_ROOT_URL, $_SERVER['REQUEST_URI']));

	// URL For Current Page (which is full absolute url excluding home directory url)
	// index.php/page-name or index.php?page-name
	if ( !defined('CURRENT_PAGE_URL') )
		define('CURRENT_PAGE_URL', str_replace(ROOT_DIR_URL,'',ABSURL));

	// The page information which will be used to check the page content
	// /home
	if ( !defined('THIS_PAGE') )
		define('THIS_PAGE', str_replace(BASE_FILE,'',CURRENT_PAGE_URL));
?>