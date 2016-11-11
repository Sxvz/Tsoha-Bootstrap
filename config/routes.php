<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });
  
  $routes->get('/memes', function() {
    HelloWorldController::list_memes();
  });
  
  $routes->get('/memes/1', function() {
    HelloWorldController::single_meme();
  });
  
  $routes->get('/memes/1/edit', function() {
    HelloWorldController::edit_meme();
  });
  
  $routes->post('/memes/1/edit', function() {
    HelloWorldController::edit_meme();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
