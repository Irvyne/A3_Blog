<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
</head>
<body>
    <?php if (isset($error_msg) && count($error_msg) > 0) { ?>
        <ul>
            <?php foreach($error_msg as $message) { ?>
                <li><?= $message; ?></li>
            <?php } ?>
        </ul>
    <?php } ?>
    <form action="" method="post">
        <label for="title">Title</label>
            <input id="title" name="title" type="text" required autofocus><br>
        <label for="content">Content</label>
            <textarea id="content" name="content" required></textarea><br>
        <label for="author">Author</label>
            <input id="author" name="author" type="number" required><br>
        <label for="enabled">Enabled</label>
            <input id="enabled" name="enabled" type="checkbox"><br>
        <input id="submit" name="submit" type="submit" value="create">
    </form>
</body>
</html>