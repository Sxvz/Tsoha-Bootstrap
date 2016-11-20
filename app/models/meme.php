<?php

class Meme extends BaseModel {

    public $id, $poster, $title, $type, $content;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function find_all($offset) {
        $query = DB::connection()->prepare('SELECT * FROM Meme OFFSET :offset LIMIT 10');
        $query->execute(array('offset' => $offset));

        return self::fetch($query);
    }

    public static function find_all_by_x($offset, $type, $phrase) {
        $type = self::sanitize_type($type);
        $phrase = '%' . $phrase . '%';
        $query = DB::connection()->prepare("SELECT * FROM Meme WHERE lower($type) LIKE lower(:phrase) OFFSET :offset LIMIT 10");
        $query->execute(array('phrase' => $phrase, 'offset' => $offset));

        return self::fetch($query);
    }

    private static function fetch($query) {
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

    private static function sanitize_type($type) {
        if ($type != 'Title' && $type != 'Type' && $type != 'Content' && $type != 'Poster') {
            $type = 'Title';
        }

        return $type;
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
        $query = DB::connection()->prepare('SELECT count(*) as count FROM Meme');
        $query->execute();
        $result = $query->fetch();

        return $result['count'];
    }

    public static function count_search_results($type, $phrase) {
        $type = self::sanitize_type($type);
        $phrase = '%' . $phrase . '%';
        $query = DB::connection()->prepare("SELECT count(*) as count FROM Meme WHERE lower($type) LIKE lower(:phrase)");
        $query->execute(array('phrase' => $phrase));
        $result = $query->fetch();

        return $result['count'];
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Meme (poster, title, type, content) VALUES (:poster, :title, :type, :content) RETURNING id');
        $query->execute(array('poster' => $this->poster, 'title' => $this->title, 'type' => $this->type, 'content' => $this->content));
        $result = $query->fetch();
        $this->id = $result['id'];
    }

}
