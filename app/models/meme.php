<?php

class Meme extends BaseModel {

    public $id, $poster, $title, $type, $content;
    private static $entries_per_page = 10;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function find_all($offset) {
        $query = DB::connection()->prepare('SELECT * FROM Meme ORDER BY id DESC OFFSET :offset LIMIT :limit');
        $query->execute(array('offset' => $offset, 'limit' => self::$entries_per_page));

        return self::fetchMany($query);
    }

    public static function find_all_by_x($offset, $type, $phrase) {
        $type = self::sanitize_research_type($type);
        if ($type != 'Poster') {
            $phrase = '%' . $phrase . '%';
        }
        $query = DB::connection()->prepare("SELECT * FROM Meme WHERE lower($type) LIKE lower(:phrase) ORDER BY id DESC OFFSET :offset LIMIT :limit");
        $query->execute(array('phrase' => $phrase, 'offset' => $offset, 'limit' => self::$entries_per_page));

        return self::fetchMany($query);
    }

    private static function fetchMany($query) {
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

    private static function sanitize_research_type($type) {
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
        $type = self::sanitize_research_type($type);
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

    public function update() {
        $query = DB::connection()->prepare('UPDATE Meme SET title = :title, content = :content WHERE id = :id');
        $query->execute(array('title' => $this->title, 'content' => $this->content, 'id' => $this->id));
    }

    public function delete() {
        $query = DB::connection()->prepare('DELETE FROM Meme WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }

    public static function find_all_ids() {
        $query = DB::connection()->prepare('SELECT id FROM Meme');
        $query->execute();

        return $query->fetchAll();
    }

    protected function add_valitron_rules() {
        $this->valitron->rule('required', array('poster', 'title', 'type', 'content'));
        $this->valitron->rule('lengthBetween', 'title', 2, 50);
        $this->valitron->rule('lengthBetween', 'content', 2, 1000);

        if ($this->type == 'Video') {
            $this->handle_video_rules();
        } elseif ($this->type == 'Image') {
            $this->handle_image_rules();
        }
    }

    private function handle_image_rules() {
        $this->valitron->rule('urlActive', 'content');
        $this->valitron->addRule('urlImage', function($field, $value, array $params, array $fields) {
            try {
                $headers = get_headers($value);
                foreach ($headers as $header) {
                    if (strpos($header, 'Content-Type: image/') !== false) {
                        return true;
                    }
                }
            } catch (Exception $ex) {
                
            }
            return false;
        }, 'must be an url of an image');
        $this->valitron->rule('urlImage', 'content');
    }

    private function handle_video_rules() {
        $this->valitron->addRule('videoId', function($field, $value, array $params, array $fields) {
            try {
                $result = file_get_contents("https://www.youtube.com/oembed?url=http%3A//www.youtube.com/watch%3Fv%3D$value&format=json");
            } catch (Exception $ex) {
                
            }
            if (isset($result)) {
                return true;
            }
            return false;
        }, 'must be a valid video id');
        $this->valitron->rule('videoId', 'content');
    }

    protected function setup_valitron() {
        $attributes = array('poster' => $this->poster,
            'title' => $this->title,
            'type' => $this->type,
            'content' => $this->content);
        $this->valitron = new Valitron\Validator($attributes);
    }

}
