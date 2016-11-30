<?php

class User extends BaseModel {

    public $username, $password, $password_confirm;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function authenticate($username, $password) {
        $user = self::find_by_username($username);

        //if (password_verify($password, $user->password)) { //php 5.5+ tarvitaan (laitoksen koneilla liian käpynen versio)
        if ($user != null && $user->password === crypt($password, $user->password)) {
            return $user;
        }

        return false;
    }

    public static function find_all_usernames() {
        $query = DB::connection()->prepare('SELECT username FROM Usr');
        $query->execute();
        $usernames = $query->fetchAll();

        return $usernames;
    }

    public static function find_by_username($username) {
        $query = DB::connection()->prepare('SELECT * FROM Usr WHERE username = :username');
        $query->execute(array('username' => $username));
        $row = $query->fetch();

        if ($row) {
            $user = new User(array(
                'username' => $row['username'],
                'password' => $row['password']
            ));

            return $user;
        }

        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Usr (username, password) VALUES (:username, :password)');
        $query->execute(array('username' => $this->username, 'password' => crypt($this->password))); //php 5.5+ password_hash()
    }

    protected function add_valitron_rules() {
        $this->valitron->rule('required', array('username', 'password'));
        $this->valitron->rule('lengthBetween', 'username', 3, 20);
        $this->valitron->rule('lengthMin', 'password', 6);
        $user = $this;
        $this->valitron->addRule('usernameUnique', function($field, $value, array $params, array $fields) use($user) {
            return $user->is_username_unique();
        }, 'is already in use.');
        $this->valitron->rule('usernameUnique', 'username');
        //$this->valitron->rule('alphaNum', 'username');
        $this->valitron->rule('equals', 'password', 'password_confirm')->message('Passwords must match');
    }

    public function is_username_unique() {
        foreach (self::find_all_usernames() as $username) {
            if ($this->username === $username[0]) {
                return false;
            }
        }

        return true;
    }

    protected function setup_valitron() {
        $attributes = array('username' => $this->username,
            'password' => $this->password,
            'password_confirm' => $this->password_confirm);
        $this->valitron = new Valitron\Validator($attributes);
    }

}
