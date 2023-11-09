<?php

namespace App\DataFixtures;

use App\Entity\Color;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ColorFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $defaultColors = ['red', 'white', 'blue', 'black'];

        foreach ($defaultColors as $c) {
            $color = new Color();
            $color->setName($c);

            $manager->persist($color);
        }       

        $manager->flush();
    }    
}
