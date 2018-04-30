<?php

namespace App\Controller;

use App\Entity\Datas;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CurrencyController extends Controller
{
    public function curl_json($url)
    {
        // Curl get ile gelen veriyi json decode ediyor

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch,CURLOPT_HEADER, false);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output);
    }

    public function object_to_array($obj)
    {
        // Eğer veri object ise arraya çeviriyor

        $items = array();
        foreach ($obj as $key => $value) {
            $items[$key] = $value;
        }

        return $items;
    }


    function get_self($array)
    {

        // Parametre isimlerini sıfırlar

        $item = array();
        foreach ($array as $key) {
            $item[] = $key;
        }

        return $item;
    }

    public function get_row($array)
    {
        // Eğer veride json array var ise döndürüp son array a ulaşıyor

        if (count($array) == 1) { // 1 ise yeniden döngüye sokuyor
            foreach ($array as $key => $value) {
                $items[] = $value;
            }
            foreach ($items[0] as $key2) {
                $newItem[] = $key2;
            }
            $row = $this->object_to_array($newItem);
        } else { // 1 değilse zaten veriye ulaşılmış demektir
            $row = $this->object_to_array($array);
        }

        return $row;
    }

    public function list_row($array)
    {
        /**
         * Veriyi sembol ve oranlarına göre yeniden düzenleyip array yapıyor
         */

        $items = array();
        for ($i = 0; $i < count($array); $i++) {
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
        if ($varType == 'array') { // veri çekildiğinde tipini bakıp dönüştürüyor

            return $this->list_row($this->get_row($json_data));

        } else if ($varType == 'object') { // veri çekildiğinde tipini bakıp dönüştürüyor

            $array = $this->object_to_array($json_data);
            return $this->list_row($this->get_row($array));
        }
    }


    public function api($url, $randKeyCreate)
    {
        /**
         * Api burada url ile verileri alıp işleyip veritabanına ekliyor.
         */

        $dataToDb = $this->adaptor($url);

        $entityManager = $this->getDoctrine()->getManager();

        $symbol = array(0 => 'USDTRY', 1 => 'EURTRY', 2 => 'GBPTRY');

        for ($i = 0; $i < count($dataToDb[1]); $i++) {
            $datas = new Datas();
            $datas->setSymbol($symbol[$i]);
            $datas->setAmount($dataToDb[1][$i]);
            $datas->setRandKey($randKeyCreate);
            $entityManager->persist($datas);
            $entityManager->flush();
        }

    }


    public function api_settings()
    {
        /**
         * Apinin ayarlanacağı kısım
         */
        $randKeyCreate = rand(456444, 999999); // bir random key atayıp vt´ye ekliyor

        $this->api('http://www.mocky.io/v2/5a74519d2d0000430bfe0fa0', $randKeyCreate);
        $this->api('http://www.mocky.io/v2/5a74524e2d0000430bfe0fa3', $randKeyCreate);

        return $randKeyCreate;

    }

    public function list_data()
    {

        /**
         * GUI
         */

        $randKey = $this->api_settings(); // Random key´i alıp vt den eşitleyip doğru veriyi seçiyor

        $repostory = $this->getDoctrine()
            ->getRepository(Datas::class);

        $USDTRY = $repostory->findOneBy(
            ['symbol' => 'USDTRY', 'rand_key'=>$randKey], ['amount' => 'ASC']
        );

        $EURTRY = $repostory->findOneBy(
            ['symbol' => 'EURTRY', 'rand_key'=>$randKey], ['amount' => 'ASC']
        );

        $GBPTRY = $repostory->findOneBy(
            ['symbol' => 'GBPTRY', 'rand_key'=>$randKey], ['amount' => 'ASC']
        );

        $viewData = array('data' =>
            array('USDTRY' => $USDTRY, 'EURTRY' => $EURTRY, 'GBPTRY' => $GBPTRY)
        );


        /**
         * Gelen veri arasında en düşük fiyatı bulup gösteriyor.
         */
        return $this->render('currency/show.html.twig', $viewData);
    }


}