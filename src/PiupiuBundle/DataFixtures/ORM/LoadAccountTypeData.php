<?php
/**
 * Created by codesaya
 */

namespace DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use PiupiuBundle\Entity\AccountType;
use Doctrine\Common\Persistence\ObjectManager;

class LoadAccountTypeData  extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager) {
        // load admin account type
        $admin = new AccountType();
        $admin->setDesignation('admin');

        // load 'naturaliste' account type
        $naturaliste = new AccountType();
        $naturaliste->setDesignation('naturaliste');

        // load 'particulier' account type
        $particulier = new AccountType();
        $particulier->setDesignation('particulier');

        $manager->persist($admin);
        $manager->persist($naturaliste);
        $manager->persist($particulier);
        $manager->flush();

        $this->addReference('admin', $admin);
        $this->addReference('naturaliste', $naturaliste);
        $this->addReference('particulier', $particulier);
    }


    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder() {
        return 1;
    }
}