<?php
	$mxHosts = array();
	getmxrr('victorfarmingtonambulance.org', $mxHosts);
	
	echo serialize($mxHosts);
?>
