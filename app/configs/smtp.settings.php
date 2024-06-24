<?php
    if(!defined("CryptExchanger_INSTALLED")){
        header("HTTP/1.0 404 Not Found");
        exit;
    }
    
    $smtpconf = array();
    $smtpconf["host"] = "mail.virsymcoin.com"; // SMTP SERVER IP/HOST
    $smtpconf["user"] = "info@virsymcoin.com";	// SMTP AUTH USERNAME if SMTPAuth is true
    $smtpconf["pass"] = "@I2D=+UCVeTz";	// SMTP AUTH PASSWORD if SMTPAuth is true
    $smtpconf["port"] = "587";	// SMTP SERVER PORT
    $smtpconf["ssl"] = "1"; // 1 -  YES, 0 - NO
    $smtpconf["SMTPAuth"] = true; // true / false
    ?>
    