<!DOCTYPE html>
<html lang="en">

<title>Bruce & Jeffrey's News Website Login</title>

<body>
    <?php
        require 'database.php';
        require 'validate.php';
        require 'loginStatus.php';
        // get user login info
        $username = (string)$_POST["username"];
        $password = (string)$_POST["password"];

        // validate username
        validateInput($username, "username", 64);

        // validate password
        validateInput($password, "password", 64);

        // check if user exists, if exists, get hashed password from database
        $stmt = $mysqli->prepare("select password from users where username=?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->bind_result($storedPwd);
        $stmt->fetch();

        // check if password matches
        if (password_verify($password, $storedPwd)) {

            login($username);
            header("Location: index.php");

        } else {
            echo "Login failed";
        }
    ?>

</body>
</html>