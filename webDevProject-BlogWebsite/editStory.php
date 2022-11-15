<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Story</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body>

    <?php 
        require 'navbar.php';
        require 'database.php';
        // if not logged in, redirect to index page
        if (!isLoggedIn()) {
            header("Location: index.php");
        }

        // get article id from post
        $article_id = $_POST['id'];

        // get title, story, from database
        $stmt = $mysqli->prepare("select title, text, attachments.name
                                    from articles
                                    join attachments
                                    on (articles.id) = (attachments.article_id)
                                    where articles.id=?;");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('i', $article_id);
        $stmt->execute();
        $stmt->bind_result($title, $text, $link);
        $stmt->fetch();
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

    <div class="card" style="width:76%;position:absolute;top:12%;left:12%;right:12%">
        <div class="card-body">
            <?php
                echo "<h5 class=\"card-title\">Edit Your Story #".htmlspecialchars($article_id)." </h5>";
            ?>
            <br>

            <form action="editStorySubmit.php" method="POST">
                <!-- hidden input for article id -->
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($article_id); ?>">
                <div class="mb-3">
                    <label class="form-label">Title:</label>
                    <?php
                        echo "<input type=\"text\" name=\"title\" class=\"form-control\" value='$title'>";
                    ?>
                    
                </div>
                
                <div class="mb-3">
                    <label  class="form-label">Your Story:</label>
                    <?php
                        echo "<textarea rows=\"15\" name=\"content\" class=\"form-control\">".htmlspecialchars($text)."</textarea>";
                    ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">External Link:</label>
                    <?php
                        echo "<input type=\"text\" name=\"link\" class=\"form-control\" value='$link'>";
                    ?>
                </div>
                

                <div class="mb-3">
                    <br>
                    <input type="submit" name="action" value="Save" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>

</body>

</html>