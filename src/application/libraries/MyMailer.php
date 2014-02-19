<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__).'/swift-mailer/swift_required.php';

class MyMailer
{

    /**
     * Genera una nueva instancia de Swift_Mailer
     * @param boolean $debug
     * @return Swift_Mailer
     */
	static public function getNewInstance($debug = null)
	{
	    // get config
	    require dirname(__FILE__).'/../config/email.php';

	    $debug = $debug ? $debug : $config['email_config']['debug'];

		$transport = $config['email_config']['transport_class']::newInstance($config['email_config']['smtp_host'],$config['email_config']['smtp_port'],$config['email_config']['smtp_security'])
			->setUsername($config['email_config']['smtp_user'])
			->setPassword($config['email_config']['smtp_pass']);
		$mailer = Swift_Mailer::newInstance($transport);
	    if ($debug)
	    {
    		$mailer->registerPlugin(new Swift_Plugins_RedirectingPlugin($config['email_config']['debug_email']));
	    }
		return $mailer;
	}

}