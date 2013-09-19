<?php

require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});

// routes

$app->get('/', function(){
  $app.render("docs.php")
});


// TODO: create a Renderer class
function json(){
  echo "{ a: \"b\" }";
}


$event_types = ["enter", "click", "exit"];

// renamed /track into /tracks that it follows the REST principle of "directories"
// e.g.: /resources_collection_name/collection_id - /collection/id - /posts/1
//       and POST, PUT, DELETE /collection/id
//       then GET /collection and POST /collection
//       the collection name is usually plural as in URLs (it makes sense if you think urls more like directories / levels)
$app->get('/tracks/:activity_id/:user_id/:event_type', function($activity_id, $user_id, $event_type) use ($app){
  json();
});

$app->get('/activities/:activity_id', function($activity_id) use ($app){
  json();
});

$app->get('/users/:user_id', function($user_id) use ($app){
  json();
});


// /track/<ActivityID>/<UserID>/<Event>
// /activity/<ActivityID>
// /user/<UserID>


// run

$app->run();