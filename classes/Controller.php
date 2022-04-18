<?php

class Controller
{
    private $command;
    private $db; // the idea is give our controller sole access to the database connection

    // contructor

    // controller logic

    


    public function meeting() {
      
    }
    /*
        This function generates the table for meetings.php
    */
    public function generateMeetingTable($user, $sort_by='NONE') {
        // call getUserMeetings($user) to get array with all meeting data
        $meetings = getUserMeetings($user, $sort_by);
        $table_body = "";
        //date_default_timezone_set('');

        foreach($meetings as $meeting) {
            $start = date('m.d.y g:i a', $meeting['start_datetime']);
            $end = date('m.d.y g:i a', $meeting['end_datetime']);
            $place = $meeting['building_room'];
            $attendees = $meeting['attendees'];
            $row = '
                <tr>
                    <td class="text-truncate" style="max-width: 200px">' . "$start" . '</td>
                    <td class="text-truncate" style="max-width: 200px">' . "$end" . '</td>
                    <td class="text-truncate" style="max-width: 200px">' . "$place" . '</td>
                    <td class="text-truncate" style="max-width: 200px">' . "$attendees" . '</td>
                    <td class="text-center text-center">
                    <div class="btn-group btn-group-sm d-flex float-end flex-row flex-nowrap justify-content-lg-end align-items-lg-center" role="group" style="border-style: none">
                    <button class="btn btn-primary" type="button" 
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
                      <pathd="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"></path>
                    </svg></button
                  ><button class="btn btn-primary" type="button"
                      style="
                          background: var(--bs-table-bg);
                          border-style: none;
                          padding: 0.25rem;">
                    <svg
                      class="bi bi-eye-fill fs-5 fs-5 text-primary"
                      xmlns="http://www.w3.org/2000/svg"
                      width="1em"
                      height="1em"
                      fill="currentColor"
                      viewBox="0 0 16 16"
                      style="margin-left: 11px">
                      <pathd="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"></path>
                      <pathd="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"></path>
                    </svg></button>
                    <button class="btn btn-primary"type="button"
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
                    </div>
                </td>
                </tr>';
            $table_body .= $row;
        }
    }
    echo $table_body;
}

