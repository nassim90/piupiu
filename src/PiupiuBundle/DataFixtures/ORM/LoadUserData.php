<?php
/**
 * Created by codesaya
 * Date: 6/17/2017
 * Time: 16:22
 */

namespace DataFixtures\ORM;

use PiupiuBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        $userAdmin->setAccountType($this->getReference('admin'));

        $userPro = new User();
        $userPro->setUsername('raven');
        $password = $encoder->encodePassword($userPro, 'eapoe');
        $userPro->setPassword($password);
        $userPro->setPrename('Dark');
        $userPro->setSurname('Bird');
        $userPro->setEmail('dark@bird.com');
        $userPro->setAccountType($this->getReference('naturaliste'));

        $userPart = new User();
        $userPart->setUsername('nobody');
        $password = $encoder->encodePassword($userPart, 'isperfect');
        $userPart->setPassword($password);
        $userPart->setPrename('Mr');
        $userPart->setSurname('Perfect');
        $userPart->setEmail('nobody@perfect.com');
        $userPart->setAccountType($this->getReference('particulier'));

        $manager->persist($userAdmin);
        $manager->persist($userPro);
        $manager->persist($userPart);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder() {
        return 2;
    }
}