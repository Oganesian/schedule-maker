<?php

include_once 'VARIABLES.php';

function my_query($query, $hasResult){
    $db = new mysqli(HOST, USER, PASSWORD, DATABASE);
    if(!$result = $db->query($query)){
        die("<h2 class='empty-table-warning'>There was an error running the query [' . $db->error . ']</h2><br />".$query);
    } else {
        if($hasResult){
            return $result;
        }
    }
}

function safe_query($query){
	$suspicious_strings = array("DROP", "TABLE", "DATABASE", "DELETE",
	 "UNION", "UPDATE", "ALTER", "ADD", "SET", "=", "SELECT", "CREATE", "script", ";", "'", "\"", "--");
	foreach ($suspicious_strings as $string) {
		$query = str_ireplace($string, "", $query);
	}
	return $query;
}

?>
