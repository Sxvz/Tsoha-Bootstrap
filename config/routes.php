<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });
  
  $routes->get('/memes', function() {
    HelloWorldController::list_memes();
  });
  
  $routes->get('/memes/create', function() {
    HelloWorldController::create_meme();
  });
  
  $routes->get('/memes/1', function() {
    HelloWorldController::single_meme();
  });
  
  $routes->get('/memes/1/edit', function() {
    HelloWorldController::edit_meme();
  });
  
  $routes->get('/message/1/edit', function() {
    HelloWorldController::edit_message();
  });

  $routes->get('/tags', function() {
    HelloWorldController::list_tags();
  });
  
  $routes->get('/tags/1', function() {
    HelloWorldController::single_tag();
  });
  
  $routes->get('/tags/1/edit', function() {
    HelloWorldController::edit_tag();
  });
  
  $routes->get('/tags/create', function() {
    HelloWorldController::create_tag();
  });
  
  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
