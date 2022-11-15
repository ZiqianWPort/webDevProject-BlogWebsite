<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bruce & Jeffrey's News Website Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
   
    <div class="position-absolute top-50 start-50 translate-middle">
        <h1>Bruce & Jeffrey's News Website</h1>
        <p>&nbsp;</p>
        <h3>Login or Register</h3>
        <p>&nbsp;</p>
        <form action="loginSubmit.php" method="POST">
            <div class="hstack gap-3">
                <input type="text" name="username" class="form-control" placeholder="Username">
                <input type="password" name="password" class="form-control" placeholder="Password">
                <input type="submit" name="action" value="Login" class="btn btn-primary">
            </div>
        </form>

        <p>&nbsp;</p>

        <form action="register.php" method="GET">
            <div class="hstack gap-3">
                <input type="submit" name="action" value="Register" class="btn btn-secondary">
            </div>
        </form>
    </div>

</body>

</html>