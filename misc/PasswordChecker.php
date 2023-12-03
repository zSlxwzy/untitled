<?php

namespace misc;

class PasswordChecker
{

    public function check($password) {

        if(strlen($password) < 8) {

            return false;
        }

        if(!preg_match("/A-Z/")) {

            return false;
        }

        return true;
    }




}