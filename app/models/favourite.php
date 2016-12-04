<?php

class Favourite extends BaseModel {

    public $username, $meme_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function find_favourite_memes_by_username($username, $offset) {
        $query = DB::connection()->prepare('SELECT * FROM Favourite INNER JOIN Meme ON meme_id = id AND username = :username LIMIT :limit OFFSET :offset');
        $query->execute(array('username' => $username, 'offset' => $offset, 'limit' => self::$entries_per_page));
        $rows = $query->fetchAll();

        return Meme::construct_from_rows($rows);
    }

    public static function count_results($username) {
        $query = DB::connection()->prepare('SELECT count(*) AS count FROM Favourite INNER JOIN Meme ON meme_id = id AND username = :username');
        $query->execute(array('username' => $username));
        $result = $query->fetch();

        return $result['count'];
    }

    public static function find_one($username, $meme_id) {
        $query = DB::connection()->prepare('SELECT * FROM Favourite WHERE username = :username AND meme_id = :meme_id');
        $query->execute(array('username' => $username, 'meme_id' => $meme_id));
        $row = $query->fetch();

        if ($row) {
            $favourite = new Favourite(array(
                'username' => $row['username'],
                'meme_id' => $row['meme_id']
            ));

            return $favourite;
        }

        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Favourite VALUES (:username, :meme_id)');
        $query->execute(array('username' => $this->username, 'meme_id' => $this->meme_id));
    }

    public function delete() {
        $query = DB::connection()->prepare('DELETE FROM Favourite WHERE username = :username AND meme_id = :meme_id');
        $query->execute(array('username' => $this->username, 'meme_id' => $this->meme_id));
    }

    protected function add_valitron_rules() {
        $this->valitron->rule('required', array('username', 'meme_id'));
        $favourite = $this;
        $this->valitron->addRule('entityIsUnique', function($field, $value, array $params, array $fields) use($favourite) {
            return $favourite->is_unique();
        }, '');
        $this->valitron->rule('entityIsUnique', 'username')->message('This meme is already in your favourites');
    }

    public function is_unique() {
        if (Favourite::find_one($this->username, $this->meme_id) != null) {
            return false;
        }
        
        return true;
    }

    protected function setup_valitron() {
        $attributes = array('username' => $this->username,
            'meme_id' => $this->meme_id);
        $this->valitron = new Valitron\Validator($attributes);
    }

}
