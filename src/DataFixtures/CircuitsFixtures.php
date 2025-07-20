<?php

namespace App\DataFixtures;

use App\Entity\Circuits;
use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CircuitsFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private ParameterBagInterface $parameterBag)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $jsonFile = $this->parameterBag->get('kernel.project_dir') . '/public/utils/circuits.json';
        $jsonData = file_get_contents($jsonFile);
        $data = json_decode($jsonData, true);
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);

        if (isset($data)) {
            foreach ($data as $c) {
                $circuit=new Circuits();
                $circuit->setName($c['fullName'])
                    ->setCircuitsId($c['id'])
                    ->setShortName($c['name'])
                    ->setType($c['type'])
                    ->setLocation($c['placeName'])
                    ->setCountry($this->getReference('country__'. $c["countryId"],Country::class))
                ;
                $this->addReference('circuit__'.$c['id'], $circuit);
                $manager->persist($circuit);
            }
        }

        $manager->flush();
        $manager->clear();
        unset($data);
    }

    public function getDependencies(): array
    {
        return [
            CountryFixtures::class,
        ];
    }
}
