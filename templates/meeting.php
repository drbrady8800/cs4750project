<?php
include "header.php";
?>

<!-- Begin Meeting -->
<!DOCTYPE HTML>
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
                          <button
                            class="btn btn-light btn-sm"
                            data-bss-disabled-mobile="true"
                            data-bss-hover-animate="pulse"
                            type="button"
                          >
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              width="1em"
                              height="1em"
                              fill="currentColor"
                              viewBox="0 0 16 16"
                              class="bi bi-sort-down fs-3"
                            >
                              <path
                                d="M3.5 2.5a.5.5 0 0 0-1 0v8.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L3.5 11.293V2.5zm3.5 1a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zM7.5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zm0 3a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z"
                              ></path>
                            </svg>
                          </button>
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
                              <a class="dropdown-item" href="#">First Item</a
                              ><a class="dropdown-item" href="#">Second Item</a
                              ><a class="dropdown-item" href="#">Third Item</a>
                            </div>
                          </div>
                        </div>
                        <div
                          class="input-group input-group-sm d-lg-flex flex-grow-0 justify-content-lg-end w-auto"
                        >
                          <input
                            class="form-control form-control-sm"
                            type="text"
                          /><button
                            class="btn btn-outline-primary btn-sm"
                            type="button"
                          >
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              width="1em"
                              height="1em"
                              fill="currentColor"
                              viewBox="0 0 16 16"
                              class="bi bi-search mb-1"
                            >
                              <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"
                              ></path>
                            </svg>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive text-start">
                      <table class="table table-striped table-hover">
                        <thead>
                          <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Room</th>
                            <th>Participants</th>
                            <th class="text-center">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="text-truncate" style="max-width: 200px">
                              04/16/22
                            </td>
                            <td class="text-truncate" style="max-width: 200px">
                              12:00pm
                            </td>
                            <td class="text-truncate" style="max-width: 200px">
                              Building - Room #
                            </td>
                            <td>Alice, Bob</td>
                            <td class="text-center text-center">
                              <div
                                class="btn-group btn-group-sm d-flex float-end flex-row flex-nowrap justify-content-lg-end align-items-lg-center"
                                role="group"
                                style="border-style: none"
                              >
                                <button
                                  class="btn btn-primary"
                                  type="button"
                                  style="
                                    background: var(--bs-table-bg);
                                    border-style: none;
                                    padding: 0.25rem;
                                  "
                                >
                                  <svg
                                    class="bi bi-pencil-fill fs-5"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="1em"
                                    height="1em"
                                    fill="currentColor"
                                    viewBox="0 0 16 16"
                                    style="
                                      color: var(--bs-table-striped-color);
                                      margin-left: 11px;
                                    "
                                  >
                                    <path
                                      d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"
                                    ></path>
                                  </svg></button
                                ><button
                                  class="btn btn-primary"
                                  type="button"
                                  style="
                                    background: var(--bs-table-bg);
                                    border-style: none;
                                    padding: 0.25rem;
                                  "
                                >
                                  <svg
                                    class="bi bi-eye-fill fs-5 fs-5 text-primary"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="1em"
                                    height="1em"
                                    fill="currentColor"
                                    viewBox="0 0 16 16"
                                    style="margin-left: 11px"
                                  >
                                    <path
                                      d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"
                                    ></path>
                                    <path
                                      d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"
                                    ></path>
                                  </svg></button
                                ><button
                                  class="btn btn-primary"
                                  type="button"
                                  style="
                                    background: var(--bs-table-bg);
                                    border-style: none;
                                    padding: 0.25rem;
                                  "
                                >
                                  <svg
                                    class="bi bi-trash-fill fs-5"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="1em"
                                    height="1em"
                                    fill="currentColor"
                                    viewBox="0 0 16 16"
                                    style="
                                      color: var(--bs-danger);
                                      margin-left: 11px;
                                    "
                                  >
                                    <path
                                      d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"
                                    ></path>
                                  </svg>
                                </button>
                              </div>
                            </td>
                          </tr>
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