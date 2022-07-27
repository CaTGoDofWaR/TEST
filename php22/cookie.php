<?php

class Cookie
{
    public function set(string $key, $value, int $limit = 0)
    {
        setcookie($key, $value, time() + $limit, "/");
    }

    public function unset(string $key)
    {
        setcookie($key, "", time() - 3600, "/");
    }

    public function getcookie($name) {
        $cookies = [];
        $headers = headers_list();
        foreach($headers as $header) {
            if (strpos($header, 'Set-Cookie: ') === 0) {
                $value = str_replace('&', urlencode('&'), substr($header, 12));
                parse_str(current(explode(';', $value, 1)), $pair);
                $cookies = array_merge_recursive($cookies, $pair);
            }
        }
        return $cookies[$name];
    }
}
?>