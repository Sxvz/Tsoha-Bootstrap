<?php

$routes->get('/', function() {
    MemeController::index();
});

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

$routes->get('/comment/1/edit', function() {
    HelloWorldController::edit_comment();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

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
