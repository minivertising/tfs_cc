<?
/* returns the shortened url */
function get_bitly_short_url($url,$login,$appkey,$format='txt') {
	$connectURL = 'http://api.bit.ly/v3/shorten?login='.$login.'&apiKey='.$appkey.'&uri='.urlencode($url).'&format='.$format;
	return curl_get_result($connectURL);
}

/* returns expanded url */
/*
function get_bitly_long_url($url,$login,$appkey,$format='txt') {
	$connectURL = 'http://api.bit.ly/v3/expand?login='.$login.'&apiKey='.$appkey.'&shortUrl='.urlencode($url).'&format='.$format;
	return curl_get_result($connectURL);
}
*/

/* returns a result form url */
function curl_get_result($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

/* get the short url */
$short_url = get_bitly_short_url('http://www.naver.com','kyhfan','R_11ea80ffc2bf4bbe8c848b761e71df8a');
print_r($short_url);
/* get the long url from the short one */
//$long_url = get_bitly_long_url($short_url,'kyhfan','R_11ea80ffc2bf4bbe8c848b761e71df8a');

?>

