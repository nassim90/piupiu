<?php
/**
 * Created by codesaya
 * Date: 6/16/2017
 * Time: 18:08
 */

namespace PiupiuBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class LoginAuthenticator extends AbstractFormLoginAuthenticator
{
    private $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     * @return string
     */
    protected function getLoginUrl() {
        return $this->container->get('router')
            ->generate('security_login');
    }

    /**
     * {@inheritdoc}
     * @param Request $request
     *
     * @return mixed|null
     */
    public function getCredentials(Request $request) {
        if ($request->getPathInfo() != '/login' || !$request->isMethod('POST')) {
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

    /**
     * {@inheritdoc}
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     *
     * @throws AuthenticationException
     *
     * @return UserInterface|null
     */
    public function getUser($credentials, UserProviderInterface $userProvider) {
        $username = $credentials['username'];
        /*$userRepo = $this->container
            ->get('doctrine')
            ->getManager()
            ->getRepository('PiupiuBundle:User');
        return $userRepo->findByUsernameOrEmail($username);*/
        return $userProvider->loadUserByUsername($username);
    }

    /**
     * {@inheritdoc}
     * @param mixed $credentials
     * @param UserInterface $user
     *
     * @return bool
     *
     * @throws AuthenticationException
     */
    public function checkCredentials($credentials, UserInterface $user) {
        $plainPassword = $credentials['password'];
        $encoder = $this->container->get('security.password_encoder');
        if (!$encoder->isPasswordValid($user, $plainPassword)) {
            throw new BadCredentialsException();
        }
        return TRUE;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultSuccessRedirectUrl() {
        return $this->container->get('router')
            ->generate('piupiu_homepage');
    }
}
