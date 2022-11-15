<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Story</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body>

    <?php 
        require 'navbar.php';
        // if not logged in, redirect to index page
        if (!isLoggedIn()) {
            header("Location: index.php");
        }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

    <div class="card" style="width:76%;position:absolute;top:12%;left:12%;right:12%">
        <div class="card-body">
            <h5 class="card-title">Post Your New Story</h5>
            <br>

            <form action="newstorySubmit.php" method="POST">
                <div class="mb-3">
                    <label  class="form-label">Title:</label>
                    <input type="text" name="title" class="form-control">
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Your Story:</label>
                    <textarea class="form-control" name="content" rows="15"></textarea>
                </div>

                <div class="mb-3">
                    <label  class="form-label">External Link:</label>
                    <input type="text" name="link" class="form-control">
                </div>
                

                <div class="mb-3">
                    <br>
                    <input type="submit" name="action" value="Post" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>



</body>

</html>