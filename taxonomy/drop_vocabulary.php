<?php

//drop_vocabulary.php


include "../admin_header.php";


if ( isset($_POST['dropper']) ) {
	$name = $_POST['name'];

	switch_db_connection("taxonomy");

	$DD = "DELETE FROM vocabulary WHERE name = '$name'";
	db_query_exe($DD);
}





?>
VOCABULARY <?php echo $name; ?> DROPPED.