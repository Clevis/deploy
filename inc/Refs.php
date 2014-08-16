<?php

class Refs
{

	public static function read()
	{
		$lines = [];
		while ($line = fgets(STDIN))
		{
			$lines[] = explode(' ', trim($line));
		}

		return $lines;
	}

	public static function getRef()
	{
		foreach (Refs::read() as $row)
		{
			list($from, $to, $ref) = $row;
			return $ref;
		}
		return NULL;
	}

	public static function getCommit()
	{
		foreach (Refs::read() as $row)
		{
			list($from, $to, $ref) = $row;
			return $to;
		}
		return NULL;
	}

	public static function validate($ref)
	{
		return in_array($ref, ['refs/heads/production', 'refs/heads/test']);
	}

}
