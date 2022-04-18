<?php
  include "header.php";
  require('../connect-db.php');
  require('../query-funcs.php');


  // For sorting the meetings
  if (isset($_GET["sort_meetings"]))
  {
    $table = generateMeetingTable($sort_by=$_GET["sort_meetings"]);
  } else {
    $table = generateMeetingTable();
  }

  if(isset($_POST['delete']) && $_POST['delete'] != "")
  {
    $meeting_id = (int)$_POST['delete'];
    deleteMeeting($meeting_id);
    $table = generateMeetingTable();
  }    


      /*
        This function generates the table for meetings.php
    */
    function generateMeetingTable($sort_by="NONE") {
      $meetings = getUserMeetings($_SESSION["computing_id"], $sort_by);
      // call getUserMeetings($user) to get array with all meeting data
      $table_body = "";
      //date_default_timezone_set('');

      foreach($meetings as $meeting) {
          $start = $meeting['start_datetime'];
          $end = $meeting['end_datetime'];
          $place = $meeting['building_room'];
          $attendees = $meeting['attendees'];
          $meeting_id = $meeting['meeting_id'];
          $meeting_info = 
          $row = '
              <tr id=' . "$meeting_id" . '>
                  <td class="text-truncate" style="max-width: 200px">' . "$start" . '</td>
                  <td class="text-truncate" style="max-width: 200px">' . "$end" . '</td>
                  <td class="text-truncate" style="max-width: 200px">' . "$place" . '</td>
                  <td class="text-truncate" style="max-width: 200px">' . "$attendees" . '</td>
                  <td class="text-center text-center">
                  <div class="btn-group btn-group-sm d-flex float-end flex-row flex-nowrap justify-content-lg-end align-items-lg-center" role="group" style="border-style: none">
                  
                  <a class="btn" name="edit" href="edit-meeting.php?meeting_id=' . "$meeting_id" . '"
                      style="
                          background: var(--bs-table-bg);
                          border-style: none;
                          padding: 0.25rem;">
                      <svg
                      class="bi bi-pencil-fill fs-5"
                      xmlns="http://www.w3.org/2000/svg"
                    width="1em"
                    height="1em"
                    fill="currentColor"
                    viewBox="0 0 16 16"
                    style="
                      color: var(--bs-table-striped-color);
                      margin-left: 11px;">
                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"></path>
                  </svg></a
                >
                <form method="POST" action="">
                <button class="btn btn-primary" type="submit" name="delete" value=' .  "$meeting_id" . '
                        style="
                            background: var(--bs-table-bg);
                            border-style: none;
                            padding: 0.25rem;">
                  <svg
                    class="bi bi-trash-fill fs-5"
                    xmlns="http://www.w3.org/2000/svg"
                    width="1em"
                    height="1em"
                    fill="currentColor"
                    viewBox="0 0 16 16"
                    style="color: var(--bs-danger);
                    margin-left: 11px;">
                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"></path>
                  </svg>
                </button>
                </form>
                  </div>
              </td>
              </tr>';
          $table_body .= $row;
      }
      return($table_body);
  }
  

?>

<!-- Begin Meeting -->
<header class="bg-primary-gradient py-5">
      <div class="container py-5">
        <div class="row py-5">
          <div class="col">
            <div class="row justify-content-center">
              <div class="col-xl-10 col-xxl-9">
                <div class="card shadow">
                  <div
                    class="card-header float-none d-flex flex-wrap justify-content-center align-items-center justify-content-sm-between gap-3"
                    style="padding: 9px 16px"
                  >
                    <h5
                      class="display-6 text-nowrap text-capitalize d-sm-flex d-lg-flex flex-row justify-content-sm-start align-items-sm-center justify-content-lg-end mb-0"
                    >
                      Your Meetings
                    </h5>
                    <div class="col">
                      <div
                        class="d-inline-flex d-lg-flex order-last justify-content-sm-end align-items-lg-end"
                      >
                        <div
                          class="btn-group btn-group-sm d-lg-flex"
                          role="group"
                        >
                          <div class="dropdown btn-group" role="group">
                            <button
                              class="btn btn-light btn-sm dropdown-toggle"
                              aria-expanded="false"
                              data-bs-toggle="dropdown"
                              type="button"
                            >
                              <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="1em"
                                height="1em"
                                fill="currentColor"
                                viewBox="0 0 16 16"
                                class="bi bi-filter-circle fs-3"
                              >
                                <path
                                  d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"
                                ></path>
                                <path
                                  d="M7 11.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5z"
                                ></path>
                              </svg>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="?sort_meetings=start_datetime">Start Date/Time</a>
                              <a class="dropdown-item" href="?sort_meetings=end_datetime">End Date/Time</a>
                              <a class="dropdown-item" href="?sort_meetings=room_number">Room Number</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive text-start">
                      <table class="table table-striped table-hover">
                        <thead>
                          <tr>
                            <th>Start</th>
                            <th>End</th>
                            <th>Room</th>
                            <th>Participants</th>
                            <th class="text-center">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- Begin Meeting Row Generation -->
                          <?php
                            echo $table;
                          ?>
                          <!-- End Meeting Row Generation -->
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>

<?php
include "footer.php";
?>