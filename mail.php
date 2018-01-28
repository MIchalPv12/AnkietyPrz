<?php 
//Konfiguracja

//Koniec Konfiguracji

function smtp_mail($mail_to, $subject, $message){ 
    $header="Content-Type: text/plain; charset=UTF-8";
$smtp_host="smtp.wp.pl"; //adres serwera smtp np:smtp.wp.pl
$smtp_user="AnkietyPrz@wp.pl"; //login na twoje konto
$smtp_pass="test123$"; //haslo na twoje konto
$email="AnkietyPrz@wp.pl"; //twoj adres email
    
    if($mail_to == '')   
        $error = 'Nie poda³eœ adresu odbiorcy!';   
    if(trim($subject) == '')   
        $error = 'Nie poda³eœ tematu wiadomoœci!'; 
    if(trim($message) == '')   
        $error = 'Wiadomoœæ jest pusta!'; 
    if(!$socket = pfsockopen($smtp_host, 25, $errno, $errstr, 20))   
        $error = 'Nie mogê siê po³¹czyæ z serwerem SMTP!'; 

    if(!empty($error)){ 
        echo "<B>B³¹d: </B>$error<BR>\n"; 
        return false; 
    }      

    
    if(!empty($smtp_user) && !empty($smtp_pass)){ 
        fputs($socket, 'EHLO '.$smtp_host."\r\n");     
        fputs($socket, "AUTH LOGIN\r\n");     
        fputs($socket, base64_encode($smtp_user)."\r\n");   
        fputs($socket, base64_encode($smtp_pass)."\r\n");     
    }   
    else{ 
        fputs($socket, 'HELO '.$smtp_host."\r\n");    
    } 
    
    fputs($socket, 'MAIL FROM: <' . $email . ">\r\n"); 
    $mail_to_array = explode(',', $mail_to);   
    

    $to_header = 'To: '; 
    @reset($mail_to_array); 
      
    foreach($mail_to_array as $mail_to_address){ 
        $mail_to_address = trim($mail_to_address); 
          
        if (preg_match('/[^ ]+\@[^ ]+/', $mail_to_address)) { 
            fputs( $socket, "RCPT TO: <$mail_to_address>\r\n" ); 
        } 
        $to_header .= (($mail_to_address != '') ? ', ' : '')."<$mail_to_address>"; 
    } 
    
    $message = preg_replace("/(?<!\r)\n/si", "\r\n", $message); 
    
    fputs($socket, "DATA\r\n"); 
    fputs($socket, "Subject: $subject\r\n"); 
    fputs($socket, "$to_header\r\n"); 
    fputs($socket, "From: $email\r\n");   
    fputs($socket, "$header\r\n\r\n"); 
    fputs($socket, "$message\r\n"); 
    fputs($socket, ".\r\n"); 
    fputs($socket, "QUIT\r\n"); 
    fclose($socket); 

    return true; 
} 
 

?>