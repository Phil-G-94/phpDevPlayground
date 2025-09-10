<?php

// SQLite

class DB {
  function fetchAllRecords($query) {
    $db = new SQLite3("./data/data.db");
    $result = $db->query($query);

    $rows = [];

    if ($result) {

      while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $rows[] = $row; # push result row into rows array
      };


      return $rows;
    }
  }
}

?>