<?php

namespace misc;

class PasswordChecker
{

    public function check($password) {

        if(strlen($password) < 8) {
            echo "";
            return false;
        }

        if(!preg_match("/[A-Z]/", $password)) {
            echo "";
            return false;
        }
        if(!preg_match("/[a-z]/", $password)) {
            echo "";
            return false;
        }
        if(!preg_match("/[0-9]/", $password)) {
            echo "";
            return false;
        }
        if(!preg_match("/[!@#]/", $password)) {
            echo "";
            return false;
        }

        return true;
    }

}