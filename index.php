<?php
/**
 * Created by Thibaud BARDIN (Irvyne)
 * This code is under the MIT License (https://github.com/Irvyne/license/blob/master/MIT.md)
 */

require 'autoload.php';
$config = require 'config/database.php';

try {
    $dsn = $config['driver'].':dbname='.$config['dbname'].';host='.$config['host'].';port='.$config['port'].';charset=utf8';
    $pdo = new \PDO($dsn, $config['username'], $config['password']);
} catch (\PDOException $exception) {
    //mail('monadresse@gmail.com', 'Problème de Connexion BDD', $exception->getCode().' '.$exception->getMessage().' '.$exception->getTraceAsString());
    exit('BDD Error');
}

$user = new User(array(
    'id'        => 2,
    'name'      => 'admin',
    'password'  => 'admin',
    'role'      => 'ROLE_ADMIN',
));

if (isset($_POST['submit']))
{
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['author'];
    true === isset($_POST['enabled']) ? $enabled = true : $enabled = false;

    $error_msg = array();
    if (empty($title))
        $error_msg[] = 'Champ title vide !';
    if (empty($content))
        $error_msg[] = 'Champ content vide !';
    if (empty($author))
        $error_msg[] = 'Champ auteur vide !';

    if (count($error_msg) == 0) {
        $arguments = array(
            'title'     => $title,
            'content'   => $content,
            'author'    => $author,
            'enabled'   => $enabled,
            'date'      => new DateTime(),
        );
        $article = new Article($arguments);
        $articleManager = new ArticleManager($pdo);
        $articleManager->add($article);
    }
}

include 'template/add.php';

/*
foreach ($articles as $article) {
    echo '<h1>'.$article->getTitle().'</h1>';
    echo '<small>'.$article->getDate()->format(\DateTimeFormat::DATE_FRENCH).'</small>';
    echo '<hr>';
}
*/