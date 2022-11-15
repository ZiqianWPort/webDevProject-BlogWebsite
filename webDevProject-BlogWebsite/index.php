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
    
    <?php require 'navbar.php'?>


    <div class="mx-auto" style="width: 60pc;">

        <br>
        <br>

        <!-- <form action="article.php" method="GET"> -->

            <?php
                
                require 'database.php';
                require 'userData.php';

                // get search keyword, if empty, set to empty string
                $keyword = isset($_GET["keyword"]) ? $_GET["keyword"] : "";

                $stmt = $mysqli->prepare("select title,author,date,text,id from articles where title like '%$keyword%' order by date desc");
                if(!$stmt){
                    printf("Query Prep Failed: %s\n", $mysqli->error);
                    exit;
                }

                $stmt->execute();
                $stmt->bind_result($title,$author,$date,$text,$id);

                echo "<div class=\"list-group\">";
                
                    function shorten($title,$nickname,$date) {
                        $output = $title;
                        if (strlen($title)+strlen($nickname)+strlen($date)>90 && strlen($title)>strlen($nickname)){
                            $output = substr($title,0,30).' ...... '.substr($title,-25);
                        }
                        return $output;
                    }

                    while($stmt->fetch()){
                            $nickname = databaseGetNickname($author);


                        echo "<form action=\"article.php\" method=\"GET\">";
                            // field for article id
                            echo "<input type=\"hidden\" name=\"id\" value=\"$id\">";

                            // field for article title,author,date
                            $titleLine = shorten($title,$nickname,$date);
                            echo "<button type=\"submit\" name=\"action\" class=\"list-group-item list-group-item-action\">";
                            echo "<span class=\"hstack gap-3\">";
                                echo "<span class=\"text-start\"> &nbsp;</span>";//button height holder
                                echo "<span class=\"text-start\" style=\"position:absolute;top:30%\"> ".htmlspecialchars($titleLine)." </span>";
                                echo "<span class=\"text-end\" style=\"position:absolute;top:30%;right:3%;color:gray\"> ".htmlspecialchars($nickname).": ".htmlspecialchars($date)." </span>";
                                                        
                            echo "</span>";
                            echo "</button>";
                        echo "</form>";
                    };
                
                echo "</div>";

                $stmt->close();
            ?>

        <!-- </form> -->
    </div>
</body>

</html>