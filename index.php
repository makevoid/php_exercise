<?php

require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();


// init & configs

$app = new \Slim\Slim(array(
    'templates.path' => './views'
));

require "config/env.php";

$m = new Mongo("mongodb://localhost");
$db = $m->selectDB('squaretestdb');
// FIXME: for php 5.4 create a static class DB
$app->config('db', $db);


// routes

$app->get('/', function() use ($app){
  // just for show/debug
  
  $db = $app->config('db');
  $users      = new MongoCollection($db, 'users');
  $activities = new MongoCollection($db, 'activities');
  $events     = new MongoCollection($db, 'events');

  $app->render("docs.php", array(
      'users'      => $users,
      'activities' => $activities,
      'events'     => $events            
    )
  );
});


// TODO: create a Response class, extend it and make this an InvalidResponse
function invalid_response($app, $hint='') {
  $app->halt(400, "<h1>Invalid response</h1><p>$hint</p><p>go back to the <a href=\"/\">API docs</a></p>");
}

// PHP 5.4
// class Event {
//   public static $types = ["enter", "click", "exit"];
// }

// TODO: move each route in a different file for a more modular structure

// TODO: refactor parameters check

// renamed /track into /events that it follows the REST principle of "directories"
// e.g.: /resources_collection_name/collection_id - /collection/id - /posts/1
//       and POST, PUT, DELETE /collection/id
//       then GET /collection and POST /collection
//       the collection name is usually plural as in URLs (it makes sense if you think urls more like directories / levels)
$app->get('/events/:activity_id/:user_id/:event_type', function($activity_id, $user_id, $event_type) use ($app){

  // parameters checks
  if ( !is_numeric($user_id) ) {
    invalid_response($app, "You need to pass integers as arguments");
  }
  // PHP 5.4
  //if ( !in_array($event_type, Event::$types) ) {
  $event_types = array("enter", "click", "exit"); // 5.3
  if ( !in_array($event_type, $event_types) ) {
    invalid_response($app, ":event_type needs to be in: ".print_r(Event::$types));
  }
  // parameters checks
  if ( !preg_match("/[\w\d]{4,9}/i", $activity_id) ) {
    invalid_response($app, "You need to pass a valid activity");
  }
  
  // TODO: refactor 
  $db = $app->config('db');
  $events = new MongoCollection($db, 'events');
  $event = $events->findOne( array('activity_id' => $activity_id, 'user_id' => intval($user_id), 'event_type' => $event_type) );
  unset($event["_id"]);
  echo json_encode($event);
});

$app->get('/activities/:activity_id', function($activity_id) use ($app){

  // parameters checks
  if ( !preg_match("/[\w\d]{4,9}/i", $activity_id) ) {
    invalid_response($app, "You need to pass a valid activity");
  }
  
  // TODO: refactor 
  $db = $app->config('db');
  $activities = new MongoCollection($db, 'activities');
  $activity = $activities->findOne( array('id' => $activity_id) );
  unset($activity["_id"]);
  echo json_encode($activity);
});

$app->get('/users/:user_id', function($user_id) use ($app){

  // parameters checks
  if ( !is_numeric($user_id) ) {
    invalid_response($app, "You need to pass integers as arguments");
  }
  
  // TODO: refactor 
  $db = $app->config('db');
  $users = new MongoCollection($db, 'users');
  $user = $users->findOne( array('id' => intval($user_id)) );
  unset($user["_id"]);
  echo json_encode($user);
});


// note: renamed /track to /events as it make more sense
// TODO: change method from PUT to POST as it's the creation of an event and not an update to a resource (event)
// FIXME: move :activity_id, :user_id, :event_type into post sent parameters so the url is only /events
$app->put('/events/:activity_id/:user_id/:event_type', function($activity_id, $user_id, $event_type) use ($app){
  $req = $app->request;
  
  // TODO: refactor 
  $db = $app->config('db');
  $activities = new MongoCollection($db, 'activities');
  $users      = new MongoCollection($db, 'activities');
  $events     = new MongoCollection($db, 'events');
  
  $event = array(
    "activity_id" => $activity_id,
    "user_id"     => $user_id,
    "event_type"  => $event_type,
    "created_at"  => new MongoDate(),
    "user_agent"  => $req->getUserAgent(),
    "ip_address"  => $req->getIp()
  );

  $events->insert($event);
  

  // pseudo code:

  // TODO: rename in "events:activity_id" maybe...
  // store("track_[activity_id]", $event);


  $activities->update(
    array('id'    => $activity_id), 
    array('$inc'  => array("counters.$event_type" => 1))
  );
  
  $users->update(
    array('id'    => $activity_id), 
    array('$inc'  => array("counters.$event_type" => 1))
  );

  // update users
  // $user = find("user", $user_id);
  // incr($user["counters"][$event_type]);

  // TODO: skipped those two:
  // - Setting, on document creation, a creation time field to the current timestamp.
  // - Setting a last update field to the current timestamp.


  // echo $event;
  echo json_encode(array("success" => "true"));
});

function update() {
  // TODO: set updated_at to time()
}


// run

$app->run();