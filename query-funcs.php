<?php
function debug_to_console($data) {
    $output = $data;
    if (is_array($output)) {
        $output = var_dump($data);
    }

    echo `<script>console.log('Debug Objects: ` . $output . `' );</script>`;
}

function getMeetingAttendees($meeting_id) {
  global $db;
  // Gets attendee list
  $query = "SELECT U.first_name FROM Meeting M
    JOIN User U on U.computing_id = M.owner_computing_id
    WHERE M.meeting_id = :meeting_id
    UNION
    SELECT U.first_name FROM Meeting_Attendee MA
    JOIN User U on U.computing_id = MA.attendee_computing_id
    WHERE MA.meeting_id = :meeting_id";
  $statement = $db->prepare($query);
  $statement->bindValue(':meeting_id', $meeting_id);
  $statement->execute();
  $raw_data = $statement->fetchall();
  $statement->closeCursor();

  $to_return = "";
  foreach ($raw_data as $name) {
    $to_return .= $name["first_name"] . ", ";
  }

  return($to_return);
}

function getBuildings() {
  global $db;
  // Gets attendee list
  $query = "SELECT B.building_name FROM Building B";
  $statement = $db->query($query);
  $raw_data = $statement->fetchall();
  $statement->closeCursor();

  return($raw_data);
}

function getUserMeetings($user, $sort_by) {
  // Get user's computing id
  
  global $db;
  // Gets all info except for list of attendees, that is a seperate query
  $query = "SELECT M.meeting_id, T.start_datetime, T.end_datetime, B.building_name, R.room_number
    FROM Meeting M
    JOIN Room R on R.room_id = M.room_id
    JOIN Timeslot T on T.timeslot_id = M.timeslot_id
    JOIN Building B on B.address = R.address
    WHERE M.owner_computing_id = :user";
  if ($sort_by != "NONE") {
    $query .= "ORDER BY :sort_by";
  }
  $statement = $db->prepare($query);
  $statement->bindValue(':user', $user);
  if ($sort_by != "NONE") {
    $statement->bindValue(':sort_by', $sort_by);
  }
  $statement->execute();

  $raw_data = $statement->fetchall();
  $statement->closeCursor();

  // Return formatting
  $to_return = array();
  foreach($raw_data as $meeting) {
    $attendees = getMeetingAttendees($meeting["meeting_id"]);
    $to_add = array(
      "meeting_id" => $meeting["meeting_id"],
      "start_datetime" => $meeting["start_datetime"],
      "end_datetime" => $meeting["end_datetime"],
      "building_room" => $meeting["building_name"] . " - " . $meeting["room_number"],
      "attendees" => $attendees
    );
    $to_return[$meeting["meeting_id"]] = $to_add;
  }

  return($to_return);
}

function getMeetingInfo($meeting_id) {  
  global $db;
  // Gets all info except for list of attendees, that is a seperate query
  $query = "SELECT M.meeting_id, T.start_datetime, T.end_datetime, B.building_name, R.room_number, R.has_tv, R.has_whiteboard
    FROM Meeting M
    JOIN Room R on R.room_id = M.room_id
    JOIN Timeslot T on T.timeslot_id = M.timeslot_id
    JOIN Building B on B.address = R.address
    WHERE M.meeting_id = '" . $meeting_id . "'";

  $statement = $db->query($query);
  $raw_data = $statement->fetch();
  $statement->closeCursor();

  // Return formatting
  $attendees = getMeetingAttendees($raw_data["meeting_id"]);
  $to_return = array(
    "meeting_id" => $raw_data["meeting_id"],
    "date" => explode(" " , $raw_data["start_datetime"])[0],
    "start_time" => explode(" " , $raw_data["start_datetime"])[1],
    "end_time" => explode(" " , $raw_data["end_datetime"])[1],
    "building_name" => $raw_data["building_name"],
    "tv_required" => $raw_data["has_tv"],
    "whiteboard_required" => $raw_data["has_whiteboard"],
    "attendees" => $attendees
  );

  return($to_return);
}


