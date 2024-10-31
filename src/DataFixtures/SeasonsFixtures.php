<?php

namespace App\DataFixtures;

use App\Entity\Seasons;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SeasonsFixtures extends Fixture
{
    public function __construct(private ParameterBagInterface $parameterBag)
    {
    }


    public function load(ObjectManager $manager): void
    {

        $jsonFile = $this->parameterBag->get('kernel.project_dir') . '/public/utils/seasons.json';
        $jsonData = file_get_contents($jsonFile);
        $data = json_decode($jsonData, true);

        if (isset($data)) {
            foreach ($data as $s) {

                $season = new Seasons();
                $season->setYear($s['year']);

                $this->addReference('season__'.$s['year'], $season);
                $manager->persist($season);
            }

        }
        $manager->flush();
    }

}
