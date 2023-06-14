<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'libs/mailer/src/Exception.php';
    require 'libs/mailer/src/PHPMailer.php';
    require 'libs/mailer/src/SMTP.php';

    $mail = new PHPMailer(true);

    echo "<h4>Sending your message...</h4>";

    $name = $_POST["name"];
    $email = $_POST["email"];
    $serviceType = $_POST["serviceType"];
    $phone = $_POST["phone"];
    $message = $_POST["message"];
    $finalLocation = 'send_us_a_message.html';

    echo "Welcome back, $name, $email, $serviceType, $phone, $message";

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = '***';
        $mail->SMTPAuth   = true;
        $mail->Username   = '***';
        $mail->Password   = '***';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;
    
        //Recipients
        $mail->setFrom('rockrealtymailer@rockrealtylimited.com');
        $mail->addAddress('info@rockrealtylimited.com');
        $mail->addReplyTo($email);

        $serviceTypeUpper = strtoupper($serviceType);
    
        //Content
        $mail->isHTML(true);
        $mail->Subject = "CUSTOMER INQUIRY ON $serviceTypeUpper - RRL WEBSITE";
        $mail->Body    = "Dear Rock Realty Team, <br/><br/>There is a new customer inquiry on $serviceType. See details below: <br/><br/> <b>Name:</b> $name <br/> <b>Phone Number:</b> $phone <br/> <b>Service Type:</b> $serviceType <br/> <b>Message:</b> $message";
        $mail->AltBody = "Dear Rock Realty Team, \n \n There is a new customer inquiry on $serviceType. See details below: \n \n Name: $name \n Phone Number: $phone \n Service Type: $serviceType \n Message: $message";
    
        $mail->send();
        echo 'Message has been sent';

        header("Location: $finalLocation?msgSent=Y");
        die();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

        header("Location: $finalLocation?msgSent=N");
        die();
    }
?>