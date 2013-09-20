<?

  function link_to($url) {
    echo "<a href=\"$url\">$url</a>";
  }

?>

<h1>API</h1>

<section>
  <h1>Routes</h1>

  <section>
    <h1>GET /tracks/:activity_id/:user_id/:event_type</h1>
    <p>example: <?= link_to("/tracks/ff7x/1/click") ?></p>

    <h1>GET /activities/:activity_id</h1>
    <p>example: <?= link_to("/activities/1") ?></p>

    <h1>GET /users/:user_id</h1>
    <p>example: <?= link_to("/users/1") ?></p>

    <h1>PUT /tracks/:activity_id/:user_id/:event_type</h1>
    <p>example:</p>
    <form method="put" action="/tracks/ff7x/1/click">
      <!-- <input name="_method" value="PUT" type="hidden" /> use this as a fallback for older browser, need to change the server to accept the PUT/DELETE fallback -->
      <input type="submit" />
    </form>
  </section>
</section>
