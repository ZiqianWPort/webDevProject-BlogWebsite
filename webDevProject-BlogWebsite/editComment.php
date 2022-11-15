<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Comment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<?php
    require 'navbar.php';
    require 'database.php';
    // get article id from post
    $article_id = $_POST['article_id'];
    // get comment id from post
    $comment_id = $_POST['comment_id'];

    // get comment text from database
    $stmt = $mysqli->prepare("select comment from comments where id=?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('i', $comment_id);
    $stmt->execute();
    $stmt->bind_result($comment);
    $stmt->fetch();

    //echo $comment;
    echo "<br>";


    echo "<div class=\"card\" style=\"width:73.4%;position:absolute;left:15%;right:10%\">";
        echo "<div class=\"card-body\">";
            //enter new comments:
            echo "<h6 class=\"card-title\">Edit Your Comment:</h6>";
            echo "<form action='editCommentSubmit.php' method='POST'>";
                echo "<div class=\"hstack gap-3\">";
                    echo "<input type='hidden' name='article_id' value='$article_id'>";
                    echo "<input type='hidden' name='comment_id' value='$comment_id'>";
                    echo "<textarea class=\"form-control\" name=\"comment\" rows=\"1\">".htmlspecialchars($comment)."</textarea>";
                    echo "<input type=\"submit\" name=\"action\" value=\"Send\" class=\"btn btn-primary\">";
                echo "</div>";
            echo "<br>";
            echo "</form>";
        echo "</div>";
    echo "</div>";
?>