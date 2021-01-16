<?php

use Router\Router;


Router::get("api/articles","Api\ArticleController@index");
Router::get("api/articles/([0-9]+)","Api\ArticleController@show");
Router::post("api/articles/store","Api\ArticleController@store");
Router::post("api/articles/update/([0-9]+)","Api\ArticleController@update");

Router::delete("api/articles/([0-9]+)","Api\ArticleController@delete");

Router::get("api/categories","Api\CategoryController@index");


Router::get("api/comments/get/([0-9]+)","Api\CommentController@get");
Router::post("api/comments/store","Api\CommentController@store");

