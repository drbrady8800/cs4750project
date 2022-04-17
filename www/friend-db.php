<?php
function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

function addFriend($name, $major, $year) {
    global $db;
    $query = "INSERT INTO friends VALUES('" . $name . "', '" . $major . "', " . $year . ")";
    $statement = $db->query($query);
    $statement->closeCursor();
}

function updateFriend($name, $major, $year, $friend_to_update) {
    global $db;
    $query = "UPDATE friends SET name='" . $name . "', major='" . $major . "', year=" . $year . " WHERE name='" . $friend_to_update . "'";
    $statement = $db->query($query);
    $statement->closeCursor();
}

function getAllFriends() {
    global $db;
    $query = "SELECT * FROM friends";
    $statement = $db->query($query);
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function getFriend_byName($name) {
    global $db;
    $query = "SELECT * FROM friends WHERE name = '" . $name . "'";
    $statement = $db->query($query);
    $results = $statement->fetch();
    $statement->closeCursor();

    return $results;
}

function deleteFriend($name) {
    global $db;
    $query = "DELETE FROM friends WHERE name = '" . $name . "'";
    $statement = $db->query($query);
    $statement->closeCursor();
}

?>

