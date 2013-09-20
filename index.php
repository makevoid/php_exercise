<?php

require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();


// init & configs

$app = new \Slim\Slim(array(
    'templates.path' => './views'
));

require "config/env.php"

// routes

$app->get('/', function() use ($app){
  $app->render("docs.php");
});


// create some response mocks

// TODO: create a Renderer class
function mock_response($type){
  switch ($type) {
    case "user":
      echo "{ id: 1, name: \"mario\" }";
      break;
    case "track":
      echo "{ id: 1, name: \"mario\" }";
      break;
    case "activity":
      echo "{ id: 1, name: \"mario\" }";
      break;
  }

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
  if ( !is_numeric($user_id) ) {
    invalid_response($app, "You need to pass integers as arguments");
  }
  if ( !in_array($event_type, Event::$types) ) {
    invalid_response($app, ":event_type needs to be in: ".print_r(Event::$types));
  }
  // parameters checks
  if ( !preg_match("/[\w\d]{4,9}/i", $activity_id) ) {
    invalid_response($app, "You need to pass a valid activity");
  }

  mock_response("track");
});

$app->get('/activities/:activity_id', function($activity_id) use ($app){

  // parameters checks
  if ( !preg_match("/[\w\d]{4,9}/i", $activity_id) ) {
    invalid_response($app, "You need to pass a valid activity");
  }

  mock_response("activity");
});

$app->get('/users/:user_id', function($user_id) use ($app){

  // parameters checks
  if ( !is_numeric($user_id) ) {
    invalid_response($app, "You need to pass integers as arguments");
  }

  mock_response("user");
});


// note: renamed /tracks to /events as it make more sense
// TODO: change method from PUT to POST as it's the creation of an event and not an update to a resource (event)
// FIXME: move :activity_id, :user_id, :event_type into post sent parameters so the url is only /events
$app->put('/events/:activity_id/:user_id/:event_type', function($activity_id, $user_id, $event_type) use ($app){
  $req = $app->request;

  $event = "{ activity_id: \"$activity_id\" , user_id: \"$user_id\" , event_type: \"$event_type\", created_at: ".time().", user_agent: \"".$req->getUserAgent()."\", ip_address: \"".$req->getIp()."\" }";

  // pseudo code:

  // TODO: rename in "events:activity_id" maybe...
  // store("track_[activity_id]", $event);


  // update activities
  // $activity = find("activity", $activity_id);
  // incr($activity["counters"][$event_type]);
  // update($activity);


  // update users
  // $user = find("user", $user_id);
  // incr($user["counters"][$event_type]);

  // TODO: skipped those two:
  // - Setting, on document creation, a creation time field to the current timestamp.
  // - Setting a last update field to the current timestamp.


  echo $event;
});

function update() {
  // TODO: set updated_at to time()
}


// run

$app->run();