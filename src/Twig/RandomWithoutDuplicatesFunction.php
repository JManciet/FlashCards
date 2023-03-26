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

    public function randomWithoutDuplicates(array $array)
    {
        $usedIndexes = $this->session->get('usedIndexes', []);
        $remainingIndexes = array_diff(array_keys($array), $usedIndexes);

        // var_dump($usedIndexes);
        // var_dump($remainingIndexes);

        if (empty($remainingIndexes)) {

            // var_dump("aaaa");
            $remainingIndexes = array_keys($array);
            
            $lastValueOfusedIndexes = end($usedIndexes);

            $usedIndexes = [$lastValueOfusedIndexes];

            $remainingIndexes = array_diff(array_keys($array), $usedIndexes);

            // var_dump($remainingIndexes);

            $randomIndex = array_rand($remainingIndexes);

        }else{

            $randomIndex = array_rand($remainingIndexes);
            
            $usedIndexes[] = $remainingIndexes[$randomIndex];
        
        }

        $this->session->set('usedIndexes', $usedIndexes);

        return $array[$remainingIndexes[$randomIndex]];
    }
}
