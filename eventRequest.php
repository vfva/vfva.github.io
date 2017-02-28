<?php
	require_once('cgi-bin/class.phpmailer.php');
	require_once('cgi-bin/class.smtp.php');

	$mailSubject    = 'Standby Services Request Form - victorfarmingtonambulance.org';
	$mailRecipients = array('jeremyh@fltg.com', 'operations@victorfarmingtonambulance.org');
	//$mailRecipients = array('vlisc@symbolicinc.com');
	
	/* ------------------------------------------------------------------------ */

	$formFieldNames = array(
		'day', 'month', 'year',
		'location', 'indoorOutdoor',
		'time', 'ampm', 'eventLength',
		'description', 'attendance',
		'hazards', 'specialInstructions', 'personnel', 
		'contact', 'phone'
	);

	$formVals = array();
	foreach($formFieldNames as $thisFieldName) {
		$formVals[$thisFieldName] = nnTrim($_REQUEST[$thisFieldName]);
	}
	
	$mailBody  = "<html><body>\n";
	
	$mailBody .= "<p>The following request for standby services was submitted via the website.</p>\n";
	$mailBody .= "<table>\n";
	
	$mailBody .= makeRow('Date', $formVals['month'] . '/' . $formVals['day'] . '/' . $formVals['year']);
	$mailBody .= makeRow('Location', $formVals['location']);
	$mailBody .= makeRow('Indoor/Outdoor', $formVals['indoorOutdoor']);
	$mailBody .= makeRow('Time', $formVals['time'] . ' ' . $formVals['ampm']);
	$mailBody .= makeRow('Duration', $formVals['eventLength']);
	$mailBody .= makeRow('Attendance', $formVals['attendance']);
	$mailBody .= makeRow('Description', $formVals['description']);
	
	if ($formVals['specialInstructions'] != '') {
		$mailBody .= makeRow('Special Instructions', $formVals['specialInstructions']);
	}
	if ($formVals['hazards'] != '') {
		$mailBody .= makeRow('Hazards', $formVals['hazards']);
	}
	if ($formVals['personnel'] != '') {
		$mailBody .= makeRow('Other Personnel', 'There will be other emergency personnel on location');
	}
	
	$mailBody .= makeRow('Contact Name', $formVals['contact']);
	$mailBody .= makeRow('Contact Phone', $formVals['phone']);

	$mailBody .= "</table></body></html>\n";
	
//	$additionalHeaders  = '';
//	$additionalHeaders .= 'MIME-Version: 1.0' . "\r\n";
//	$additionalHeaders .= 'Content-type: text/html; charset=iso-8859-1';// . "\r\n";
//	@mail($mailToAddrs, $mailSubject, $mailBody, $additionalHeaders);
	
	$jsEnabled = intval(nnTrim($_REQUEST['jsEnabled']));
	
	if ($jsEnabled == 1) {
		$mailResult = sendMail($mailRecipients, $mailSubject, $mailBody);
	}
		
	header("Location: S-Events_thanks.html");

	exit;
	
	
	// ---------------------------------------------------------------------------
	// Helper functions
	// ---------------------------------------------------------------------------
	
	function makeRow($rowTitle, $rowValue) {
		$rowTitle = nnTrim($rowTitle);
		$rowValue = nnTrim($rowValue);
		
		return "<tr><td style='color: #66c; font-weight: bold; text-align: right; padding-right: 10px; font-size: 9pt;'>" . $rowTitle . ":</td><td>" . $rowValue . "</td></tr>\n";
		
		return $thisRow;
	}
	
	function nnTrim($input = '') {
		return stripslashes(trim($input));
	}
	
	function sendMail($to, $subject, $message) {
		$mail = new PHPMailer();

		$body = nnTrim($message);

		$mail->IsSMTP();
		$mail->SMTPAuth   = true;
		$mail->SMTPSecure = "ssl";
		$mail->Host       = "smtp.gmail.com";
		$mail->Port       = 465;

		$mail->Username   = "donotreply@victorfarmingtonambulance.org";
		$mail->Password   = "EJQ3nboWyB";

		$mail->From       = "donotreply@victorfarmingtonambulance.org";
		$mail->FromName   = "Web Form";
		$mail->Subject    = nnTrim($subject);
		//$mail->WordWrap   = 60;

		$mail->Body = $body;

		if (is_array($to)) {
			foreach($to as $thisRecipientAddress) {
				$mail->AddAddress(nnTrim($thisRecipientAddress));
			}
		} else {
			$mail->AddAddress(nnTrim($to));
		}
		

		$mail->IsHTML(true);

		if(!$mail->Send()) {
			return($mail->ErrorInfo);
		} else {
			return '';
		}
	}

?>