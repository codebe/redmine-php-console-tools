<?php

require_once ('Loader/ClassMapAutoloader.php');

use Zend\Loader\ClassMapAutoloader;
use Symfony\Component\Console as Console;
use Redmine\Resources as Resources;

$loader = new ClassMapAutoloader(array('autoload_classmap.php'));

$loader->register();
$console = new Console\Application();

$console->add(new Resources\IssueCreateCommand());
$console->add(new Resources\IssueListCommand());
$console->add(new Resources\IssueUpdateCommand());
$console->add(new Resources\IssueDeleteCommand());
$console->add(new Resources\IssueCategoryListCommand());
$console->add(new Resources\IssueCategoryCreateCommand());
$console->add(new Resources\ProjectListCommand());
$console->add(new Resources\UserListCommand());

$console->run();