<?php

use MVC\Core\Model\Model;

class Auth {

    private $model;
    private $firstName;
    private $lastName;
    private $nick;
    private $email;
    private $password;
    private $passwordAgain;
    private $errors = array();

    public function __construct($firstName, $lastName, $nick, $email, $password, $passwordAgain) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->nick = $nick;
        $this->email = $email;
        $this->password = $password;
        $this->passwordAgain = $passwordAgain;
        $this->model = Model::getInstance();
    }

    public function isRegistrationAvailable() {
        $this->areVariablesSet();
        $this->checkNickLength();
        $this->checkNickExists();
        $this->checkEmailExists();
        $this->checkPasswordLength();
        $this->arePasswordsMatch();
        if ($this->errors == null) {
            return true;
        } else {
            return false;
        }
    }

    public function isLoginAvailable() {
        return true;
    }

    public function getErrors() {
        return $this->errors;
    }

    private function areVariablesSet() {
        if (FIRST_NAME_REQUIRED && $this->firstName == null) {
            array_push($this->errors, 'First Name is required');
        }
        if (LAST_NAME_REQUIRED && $this->lastName == null) {
            array_push($this->errors, 'Last Name is required');
        }
        if (NICK_REQUIRED && $this->nick == null) {
            array_push($this->errors, 'Nick is required');
        }
        if (EMAIL_REQUIRED && $this->email == null) {
            array_push($this->errors, 'Email is required');
        }
        if (PASSWORD_REQUIRED && $this->password == null) {
            array_push($this->errors, 'Password is required');
        }
        if (PASSWORD_AGAIN_REQUIRED && $this->passwordAgain == null) {
            array_push($this->errors, 'Repeated password is required');
        }
    }

    private function checkNickLength() {
        if(strlen($this->nick) < NICK_LENGTH_MIN) {
            array_push($this->errors, 'Nick name is too short');
        }
        if(strlen($this->nick) > NICK_LENGTH_MAX) {
            array_push($this->errors, 'Nick name is too long');
        }
    }

    private function checkNickExists() {
        $dbNick = $this->model->query('SELECT * FROM users WHERE username = :username', array(':username' => $this->nick));
        if($dbNick->getCount() != 0) {
            array_push($this->errors, 'User already exists');
        }
    }

    private function checkEmailExists() {
        $dbEmail = $this->model->query('SELECT * FROM users WHERE email = ?', array($this->email), PDO::FETCH_OBJ)->getCount();
        if ($dbEmail != 0) {
            array_push($this->errors, 'Email already used');
        }
    }

    private function checkPasswordLength() {
        if(strlen($this->password) < PASSWORD_LENGTH_MIN) {
            array_push($this->errors, 'Password is too short');
        }
        if(strlen($this->password) > PASSWORD_LENGTH_MAX) {
            array_push($this->errors, 'Password is too long');
        }
    }

    private function arePasswordsMatch() {
        if ($this->passwordAgain != $this->password) {
            array_push($this->errors, 'Passwords are not same');
        }
    }
}