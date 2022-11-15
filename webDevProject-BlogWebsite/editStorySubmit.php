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
        $id = $_POST['id'];

        // validate title
        $title = validateContent($title);

        // validate content
        $content = validateContent($content);
        
        // validate link
        $link = validateContent($link);

        // insert into database
        $stmt = $mysqli->prepare("update articles
                                    JOIN attachments
                                    on (articles.id) = (attachments.article_id)
                                    set title=?,
                                    text=?,
                                    attachments.name=?
                                    where articles.id=?;");

        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }

        $stmt->bind_param('sssi', $title, $content, $link, $id);
        $stmt->execute();
        $stmt->close();
        
        // redirect to article page
        header("Location: article.php?id=$id");
    ?>

</body>
</html>