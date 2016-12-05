<?php

//Huolehtii kommentteihin liittyvistä pyynnöistä
class CommentController extends BaseController {
    
    //Näyttää kommentin editointisivun
    public static function edit_comment($id) {
        self::check_logged_in();
        
        $comment = Comment::find_one($id);
        $parent_meme = Meme::find_one($comment->parent_meme);

        //Tarkistetaan vielä, että käyttäjä on varmasti oikea, härömpien
        //keinojen estämiseksi. Saman kaltaista tehdään muualla myöhemminkin
        //sen enempää asiaa kommentoimatta.
        if (self::get_user_logged_in()->username == $comment->poster) {
            View::make('comment/edit_comment.html', array('comment' => $comment, 'meme' => $parent_meme));
        } else {
            //Virheviesti on vähän typerä, mutta sen nähdessään käyttäjän voisi
            //kuvitella tietävän mitä juuri yritti. Tätä viestiä ei näy
            //normaalioloissa.
            Redirect::to('/', array('error' => 'nope.avi'));
        }
    }

    //Käsittelee varsinaisen kommentin editointipyynnön
    public static function handle_edit($id) {
        self::check_logged_in();
        
        $comment = Comment::find_one($id);
        $params = $_POST;

        $comment->message = $params['message'];

        $errors = $comment->errors();
        if (count($errors) == 0) {
            if (self::get_user_logged_in()->username == $comment->poster) {
                $comment->update();
                Redirect::to('/memes/' . $comment->parent_meme, array('info' => 'Operation successful!'));
            } else {
                Redirect::to('/', array('error' => 'nope.avi'));
            }
        } else {
            Redirect::to("/comment/$id/edit", array('errors' => $errors, 'comment' => $comment));
        }
    }

    //Huolehtii uusien kommentien tallettamisesta tietokantaan
    public static function store() {
        self::check_logged_in();
        
        $params = $_POST;
        $attributes = array(
            'poster' => self::get_user_logged_in()->username,
            'parent_meme' => $params['parent_meme'],
            'message' => $params['message']
        );

        $comment = new Comment($attributes);

        $errors = $comment->errors();
        if (count($errors) == 0) {
            $comment->save();
            Redirect::to('/memes/' . $params['parent_meme'], array('info' => 'Operation successful!'));
        } else {
            Redirect::to('/memes/' . $params['parent_meme'], array('errors' => $errors, 'failed_message' => $attributes['message']));
        }
    }

    //Huolehtii kommenttien poistamisesta tietokannasta.
    public static function delete($id) {
        self::check_logged_in();
        
        $comment = Comment::find_one($id);

        if (self::get_user_logged_in()->username == $comment->poster) {
            $comment->delete();
            Redirect::to('/memes/' . $comment->parent_meme, array('info' => 'Operation successful!'));
        } else {
            Redirect::to('/', array('error' => 'nope.avi'));
        }
    }

}
