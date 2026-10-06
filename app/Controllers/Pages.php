<?php

namespace App\Controllers;

class Pages extends BaseController
{
    /**
     * Landing page ("/")
     */
    public function landing()
    {
        $data = [
            'title' => 'Home',
        ];

        return view('templates/header', $data)
            . view('pages/landing')
            . view('templates/footer');
    }

    /**
     * About page ("/about")
     */
    public function about()
    {
        $data = [
            'title' => 'About',
        ];

        return view('templates/header', $data)
            . view('pages/about')
            . view('templates/footer');
    }
}
