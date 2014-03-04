<?php

$config = array();

$config["memcache_servers"] = array('10.93.81.54', '10.87.71.200', '10.181.139.172', '10.29.5.39', '10.93.94.25');
//$config["memcache_servers"] = array('10.180.144.239');
$config["backup_memcache_servers"] = array();
$config["memcache_port"] = 11211;
$config["data_manager"] = 'memcache';
$config["loader_cache_limit"] = 10;

return $config;