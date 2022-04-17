<?php
function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

function getUserMeetings() {
  // Get user's computing id
  $user;
  global $db;
  // Gets all info except for list of attendees, that is a seperate query
  $query = "SELECT M.meeting_id, T.start_datetime, B.building_name, R.room_number
    FROM Meeting M
    JOIN Room R on R.room_id = M.room_id
    JOIN Timeslot T on T.timeslot_id = M.timeslot_id
    JOIN Building B on B.address = R.address
    WHERE M.owner_computing_id = '" . $user . "'";
  $statement = $db->query($query);
  $statement->closeCursor();
}

function getMeetingAttendees($meeting_id) {
  global $db;
  // Gets attendee list
  $query = "SELECT U.first_name FROM meeting M
    JOIN User U on U.computing_id = M.owner_computing_id
    WHERE M.meeting_id = " . $meeting_id . "
    UNION
    SELECT U.first_name FROM meeting_attendee MA
    JOIN User U on U.computing_id = MA.attendee_computing_id
    WHERE MA.meeting_id = " . $meeting_id;
  $statement = $db->query($query);
  $statement->closeCursor();
}

// TO DO AFTER CREATE QUERY / MODAL
function editMeeting($meeting_id, $start_datetime, $end_datetime, $building_name, $room_number) {
  global $db;
  // Gets attendee list
  $query = "UPDATE Meeting M
    SET M.room_id = (
      SELECT R.room_id from Room R
        WHERE R.room_number = " . $room_number . "
        AND R.address = (
            SELECT B.address FROM Building B
            WHERE B.building_name = '" . $building_name . "'
        )
    ), M.timeslot_id = (
        SELECT T.timeslot_id from timeslot T
        WHERE T.start_datetime = '" . $start_datetime ."'
        AND T.end_datetime = '" . $end_datetime . "'
    ) WHERE M.meeting_id = " . $meeting_id;
  $statement = $db->query($query);
  $statement->closeCursor();
}

function deleteMeeting($meeting_id) {
    global $db;
    $query = "DELETE FROM Meeting WHERE Meeting.meeting_id = " . $meeting_id;  // since meeting_id is an int I don't think I need quotes around it
    $statement = $db->query($query);
    // we have triggers written upon meeting deletion to also delete the relevant entries from the other tables
    $statement->closeCursor();
}

// sort_metric should be one of capacity, room_number (maybe), Building.open_time, Building.close_time
// descending should be a boolean: True for descending
function sortMeeting($sort_metric, $descending) {
    global $db;
    $query = " SELECT room_id, capacity, room_number, has_tv, has_whiteboard,
    Building.address, Building.building_name, Building.open_time, Building.close_time
    FROM Room JOIN Building
        ON Room.address = Building.address
    ORDER BY '" . $sort_metric . "'";
    if ($descending) { $query .= " DESC"; }
    
    $statement = $db->query($query);
    $statement->closeCursor();
}

function createMeeting($start_datetime, $end_datetime, $building_name, $room_number) {
  // get the next id to use
  $id_query = "SELECT MAX(M.meeting_id) FROM Meeting M";
  $id_statement = $db->query($query);
  $next_id = $db->fetch() + 1;
  $id_statement->closeCursor();
  
  $user;
  global $db;
  // Gets attendee list
  $query = "INSERT INTO Meeting
    VALUES (" . $next_id . ", '" . $user . "', (
      SELECT R.room_id from Room R
        WHERE R.room_number = " . $room_number . "
        AND R.address = (
            SELECT B.address FROM Building B
            WHERE B.building_name = '" . $building_name . "'
        )
    ), M.timeslot_id = (
        SELECT T.timeslot_id from timeslot T
        WHERE T.start_datetime = '" . $start_datetime ."'
        AND T.end_datetime = '" . $end_datetime . "'
    ))";
  $statement = $db->query($query);
  $statement->closeCursor();
}

function getValidPossibleMeetings($start_datetime, $end_datetime, $capacity, $building_name, $tv_required, $whiteboard_required) {
  // Bear with me here, writing a SQL query for this is going to take a bit
  global $db;
  $query = "SELECT M.meeting_id, T.start_datetime, T.end_datetime, B.building_name, R.room_number, R.has_whiteboard, R.has_tv, R.capacity
    FROM Meeting M
    JOIN Room R on R.room_id = M.room_id
    JOIN Timeslot T on T.timeslot_id = M.timeslot_id
    JOIN Building B on B.address = R.address
    WHERE T.start_datetime < '" . $end_datetime . "'
    AND T.end_datetime < '" . $start_datetime . "'
    AND CAST(T.end_datetime AS TIME) < B.close_time
    AND CAST(T.start_datetime AS TIME) > B.open_time
    AND '" . $start_datetime . "' < '" . $end_datetime . "'";
      
  if ($tv_required) { $query .= "AND R.has_tv = TRUE" }
  if ($whiteboard_required) { $query .= "AND R.has_whiteboard = TRUE" }
  if ($capacity != -1) { $query .= "AND R.capacity >= '" . $capacity . "'"; }
  if ($building_name != "NONE") { $query .= "AND B.building_name = '" . $building_name . "'"; }
  
  $statement = $db->query($query);
  $statement->closeCursor();
}

// meeting.html functions
/*
--fetch list of a user's meetings (getUserMeetings, getMeetingAttendees)
--delete a meeting (deleteMeeting)
--edit a meeting / edit modal (editMeeting)
--sort meetings (sortMeeting)
*/


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

