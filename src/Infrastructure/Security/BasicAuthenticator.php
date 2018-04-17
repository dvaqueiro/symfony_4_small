<?php
namespace App\Infrastructure\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class BasicAuthenticator extends AbstractGuardAuthenticator
{
    public function supports(Request $request)
    {
        // return $request->headers->has('php-auth-user') && $request->headers->has('php-auth-pw');
        return true;
    }

    public function getCredentials(Request $request)
    {
        return array(
            'username' => $request->headers->get('php-auth-user'),
            'password' => $request->headers->get('php-auth-pw'),
        );
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $email = $credentials['username'];

        if (null === $email) {
            return;
        }

        // if a User object, checkCredentials() is called
        return $userProvider->loadUserByUsername($email);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return md5($credentials['password']) == $user->getPassword();
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // on success, let the request continue
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = array(
            'status' => 0,
            'errors' => [strtr($exception->getMessageKey(), $exception->getMessageData())]
        );

        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }

    /**
     * Called when authentication is needed, but it's not sent
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = array(
            'status' => 0,
            'errors' => ['403: Authentication Required']
        );

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
