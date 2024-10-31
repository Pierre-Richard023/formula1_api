<?php

namespace App\DataFixtures;

use App\Entity\Sessions;
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
                ->setRace($this->getReference('races__' . $entries->id));
            $this->addReference('sessions__r__' . $entries->id, $session);
            $manager->persist($session);


        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            RacesFixtures::class,
        ];
    }
}
