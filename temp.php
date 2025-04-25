<?php
$env = parse_ini_file('.env');
$MAIL_APP_ID = $env["MAIL_APP_ID"];
$MAIL_API_KEY = $env["MAIL_API_KEY"];
require_once('vendor/autoload.php');

$client = new \GuzzleHttp\Client();

$response = $client->request('POST', 'https://api.onesignal.com/notifications?c=email', [
    'body' => '{"app_id":"$MAIL_APP_ID","email_subject":"test otp for verification","email_preheader":"string","email_body":"<html>Your Email as HTML.</html>","template_id":"string","email_from_name":"VITS","email_from_address":"pranavbairy2@gmail.com","email_sender_domain":"pranavbairy@proton.me","email_reply_to_address":"string","include_unsubscribed":true,"disable_email_click_tracking":true,"name":"string","include_aliases":"string","email_to":["string"],"included_segments":["string"],"filters":[{"field":"first_session","key":"string","relation":">","value":"1"}]}',
    'headers' => [
        'Authorization' => 'Key YOUR_APP_API_KEY',
        'accept' => 'application/json',
        'content-type' => 'application/json',
    ],
]);

echo $response->getBody();
?>