// TO DO AFTER CREATE QUERY / MODAL
function editMeeting($meeting_id, $start_datetime, $end_datetime, $building_name, $room_number) {
  global $db;
  // Gets attendee list
  $query = "UPDATE Meeting M
    SET M.room_id = (
      SELECT R.room_id from Room R
        WHERE R.room_number = :room_number
        AND R.address = (
            SELECT B.address FROM Building B
            WHERE B.building_name = :building_name
        )
    ), M.timeslot_id = (
        SELECT T.timeslot_id from timeslot T
        WHERE T.start_datetime = :start_datetime
        AND T.end_datetime = :end_datetime
    ) WHERE M.meeting_id = :meeting_id";
  $statement = $db->query($query);
    
  $statement->bindValue(':meeting_id', $meeting_id);
  $statement->bindValue(':start_datetime', $start_datetime);
  $statement->bindValue(':end_datetime', $end_datetime);
  $statement->bindValue(':building_name', $building_name);
  $statement->bindValue(':room_number', $room_number);
  $statement->execute();
  
  $statement->closeCursor();
}

function deleteMeeting($meeting_id) {
    global $db;
    $query = "DELETE FROM Meeting WHERE Meeting.meeting_id = :meeting_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':meeting_id', $meeting_id);
    $statement->execute();
    // we have triggers written upon meeting deletion to also delete the relevant entries from the other tables
    $statement->closeCursor();
}

function createMeeting($user, $start_datetime, $end_datetime, $building_name, $room_number) {
  // get the next id to use
  $id_query = "SELECT MAX(M.meeting_id) FROM Meeting M";
  $id_statement = $db->query($query);
  $next_id = $db->fetch() + 1;
  $id_statement->closeCursor();
  
  global $db;
  // Gets attendee list
  $query = "INSERT INTO Meeting
    VALUES (:nextid, :user, (
      SELECT R.room_id from Room R
        WHERE R.room_number = :room_number
        AND R.address = (
            SELECT B.address FROM Building B
            WHERE B.building_name = :building_name
        )
    ), M.timeslot_id = (
        SELECT T.timeslot_id from timeslot T
        WHERE T.start_datetime = :start_datetime
        AND T.end_datetime = :end_datetime
    ))";
    
  $statement = $db->prepare($query);
  $statement->bindValue(':user', $user);
  $statement->bindValue(':start_datetime', $start_datetime);
  $statement->bindValue(':end_datetime', $end_datetime);
  $statement->bindValue(':building_name', $building_name);
  $statement->bindValue(':room_number', $room_number);
  $statement->execute();

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
    AND T.start_datetime < '" . $end_datetime . "'
    AND T.end_datetime < '" . $start_datetime . "'
    AND '" . $start_datetime . "' < '" . $end_datetime . "'";
      
  if ($tv_required) { $query .= " AND R.has_tv = TRUE"; }
  if ($whiteboard_required) { $query .= " AND R.has_whiteboard = TRUE"; }
  if ($capacity != -1) { $query .= " AND R.capacity >= " . $capacity; }
  if ($building_name != "NONE") { $query .= " AND B.building_name = '" . $building_name . "'"; }
  
  $statement = $db->query($query);
  $raw_data = $statement->fetchall();
  $statement->closeCursor();

  // Return formatting
  $to_return = array();
  foreach($raw_data as $meeting) {
    $attendees = getMeetingAttendees($meeting["meeting_id"]);
    $to_add = array(
      "meeting_id" => $meeting["meeting_id"],
      "start_datetime" => $meeting["start_datetime"],
      "end_datetime" => $meeting["end_datetime"],
      "building_room" => $meeting["building_name"] . " - " . $meeting["room_number"],
      "has_tv" => $meeting["has_tv"],
      "has_whiteboard" => $meeting["has_whiteboard"],
      "capacity" => $meeting["capacity"]
    );
    $to_return[$meeting["meeting_id"]] = $to_add;
  }

  return($to_return);
}

?>

