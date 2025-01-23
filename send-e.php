<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $org = trim($_POST["org"]);
    $number = trim($_POST["number"]);
    $subject = "From TMM Website";
    $message = trim($_POST["message"]);
    // Check if data is valid
    if (empty($name) || empty($org) || empty($message) || empty($number) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Please complete the form and try again.";
        exit;
    }

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'afaqahmed468@gmail.com';                     //SMTP username
    $mail->Password   = '';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('afaqahmed468@gmail.com', $name);
    $mail->addAddress('afaqahmed468@gmail.com', 'Form TMM Website');     //Add a recipient
    // $mail->addReplyTo('---------20@yahoo.com', 'Reply-To Name');     //reply to address
    
    
    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    ="Name = ".$name . '<br>' . "Email = ".$email . '<br>' . "Subject = ".$subject . '<br>' ."Organization = ".$org . '<br>' . "Number = ".$number . '<br>'."Messege = ". $message      ;
    
    
    
    
    
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
    $mail->send();
    echo 'Message has been sent';
    $thankYouMessage = 'Thank you for your submission!';
    // header ("Location: contact.html");
    header('Location: ' . $_SERVER['PHP_SELF']);

}


 catch (Exception $e) {
    $thankYouMessage = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}

else {
    http_response_code(403);
     header ("Location: contact.html");
}
?>