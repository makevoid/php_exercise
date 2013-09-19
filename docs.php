<?

  function link($url) {
    echo "<a href=\"$url\">$url</a>";
  }

?>

<h1>API</h1>

<section>
  <h1>Routes</h1>

  <section>
    <h1>GET /tracks/:activity_id/:user_id/:event_type</h1>
    <p>example: <?= link("/tracks/1/1/click") ?></p>

    <h1>GET /activities/:activity_id</h1>
    <p>example: <?= link("/activities/1") ?></p>

    <h1>GET /users/:user_id</h1>
    <p>example: <?= link("/users/1") ?></p>
  </section>
</section>
