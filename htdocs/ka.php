<?php

/**
 * KtaiAnalytics, Google Analytics tracking for Ktai (Japanese mobile phone)
 * 
 * @package    ka.php
 * @author     naberon <naberon86@gmail.com>
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

// Tracker version.
define("VERSION", "4.4sh");

define("COOKIE_NAME", "__utmmobile");

// The path the cookie will be available to, edit this to use a different
// cookie path.
define("COOKIE_PATH", "/");

// Two years in seconds.
define("COOKIE_USER_PERSISTENCE", 63072000);

// The last octect of the IP address is removed to anonymize the user.
function getIP($remoteAddress) {
    if(empty($remoteAddress)) {
        return "";
    }

    // Capture the first three octects of the IP address and replace the forth
    // with 0, e.g. 124.455.3.123 becomes 124.455.3.0
    $regex = "/^([^.]+\.[^.]+\.[^.]+\.).*/";
    if (preg_match($regex, $remoteAddress, $matches)) {
        return $matches[1] . "0";
    } else {
        return "";
    }
}

// Generate a visitor id for this hit.
// If there is a visitor id in the cookie, use that, otherwise
// use the guid if we have one, otherwise use a random number.
function getVisitorId() {

    // If there is a value in the cookie, don't change it.
    if (isset($_COOKIE[COOKIE_NAME])) {
        return $_COOKIE[COOKIE_NAME];
    }

    $guid = '';
    if(isset($_SERVER["HTTP_X_DCMGUID"])) {
        $guid = $_SERVER["HTTP_X_DCMGUID"];
    } else if (isset($_SERVER["HTTP_X_UP_SUBNO"])) {
        $guid = $_SERVER["HTTP_X_UP_SUBNO"];
    } else if (isset($_SERVER["HTTP_X_JPHONE_UID"])) {
        $guid = $_SERVER["HTTP_X_JPHONE_UID"];
    } else if (isset($_SERVER["HTTP_X_EM_UID"])) {
        $guid = $_SERVER["HTTP_X_EM_UID"];
    }

    $message = "";

    if (!empty($guid)) {
        // Create the visitor id using the guid.
        $message = $guid . $_GET["utmac"];
    } else {
        $userAgent = '';
        if (isset($_SERVER["HTTP_USER_AGENT"])) {
            $userAgent = $_SERVER["HTTP_USER_AGENT"];
        }
        // otherwise this is a new user, create a new random id.
        $message = $userAgent . uniqid(getRandomNumber(), true);
    }

    $md5String = md5($message);

    $VisitorId = "0x" . substr($md5String, 0, 16);

    setrawcookie(
        COOKIE_NAME,
        $VisitorId,
        time() + COOKIE_USER_PERSISTENCE,
        COOKIE_PATH);
    return $VisitorId;
}

// Get a random number string.
function getRandomNumber() {
    return rand(0, 0x7fffffff);
}

// Writes the bytes of a 1x1 transparent gif into the response.
function writeGifData() {
    header("Content-Type: image/gif");
    header("Accept-Ranges: bytes");
    header("Content-Length: 35");
    header("Cache-Control: private, no-cache, no-cache=Set-Cookie, proxy-revalidate");
    header("Pragma: no-cache");
    header("Expires: Wed, 17 Sep 1975 21:32:10 GMT");
    echo join(
        array(
            chr(0x47), chr(0x49), chr(0x46), chr(0x38), chr(0x39), chr(0x61),
            chr(0x01), chr(0x00), chr(0x01), chr(0x00), chr(0x80), chr(0xff),
            chr(0x00), chr(0xff), chr(0xff), chr(0xff), chr(0x00), chr(0x00),
            chr(0x00), chr(0x2c), chr(0x00), chr(0x00), chr(0x00), chr(0x00),
            chr(0x01), chr(0x00), chr(0x01), chr(0x00), chr(0x00), chr(0x02),
            chr(0x02), chr(0x44), chr(0x01), chr(0x00), chr(0x3b)
        )
	);
}

// Make a tracking request to Google Analytics from this server.
// Copies the headers from the original request to the new one.
// If request containg utmdebug parameter, exceptions encountered
// communicating with Google Analytics are thown.
function sendRequestToGoogleAnalytics($utmUrl) {
    $options = array(
        "http" => array(
            "method" => "GET",
            "user_agent" => $_SERVER["HTTP_USER_AGENT"],
            "header" => ("Accepts-Language: " . $_SERVER["HTTP_ACCEPT_LANGUAGE"]))
        );
    if (!empty($_GET["utmdebug"])) {
        $data = file_get_contents(
            $utmUrl, false, stream_context_create($options));
    } else {
        $data = @file_get_contents(
            $utmUrl, false, stream_context_create($options));
    }
}

// Track a page view, updates all the cookies and campaign tracker,
// makes a server side request to Google Analytics and writes the transparent
// gif byte data to the response.
function trackPageView() {
    // $GET is non decode get parameter
    $GET = array();
    $get_params = preg_split("/&/", $_SERVER['QUERY_STRING']);
    foreach($get_params as $param) {
        list($key, $val) = preg_split("/=/", $param);
        $GET[$key] = $val;
    }

    $domainName = isset($_SERVER["SERVER_NAME"]) ? urlencode($_SERVER["SERVER_NAME"]) : '';

    // Get the referrer from the utmr parameter, this is the referrer to the
    // page that contains the tracking pixel, not the referrer for tracking
    // pixel.
    $documentReferer = isset($GET["utmr"]) ? $GET["utmr"] : '';
    if(empty($documentReferer) && $documentReferer !== "0") {
        $documentReferer = "-";
    }
    $documentPath = isset($GET["utmp"]) ? $GET["utmp"] : '';
    $pageTitle = isset($GET["utmdt"]) ? $GET["utmdt"] : '';
    $utmt = isset($GET["utmt"]) ? $GET["utmt"] : '';

    $utme = isset($GET["utme"]) ? $GET["utme"] : '';

    $account = $GET["utmac"];

    $visitorId = getVisitorId();

    $utmGifLocation = "http://www.google-analytics.com/__utm.gif";

    // Construct the gif hit url.
    $utmUrl = "{$utmGifLocation}?utmwv=" . VERSION .
        "&utmn=" . getRandomNumber() .
        "&utmhn={$domainName}" .
        "&utmr={$documentReferer}" .
        "&utmp={$documentPath}" .
        "&utmac={$account}" .
        "&utmcc=__utma%3D999.999.999.999.999.1%3B" .
        "&utmvid={$visitorId}" .
        "&utmip=" . getIP($_SERVER["REMOTE_ADDR"]);

    if(!empty($utme)) $utmUrl .= "&utme={$utme}";
    if(!empty($pageTitle)) $utmUrl .= "&utmdt={$pageTitle}";

    sendRequestToGoogleAnalytics($utmUrl);

    // If the debug parameter is on, add a header to the response that contains
    // the url that was used to contact Google Analytics.
    if (!empty($_GET["utmdebug"])) {
        header("X-GA-MOBILE-URL:" . $utmUrl);
    }
    // Finally write the gif data to the response.
    writeGifData();
}
trackPageView();

