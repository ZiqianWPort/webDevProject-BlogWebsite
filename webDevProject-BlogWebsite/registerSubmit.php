<!DOCTYPE html>
<html lang="en">

<title>Bruce & Jeffrey's News Website Login</title>

<body>
    <?php
        require 'database.php';
        require 'validate.php';
        // get user registration info
        $username = (string)$_GET["username"];
        $password = (string)$_GET["password"];
        $repeatPassword = (string)$_GET["repeatPassword"];
        $email = (string)$_GET["email"];
        $nickname = (string)$_GET["nickname"];

        // validate username
        validateInput($username, "username", 64);

        // validate repeat password
        if ($password != $repeatPassword) {
            echo "Passwords do not match";
            exit;
        }

        // validate password limit to 64 characters
        if (strlen($password) > 64) {
            echo "Password too long";
            exit;
        }

        // validate email, invalid if contains special characters or doesnot follow email format
        if( !preg_match('/^[\w_\-]+@[\w_\-]+\.[\w_\-]+$/', $email) ){
            echo "Invalid email";
            exit;
        }
        if (strlen($email) > 255) {
            echo "Email too long";
            exit;
        }

        // if nickname is empty, set it to username
        if (empty($nickname)) {
            $nickname = $username;
        }

        // validate nickname
        validateInput($nickname, "nickname", 64);

        // hash password
        $password = password_hash($password, PASSWORD_DEFAULT);

        // check if username already exists
        $stmt = $mysqli->prepare("select username from users where username=?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->bind_result($user);
        $stmt->fetch();
        if ($user) {
            echo "Username already exists";
            exit;
        }

        // prepare query
        $stmt = $mysqli->prepare("insert into users (username, password, email, nickname) values (?, ?, ?, ?)");

        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }

        // bind parameters
        $stmt->bind_param('ssss', $username, $password, $email, $nickname);

        // execute query
        $stmt->execute();

        $stmt->close();

        // redirect to login page
        header("Location: login.php");
    ?>

</body>
</html>