<?php

class HelloWorldController extends BaseController {

    public static function index() {
        View::make('plans/front_page.html');
    }

    public static function list_memes() {
        View::make('plans/memes.html');
    }

    public static function single_meme() {
        View::make('plans/meme.html');
    }

    public static function edit_meme() {
        View::make('plans/edit_meme.html');
    }

    public static function create_meme() {
        View::make('plans/create_meme.html');
    }

    public static function edit_message() {
        View::make('plans/edit_message.html');
    }

    public static function sandbox() {
//        $meme = new Meme(array(
//            'poster' => 'User3', //placeholder, haetaan sessiosta nykyinen käyttäjä
//            'title' => 'Seppo',
//            'type' => 'Video',
//            //'content' => 'seppo',
//            'content' => 'https://fat.gfycat.com/OptimalThoseFoal.gif',
//        ));
//        
//        Kint::dump($meme->errors());

//        $value = 'https://fat.gfycat.com/OptimalThoseFoal.gif';
//        //$value = 'seppo';
//        try {
//            $headers = get_headers($value);
//            Kint::dump($headers);
//            foreach ($headers as $header) {
//                Kint::dump(strpos($header, 'Content-Type: image/') !== false);
//            }
//        } catch (Exception $ex) {
//            Kint::dump($ex);
//        }

        View::make('sandbox.html');
    }

}
