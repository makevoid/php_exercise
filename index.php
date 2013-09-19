<?php

require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();


// init & configs

$app = new \Slim\Slim(array(
    'templates.path' => './views'
));

// routes

$app->get('/', function() use ($app){
  $app->render("docs.php");
});


// TODO: create a Renderer class
function json(){
  echo "{ a: \"b\" }";
}

// TODO: create a Response class, extend it and make this an InvalidResponse
function invalid_response($app, $hint='') {
  $app->halt(400, "<h1>Invalid response</h1><p>$hint</p><p>go back to the <a href=\"/\">API docs</a></p>");
}


class Event {
  public static $types = ["enter", "click", "exit"];
}

// TODO: move each route in a different file for a more modular structure

// TODO: refactor parameters check

// renamed /track into /tracks that it follows the REST principle of "directories"
// e.g.: /resources_collection_name/collection_id - /collection/id - /posts/1
//       and POST, PUT, DELETE /collection/id
//       then GET /collection and POST /collection
//       the collection name is usually plural as in URLs (it makes sense if you think urls more like directories / levels)
$app->get('/tracks/:activity_id/:user_id/:event_type', function($activity_id, $user_id, $event_type) use ($app){

  // parameters checks
  if ( !is_integer($activity_id) | !is_integer($user_id) ) {
    invalid_response($app, "You need to pass integers as arguments");
  }
  if ( !in_array($event_type, Event::$types) ) {
    invalid_response($app, ":event_type needs to be in: ".print_r(Event::$types));
  }

  json();
});

$app->get('/activities/:activity_id', function($activity_id) use ($app){

  // parameters checks
  if ( !is_integer($activity_id) ) {
    invalid_response($app, "You need to pass integers as arguments");
  }

  json();
});

$app->get('/users/:user_id', function($user_id) use ($app){

  // parameters checks
  if ( !is_integer($user_id) ) {
    invalid_response($app, "You need to pass integers as arguments");
  }

  json();
});


// /track/<ActivityID>/<UserID>/<Event>
// /activity/<ActivityID>
// /user/<UserID>


// run

$app->run();