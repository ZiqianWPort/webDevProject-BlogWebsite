<?php
    require 'database.php';
    require 'loginStatus.php';
    require 'validate.php';
    // get article id from post
    $article_id = $_POST['article_id'];
    // get comment from post
    $comment = $_POST['comment'];
    // get user id from session
    $user_id = getUserId();

    // validate comment
    $comment = validateContent($comment);


    // insert comment into database
    $stmt = $mysqli->prepare("insert into comments (article_id, user_id, comment) values (?, ?, ?)");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('iis', $article_id, $user_id, $comment);
    $stmt->execute();
    $stmt->close();
    // redirect to article page
    header("Location: article.php?id=$article_id");

?>