<?php

/**
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param string $email The email address
 * @param string $s Size in pixels, defaults to 80px [ 1 - 512 ]
 * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
 * @param boole $img True to return a complete IMG tag False for just the URL
 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
 * @return String containing either just a URL or a complete image tag
 * @source http://gravatar.com/site/implement/images/php/
 */
function loadImage($email, $s = 60, $d = 'identicon', $r = 'g', $img = false, $atts = array()) {
    $url = 'http://www.gravatar.com/avatar/';
    
    if (getNetworkStatus($url)){
		return "images/user.jpeg";
	}
	
    $url .= md5(strtolower(trim($email)));
    $url .= "?s=$s&d=$d&r=$r";
    if ($img) {
        $url = '<img src="' . $url . '"';
        foreach ($atts as $key => $val)
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    
    
    //if gravatar isn't available, use this image...
    /*
    if (!$size = getimagesize($url))
        $url = "images/user.jpeg";
    */
    return $url;
}

function getNetworkStatus($url) {	
	ini_set('default_socket_timeout', 7); 
	$a = file_get_contents($url,FALSE,NULL,0,20); 
	return ( ($a!= "") && ($http_response_header!= "") ); 
}
?>
