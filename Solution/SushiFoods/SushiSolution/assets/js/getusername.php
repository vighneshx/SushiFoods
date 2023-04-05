<?php

require "requires/config.php";

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    echo $_SESSION['username'];
} else {
    echo "not_logged_in";
}
?>