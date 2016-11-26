<?php

class MemeController extends BaseController {

    public static function index() {
        $rnd_id = rand(1, Meme::count());
        $rnd_meme = Meme::find_one($rnd_id);

        View::make('meme/front_page.html', array('meme' => $rnd_meme));
    }

    public static function list_memes() {
        $params = $_GET;
        $additional_params = '';
        $current_page = 0;
        if (isset($params['page'])) {
            $current_page = $params['page'] - 1;
        }
        $offset = 10 * $current_page;

        if (isset($params['search_phrase'])) {
            $type = $params['search_type'];
            $phrase = $params['search_phrase'];
            $memes = Meme::find_all_by_x($offset, $type, $phrase);
            $count = Meme::count_search_results($type, $phrase);
            $additional_params = "&search_phrase=$phrase&search_type=$type";
        } else {
            $memes = Meme::find_all($offset);
            $count = Meme::count();
        }

        self::prepare_content_previews($memes);
        $pages = self::count_pages($count);

        View::make('meme/memes.html', array('memes' => $memes, 'pages' => $pages, 'additional_params' => $additional_params));
    }

    private static function prepare_content_previews($memes) {
        foreach ($memes as $meme) {
            if ($meme->type == 'Copypasta' && strlen($meme->content) > 50) {
                $meme->content = mb_substr($meme->content, 0, 50, 'UTF-8');
            }
        }
    }

    private static function count_pages($count) {
        $pages = array();
        $i = 1;
        while ($count > 0) {
            $pages[] = $i;
            $count -= 10;
            $i++;
        }

        return $pages;
    }

    public static function single_meme($id) {
        $meme = Meme::find_one($id);
        $comments = Comment::find_by_parent_meme($id);

        View::make('meme/meme.html', array('meme' => $meme, 'comments' => $comments));
    }

    public static function edit_meme() {
        View::make('plans/edit_meme.html');
    }

    public static function create_meme() {
        View::make('meme/create_meme.html');
    }

    public static function store() {
        $params = $_POST;
        $attributes = array(
            'poster' => 'User3', //placeholder, haetaan sessiosta nykyinen käyttäjä
            'title' => $params['title'],
            'type' => $params['type'],
            'content' => $params['content'],
        );

        $meme = new Meme($attributes);
        $errors = $meme->errors();

        if (count($errors) == 0) {
            $meme->save();
            Redirect::to('/memes/' . $meme->id, array('info' => 'Operation successful!'));
        } else {
            View::make('meme/create_meme.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

}
