<?php

Config::set('site_name', 'Ювелирные украшения');

Config::set('languages', ['ru', 'ua']);
//Routes
Config::set('routes', [
    'default' => '',
    'admin' => 'admin_',
]);

Config::set('default_route', 'default');
Config::set('default_language', 'ru');
Config::set('default_controller', 'home');
Config::set('default_action', 'index');

//DB
Config::set('db.host', 'localhost');
Config::set('db.user', 'root');
Config::set('db.password', '');
Config::set('db.db_name', 'jewelry');

Config::set('salt', '3a23bb515e06d0e944ff916e79a7775c');