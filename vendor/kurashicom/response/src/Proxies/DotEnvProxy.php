<?php namespace Kurashicom\Response\Proxies;

class DotEnvProxy
{

    /**
     * Call global get_env function.
     *
     * @param  string $key
     * @param  mixed  $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return getenv($key) ? getenv($key) : $default;
    }
}
