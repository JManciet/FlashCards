<?php

namespace App\Twig;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class RandomWithoutDuplicatesFunction extends AbstractExtension
{
    // private $used = [];

    public function getFunctions()
    {
        return [
            new TwigFunction('random_without_duplicates', [$this, 'randomWithoutDuplicates']),
        ];
    }

    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }



    public function randomWithoutDuplicates(array $array, $sessionTabPosition)
    {



        $useds = $this->session->get($sessionTabPosition, []);

        // var_dump($array);
        // var_dump($useds);
        
       
        // dd("g");
        $remainings = $this->multi_array_diff($array, $useds);
        // var_dump($useds);
        // var_dump($remainings);
        // foreach($useds as $index){
            // var_dump($useds[2]->getId());
        // }            
        
    

        if (empty($remainings)) {

            // var_dump("aaaa");
            $remainings = $array;
            
            $lastValueOfuseds = end($useds);


            $useds = array();

            $useds[] = $lastValueOfuseds;

            // var_dump($useds);


        //     $diff = array_udiff($array, $useds, [$this, 'compare_users']);

            $remainings = $this->multi_array_diff($array, $useds);

            // var_dump($remainings);

            $random = $remainings[array_rand($remainings)];

        }else{


            // var_dump("bbbb");
            

            $random = $remainings[array_rand($remainings)];

            

            array_push($useds,$random);
        
        }

        $this->session->set($sessionTabPosition, $useds);


        // dd($remainings);

        return $random;
    }




    

    function compare_users($a, $b) {
        return $a->id - $b->id;
    }

    function multi_array_diff($arraya, $arrayb) {

        foreach ($arraya as $keya => $valuea) { 
            if(is_object($valuea)){

                $aa = [];
                foreach( $arrayb as $valueb ){

                    $aa[] = $valueb->getId();
                }

                // if (    array_key_exists($valuea->getId(), $arrayb)) {
                if (in_array($valuea->getId(), $aa)) { 
                    
                    unset($arraya[$keya]);
                    // var_dump($arraya        );
                }
            }else{
                if (in_array($valuea, $arrayb)) { 
                    unset($arraya[$keya]); 
                } 
            }
        } 
        return $arraya; 
    } 
    
}
