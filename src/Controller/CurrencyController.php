<?php

namespace App\Controller;

use App\Entity\Datas;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CurrencyController extends Controller
{
    public function curl_json($url)
    {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        // curl_setopt($ch,CURLOPT_HEADER, false);
        $output=curl_exec($ch);
        curl_close($ch);
        return json_decode($output);
    }

    public function object_to_array($obj){
        $items = array();
        foreach ($obj as $key => $value) {
            $items[$key] = $value;
        }

        return $items;
    }


    function get_self($array){
        $item = array();
        foreach ($array as $key) {
            $item[] = $key;
        }

        return $item;
    }




    public function get_row($array)
    {
        if(count($array)==1){
            foreach ($array as $key=>$value) {
                $items[] = $value;
            }
            foreach ($items[0] as $key2) {
                $newItem[] = $key2;
            }
            $row =  $this->object_to_array($newItem);
        } else {
            $row =  $this->object_to_array($array);
        }

        return $row;
    }

    public function list_row($array){
        $items = array();
        for($i=0; $i<count($array); $i++){
            foreach ($array[$i] as $key => $value) {
                $items[$key][] = $value;
            }
        }

        return $this->get_self($items);
    }



    public function adaptor($url)
    {
        $json_data = $this->curl_json($url);
        $varType = gettype($json_data);
        if($varType=='array'){

            return $this->list_row($this->get_row($json_data));

        } else if($varType=='object'){

            $array = $this->object_to_array($json_data);
            return $this->list_row($this->get_row($array));
        }
    }






    public function apitest()
    {
        return 'test';
    }

    public function index($url)
    {

        $dataToDb = $this->adaptor($url);

        $entityManager = $this->getDoctrine()->getManager();

        for ($i=0; $i<count($dataToDb[1]); $i++){
            $datas = new Datas();
            $datas->setSymbol($dataToDb[0][$i]);
            $datas->setAmount($dataToDb[1][$i]);

            $entityManager->persist($datas);

            $entityManager->flush();
        }




        return new Response('Saved: '.$datas->getId());
    }

    public function api()
    {
        return new Response($this->index('http://www.mocky.io/v2/5a74519d2d0000430bfe0fa0'));
        return new Response($this->index('http://www.mocky.io/v2/5a74524e2d0000430bfe0fa3'));
    }

    public function list_data()
    {
        $datas = $this->getDoctrine()
            ->getRepository(Datas::class)
            ->find(1);

        if(!$datas){
            throw $this->createNotFoundException('No data found');
        }

        return new Response('Currency : '.$datas->getSymbol());
    }




}