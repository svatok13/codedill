<?php
/*
 * This file is part of the Codedill project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Bundle\UserBundle\Security\Provider;

use Application\Bundle\UserBundle\Entity\User;
use FOS\UserBundle\Model\UserManagerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\OAuth\ResourceOwner\GitHubResourceOwner;
use HWI\Bundle\OAuthBundle\OAuth\ResourceOwner\BitbucketResourceOwner;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseProvider;
/**
 * Class AuthProvider
 */
class AuthProvider extends BaseProvider
{
    /**
     * @var array $adminGitHubIds Admin GitHub IDs
     */
    private $adminGitHubIds = [
        424723,  // Valera
        815865,  // Artem
        1199467, // Zhenya
        1430407, // Misha
        1486415, // Timur
        2345473, // Vadim
        5329546, // Sasha
    ];

    /**
     * @var array $adminBitBucketIds Admin BitBucket IDs
     */
    private $adminBitBucketIds = [];

    /**
     * @var UserManagerInterface
     */
    protected $userManager;

    /**
     * Constructor
     *
     * @param UserManagerInterface $userManager
     */
    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $user = null;

        $resourceOwner = $response->getResourceOwner();
        if ($resourceOwner instanceof GitHubResourceOwner) {
            $user = $this->userManager->findUserBy(['githubId' => $response->getUsername()]);
        } elseif ($resourceOwner instanceof BitbucketResourceOwner) {
            $user = $this->userManager->findUserBy(['bitbucketId' => $response->getUsername()]);
        }

        if ($user instanceof User) {
            return $user;
        }

        // Try to create user
        if ($resourceOwner instanceof GitHubResourceOwner) {
            $user = $this->createUserFromGitHubResponse($response);
        } elseif ($resourceOwner instanceof BitbucketResourceOwner) {
            $user = $this->createUserFromBitBucketResponse($response);
        }

        return $user;
    }

    /**
     * Create user from Github response
     *
     * @param UserResponseInterface $response
     *
     * @return User
     */
    private function createUserFromGitHubResponse(UserResponseInterface $response)
    {
        $email = $response->getEmail() ?: $response->getUsername() . '@example.com';

        /** @var User $user */
        $user = $this->userManager->findUserByEmail($response->getEmail());
        if ($user instanceof User) {
            $user->setGithubId($response->getUsername());
        } else {
            $user = $this->userManager->createUser();
            $user->setEmail($email);
            $user->setUsername($email);
            $user->setEnabled(true);
            $user->setPlainPassword(uniqid());
            $user->setGithubId($response->getUsername());
        }
        // Move to separate listener
        if (in_array($response->getUsername(), $this->adminGitHubIds)) {
            $user->addRole('ROLE_ADMIN');
        }

        $this->userManager->updateUser($user);

        return $user;
    }

    /**
     * Create user from Bitbucket response
     *
     * @param UserResponseInterface $response
     *
     * @return User
     */
    private function createUserFromBitBucketResponse(UserResponseInterface $response)
    {
        $email = $response->getEmail() ?: $response->getUsername() . '@bitbucket.com';

        /** @var User $user */
        $user = $this->userManager->findUserByEmail($response->getEmail());
        if ($user instanceof User) {
            $user->setBitbucketId($response->getUsername());
        } else {
            $user = $this->userManager->createUser();
            $user->setEmail($email);
            $user->setUsername($email);
            $user->setEnabled(true);
            $user->setPlainPassword(uniqid());
            $user->setBitbucketId($response->getUsername());
        }
        // Move to separate listener
        if (in_array($response->getUsername(), $this->adminBitBucketIds)) {
            $user->addRole('ROLE_ADMIN');
        }

        $this->userManager->updateUser($user);

        return $user;
    }
}
