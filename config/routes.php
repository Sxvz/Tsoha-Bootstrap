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

$routes->get('/memes/1/edit', function() {
    HelloWorldController::edit_meme();
});

$routes->get('/comment/1/edit', function() {
    HelloWorldController::edit_comment();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});