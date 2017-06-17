<?php
/**
 * Created by codesaya
 * Date: 6/16/2017
 * Time: 18:08
 */

namespace PiupiuBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class LoginAuthenticator extends AbstractFormLoginAuthenticator
{
    private $container;
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getCredentials(Request $request)
    {
        if ($request->getPathInfo() != '/login_check') {
            return;
        }

        $username = $request->request->get('_username');
        $request->getSession()->set(Security::LAST_USERNAME, $username);
        $password = $request->request->get('_password');

        return [
            'username' => $username,
            'password' => $password
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $username = $credentials['username'];
        $userRepo = $this->container
            ->get('doctrine')
            ->getManager()
            ->getRepository('AppBundle:User');
        return $userRepo->findByUsernameOrEmail($username);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $plainPassword = $credentials['password'];
        $encoder = $this->container->get('security.password_encoder');
        if (!$encoder->isPasswordValid($user, $plainPassword)) {
            // throw any AuthenticationException
            throw new BadCredentialsException();
        }
    }

    protected function getLoginUrl()
    {
        return $this->container->get('router')
            ->generate('security_login');
    }

    protected function getDefaultSuccessRedirectUrl()
    {
        return $this->container->get('router')
            ->generate('piupiu_homepage');
    }
}