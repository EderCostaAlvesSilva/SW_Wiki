<?php

$routes = [
    '/' =>  'RenderPageController@index',
    '/people' => 'RenderPageController@people',
    '/planets' => 'RenderPageController@planets',
    '/films' => 'RenderPageController@films',
    '/species' => 'RenderPageController@species',
    '/vehicles' => 'RenderPageController@vehicles',
    '/starships' => 'RenderPageController@starships',

    '/users' => 'RenderPageController@userList',
    '/myuser' => 'RenderPageController@user',
    '/favorites' => 'RenderPageController@favorites',
    '/pageView' => 'RenderPageController@pageView',
    '/comments' => 'RenderPageController@comments',

    '/api/people' => 'StarWarsAPIController@listPeople',
    '/api/people/{id}' => 'StarWarsAPIController@getPeople',
    '/api/planets' => 'StarWarsAPIController@listPlanets',
    '/api/planets/{id}' => 'StarWarsAPIController@getPlanets',
    '/api/films' => 'StarWarsAPIController@listFilms',
    '/api/films/{id}' => 'StarWarsAPIController@getFilms',
    '/api/species' => 'StarWarsAPIController@listSpecies',
    '/api/species/{id}' => 'StarWarsAPIController@getSpecies',
    '/api/vehicles' => 'StarWarsAPIController@listVehicles',
    '/api/vehicles/{id}' => 'StarWarsAPIController@getVehicles',
    '/api/starships' => 'StarWarsAPIController@listStarships',
    '/api/starships/{id}' => 'StarWarsAPIController@getStarships',

    '/api/user' => 'UserController@list',
    '/api/user/create' => 'UserController@create',
    '/api/user/update' => 'UserController@update',
    '/api/user/delete' => 'UserController@delete',
    '/api/user/auth' => 'UserController@auth',

    '/api/favorites/favorite-status' => 'FavoritesController@getFavorite',
    '/api/favorites/delete' => 'FavoritesController@delete',
    '/api/favorites/create' => 'FavoritesController@create',
    '/api/favorites/myfav/{id}' => 'FavoritesController@listMyfavorites',

    '/api/pageView' => 'PageViewController@list',
    '/api/pageView/create' => 'PageViewController@create',

    '/api/comments' => 'CommentsController@list',
    '/api/comments/create' => 'CommentsController@create',
    '/api/comments/delete' => 'CommentsController@delete',
    '/api/comments/chat' => 'CommentsController@listchat'


];