<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Story</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

    <?php
        require 'database.php';
        require 'navbar.php';
        require 'userData.php';

        // get article id
        // if empty id, redirect to index.php
        if (!isset($_GET["id"])) {
            // back to main page
            header("Location: index.php");
        } else {
            $id = (int)$_GET["id"];
        }

        //------------------article texts--------------------//

        $stmt1 = $mysqli->prepare("select title,author,date,text,articles.id,name
                                   from articles
                                   join attachments on (articles.id = attachments.article_id)
                                   where articles.id=?");
        if(!$stmt1){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt1->bind_param('i', $id);
        $stmt1->execute();
        $stmt1->bind_result($title,$author,$date,$text,$id,$link);
        $stmt1->fetch();

        $nickname = databaseGetNickname($author);

        //article text
        echo "<br>";
        echo "<br>";
        echo "<div class=\"card\" style=\"width:76%;position:relative;overflow:hidden;left:12%;right:12%\">";
            echo "<div class=\"card-body\">";

                //text body (title, author, date, text)
                echo "<h5 class=\"card-title\">".htmlspecialchars($title)."</h5>";
                echo "<br>";
                echo "<h6 class=\"card-subtitle mb-2 text-muted\">".htmlspecialchars($nickname)."</h6>";
                echo "<h6 class=\"card-subtitle mb-2 text-muted\">".htmlspecialchars($date)."</h6>";
                echo "<br>";
                echo "<p class=\"card-text\">".htmlspecialchars($text)."</p>";
                echo "<a class=\"card-text\" href=\"http://".htmlspecialchars($link)."\" style=\"z-index:1000\">".htmlspecialchars($link)."</a>";
                
                //edit & delete buttons
                // if user is logged in and is the author of the article or is an admin
                if (isLoggedIn() && (getUserId() == $author || isAdmin())) {
                    echo "<div class=\"p-2\">
                            <form action='editStory.php' method='POST'>
                                <input type='hidden' name='id' value='$id'>
                                <input type='submit' value='edit' class=\"btn btn-outline-secondary\">
                            </form>
                        </div>";
                    echo "<div class=\"p-2\">
                            <form action='deleteStory.php' method='POST'>
                                <input type='hidden' name='id' value='$id'>
                                <input type='submit' value='delete' class=\"btn btn-outline-danger\">
                            </form>
                         </div>";
                }
                
                //echo "</ul>\n";
            echo "</div>";
        echo "</div>";

        $stmt1->close();

        //------------------comments--------------------//

        $stmt2 = $mysqli->prepare("select comment,id,article_id,user_id from comments where article_id=?");
        if(!$stmt2){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt2->bind_param('i', $id);
        $stmt2->execute();
        $stmt2->bind_result($comment,$comment_id,$article_id,$user_id);

        echo "<br>";

        echo "<div class=\"card\" style=\"width:76%;position:absolute;left:12%;right:12%\">";
            echo "<div class=\"card-body\">";

                // show if user is logged in
                if (isLoggedIn()) {
                //enter new comments:
                    echo "<h6 class=\"card-title\">Share Your Thoughts:</h6>";
                    echo "<form action='postComment.php' method='POST'>";
                        echo "<div class=\"hstack gap-3\">";
                            echo "<input type='hidden' name='article_id' value='$id'>";

                            echo "<textarea class=\"form-control\" name=\"comment\" rows=\"1\"></textarea>";
                            echo "<input type=\"submit\" name=\"action\" value=\"Send\" class=\"btn btn-primary\">";
                        echo "</div>";
                    echo "<br>";
                    echo "</form>";
                }

                //display previous comments:
                echo "<h6 class=\"card-title\">Comments:</h6>";
                while($stmt2->fetch()){
                    $commentNickname = databaseGetNickname($user_id);

                    echo "<div class=\"card\">";
                        echo "<div class=\"card-body\">";

                            echo "<div class=\"hstack gap-5\">";
                                //comment text
                                echo "<div class=\"card-text text-wrap\">".htmlspecialchars($commentNickname).": &nbsp &nbsp ".htmlspecialchars($comment)."</div>";
                                
                                //edit & delete buttons
                                // if user is logged in and is the author of the commentecho isAdmin();
                                if (isLoggedIn() && (getUserId() == $author || isAdmin())) {
                                    echo "<div class=\"p-2\">
                                    <form action='editComment.php' method='POST'>
                                        <input type='hidden' name='comment_id' value='$comment_id'>
                                        <input type='hidden' name='article_id' value='$id'>
                                        <input type='submit' value='edit' class=\"btn btn-outline-secondary\" style=\"position:absolute;top:16%;right:10.5%\">
                                    </form>
                                    </div>";
                                    echo "<div class=\"p-2\">
                                    <form action='deleteComment.php' method='POST'>
                                        <input type='hidden' name='comment_id' value='$comment_id'>
                                        <input type='hidden' name='article_id' value='$id'>
                                        <input type='submit' value='delete' class=\"btn btn-outline-danger\" style=\"position:absolute;top:16%;right:1%\">
                                    </form>
                                    </div>";
                                }

                            echo "</div>";
                        
                        echo "</div>";
                    echo "</div>";

                    echo "<br>";
                };

            //echo "</ul>\n";
            echo "</div>";
        echo "</div>";

        $stmt2->close();
    ?>

</body>
</html>