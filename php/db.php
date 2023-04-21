<?php 
    $db = new PDO('mysql:host=localhost;dbname=id20639256_territorium', 'id20639256_writer', '$2z%Rs2!Bzq+W^5k');
    //id20639256_territorium
    //id20639256_writer
    //$2z%Rs2!Bzq+W^5k

    $sql = file_get_contents('../sql/festival_attendant.sql');

    // Execute the SQL script
    $db->exec($sql);
?>