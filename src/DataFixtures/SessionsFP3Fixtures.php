<?php

namespace App\DataFixtures;

use App\Entity\Sessions;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use JsonMachine\Items;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SessionsFP3Fixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private ParameterBagInterface $parameterBag)
    {
    }

    public function load(ObjectManager $manager): void
    {

        $jsonFile = $this->parameterBag->get('kernel.project_dir') . '/public/utils/standingsFP3.json';
        $data = Items::fromFile($jsonFile);

        foreach ($data as $k => $entries) {
            if ($k === 'free-practice-3') {
                foreach ($entries as $entry) {
                    $session = new Sessions();
                    $session->setName("free-practice-3")
                        ->setRace($this->getReference('races__' . $entry->raceId));
                    $this->addReference('sessions__fp3__' . $entry->raceId, $session);
                    $manager->persist($session);
                }
            }
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
