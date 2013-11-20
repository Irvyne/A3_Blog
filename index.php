<?php
/**
 * Created by Thibaud BARDIN (Irvyne)
 * This code is under the MIT License (https://github.com/Irvyne/license/blob/master/MIT.md)
 */

//require 'Entity/ArticleManager.php';

spl_autoload_register(function($className){
    $fileName = $className.'.php';
    if (is_file('Entity/'.$fileName)) {
        require 'Entity/'.$fileName;
    }
});

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

$articles = $articleManager->findAll();

var_dump($articles);