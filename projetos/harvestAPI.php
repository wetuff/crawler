<?php
	$url = "https://api.harvestapp.com/v2/projects";
	$headers = array(
		"Authorization: Bearer 1435672.pt.sU2GxIrvkodZrCNYkIBu_5A5N-eTyh9cXAybzO5qzug1lXtamO8gZh9q8FQftEXrDWDRofyddUK_AwxHEy5BZg",
		"Harvest-Account-ID: 810112",
		"User-Agent: Crawler"
	);
	$handle = curl_init();
	curl_setopt($handle, CURLOPT_URL, $url);
	curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($handle, CURLOPT_USERAGENT, "PHP Harvest API Sample");
	$response = curl_exec($handle);

	if (curl_errno($handle)) {
		print "Error: " . curl_error($handle);
	} else {
		//print json_encode(json_decode($response), JSON_PRETTY_PRINT);
		print_r(($response));
		//echo '<script>loadProjetos('.$response.');</script>';
		curl_close($handle);
	}
?>