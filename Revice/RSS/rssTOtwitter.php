<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['user_type'])){
    header("Location:".$_SERVER['DOCUMENT_ROOT']."/index.php");
}
else if ($_SESSION['user_type'] != 'admin'){
    header("Location:".$_SERVER['DOCUMENT_ROOT']."/index.php");
}
else {


    define('TWITTER_CONSUMER_KEY', 'qlQpM6QgxMZ3clWY5IAyF9AH3');
    define('TWITTER_CONSUMER_SECRET', 'Kt2InBMxFWfwaVqc6W9ADnjUF2n1BlVjIMMWWkSPjksZkyU5tB');
    define('TWITTER_ACCESS_TOKEN', '1540361968439148545-UPGlwgT79IoZNLgyIthH0KZQI06AMx');
    define('TWITTER_ACCESS_TOKEN_SECRET', 'KPLfn9SaHDf8NioF4w9OUo3vXG8zFKciIJ8or68EtGUlm');
    require_once('TwitterAPIExchange.php');
    function tweet($input)
    {
// settings for twitter api connection
        $settings = array(
            'oauth_access_token' => TWITTER_ACCESS_TOKEN,
            'oauth_access_token_secret' => TWITTER_ACCESS_TOKEN_SECRET,
            'consumer_key' => TWITTER_CONSUMER_KEY,
            'consumer_secret' => TWITTER_CONSUMER_SECRET
        );

// twitter api endpoint
        $url = 'https://api.twitter.com/1.1/statuses/update.json';

// twitter api endpoint request type
        $requestMethod = 'POST';

// twitter api endpoint data
        $apiData = array(
            'status' => $input,
        );

// create new twitter for api communication
        $twitter = new TwitterAPIExchange($settings);

// make our api call to twiiter
        $twitter->buildOauth($url, $requestMethod);
        $twitter->setPostfields($apiData);
        $response = $twitter->performRequest(true, array(CURLOPT_SSL_VERIFYHOST => 0, CURLOPT_SSL_VERIFYPEER => 0));

// display response from twitter
        echo '<pre>';
        print_r(json_decode($response, true));
    }
}
