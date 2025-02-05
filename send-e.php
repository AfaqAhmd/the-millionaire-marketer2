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
        echo json_encode(["success" => false, "message" => "Invalid form input. Please try again."]);
        exit;
    }

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'tmm.support@crtmm.com';                     //SMTP username
    $mail->Password   = '';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`




    //Recipients
    $mail->setFrom('no-reply@TMM.com', $name);
    $mail->addAddress('tmm.support@crtmm.com', 'From TMM Website');     //Add a recipient
    // $mail->addReplyTo('---------20@yahoo.com', 'Reply-To Name');     //reply to address
    
    
    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    ="
            <h2>New Contact Form Submission</h2>
            <p><strong>Name:</strong> {$name}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Organization:</strong> {$org}</p>
            <p><strong>Phone Number:</strong> {$number}</p>
            <p><strong>Message:</strong> {$message}</p>
        ";
    
    
    
    
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
    $mail->send();
    http_response_code(200);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(["success" => true, "message" => "Form submitted successfully!"]);
    exit;

    // header ("Location: contact.html");
    // header('Location: ' . $_SERVER['PHP_SELF']);

}


 catch (Exception $e) {
    http_response_code(500);
        echo json_encode(["success" => false, "message" => "Mailer Error: {$mail->ErrorInfo}"]);
}
}

else {
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "Forbidden: Invalid request method."]);
}
?>