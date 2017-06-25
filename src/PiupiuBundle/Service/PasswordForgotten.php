<?php
/**
 * Created by codesaya
 * Date: 6/23/2017
 * Time: 21:06
 */

namespace PiupiuBundle\Service;


use PiupiuBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class PasswordForgotten
{
    private $em;
    private $encoder;
    private $container;

    public function __construct(EntityManager $em, UserPasswordEncoder $encoder, ContainerInterface $container) {
        $this->em           = $em;
        $this->encoder      = $encoder;
        $this->container    = $container;
    }

    public function generateNewPassword(User $user) {
        try {
            $plainpwd = time();
            $password = $this->encoder->encodePassword($user, $plainpwd);
            $user->setPassword($password);
            $user->setFirstLogin(True);
            $this->em->persist($user);
            $this->em->flush();
            return $plainpwd;
        } catch (Exception $e) {
            return False;
        }
    }

    public function sendNewPwdMail(User $user, $plainpwd) {
        $translator = $this->container->get('translator');
        $subject = $translator->trans('Your temporary password');
        $message = \Swift_Message::newInstance();
        $message
            ->setSubject($subject)
            ->setFrom('admin@piupiu.com')
            ->setTo($user->getEmail())
            ->setBody($this->container->get('templating')->render('PiupiuBundle:Mail:pwd_forgotten.html.twig',[
                'pwd'         => $plainpwd,
            ]), 'text/html');

        $this->container->get('mailer')->send($message);
    }

}