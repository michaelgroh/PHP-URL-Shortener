<?php
/*
 * First authored by Brian Cray
 * License: http://creativecommons.org/licenses/by/3.0/
 * Contact the author at http://briancray.com/
 */

// db options
define('DB_NAME', 'your db name');
define('DB_USER', 'your db usernae');
define('DB_PASSWORD', 'your db password');
define('DB_HOST', 'localhost');
define('DB_TABLE', 'shortenedurls');

// connect to database
mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysql_select_db(DB_NAME);

// base location of script (include trailing slash)
define('BASE_HREF', 'http://' . $_SERVER['HTTP_HOST'] . '/');

// change to limit short url creation to a single IP
define('LIMIT_TO_IP', $_SERVER['REMOTE_ADDR']);

// change to TRUE to start tracking referrals
define('TRACK', FALSE);

// check if URL exists first
define('CHECK_URL', FALSE);

// Change the shortened URL allowed characters.
// Does not include similar characters, upper case characters and is
// randomized to make shortened URLs seem more random.
define('ALLOWED_CHARS', '6f5aygbjwkudpqesnr8v7xz3h492ctm');

// do you want to cache?
define('CACHE', TRUE);

// if so, where will the cache files be stored? (include trailing slash)
define('CACHE_DIR', dirname(__FILE__) . '/cache/');
