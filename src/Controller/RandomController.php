<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RandomController extends Controller
{

    public function names()
    {
        $names = array('Rasmus', 'Steve', 'Bill', 'Mark');

        return $this->render('random/names.html.twig', array('names' => $names));
    }

    public function cars()
    {
        $url = 'http://www.mocky.io/v2/5a74519d2d0000430bfe0fa0';
        $url2 = 'http://www.mocky.io/v2/5a74524e2d0000430bfe0fa3';
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url2);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        // curl_setopt($ch,CURLOPT_HEADER, false);
        $output=curl_exec($ch);
        curl_close($ch);
        $a = $output;
        //return $this->render('random/cars.html.twig', array('data' => $a));

        return print_r(json_decode($a));
    }

    public function api1()
    {
        $url = 'http://www.mocky.io/v2/5a74519d2d0000430bfe0fa0';
        $url2 = 'http://www.mocky.io/v2/5a74524e2d0000430bfe0fa3';
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url2);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        // curl_setopt($ch,CURLOPT_HEADER, false);
        $output=curl_exec($ch);
        curl_close($ch);
        $a = json_decode($output);

        foreach ($a as $row){
            $items[] = $row;
        }

        return $this->render('random/cars.html.twig', array('data' => $a));


    }

    public function api2()
    {
        $url = 'http://www.mocky.io/v2/5a74519d2d0000430bfe0fa0';
        $url2 = 'http://www.mocky.io/v2/5a74524e2d0000430bfe0fa3';
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url2);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        // curl_setopt($ch,CURLOPT_HEADER, false);
        $output=curl_exec($ch);
        curl_close($ch);
        $a = $output;
        return $this->render('random/cars.html.twig', array('data' => $a));

    }

    public function test()
    {
        return new Response(
            'test'
        );
    }

}