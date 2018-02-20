<?php

class Hash {

    public static function hashPassword($password) {
        $hashedPassword = md5($password);
        return $hashedPassword;
    }
}