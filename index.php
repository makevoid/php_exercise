<?php

require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});

// routes

$app->get('/', function(){
  echo "home page!";
});

$app->get('/hi', function() use ($app){
  $app->render('hi.php');
});


// /track/<ActivityID>/<UserID>/<Event>  
// /activity/<ActivityID>
// /user/<UserID>


// run

$app->run();