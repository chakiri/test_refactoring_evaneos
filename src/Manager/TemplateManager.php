<?php

namespace App\Manager;

use App\Entity\Template;
use App\Entity\Quote;
use App\Entity\User;
use App\Repository\DestinationRepository;
use App\Repository\SiteRepository;
use App\Service\RandomContext;

class TemplateManager
{
    private $randomContext;

    public function __construct(){
        $this->randomContext = new RandomContext();
    }

    //Replace template by data information
    public function getTemplateComputed(Template $template, array $data)
    {
        if ($template) {
            $template->setSubject($this->replacePlaceholder($template->getSubject(), $data));
            $template->setContent($this->replacePlaceholder($template->getContent(), $data));

            return $template;
        }

        throw new \RuntimeException('no template given');
    }

    //Replace text with data
    private function replacePlaceholder($text, array $data)
    {
        //Get User
        $user = $this->getUser($data);

        //Get Quote
        $quote = $this->getQuote($data);

        //Get destination
        $destination = $this->getDestination($quote);

        //Get site
        $site = $this->getSite($quote);

        if(strpos($text, '[quote:summary_html]') !== false) {
            $text = str_replace('[quote:summary_html]', $quote->renderHtml($quote), $text);
        }

        if(strpos($text, '[quote:summary]') !== false) {
            $text = str_replace('[quote:summary]', $quote->renderText($quote), $text);
        }

        if(strpos($text, '[quote:destination_name]') !== false) {
            $text = str_replace('[quote:destination_name]', $destination->getCountryName(),$text);
        }

        if(strpos($text, '[quote:destination_link]') !== false) {
            $text = str_replace('[quote:destination_link]', $site->getUrl() . '/' . $destination->getCountryName() . '/quote/' . $quote->getId(), $text);
        }

        //Change info user
        if(strpos($text, '[user:first_name]') !== false) {
            $text = str_replace('[user:first_name]', ucfirst(mb_strtolower($user->getFirstName())),$text);
        }

        if(strpos($text, '[user:last_name]') !== false) {
            $text = str_replace('[user:last_name]', ucfirst(mb_strtolower($user->getLastName())),$text);
        }

        if(strpos($text, '[user:last_email]') !== false) {
            $text = str_replace('[user:last_email]', ucfirst(mb_strtolower($user->getEmail())),$text);
        }

        return $text;
    }

    private function getUser(array $data)
    {
        if (isset($data['user']) && $data['user']  instanceof User){
            return $user = $data['user'];
        }
        return $user = $this->randomContext->getCurrentUser();
    }

    private function getQuote(array $data)
    {
        if (isset($data['quote']) && $data['quote'] instanceof Quote) {
            $quote = $data['quote'];
        }
        return $quote = $this->randomContext->getCurrentQuote();
    }

    private function getDestination($quote)
    {
        $destinationRepository = new DestinationRepository();
        $destination = $destinationRepository->getById($quote->getDestinationId());
        if (!$destination){
            return $destination = $this->randomContext->getCurrentDestination();
        }
        return $destination;
    }

    private function getSite($quote){
        $siteRepository = new SiteRepository();
        $site = $siteRepository->getById($quote->getSiteId());
        if (!$site){
            return $site = $this->randomContext->getCurrentSite();
        }
        return $site;
    }
}
