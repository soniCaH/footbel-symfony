<?php

namespace KevinVR\FootbalistoBackendBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $apiKey;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->apiKey = $this->generateKey($this->getUsername(), $this->getSalt());
    }

    /**
     * Get the API key for the user.
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Generate unique md5 hash based on username, timestamp and salt.
     *
     * @param string $username
     * @param string $salt
     * @return string
     */
    private function generateKey($username, $salt)
    {
        return md5($username . $salt . time());
    }
}