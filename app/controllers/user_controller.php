<?php

class UserController extends BaseController {

    public static function login() {
        View::make('user/login.html');
    }

    public static function handle_login() {
        $params = $_POST;

        $user = User::authenticate($params['username'], $params['password']);

        if (!$user) {
            View::make('user/login.html', array('error' => 'Wrong username or password', 'username' => $params['username']));
        } else {
            $_SESSION['user'] = $user->username;

            Redirect::to('/');
        }
    }

    public static function register() {
        View::make('user/register.html');
    }

    public static function create_account() {
        $params = $_POST;
        $attributes = array(
            'username' => $params['username'],
            'password' => $params['password'],
            'password_confirm' => $params['password_confirm'],
        );

        $user = new User($attributes);
        $errors = $user->errors();
        
        if (count($errors) == 0) {
            //$user->save();
            //Redirect::to('/login', array('info' => 'Operation successful!', 'username' => $user->username));
            View::make('user/register.html', array('errors' => $errors));
        } else {
            View::make('user/register.html', array('errors' => $errors));
        }
    }

}
