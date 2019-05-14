<?php
error_reporting(0);
function checkURL($url) {
	// Check Scheme
	if (preg_match("/^https?:\/\//i", $url)) {
		if ($res = parse_url($url)) {
			//print_r($res);
			// Check Host
			if ($res['host']) {
				$ip = gethostbyname($res['host']);
				$is_inner_ip = (ip2long('0.0.0.0') === ip2long($ip)) ||
					(ip2long('127.0.0.0')>>24 === ip2long($ip)>>24) ||
					(ip2long('10.0.0.0')>>24 === ip2long($ip)>>24) ||
					(ip2long('172.16.0.0')>>20 === ip2long($ip)>>10) ||
					(ip2long('192.168.0.0')>>16 === ip2long($ip)>>16);
				if (!$is_inner_ip) {
					return true;
				}
			}
		}
	}
	return false;
}
function checkDTD($xmlcontent) {
	$pattern = "/\<\!ENTITY.*?SYSTEM \"(.*?)\"/i";
	$blacklist = array("gopher","dict","ftp","sftp","tftp","scp","ssh");
	if (preg_match($pattern, $xmlcontent, $res)) {
		foreach ($blacklist as $v) {
			if (preg_match("/^".$v."/i", $res[1])) {
				return false;
			}
		}
	}
	return true;
}
function getXML($xmlurl) {
	libxml_disable_entity_loader(false);
    $xmlcontent = file_get_contents($xmlurl);
    if (checkDTD($xmlcontent)) {
    	$dom = new DOMDocument();
    	if ($dom->loadXML($xmlcontent, LIBXML_NOENT | LIBXML_DTDLOAD)) {
		    $xml = simplexml_import_dom($dom);
		    return $xml;
    	}else{
    		return false;
    	}
    }else{
    	return false;
    }
}