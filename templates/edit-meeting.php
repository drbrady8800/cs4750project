git
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
$meetings = "";
$table = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (!empty($_POST['action']) && $_POST['action'] == 'Submit') {
    $start_datetime = $_POST['meeting-date'] . " " . $_POST['meeting-time-start'];
    $end_datetime = $_POST['meeting-date'] . " " . $_POST['meeting-time-end'];
    $whiteboard_required = isset($_POST['whiteboard-required']);
    $tv_required = isset($_POST['tv-required']);
    $meetings = getValidPossibleMeetings($start_datetime, $end_datetime, $_POST['attending-number'], "NONE", $tv_required, $whiteboard_required);
    $table = generateMeetingOptions($meetings);
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (!empty($_POST['selected'])) {
    debug_to_console($meetings);
    $meeting_id_selected = $_POST['meeting_id_value'];
    $start_datetime = $meetings[$meeting_id_selected]["start_datetime"];
    $end_datetime = $meetings[$meeting_id_selected]["end_datetime"];
    $building_name = explode(" - ", $meetings[$meeting_id_selected]["building_room"])[0];
    $room_number = explode(" - ", $meetings[$meeting_id_selected]["building_room"])[1];
    createMeeting($meeting_id_selected, $start_datetime, $end_datetime, $building_name, $room_number);
  }
}

function generateMeetingOptions($meetings) {
  // call getUserMeetings($user) to get array with all meeting data
  $to_return = "";

  foreach($meetings as $meeting) {
      $start = $meeting['start_datetime'];
      $end = $meeting['end_datetime'];
      $place = $meeting['building_room'];
      $cap = $meeting['capacity'];
      $meeting_id = $meeting['meeting_id'];
      $row = '
          <tr>
              <form method="POST">
              <td class="text-truncate" style="max-width: 200px">
                  ' . "$start" . '
              </td>
              <td class="text-truncate" style="max-width: 200px">
                ' . "$end" . '
              </td>
              <td class="text-truncate" style="max-width: 200px">
                ' . "$place" . '
              </td>
              <td class="text-truncate" style="max-width: 200px">
                ' . "$cap" . '
              </td>
              <td class="text-center text-center">
              <div class="btn-group btn-group-sm d-flex float-end flex-row flex-nowrap justify-content-lg-end align-items-lg-center" role="group" style="border-style: none">
              <input type="hidden" name="meeting_id_value" value = ' . "$meeting_id" . '></input>
            <input class="btn btn-primary" type="submit" name="selected" value="Select" 
                    style="
                        background: green;
                        border-style: none;
                        padding: 0.25rem;">
            </input>
            </form>
              </div>
          </td>
          </tr>';
      $to_return .= $row;
  }
  return($to_return);
}


?>

<!-- Begin Edit Meeting -->
<!DOCTYPE HTML>
<section class="py-5 mt-5">
      <div class="container py-5">
        <div class="row mb-5">
          <div class="col-md-8 col-xl-6 text-center mx-auto">
            <h2 class="fw-bold">Edit A Meeting</h2>
            <p class="text-muted w-lg-50">Fill in data to edit a meeting</p>
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
                            value=<?php echo $building["building_name"] ?>
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
                            <th>Capacity</th>
                            <th class="text-center">Select</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- Begin Meeting Row Generation -->
                          <?php
                            if (isset($table)) {

                              echo $table;
                            }
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