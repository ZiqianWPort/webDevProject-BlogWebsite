<?php
    require 'database.php';
    require 'loginStatus.php';
    require 'validate.php';
    // get article id from post
    $article_id = $_POST['article_id'];
    // get comment id from post
    $comment_id = $_POST['comment_id'];
    // get comment from post
    $comment = $_POST['comment'];
    // get user id from session
    $user_id = getUserId();

    // validate comment
    $comment = validateContent($comment);

    // insert comment into database
    $stmt = $mysqli->prepare("update comments
                                set comment=?
                                    where id=?;");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('si', $comment, $comment_id);
    $stmt->execute();
    $stmt->close();
    // redirect to article page
    header("Location: article.php?id=$article_id");

?>