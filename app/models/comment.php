<?php

class Comment extends BaseModel {

    public $id, $poster, $parent_meme, $message, $posted, $edited;

    public function __construct($attributes) {
        parent::__construct($attributes);
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

    protected function add_valitron_rules() {
        $this->valitron->rule('required', array('poster', 'parent_meme', 'message', 'posted'));
        $this->valitron->rule('lengthMax', 'message', 200);
    }

    protected function setup_valitron() {
        $attributes = array('poster' => $this->poster,
            'parent_meme' => $this->parent_meme,
            'message' => $this->message,
            'posted' => $this->posted);
        $this->valitron = new Valitron\Validator($attributes);
    }

}
