<?php

namespace App\DataFixtures;

use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CountryFixtures extends Fixture
{

    public function __construct(private ParameterBagInterface $parameterBag)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $jsonFile = $this->parameterBag->get('kernel.project_dir') . '/public/utils/country.json';
        $jsonData = file_get_contents($jsonFile);
        $data = json_decode($jsonData, true);
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);

        if (isset($data)) {
            foreach ($data as $c) {
                $country = new Country();
                $country
                    ->setCountryId($c['id'])
                    ->setName($c['name'])
                    ->setContinent($c['continent'])
                    ->setContinentCode($c['continent_code']);

                if ($c['demonym'] !== null)
                    $country->setDemonym($c['demonym']);


                $this->addReference('country__' . $c['id'], $country);
                $manager->persist($country);
            }
        }


        $manager->flush();
        $manager->clear();
        unset($data);
    }
}
