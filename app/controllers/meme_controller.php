<?php

class MemeController extends BaseController {

    public static function index() {
        $ids = Meme::find_all_ids();
        $rnd_meme = null;
        if ($ids != null) {
            $rnd_indx = rand(0, count($ids) - 1);
            $rnd_meme = Meme::find_one($ids[$rnd_indx][0]);
        }

        if ($rnd_meme == null) {
            View::make('meme/front_page.html');
        } else {
            View::make('meme/front_page.html', array('meme' => $rnd_meme));
        }
    }

    public static function list_memes() {
        $params = $_GET;
        $additional_params = '';
        $type = null;
        $phrase = null;

        $array = self::get_current_page_and_offset();
        $current_page = $array[0];
        $offset = $array[1];

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

        View::make('meme/memes.html', array('memes' => $memes, 'pages' => $pages, 'current_page' => $current_page, 'additional_params' => $additional_params, 'search_type' => $type, 'search_phrase' => $phrase));
    }

    public static function single_meme($id) {
        $meme = Meme::find_one($id);
        $comments = Comment::find_by_parent_meme($id);
        $is_favourite = false;
        $user = self::get_user_logged_in();
        if ($user != null) {
            if (Favourite::find_one($user->username, $id) != null) {
                $is_favourite = true;
            }
        }

        View::make('meme/meme.html', array('meme' => $meme, 'comments' => $comments, 'is_favourite' => $is_favourite));
    }

    public static function edit_meme($id) {
        self::check_logged_in();

        $meme = Meme::find_one($id);

        if (self::get_user_logged_in()->username == $meme->poster) {
            View::make('meme/edit_meme.html', array('meme' => $meme));
        } else {
            Redirect::to('/', array('error' => 'nope.avi'));
        }
    }

    public static function handle_edit($id) {
        self::check_logged_in();

        $meme = Meme::find_one($id);
        $params = $_POST;

        $meme->title = $params['title'];
        $meme->content = $params['content'];

        $errors = $meme->errors();
        if (count($errors) == 0) {
            if (self::get_user_logged_in()->username == $meme->poster) {
                $meme->update();
                Redirect::to('/memes/' . $meme->id, array('info' => 'Operation successful!'));
            } else {
                Redirect::to('/', array('error' => 'nope.avi'));
            }
        } else {
            Redirect::to('/memes/' . $meme->id . '/edit', array('errors' => $errors, 'meme' => $meme));
        }
    }

    public static function create_meme() {
        self::check_logged_in();

        View::make('meme/create_meme.html');
    }

    public static function store() {
        self::check_logged_in();

        $params = $_POST;
        $attributes = array(
            'poster' => self::get_user_logged_in()->username,
            'title' => $params['title'],
            'type' => $params['type'],
            'content' => $params['content']
        );

        $meme = new Meme($attributes);

        $errors = $meme->errors();
        if (count($errors) == 0) {
            $meme->save();
            Redirect::to('/memes/' . $meme->id, array('info' => 'Operation successful!'));
        } else {
            Redirect::to('/memes/create', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function delete($id) {
        self::check_logged_in();

        $meme = Meme::find_one($id);

        if (self::get_user_logged_in()->username == $meme->poster) {
            $meme->delete();
            Redirect::to('/', array('info' => 'Operation successful!'));
        } else {
            Redirect::to('/', array('error' => 'nope.avi'));
        }
    }

}
