<?php

//Luokka, jossa on kommenttien tietokantatoiminnallisuus ja validointi.
class Comment extends BaseModel {

    public $id, $poster, $parent_meme, $message, $posted, $edited;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    //Etsii halutun kommentin tietokannasta.
    public static function find_one($id) {
        $query = DB::connection()->prepare('SELECT * FROM Comment WHERE id = :id');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $comment = new Comment(array(
                'id' => $row['id'],
                'poster' => $row['poster'],
                'parent_meme' => $row['parent_meme'],
                'message' => $row['message'],
                'posted' => $row['posted'],
                'edited' => $row['edited']
            ));

            return $comment;
        }

        return null;
    }

    //Etsii haluttuun meemiin liittyvät kommentit tietokannasta.
    public static function find_all_by_parent_meme($parent_meme) {
        $query = DB::connection()->prepare('SELECT * FROM Comment WHERE parent_meme = :parent_meme');
        $query->execute(array('parent_meme' => $parent_meme));
        $rows = $query->fetchAll();
        $comments = array();

        foreach ($rows as $row) {
            $comments[] = new Comment(array(
                'id' => $row['id'],
                'poster' => $row['poster'],
                'parent_meme' => $row['parent_meme'],
                'message' => $row['message'],
                'posted' => $row['posted'],
                'edited' => $row['edited']
            ));
        }

        return $comments;
    }
    
    //Tallettaa kommentin tietokantaa.
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Comment (poster, parent_meme, message, posted) VALUES (:poster, :parent_meme, :message, now()) RETURNING id');
        $query->execute(array('poster' => $this->poster, 'parent_meme' => $this->parent_meme, 'message' => $this->message));
        $result = $query->fetch();
        $this->id = $result['id'];
    }

    //Päivittää tietokannassa olevan kommentin.
    public function update() {
        $query = DB::connection()->prepare('UPDATE Comment SET message = :message, edited = now() WHERE id = :id');
        $query->execute(array('message' => $this->message, 'id' => $this->id));
    }

    //Poistaa kommentin.
    public function delete() {
        $query = DB::connection()->prepare('DELETE FROM Comment WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }

    //Lisää kommentille olennaiset validointisäännöt validointikirjaston
    //oliolle.
    protected function add_valitron_rules() {
        $this->valitron->rule('required', array('poster', 'parent_meme', 'message'));
        $this->valitron->rule('lengthBetween', 'message', 1, 200);
    }

    //Alustaa kommentin validointiin tarvittavan olion.
    protected function setup_valitron() {
        $attributes = array('poster' => $this->poster,
            'parent_meme' => $this->parent_meme,
            'message' => $this->message);
        $this->valitron = new Valitron\Validator($attributes);
    }

}
