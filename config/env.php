<?

// mongodb://squaretestuser:squaretestpassword@ds045948.mongolab.com:45948/squaretestdb


// $m = new Mongo("mongodb://squaretestuser:squaretestpassword@ds045948.mongolab.com:45948/squaretestdb");

$m = new Mongo("mongodb://localhost");

//var_dump($m);

if ( !$m.$connected ) {
 echo "Error connecting to the db: check config/env.php<br>"; 
}

$db = $m->selectDB('squaretestdb');

//$collection = new MongoCollection($db, 'users');
// $cursor = $collection->find();
// foreach ($cursor as $doc) { var_dump($doc); }

// find
// $cursor = $collection->find(array("awards" => "gold"));

// update
// $blog->update(
//     array("comments.author" => "John"), 
//     array('$set' => array('comments.$.author' => "Jim")));
