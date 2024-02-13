<?php 
	
	// checking if the form is submit
	if ( isset($_POST['submit']) ) {
		$fullname	= $_POST['fullname'];
		$email		= $_POST['email'];
		$subject	= $_POST['subject'];
		$productId	= $_POST['productIdEmail'];
		$userId	    = $_POST['userId'];
		$message	= $_POST['message'];

		$to	 		  = 'examplewebd@gmail.com';
		$mail_subject = 'Message from Website';
		$email_body   = "Message from Contact Us Page of the Website: <br>";
		$email_body   .= "<b>From:</b> {$fullname} <br>";
		$email_body   .= "<b>User ID:</b> {$userId} <br>";
		$email_body   .= "<b>Email:</b> {$email} <br>";
		$email_body   .= "<b>Subject:</b> {$subject} <br>";
		$email_body   .= "<b>Product ID:</b> {$productId} <br>";
		$email_body   .= "<b>Message:</b><br>" . nl2br(strip_tags($message));

		$header       = "From: {$email}\r\nContent-Type: text/html;";

		$send_mail_result = mail($to, $mail_subject, $email_body, $header);


		if ( $send_mail_result ) {
			header("location: ../import.php?product_id=$productId&message=sent");

			
		} else {
			header("location: ../import.php?product_id=$productId&message=not_sent");
	}
}
 ?>