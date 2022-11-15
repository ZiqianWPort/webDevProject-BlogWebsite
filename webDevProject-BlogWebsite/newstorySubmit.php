<!DOCTYPE html>
<html lang="en">

<title>Bruce & Jeffrey's News Website</title>

<body>
    <?php
        require 'database.php';
        require 'validate.php';
        require 'loginStatus.php';
        // get post data
        $title = $_POST['title'];
        $content = $_POST['content'];
        $link = $_POST['link'];

        // validate title
        $title = validateContent($title);

        // validate content
        $content = validateContent($content);
        
        // validate link
        $link = validateContent($link);

        // insert into database
        $stmt = $mysqli->prepare("insert into articles (title,author,text) values (?, ?, ?)");

        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }

        // get user id of current user, set as author
        $author = getUserId();


        $stmt->bind_param('sis', $title, $author, $content);

        $stmt->execute();

        $stmt->close();

        // get latest article id
        $stmt = $mysqli->prepare("SELECT AUTO_INCREMENT
                                    FROM information_schema.TABLES
                                    WHERE TABLE_SCHEMA = 'm3groupwebsite'
                                    AND TABLE_NAME = 'articles'");

        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }

        $stmt->execute();

        $stmt->bind_result($article_id);

        $stmt->fetch();
        $article_id = $article_id - 1;

        $stmt->close();

        echo "Article ID: $article_id<br>";

        // insert into attachments table

        $stmt = $mysqli->prepare("insert into attachments (name, article_id) values (?, ?)");

        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }

        $type = "link";
        $stmt->bind_param('si', $link, $article_id);

        echo "Link: $link<br>";
        echo "Article ID: $article_id<br>";

        $stmt->execute();

        $stmt->close();

        // redirect to article page
        header("Location: article.php?id=$article_id");
    ?>

</body>
</html>