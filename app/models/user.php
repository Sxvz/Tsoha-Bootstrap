<?php

class User extends BaseModel {

    public $username, $password, $password_confirm;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function authenticate($username, $password) {
        $user = self::find_by_username($username);

        if (password_verify($password, $user->password)) {
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
        $query->execute(array('username' => $this->username, 'password' => password_hash($this->password, PASSWORD_DEFAULT)));
    }

    protected function add_valitron_rules() {
        $this->valitron->rule('required', array('username', 'password'));
        $this->valitron->rule('lengthBetween', 'username', 3, 20);
        $this->valitron->rule('lengthMin', 'password', 6);
        $this->valitron->addRule('usernameUnique', function($field, $value, array $params, array $fields) {
            return $this->is_username_unique();
        }, 'is already in use.');
        $this->valitron->rule('usernameUnique', 'username');
        $this->valitron->rule('equals', array('password', 'password_confirm'))->message('Passwords must match');
    }
    
    private function is_username_unique() {
        foreach (self::find_all_usernames() as $username) {
            if ($this->username === $username) {
                return false;
            }
        }
        
        return true;
    }

}
