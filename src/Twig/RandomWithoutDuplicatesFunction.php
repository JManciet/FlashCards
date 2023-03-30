<?php

namespace App\Twig;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class RandomWithoutDuplicatesFunction extends AbstractExtension
{
    // private $used = [];
    private $session;
    
    public function getFunctions()
    {
        return [
            new TwigFunction('randomWithoutDuplicates', [$this, 'randomWithoutDuplicates']),
            // new TwigFunction('test', [$this, 'test']),
        ];
    }


    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
        // dd('construct');
    }

    public function test() {
        dd("ok super");
        return "ok";
    }

    public function randomWithoutDuplicates(array $array, $sessionTabPosition)
    {
        
        $useds = $this->session->get($sessionTabPosition, []);
        
        
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
                
                // var_dump("asc",$useds);
                
                
                //     $diff = array_udiff($array, $useds, [$this, 'compare_users']);
                
                $remainings = $this->multi_array_diff($array, [$lastValueOfuseds]);
                
                $useds = array();
                
                if(sizeof($remainings)>0)
                $random = $remainings[array_rand($remainings)];
                else
                $random = $array[0];

                $useds[] = $random;
            
        }else{
            
            
            // var_dump("bbbb");
            
            
            if(sizeof($remainings)>0)
            $random = $remainings[array_rand($remainings)];
            else
            $random = $array[0];
            
            
            
            $useds[] = $random;
            
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
