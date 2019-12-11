<?php

namespace App\Service;


class ApplicationContext
{
    protected $user;
    protected $quote;

    public function __construct()
    {
        $this->user = RandomContext::getInstance()->getUser();
        $this->quote = RandomContext::getInstance()->getQuote();
        $this->destination = RandomContext::getInstance()->getDestination();
        $this->site = RandomContext::getInstance()->getSite();
    }

    /**
     * @return \App\Entity\User
     */
    public function getUser(): \App\Entity\User
    {
        return $this->user;
    }

    /**
     * @param \App\Entity\User $user
     */
    public function setUser(\App\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * @return \App\Entity\Quote
     */
    public function getQuote(): \App\Entity\Quote
    {
        return $this->quote;
    }

    /**
     * @param \App\Entity\Quote $quote
     */
    public function setQuote(\App\Entity\Quote $quote)
    {
        $this->quote = $quote;
    }

    /**
     * @return \App\Entity\Destination
     */
    public function getDestination(): \App\Entity\Destination
    {
        return $this->destination;
    }

    /**
     * @param \App\Entity\Destination $destination
     */
    public function setDestination(\App\Entity\Destination $destination)
    {
        $this->destination = $destination;
    }

    /**
     * @return \App\Entity\Site
     */
    public function getSite(): \App\Entity\Site
    {
        return $this->site;
    }

    /**
     * @param \App\Entity\Site $site
     */
    public function setSite(\App\Entity\Site $site)
    {
        $this->site = $site;
    }
}