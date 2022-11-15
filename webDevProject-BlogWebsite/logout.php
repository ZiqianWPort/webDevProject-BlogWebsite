<!DOCTYPE html>
<html lang="en">

<title>Logout</title>
<?php

    // close the login session
    session_start();
    session_destroy();
    // redirect to login page
    header("Location: index.php");

?>
</html>