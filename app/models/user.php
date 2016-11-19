<?php

class User extends BaseModel {

    public $username, $password;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

}
