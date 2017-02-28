<?php
	require_once('cgi-bin/class.phpmailer.php');
	require_once('cgi-bin/class.smtp.php');
	
	$mailRecipients = array('vlisc@symbolicinc.com', 'vlisciandro@gmail.com');
	
	//$mailResult = sendMail('operations@victorfarmingtonambulance.org', 'Test with new server mail setup', 'We are testing the new mail setup before we make it live on the web form. Please let us know when you get this so we know it works. Thank you. You can email us at tech@symbolicinc.com');
	$mailResult = sendMail($mailRecipients, 'Outgoing Mail Multiple Addresses', 'Checking to see if mailer is ok with multiples - now in array - no wordwrap.');
	
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
		

		$mail->IsHTML(false);

		if(!$mail->Send()) {
			return($mail->ErrorInfo);
		} else {
			return '';
		}
	}
	
	function nnTrim($inputString='') {
		return trim($inputString);
	}
?>
<html>
	<body>
		Mail result: '<?php echo $mailResult; ?>'
	</body>
</html>
