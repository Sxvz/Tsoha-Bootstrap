<?php

class BaseController {

    public static function get_user_logged_in() {
        if (isset($_SESSION['user'])) {
            return User::find_by_username($_SESSION['user']);
            //return $_SESSION['user'];
        }

        return null;
    }

    public static function check_logged_in() {
        if (!isset($_SESSION['user'])) {
            Redirect::to('/login', array('error' => 'You need to log in to do that'));
        }
    }
    
    //Meemien ja suosikkien jakamaa toiminnallisuutta

    //Sivutuksessä käytetty metodi, joka palauttaa nykyisen sivun ja sille
    //olennaisen offsetin kyselyä varten.
    protected static function get_current_page_and_offset() {
        $params = $_GET;
        $current_page = 1;
        if (isset($params['page'])) {
            $current_page = $params['page'];
        }
        $offset = 10 * ($current_page - 1);
        
        return array($current_page, $offset);
    }

    //Laskee annetun entiteettien lukumäärän perusteella tarvittavien sivujen
    //määrän ja palauttaa ne listana.
    protected static function count_pages($count) {
        $pages = array();
        $i = 1;
        while ($count > 0) {
            $pages[] = $i;
            $count -= 10;
            $i++;
        }

        return $pages;
    }
    
    //Lyhentää "copypasta" -tyyppisten meemien sisältöä listausnäkymään
    //sopivammaksi.
    protected static function prepare_content_previews($memes) {
        foreach ($memes as $meme) {
            if ($meme->type == 'Copypasta' && strlen($meme->content) > 50) {
                //users2017 palvelimella ei ole mbstring moduulia
                //$meme->content = mb_substr($meme->content, 0, 50, 'UTF-8') . '...';
                $meme->content = substr($meme->content, 0, 50) . '...';
            }
        }
    }
    
}
