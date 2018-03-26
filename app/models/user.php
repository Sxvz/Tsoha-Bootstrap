<?php

//Huolehtii käyttäjän autentikoinnista ja tietokantatoiminnallisuudesta.
class User extends BaseModel {

    public $username, $password, $password_confirm;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    //Tarkistaa vastaako kannassa oleva hashi syötetyn salasanan hashiä
    //kyseisellä käyttäjällä.
    public static function authenticate($username, $password) {
        $user = self::find_by_username($username);

        //if (password_verify($password, $user->password)) { 
        //ylläoleva tapa on parempi mutta siihen tarvittaisiin php 5.5+
        //(laitoksen koneilla liian käpynen versio)
        if ($user != null && $user->password === crypt($password, $user->password)) {
            return $user;
        }

        return false;
    }

    //Hakee kaikki käyttäjänimet kannasta.
    public static function find_all_usernames() {
        $query = DB::connection()->prepare('SELECT username FROM Usr');
        $query->execute();
        $usernames = $query->fetchAll();

        return $usernames;
    }

    //Hakee käyttäjän kannasta nimen perusteella.
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

    //Tallettaa käyttäjän kantaan.
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Usr (username, password) VALUES (:username, :password)');
        $query->execute(array('username' => $this->username, 'password' => password_hash($this->password, PASSWORD_DEFAULT))); //php 5.5+ password_hash() ja crypt() php <5.5
    }

    //Lisää käyttäjän validointisäännöt.
    protected function add_valitron_rules() {
        $this->valitron->rule('required', array('username', 'password'));
        $this->valitron->rule('lengthBetween', 'username', 3, 20);
        $this->valitron->rule('lengthMin', 'password', 6)->message("Password must be longer than 6 characters");
        $user = $this;
        $this->valitron->addRule('usernameUnique', function($field, $value, array $params, array $fields) use($user) {
            return $user->is_username_unique();
        }, 'is already in use');
        $this->valitron->rule('usernameUnique', 'username');
        //$this->valitron->rule('alphaNum', 'username');
        $this->valitron->rule('equals', 'password', 'password_confirm')->message('Passwords must match');
    }

    //Tarkistaa onko käyttäjänimi uniikki.
    public function is_username_unique() {
        foreach (self::find_all_usernames() as $username) {
            if ($this->username === $username[0]) {
                return false;
            }
        }

        return true;
    }

    //Alustaa validointiolion.
    protected function setup_valitron() {
        $attributes = array('username' => $this->username,
            'password' => $this->password,
            'password_confirm' => $this->password_confirm);
        $this->valitron = new Valitron\Validator($attributes);
    }

}
