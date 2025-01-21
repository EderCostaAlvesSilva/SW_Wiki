<?php

class RenderPageController extends RenderView
{
    public function index()
    {
        $this->loadView('index', []);
    }

    public function planets()
    {
        $this->loadView('planets', []);
    }
    public function films()
    {
        $this->loadView('films', []);
    }
    public function species()
    {
        $this->loadView('species', []);
    }
    public function vehicles()
    {
        $this->loadView('vehicles', []);
    }
    public function starships()
    {
        $this->loadView('starships', []);
    }

    public function people()
    {
        $this->loadView('people', []);
    }

    public function user()
    {
        $this->loadView('user', []);
    }

    public function userList()
    {
        $this->loadView('users', []);
    }

    public function favorites()
    {
        $this->loadView('favorites', []);
    }

    public function pageView()
    {
        $this->loadView('pageView', []);
    }

    public function comments()
    {
        $this->loadView('comments', []);
    }
}