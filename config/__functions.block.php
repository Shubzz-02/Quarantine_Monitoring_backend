<?php


class Functions
{
    private $random_salt_length = 0;

    public function __construct()
    {
        $this->random_salt_length = 32;
    }

    function getSalt()
    {
        return bin2hex(openssl_random_pseudo_bytes($this->random_salt_length));
    }

    function concatPasswordWithSalt($password, $salt)
    {
        if ($this->random_salt_length % 2 == 0) {
            $mid = $this->random_salt_length / 2;
        } else {
            $mid = ($this->random_salt_length - 1) / 2;
        }
        return
            substr($salt, 0, $mid - 1) . $password . substr($salt, $mid, $this->random_salt_length - 1);
    }

    function random($len)
    {
        $length = $len;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

}