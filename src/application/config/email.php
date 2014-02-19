<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config['email_config']	= array(
    'transport_class'	=> 'Swift_SmtpTransport',
    'smtp_host' => 'mail.harws.com',
    'smtp_port' => 587,
    'smtp_security' => null,
    'smtp_user'	=> 'robot@harws.com',
    'smtp_pass' => 'PsoR7Tg6',
    'debug'    => false,
    'debug_email' => 'andres_zelinscek@honda.com.ar'
);