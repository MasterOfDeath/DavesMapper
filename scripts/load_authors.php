<?php
  define('PATH', dirname(__FILE__) . '/..');

  include PATH . "/cgi-bin/db_start.php";

  $map_type = intval($_REQUEST['map_kind']);
    $map_type = ($map_type > 0) ? $map_type : 1;
    $map_type_phrase = ($map_type == 3) ? "IN (1,2,3)" : "= ".$map_type;

  $data = mysql_query("SELECT * FROM artists a LEFT JOIN
    (SELECT
      SUM(IF(tile_type = 1, 1, 0)) AS tiles,
      SUM(IF(tile_type = 2, 1, 0)) AS edges,
      SUM(IF(tile_type = 3, 1, 0)) AS corners,
      artist_id FROM tiles WHERE map_type ".$map_type_phrase." GROUP BY artist_id) t
    ON a.id = t.artist_id ORDER BY a.name");

  $authorData = Array();

  if (mysql_num_rows($data) > 0) {
    while ($author = mysql_fetch_assoc($data)) {
      if (($author['tiles']) > 0) {
        $authorData[] = $author;
      }
    }
  }
  echo json_encode($authorData);

  include PATH . "/cgi-bin/db_end.php";
?>
