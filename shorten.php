<?php
/*
 * First authored by Brian Cray
 * License: http://creativecommons.org/licenses/by/3.0/
 * Contact the author at http://briancray.com/
 */
 
ini_set('display_errors', 0);

$url_to_shorten = get_magic_quotes_gpc() ? stripslashes(trim($_REQUEST['longurl'])) : trim($_REQUEST['longurl']);

if(!empty($url_to_shorten) && preg_match('|^https?://|', $url_to_shorten))
{
	require('config.php');

	// check if the client IP is allowed to shorten
	if($_SERVER['REMOTE_ADDR'] != LIMIT_TO_IP)
	{
		die('You are not allowed to shorten URLs with this service.');
	}
	
	// check if the URL is valid
	if(CHECK_URL)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url_to_shorten);
		curl_setopt($ch,  CURLOPT_RETURNTRANSFER, TRUE);
		$response = curl_exec($ch);
		curl_close($handle);
		if(curl_getinfo($ch, CURLINFO_HTTP_CODE) == '404')
		{
			die('Not a valid URL');
		}
	}
	
	// check if the URL has already been shortened
	$queryResult = mysql_query('SELECT id FROM ' . DB_TABLE. ' WHERE long_url="' . mysql_real_escape_string($url_to_shorten) . '"');
	
	if(mysql_affected_rows() == 1)
	{
		// URL has already been shortened
		$shortened_url = getShortenedURLFromID(mysql_result($queryResult, 0, 0));
	}
	else
	{
		// URL not in database, insert
		mysql_query('LOCK TABLES ' . DB_TABLE . ' WRITE;');
		mysql_query('INSERT INTO ' . DB_TABLE . ' (long_url, created, creator) VALUES ("' . mysql_real_escape_string($url_to_shorten) . '", "' . time() . '", "' . mysql_real_escape_string($_SERVER['REMOTE_ADDR']) . '")');
		$insertId = mysql_insert_id();
		$shortened_url = getShortenedURLFromID($insertId);
		// Update the DB with the URL we just generated
		mysql_query('UPDATE ' . DB_TABLE . " SET url = '" . mysql_real_escape_string($shortened_url) . "' WHERE id = " . $insertId);
		mysql_query('UNLOCK TABLES');
	}
	echo BASE_HREF . $shortened_url;
}

function getShortenedURLFromID ($integer, $base = ALLOWED_CHARS)
{
        $length = strlen($base);
        if ($integer < $length) {
                $out = $base[$integer];
        } else {
        	$out = '';
                for($exp=0; pow($length, $exp)<=$integer; $exp++) {
                        $out = $base[(floor($integer/pow($length, $exp)))%$length] . $out;
                }
        }
        return $out;

}
