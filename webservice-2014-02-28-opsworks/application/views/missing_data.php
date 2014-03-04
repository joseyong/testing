<?php

$dataString = "";
$comma = false;
foreach($data as $param) {
	if($comma) {
		$dataString .= ", ";
	}
	$dataString .= $param;
	$comma = true;
}

echo "<pre>" . json_encode(array("missing_data" => "please specify the following parameters: $dataString"));

?>