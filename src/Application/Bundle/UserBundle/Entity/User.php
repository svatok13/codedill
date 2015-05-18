<?php
/*
 * This file is part of the Codedill project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Bundle\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="Application\Bundle\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $githubId Github user ID
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $githubId;

    /**
     * @var string $bitbucketId Bitbucket user ID
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $bitbucketId;

    /**
     * Get ID
     *
     * @return int ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get Github user ID
     *
     * @return string Github user ID
     */
    public function getGithubId()
    {
        return $this->githubId;
    }

    /**
     * Set Github user ID
     *
     * @param string $githubId Github user ID
     */
    public function setGithubId($githubId)
    {
        $this->githubId = $githubId;
    }

    /**
     * Get bitbucketId
     *
     * @return string BitbucketId
     */
    public function getBitbucketId()
    {
        return $this->bitbucketId;
    }

    /**
     * Set bitbucketId
     *
     * @param string $bitbucketId bitbucketId
     *
     * @return $this
     */
    public function setBitbucketId($bitbucketId)
    {
        $this->bitbucketId = $bitbucketId;

        return $this;
    }

}
