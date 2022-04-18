<?php
session_start();

// ! add code to use session token to change behavior of nav bar

?>
<!-- start of header  -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
    />
    <title>UVA Meeting Portal</title>
    <link
      rel="apple-touch-icon"
      type="image/png"
      sizes="180x180"
      href="../assets/img/apple-touch-icon.png"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="../assets/img/favicon-16x16.png"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="32x32"
      href="../assets/img/favicon-32x32.png"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="180x180"
      href="../assets/img/apple-touch-icon.png"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="192x192"
      href="../assets/img/android-chrome-192x192.png"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="512x512"
      href="../assets/img/android-chrome-512x512.png"
    />
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Inter:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;display=swap"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css"
    />
  </head>

  <body
    style="
      /*background: url(&quot;design.jpg&quot;);*/
      background-position: 0 -60px;
    "
  >
    <nav
      class="navbar navbar-light navbar-expand-md fixed-top navbar-shrink py-3"
      id="mainNav"
    >
      <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/"
          ><span
            class="bs-icon-sm bs-icon-circle bs-icon-primary shadow d-flex justify-content-center align-items-center me-2 bs-icon"
            ><svg
              xmlns="http://www.w3.org/2000/svg"
              width="1em"
              height="1em"
              fill="currentColor"
              viewBox="0 0 16 16"
              class="bi bi-people"
            >
              <path
                d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"
              ></path></svg></span
          ><span>UVA Meeting Portal</span></a
        ><button
          data-bs-toggle="collapse"
          class="navbar-toggler"
          data-bs-target="#navcol-1"
        >
          <span class="visually-hidden">Toggle navigation</span
          ><span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navcol-1">
          <ul class="navbar-nav mx-auto">
            <li class="nav-item">
              <a
                class="nav-link"
                data-bss-disabled-mobile="true"
                data-bss-hover-animate="pulse"
                href="index.php"
                >Home</a
              >
            </li>
            <li
              class="nav-item"
              data-bss-disabled-mobile="true"
              data-bss-hover-animate="pulse"
            >
              <a
                class="nav-link"
                data-bss-disabled-mobile="true"
                data-bss-hover-animate="pulse"
                href="meeting.php"
                >Your Meetings</a
              >
            </li>
            <li
              class="nav-item"
              data-bss-disabled-mobile="true"
              data-bss-hover-animate="pulse"
            ></li>
            <li
              class="nav-item"
              data-bss-disabled-mobile="true"
              data-bss-hover-animate="pulse"
            >
              <a
                class="nav-link"
                data-bss-disabled-mobile="true"
                data-bss-hover-animate="pulse"
                href="create-meeting.php"
                >Create Meeting</a
              >
            </li>
          </ul>
          <?php echo (!isset($_SESSION["computing_id"]) ?
          '<a
            class="btn btn-primary shadow"
            role="button"
            data-bss-disabled-mobile="true"
            data-bss-hover-animate="pulse"
            href="login.php"
            >Log In</a
          >'
          : "Logged in as " . $_SESSION['computing_id']);?>

        </div>
      </div>
    </nav>
<!-- end of header -->
