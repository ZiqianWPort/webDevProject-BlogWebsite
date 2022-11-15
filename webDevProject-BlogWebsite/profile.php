<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bruce & Jeffrey's News Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    
    <?php
        require 'database.php';
        require 'navbar.php';

        //user's articles
        $keyword = isset($_GET["keyword"]) ? $_GET["keyword"] : "";
        function shorten($title,$date) {
            $output = $title;
            if (strlen($title)+strlen($date)>90){
                $output = substr($title,0,30).' ...... '.substr($title,-25);
            }
            return $output;
        }
        
        $stmt1 = $mysqli->prepare("select title,author,date,text,id from articles where title like '%$keyword%' order by date desc");
                if(!$stmt1){
                    printf("Query Prep Failed: %s\n", $mysqli->error);
                    exit;
        }
        if(!$stmt1){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt1->execute();
        $stmt1->bind_result($title,$author,$date,$text,$id);

        echo "<br>";
        echo "<br>";

        echo "<div class=\"card\" style=\"width:76%;position:relative;overflow:hidden;left:12%;right:12%\">";
            echo "<div class=\"card-body\">";
                echo "<h5 class=\"card-title\">My Articles:</h5>";
                echo "<br>";
                
                while($stmt1->fetch()){

                    echo "<form action=\"article.php\" method=\"GET\">";
                        // field for article id
                        echo "<input type=\"hidden\" name=\"id\" value=\"$id\">";
        
                        // field for article title,author,date
                        $titleLine = shorten($title,$date);
                        echo "<div class=\"card\">";
                        echo "<div class=\"card-body\">";
                        echo "<button type=\"submit\" name=\"action\" class=\"list-group-item list-group-item-action\">";
                        echo "<div class=\"hstack gap-3\">";
                        echo "<p class=\"text-start\"> &nbsp </p>";//button height holder
                        echo "<p class=\"text-start\" style=\"position:absolute;top:30%\"> $titleLine </p>";
                        echo "<p class=\"text-end\" style=\"position:absolute;top:30%;right:3%;color:gray\"> $date </p>";
                                                    
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</button>";
                        echo "<br>";
                    echo "</form>";
                };

                echo "</ul>\n";
            echo "</div>";
        echo "</div>";

        $stmt1->close();

        echo "<br>";

        //user's comments
        $stmt2 = $mysqli->prepare("select comment,id,article_id,user_id from comments where article_id=?");
        if(!$stmt2){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt2->bind_param('i', $id);
        $stmt2->execute();
        $stmt2->bind_result($comment,$id,$article_id,$user_id);

        echo "<ul>\n";

        echo "<div class=\"card\" style=\"width:76%;position:absolute;left:12%;right:12%\">";
            echo "<div class=\"card-body\">";

                    echo "<h5 class=\"card-title\">My Comments:</h5>";
                    echo "<br>";

                        while($stmt2->fetch()){
                            echo "<div class=\"card\">";
                            echo "<div class=\"card-body\">";
                            echo "<div class=\"card-text\">$comment</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "<br>";
                        };

                    echo "</ul>\n";
            echo "</div>";
        echo "</div>";

        $stmt2->close();
    ?>

    </div>
</body>

</html>