<?php

//index

$routes->get('/', function() {
    MemeController::index();
});

//meme

$routes->get('/memes', function() {
    MemeController::list_memes();
});

$routes->get('/memes/create', function() {
    MemeController::create_meme();
});

$routes->post('/memes/create', function() {
    MemeController::store();
});

$routes->get('/memes/:id', function($id) {
    MemeController::single_meme($id);
});

$routes->get('/memes/:id/edit', function($id) {
    MemeController::edit_meme($id);
});

$routes->post('/memes/:id/edit', function($id) {
    MemeController::handle_edit($id);
});

$routes->get('/memes/:id/delete', function($id) {
    MemeController::delete($id);
});

//comment

$routes->post('/comment/create', function() {
    CommentController::store();
});

$routes->get('/comment/:id/edit', function($id) {
    CommentController::edit_comment($id);
});

$routes->post('/comment/:id/edit', function($id) {
    CommentController::handle_edit($id);
});

$routes->get('/comment/:id/delete', function($id) {
    CommentController::delete($id);
});

//user

$routes->get('/login', function() {
    UserController::login();
});

$routes->post('/login', function() {
    UserController::handle_login();
});

$routes->get('/logout', function() {
    UserController::logout();
});

$routes->get('/register', function() {
    UserController::register();
});

$routes->post('/register', function() {
    UserController::create_account();
});

//favourites

$routes->get('/favourites', function() {
    FavouriteController::list_favourites();
});

$routes->get('/memes/:id/favourite', function($id) {
    FavouriteController::favourite($id);
});

$routes->get('/memes/:id/unfavourite', function($id) {
    FavouriteController::unfavourite($id);
});
