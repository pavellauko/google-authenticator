<?php

namespace Rixxi\GoogleAuthenticator;

class SystemTimestampProvider implements ITimestampProvider
{

	public static function getInstance()
	{
		static $instance = null;
		if ($instance === null) {
			$instance = new static;
		}
		return $instance;
	}


	public function getTimestamp()
	{
		return time();
	}

}
