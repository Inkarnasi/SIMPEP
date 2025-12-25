<?php

namespace App\Controllers;


class Beranda extends BaseController
{
    public function Beranda(){
        session()->remove('error_list');


        $pages = 'beranda';

        $kirim ['asal'] = $pages;

        echo view ('Backend/Template/header');
        echo view ('Backend/Template/sidebar', $kirim);
        echo view ('Backend/Main/beranda');
        echo view ('Backend/Template/fuuter');
    }
}