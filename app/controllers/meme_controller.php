<?php

class MemeController extends BaseController {

    public static function index() {
        $rnd_id = rand(1, Meme::count());
        $rnd_meme = Meme::find_one($rnd_id);
        
        View::make('meme/front_page.html', array('meme' => $rnd_meme));
    }
    
    public static function list_memes() {
        $params = $_GET;
        $current_page = 0;
        if (isset($params['page'])) {
            $current_page = $params['page'] - 1;
        }
        $offset = 10 * $current_page;
        $memes = Meme::find_all($offset);
        $pages = array();
        $count = Meme::count();
        $i = 1;
        while ($count > 0) {
            $pages[] = $i;
            $count -= 10;
            $i++;
        }
        
        View::make('meme/memes.html', array('memes' => $memes, 'pages' => $pages));
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
        View::make('plans/create_meme.html');
    }
    
}
