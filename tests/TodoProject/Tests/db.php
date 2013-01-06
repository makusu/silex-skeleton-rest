<?php


return \Doctrine\DBAL\DriverManager::getConnection(array(
    'driver'   => $GLOBALS['DB_DRIVER'],
    'dbname'   => $GLOBALS['DB_DBNAME'],
    'host'     => $GLOBALS['DB_HOST'],
    'user'     => $GLOBALS['DB_USER'],
    'password' => $GLOBALS['DB_PASSWD']
));