<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\Color;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CarFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $car = new Car();
        $car->setMake('Honda');
        $car->setModel('Prius');
        $car->setBuildDate(new DateTime('2020-03-25T00:00:00-07:00'));
 
        $color = $manager->getRepository(Color::class)->findOneBy(['name' => 'red']);
        $car->setColor($color);

        $manager->persist($car);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ColorFixture::class
        ];
    }
}
