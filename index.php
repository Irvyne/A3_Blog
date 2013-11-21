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

$article = new Article(array(
    'id'        => 2,
    'title'     => 'Nouveau titre',
    'content'   => 'content',
    'author'    => 1,
    'date'      => new DateTime(),
    'enabled'   => true,
));

$articleManager = new ArticleManager($pdo);

var_dump($articleManager->findAllByEnabled(false));
var_dump($articleManager->findOneByTitle('abc'));

/*
foreach ($articles as $article) {
    echo '<h1>'.$article->getTitle().'</h1>';
    echo '<small>'.$article->getDate()->format(\DateTimeFormat::DATE_FRENCH).'</small>';
    echo '<hr>';
}
*/