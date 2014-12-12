<?php
	$json = array();
	foreach (glob("../data/*.json") as $filename)
	{
		$json[] = file_get_contents($filename);
	}
	print '['.str_replace("\n","",implode(',', $json)).']';
?>
