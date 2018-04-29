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

}