<?php

class System
{

	public static $failed = FALSE;

	public static function fail($message)
	{
		$message = str_replace("\n", "\033[0m\n\033[1;31m", $message);
		self::$failed = TRUE;
		echo "\033[1;31m$message\033[0m\n";
		exit(1);
	}

}
