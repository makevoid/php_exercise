<?

  function link_to($url) {
    echo "<a href=\"$url\">$url</a>";
  }

?>

<h1>API</h1>

<section>
  <h1>Routes</h1>

  <section>
    <h1>GET /activities/:activity_id</h1>
    <p>example: <?= link_to("/activities/ff7x") ?></p>

    <h1>GET /users/:user_id</h1>
    <p>example: <?= link_to("/users/1") ?></p>

    <h1>PUT /events/:activity_id/:user_id/:event_type</h1>
    <p>example:</p>
    <form method="post" action="/events/ff7x/1/click">
      <input name="_METHOD" value="PUT" type="hidden" />
      <input type="submit" />
    </form>
  </section>
  </section>
</section>