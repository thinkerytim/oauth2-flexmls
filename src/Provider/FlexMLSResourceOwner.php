<?php

namespace ThinkeryTim\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Tool\ArrayAccessorTrait;

class FlexMLSResourceOwner implements ResourceOwnerInterface
{
    use ArrayAccessorTrait;

    /**
     * Raw response
     *
     * @var array
     */
    protected $response;

    /**
     * Creates new resource owner.
     *
     * @param array  $response
     */
    public function __construct(array $response = array())
    {
        $this->response = $response['D']['Results'][0];
    }

    /**
     * Magic method to get any arbitrary key
     * @param string $name
     * @return mixed|null
     */
    public function __get(string $name)
    {
        if (array_key_exists($name, $this->response)) {
            return $this->response[$name];
        }

        return null;
    }

    /**
     * Get resource owner id
     *
     * @return string|null
     */
    public function getId()
    {
        return $this->getValueByKey($this->response, 'Id');
    }

    /**
     * Get resource owner name
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->getValueByKey($this->response, 'Name');
    }

    /**
     * Get resource company name
     *
     * @return string|null
     */
    public function getCompany()
    {
        return $this->getValueByKey($this->response, 'Company');
    }

    /**
     * Get resource active state
     *
     * @return boolean
     */
    public function isActive() : bool
    {
        return $this->getValueByKey($this->response, 'Active');
    }

    /**
     * Get resource owner primary email
     *
     * @return string|null
     */
    public function getPrimaryEmail()
    {
        foreach ($this->response['Emails'] as $email) {
            if ($email['Primary']) {
                return $email['Address'];
            }
        }
        return null;
    }

    /**
     * Return all of the owner details available as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->response;
    }
}
