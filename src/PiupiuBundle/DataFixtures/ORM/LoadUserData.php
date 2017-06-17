<?php
/**
 * Created by codesaya
 * Date: 6/17/2017
 * Time: 16:22
 */

namespace DataFixtures\ORM;

use PiupiuBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    private $container;
    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = NULL) {
        $this->container = $container;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager) {
        $encoder = $this->container->get('security.password_encoder');
        $userAdmin = new User();
        $userAdmin->setUsername('piupiu');
        $password = $encoder->encodePassword($userAdmin, '123456');
        $userAdmin->setPassword($password);
        $userAdmin->setPrename('Piu');
        $userAdmin->setSurname('Piu');
        $userAdmin->setEmail('piu@piu.com');

        $manager->persist($userAdmin);
        $manager->flush();
    }


}