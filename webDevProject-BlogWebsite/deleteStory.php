<?php
    require 'database.php';
    // get article id from post
    $article_id = $_POST['id'];
    echo $article_id;
    // delete article from database
    $stmt = $mysqli->prepare("delete from articles where id=?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('i', $article_id);
    $stmt->execute();
    $stmt->close();
    // redirect to homepage
    header("Location: index.php");
?>