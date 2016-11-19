<?php

class Meme extends BaseModel {

    public $id, $poster, $title, $type, $content;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function find_all($offset) {
        $query = DB::connection()->prepare('SELECT * FROM Meme OFFSET :offset LIMIT 10');
        $query->execute(array('offset' => $offset));
        $rows = $query->fetchAll();
        $memes = array();

        foreach ($rows as $row) {
            $memes[] = new Meme(array(
                'id' => $row['id'],
                'poster' => $row['poster'],
                'title' => $row['title'],
                'type' => $row['type'],
                'content' => $row['content'],
            ));
        }

        return $memes;
    }

    public static function find_one($id) {
        $query = DB::connection()->prepare('SELECT * FROM Meme WHERE id = :id');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $meme = new Meme(array(
                'id' => $row['id'],
                'poster' => $row['poster'],
                'title' => $row['title'],
                'type' => $row['type'],
                'content' => $row['content'],
            ));

            return $meme;
        }

        return null;
    }
    
    public static function count() {
        $query = DB::connection()->prepare('SELECT count(*) as count FROM Meme;');
        $query->execute();
        $result = $query->fetch();

        return $result['count'];
    }

}
