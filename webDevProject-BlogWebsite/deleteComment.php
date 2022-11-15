<?php
    require 'database.php';
    // get article id from post
    $comment_id = $_POST['comment_id'];
    $article_id = $_POST['article_id'];

    // delete comment from database
    $stmt = $mysqli->prepare("delete from comments where id=?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('i', $comment_id);
    $stmt->execute();
    $stmt->close();
    // redirect to article page
    header("Location: article.php?id=$article_id");

?>