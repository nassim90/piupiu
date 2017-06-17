<?php
/**
 * Created by codesaya
 * Date: 6/17/2017
 * Time: 16:09
 */

namespace PiupiuBundle\EventListener;

use PiupiuBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class LastLoginSubscriber implements EventSubscriberInterface
{

    private $em;
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function onInteractiveLogin(InteractiveLoginEvent $event)
    {
        /** @var User $user */
        $user = $event->getAuthenticationToken()->getUser();
        $user->setLastLoginTime(new \DateTime());
        $this->em->persist($user);
        $this->em->flush($user);
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents() {
        return array(SecurityEvents::INTERACTIVE_LOGIN => 'onInteractiveLogin');
    }
}