/*
 * First authored by Brian Cray
 * License: http://creativecommons.org/licenses/by/3.0/
 * Contact the author at http://briancray.com/
 */

ini_set('display_errors', 0);

if(!preg_match('|^[0-9a-zA-Z]{1,6}$|', $_GET['url']))
{
        die('That is not a valid short url');
}

require('config.php');

$result = mysql_query('SELECT id, long_url FROM ' . DB_TABLE . ' WHERE url="' . mysql_real_escape_string($_GET['url']) . '"');

if (mysql_affected_rows() == 0) {
        die('URL not found');
}

$result = mysql_fetch_array($result);

if(TRACK)
{
        mysql_query('UPDATE ' . DB_TABLE . ' SET referrals=referrals+1 WHERE id="' . mysql_real_escape_string($result[0]) . '"');
}

header('HTTP/1.1 301 Moved Permanently');
header('Location: ' .  $result[1]);
exit;
