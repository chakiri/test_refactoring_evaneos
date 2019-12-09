<?php

namespace App\Manager;

use App\Entity\Template;
use App\Entity\Quote;
use App\Entity\User;
use App\Repository\DestinationRepository;
use App\Repository\QuoteRepository;
use App\Repository\SiteRepository;
use App\Service\RandomContext;

class TemplateManager
{
    private $quoteRepository;
    private $destinationRepository;
    private $siteRepository;

    public function __construct(){
        $this->quoteRepository = new QuoteRepository();
        $this->destinationRepository = new DestinationRepository();
        $this->siteRepository = new SiteRepository();
    }

    //Replace template by data information
    public function getTemplateComputed(Template $template, array $data)
    {
        if ($template) {
            $template->setSubject($this->replaceText($template->getSubject(), $data));
            $template->setContent($this->replaceText($template->getContent(), $data));

            return $template;
        }

        throw new \RuntimeException('no template given');
    }

    //Replace text with data
    private function replaceText($text, array $data)
    {
        //Verify contains text
        $textContainsSummaryHtml = strpos($text, '[quote:summary_html]');
        $textContainsSummary     = strpos($text, '[quote:summary]');
        $textContainDestinationLink = strpos($text, '[quote:destination_link]');
        $textContainDestinationName = strpos($text, '[quote:destination_name]');
        $textContainUserFirstName = strpos($text, '[user:first_name]');
        $textContainUserLastName = strpos($text, '[user:last_name]');
        $textContainUserEmail = strpos($text, '[user:last_email]');

        $randomContext = new RandomContext();

        //Get user
        if (isset($data['user']) && $data['user']  instanceof User){
            $user = $data['user'];
        }else{
            $user = $randomContext->getCurrentUser();
        }

        //Get Quote
        if (isset($data['quote']) && $data['quote'] instanceof Quote) {
            $quote = $data['quote'];
        }else{
            $quote = $randomContext->getCurrentQuote();
        }

        //Get destination
        $destination = $this->destinationRepository->getById($quote->getDestinationId());
        if (!$destination){
            $destination = $randomContext->getCurrentDestination();
        }

        //Get site
        $site = $this->siteRepository->getById($quote->getSiteId());
        if (!$site){
            $site = $randomContext->getCurrentSite();
        }

        if($textContainsSummaryHtml !== false) {
            $text = str_replace('[quote:summary_html]', $quote->renderHtml($quote), $text);
        }

        if($textContainsSummary !== false) {
            $text = str_replace('[quote:summary]', $quote->renderText($quote), $text);
        }

        if($textContainDestinationName !== false) {
            $text = str_replace('[quote:destination_name]', $destination->getCountryName(),$text);
        }

        if($textContainDestinationLink !== false) {
            $text = str_replace('[quote:destination_link]', $site->getUrl() . '/' . $destination->getCountryName() . '/quote/' . $quote->getId(), $text);
        }

        //Change info user
        if($textContainUserFirstName !== false) {
            $text = str_replace('[user:first_name]', ucfirst(mb_strtolower($user->getFirstName())),$text);
        }

        if($textContainUserLastName !== false) {
            $text = str_replace('[user:last_name]', ucfirst(mb_strtolower($user->getLastName())),$text);
        }

        if($textContainUserEmail !== false) {
            $text = str_replace('[user:last_email]', ucfirst(mb_strtolower($user->getEmail())),$text);
        }

        return $text;
    }
}
