<?php
// IMPORT THIS ON ALL PROTECTED PAGES

session_start();

if ( isset( $_SESSION['admin'] ) ) {
} else {
    '<script>window.location.replace("login.php");</script>' // redirect
}
?>