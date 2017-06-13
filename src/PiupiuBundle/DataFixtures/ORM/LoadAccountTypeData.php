<?php
/**
 * Created by codesaya
 */

namespace DataFixtures\ORM;

use PiupiuBundle\Entity\AccountType;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

class LoadAccountTypeData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
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
    }
}