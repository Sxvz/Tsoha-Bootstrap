<?php

//Huolehtii suosikkeihin liittyvistä pyynnöistä
class FavouriteController extends BaseController {

    //Listaa pyynnön tehneen käyttäjän suosikit sivutettuna.
    public static function list_favourites() {
        self::check_logged_in();

        $username = self::get_user_logged_in()->username;
        $array = self::get_current_page_and_offset();
        $current_page = $array[0];
        $offset = $array[1];
        $memes = Favourite::find_favourite_memes_by_username($username, $offset);
        $count = Favourite::count_results($username);
        self::prepare_content_previews($memes);
        $pages = self::count_pages($count);

        View::make('favourite/favourites.html', array('memes' => $memes, 'pages' => $pages, 'current_page' => $current_page));
    }

    //Merkitsee käyttäjälle meemin suosikiksi. Pyyntö tehdään meemin
    //esittelysivulta.
    public static function favourite($meme_id) {
        self::check_logged_in();

        $username = self::get_user_logged_in()->username;
        $favourite = new Favourite(array('username' => $username, 'meme_id' => $meme_id));

        $errors = $favourite->errors();
        if (count($errors) == 0) {
            $favourite->save();
            Redirect::to('/memes/' . $favourite->meme_id, array('info' => 'Operation successful!'));
        } else {
            Redirect::to('/memes/' . $favourite->meme_id, array('errors' => $errors));
        }
    }

    //Poistaa meemin käyttäjän suosikeista. Tehdään myös meemin esittelysivulta.
    public static function unfavourite($meme_id) {
        self::check_logged_in();

        $username = self::get_user_logged_in()->username;
        $favourite = Favourite::find_one($username, $meme_id);
        $favourite->delete();
        
        Redirect::to('/memes/' . $favourite->meme_id, array('info' => 'Operation successful!'));
    }

}
