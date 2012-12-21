 <?php



global $db_connection;


/// Find all the taxonomies that are formualically named for menu use.

$QQ = "SELECT name FROM vocabulary where SUBSTRING(name,1,5) = 'menus'";
$idlist = db_query_list($QQ);







?>