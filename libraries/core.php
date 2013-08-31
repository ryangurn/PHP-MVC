<?php

if( !empty($_POST['_method']) && in_array($_POST['_method'], array('put', 'delete')) ) {
  $_SERVER['REQUEST_METHOD'] = strtoupper($_POST['_method']);
}

include 'activerecord/ActiveRecord.php';

if(file_exists(BASE_PATH . 'config/database.php')):
	include BASE_PATH . 'config/database.php';
elseif(!file_exists(BASE_PATH . 'config/database.php')):
	file_put_contents( BASE_PATH . 'config/database.php', ' ');
endif;

ActiveRecord\Config::initialize(function($cfg) use ($db_connections)
{
	$cfg->set_model_directory(BASE_PATH . '/app/models');
	$cfg->set_connections($db_connections);

	$cfg->set_default_connection('development');
});

include 'object.php';
include 'controller.php';
include 'sammy.php';
include 'router.php';

include BASE_PATH . 'config/routes.php';

$sammy->run();