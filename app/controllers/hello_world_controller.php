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

    public static function edit_comment() {
        View::make('plans/edit_comment.html');
    }

    public static function sandbox() {
        View::make('sandbox.html');
    }

}
