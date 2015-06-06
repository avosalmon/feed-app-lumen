<?php namespace Kurashicom\Response\Proxies;

class DotEnvProxy {

	/**
	 * Call global get_env function.
	 *
	 * @param  string $key
	 * @return string
	 */
	public function get($key)
	{
		return getenv($key);
	}
}
