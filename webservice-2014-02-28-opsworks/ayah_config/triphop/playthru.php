<?php

$config = array();

$config["server_hostname"] = 'triphop.ab1k.us';
$config["log_path"] = '/var/www/webservice/application/logs/';
$config["log_file_type"] = "-ws-backend-v2.log";
$config["write_to_log"] = false;
$config["recaptcha_private_key"] = "6LdaJ8sSAAAAAC5NKsdk9KpoLhUWI4R-xr5OGUEp";
$config["dfp_network_code"] = "13513415";
$config["campaign_callback_delay"] = 2000;
$config["cdn_http_url"] = 'http://cdn.areyouahuman.com';
$config["cdn_https_url"] = 'https://s3.amazonaws.com/ayah_data2';
$config["cdn_instance_path"] = "/generated_games1/";
$config["cdn_audio_path"] = "/audio1/";
//$config["ballsandbins_file"] = 'gamesource/ballsandbins-v1.25'; loads from s3
$config["ballsandbins_file"] = 'ballsandbins-v1.24';
$config["vpaid_swf"] = "/vpaid/playthru_overlay_vpaid_wrapper.swf";
$config["overlay_swf"] = "/vpaid/playthru_overlay_flash.swf";
$config["elf_overlay_swf"] = "/gamesource/elf1.1.swf";

return $config;