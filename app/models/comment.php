<?php

class Comment extends BaseModel {

    public $id, $poster, $parent_meme, $message, $posted, $edited;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
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

    public static function find_by_parent_meme($parent_meme) {
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
    
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Comment (poster, parent_meme, message, posted) VALUES (:poster, :parent_meme, :message, now()) RETURNING id');
        $query->execute(array('poster' => $this->poster, 'parent_meme' => $this->parent_meme, 'message' => $this->message));
        $result = $query->fetch();
        $this->id = $result['id'];
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Comment SET message = :message, edited = now() WHERE id = :id');
        $query->execute(array('message' => $this->message, 'id' => $this->id));
    }

    public function delete() {
        $query = DB::connection()->prepare('DELETE FROM Comment WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }

    protected function add_valitron_rules() {
        $this->valitron->rule('required', array('poster', 'parent_meme', 'message'));
        $this->valitron->rule('lengthBetween', 'message', 1, 200);
    }

    protected function setup_valitron() {
        $attributes = array('poster' => $this->poster,
            'parent_meme' => $this->parent_meme,
            'message' => $this->message);
        $this->valitron = new Valitron\Validator($attributes);
    }

}
