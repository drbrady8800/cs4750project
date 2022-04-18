
<?php
include "header.php";
require('../query-funcs.php');
require('../connect-db.php');

if ( !isset($_SESSION['computing_id'])) {
  echo '<script>alert("Please login")</script>';
  echo '<script>window.location.replace("login.php");</script>';
}

$meeting_data;

if (isset($_GET["meeting_id"]) && !isset($meeting_data))
{
  $meeting_data = getMeetingInfo($_GET["meeting_id"]);
}

$buildings = getBuildings();

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    debug_to_console("HERE");
  if (!empty($_POST['action']) && $_POST['action'] == 'Submit') {
    $start_datetime = $_POST['meeting-date'] . " " . $_POST['meeting-time-start'];
    $end_datetime = $_POST['meeting-date'] . " " . $_POST['meeting-time-end'];
    $list_of_possible_meetings = getValidPossibleMeetings($start_datetime, $end_datetime, $_POST['attending-number'], $_POST['building-name'], $_POST['tv-required'], $_POST['whiteboard-required']);
    debug_to_console($list_of_possible_meetings);
  }
}

function generateMeetingOptions($meeting_data) {
  $meetings = getValidPossibleMeetings($meeting_data['start_datetime'], $meeting_data['end_datetime'], $meeting_data['capacity'], $meeting_data['building_name'], $meeting_data['tv_required'], $meeting_data['whiteboard_required']);
  // call getUserMeetings($user) to get array with all meeting data
  $table_body = "";
  //date_default_timezone_set('');

  foreach($meetings as $meeting) {
      $start = $meeting['start_datetime'];
      $end = $meeting['end_datetime'];
      $place = $meeting['building_room'];
      $attendees = $meeting['attendees'];
      $meeting_id = $meeting['meeting_id'];
      $row = '
          <tr id=' . "$meeting_id" . '>
              <td class="text-truncate" style="max-width: 200px">' . "$start" . '</td>
              <td class="text-truncate" style="max-width: 200px">' . "$end" . '</td>
              <td class="text-truncate" style="max-width: 200px">' . "$place" . '</td>
              <td class="text-truncate" style="max-width: 200px">' . "$attendees" . '</td>
              <td class="text-center text-center">
              <div class="btn-group btn-group-sm d-flex float-end flex-row flex-nowrap justify-content-lg-end align-items-lg-center" role="group" style="border-style: none">
              
            <form method="POST" action="">
            <button class="btn btn-primary" type="submit" name="selected" value=' .  "$meeting_id" . ' 
                    style="
                        background: var(--bs-table-bg);
                        border-style: none;
                        padding: 0.25rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
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

<!-- Begin Edit Meeting -->
<!DOCTYPE HTML>
<section class="py-5 mt-5">
      <div class="container py-5">
        <div class="row mb-5">
          <div class="col-md-8 col-xl-6 text-center mx-auto">
            <h2 class="fw-bold">Create A New Meeting</h2>
            <p class="text-muted w-lg-50">PLACEHOLDER PARAGRAPH</p>
          </div>
        </div>
        <div
          class="row row-cols-1 row-cols-md-2 justify-content-center mx-auto"
        >
          <div class="col">
            <form
              id="meeting-form"
              method="post"
              style="border-radius: 20px; border: 1px solid var(--bs-blue)"
            >
              <div class="input-group text-capitalize" style="padding: 0.5rem">
                <span class="input-group-text">Date</span
                ><input
                  class="form-control"
                  type="date"
                  name="meeting-date"
                  required=""
                  value="<?php echo $meeting_data["date"]?>"
                />
              </div>
              <div class="input-group text-capitalize" style="padding: 0.5rem">
                <span class="input-group-text">Time Start</span
                ><input
                  class="form-control"
                  type="time"
                  name="meeting-time-start"
                  required=""
                  value="<?php echo $meeting_data["start_time"]?>"
                />
              </div>
              <div class="input-group text-capitalize" style="padding: 0.5rem">
                <span class="input-group-text">Time End</span
                ><input
                  class="form-control"
                  type="time"
                  name="meeting-time-end"
                  required=""
                  value="<?php echo $meeting_data["end_time"]?>"
                />
              </div>
              <div class="input-group text-capitalize" style="padding: 0.5rem">
                <span class="input-group-text">How Many?</span
                ><input
                  class="form-control"
                  type="number"
                  min="1"
                  step="1"
                  placeholder="number of people"
                  required=""
                  name="attending-number"
                  value="<?php echo count(explode(", ", $meeting_data["attendees"]))?>"
                />
              </div>
              <div
                class="accordion"
                role="tablist"
                id="building-select"
                style="padding: 0.5rem"
              >
                <div class="accordion-item">
                  <h2 class="accordion-header" role="tab">
                    <button
                      class="accordion-button"
                      disabled
                    >
                      Select Building (optional)
                    </button>
                  </h2>
                  <div
                    class="accordion-collapse item-1"
                    role="tabpanel"
                    data-bs-parent="#building-select"
                  >
                    <div class="accordion-body">
                      <p class="mb-0">
                        Declare a preference on which buildings for your
                        meeting.
                      </p>
                      <?php foreach ($buildings as $building) : ?>
                        <div class="form-check">
                          <input
                            class="form-check-input"
                            type="radio"
                            name="building-name"
                            id=<?php echo $building["building_name"] ?>
                            <?php echo ($meeting_data['building_name']==$building["building_name"] ? 'checked' : '');?>
                          />
                          <label class="form-check-label" for="flexRadioDefault2"><?php echo $building["building_name"] ?></label>
                        </div>
                      <?php endforeach; ?>
                    </div>
                  </div>
                </div>
              </div>
              <div
                class="form-check"
                style="padding: 0.5rem; margin-left: 2rem"
              >
                <input
                  class="form-check-input"
                  type="checkbox"
                  id="formCheck-2"
                  name="tv-required"
                  <?php echo ($meeting_data['tv_required']==1 ? 'checked' : '');?>
                /><label class="form-check-label" for="formCheck-2"
                  >TV Required?</label
                >
              </div>
              <div
                class="form-check"
                style="padding: 0.5rem; margin-left: 2rem"
              >
                <input
                  class="form-check-input"
                  type="checkbox"
                  id="formCheck-4"
                  name="whiteboard-required"
                  <?php echo ($meeting_data['whiteboard_required']==1 ? 'checked' : '');?>
                /><label class="form-check-label" for="formCheck-4"
                  >Whiteboard Required?</label
                >
              </div>
              <input
                class="btn btn-primary float-end"
                type="submit"
                style="margin-top: 1rem"
                value="Submit"
                name="action"
              />
            </form>
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
                            <th class="text-center">Select</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- Begin Meeting Row Generation -->
                          <?php
                            
                          ?>
                          <!-- End Meeting Row Generation -->
                        </tbody>
                      </table>
                    </div>
                  </div>
      
</section>
      
    
    <!-- end edit meeting -->

<?php
include "footer.php";
?>