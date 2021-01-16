<?php

use Router\Router;


Router::get("","MainController@main");
Router::get('page-([0-9]+)',"MainController@main");


// For articles
Router::get("article/([0-9]+)","ArticleController@index");
Router::get("articles/create","ArticleController@create");
Router::post("articles/store","ArticleController@store");
Router::get("articles/([0-9]+)","ArticleController@edit")->middleware(['auth','admin']);
Router::put("articles/([0-9]+)","ArticleController@update");
Router::delete("articles/([0-9]+)","ArticleController@delete");



// Для регистрации и авторизации
Router::get('register','UserController@create_form');
Router::post('register/create','UserController@create');
Router::get('login','UserController@create_login_form');
Router::post('login/check','UserController@login_check');
Router::get("user/cabinet","UserController@user_cabinet");
Router::get("user/logout","UserController@user_logout");


// Admin Panel
Router::resource("pelagus","AdminController");
Router::get("pelagus/page-([0-9])","AdminController@index");

//

Router::get("category/([a-zA-Z]+)","ArticleController@category_articles");
Router::get("category/([a-zA-Z]+)/page-([0-9]+)","ArticleController@category_articles");



// test editor
// Router::resource("test","TestController");
Router::get("test","TestController@index");
Router::post("test/test_xss","TestController@test_xss");
Router::post("test/get_report","TestController@get_report");
// 


Router::get("categories/other","MainController@all_cats");
Router::get("search\?q\=([a-zA-Z0-9а-яёА-ЯЁ\s\.\-\+]+)","MainController@search");




// Router::get("([a-zA-Z0-9а-яёА-ЯЁ\?\=]+)","MainController@search");