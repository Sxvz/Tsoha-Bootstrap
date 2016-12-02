<?php

class BaseController {

    public static function get_user_logged_in() {
        if (isset($_SESSION['user'])) {
            //return User::find_by_username($_SESSION['user']);
            return $_SESSION['user'];
        }

        return null;
    }

    public static function check_logged_in() {
        if (!isset($_SESSION['user'])) {
            Redirect::to('/login', array('error' => 'You need to log in to do that'));
        }
    }

}
