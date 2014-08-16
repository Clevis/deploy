<?php

class Lock
{

	const FILE = '/tmp/lock-deploy-webexpo';

	static $autorelease = TRUE;

	public static function check()
	{
		if (file_exists(self::FILE) && filemtime(self::FILE) > strToTime('-10 minutes'))
		{
			$ip = file_get_contents(self::FILE);
			$date = date('Y-m-d H:i:s', filemtime(self::FILE));
			System::fail("Site is being deployed by $ip since $date");
		}
	}

	public static function create()
	{
		list($ip) = explode(' ', getenv('SSH_CLIENT')) + ['unknown'];
		file_put_contents(self::FILE, $ip);
	}

	public static function release()
	{
		@unlink(self::FILE);
	}

	public static function registerAutorelease()
	{
		register_shutdown_function(function() {
			if (self::$autorelease)
			{
				self::release();
			}
		});
	}

	public static function disableAutorelease()
	{
		self::$autorelease = FALSE;
	}

}
