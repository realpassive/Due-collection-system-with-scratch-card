<?php 
 function passkey($format = 'u', $utimestamp = null) {
	if (is_null($utimestamp))
	$utimestamp = microtime(true);
			
	$timestamp = floor($utimestamp);
	$milliseconds = round(($utimestamp - $timestamp) * 1000000);
			
return date(preg_replace('`(?<!\\\\)u`', $milliseconds, $format), $timestamp);
	}

  function pass(){
  return rand(2000, 10000).passkey();
     
  }

?>
