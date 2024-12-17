<?php

namespace App\DataFixtures;

use App\Entity\Races;
use App\Entity\Sessions;
use App\Entity\Standings;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JsonMachine\Items;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SessionsRacesFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private ParameterBagInterface $parameterBag)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $jsonFile = $this->parameterBag->get('kernel.project_dir') . '/public/utils/races.json';
        $data = Items::fromFile($jsonFile);

        foreach ($data as $entries) {
            $session = new Sessions();
            $session->setName("race")
                ->setRace($this->getReference('races__' . $entries->id,Races::class));
            $standings = new Standings();
            $this->addReference('standings__r__' . $entries->id, $standings);
            $session->setStanding($standings);
            $manager->persist($standings);
            $manager->persist($session);
        }

        $manager->flush();
        $manager->clear();
        unset($data);
    }

    public function getDependencies(): array
    {
        return [
            RacesFixtures::class,
        ];
    }
}
