<?php

//Huolehtii käyttäjiin liittyvistä toiminnoista.
class UserController extends BaseController {

    //Näyttää login-sivun. Tälle ja vastaaville sivuille ei pääse kirjautuneena,
    //vaan vaaditaan ensin uloskirjautuminen.
    public static function login() {
        self::redirect_to_root_if_logged_in();
        
        View::make('user/login.html');
    }

    //Käsittelee sisäänkirjautumisen.
    public static function handle_login() {
        self::redirect_to_root_if_logged_in();
        
        $params = $_POST;

        $user = User::authenticate($params['username'], $params['password']);

        if (!$user) {
            Redirect::to('/login', array('error' => 'Wrong username or password', 'username' => $params['username']));
        } else {
            $_SESSION['user'] = $user->username;

            Redirect::to('/');
        }
    }

    //Näyttää rekisteröintisivun.
    public static function register() {
        self::redirect_to_root_if_logged_in();
        
        View::make('user/register.html');
    }

    //Huolehtii uuden käyttäjätilin luomisesta.
    public static function create_account() {
        self::redirect_to_root_if_logged_in();
        
        $params = $_POST;
        $attributes = array(
            'username' => $params['username'],
            'password' => $params['password'],
            'password_confirm' => $params['password_confirm'],
        );

        $user = new User($attributes);
        $errors = $user->errors();

        if (count($errors) == 0) {
            $user->save();
            Redirect::to('/login', array('info' => 'Operation successful!', 'username' => $user->username));
        } else {
            Redirect::to('/register', array('errors' => $errors, 'username' => $params['username']));
        }
    }

    //Käsittelee uloskirjautumisen.
    public static function logout() {
        self::check_logged_in();

        $_SESSION['user'] = null;

        Redirect::to('/login', array('info' => 'You have been logged out'));
    }

    //Apumetodi, joka ohjaa käyttäjän takaisin etusivulle, jos tämä on
    //kirjautuneena.
    private static function redirect_to_root_if_logged_in() {
        if (self::get_user_logged_in() != null) {
            Redirect::to('/', array('error' => 'You are already logged in'));
        }
    }

}
