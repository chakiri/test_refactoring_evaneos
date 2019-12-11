<?php

namespace App\Manager;

use App\Entity\Template;
use App\Entity\Quote;
use App\Entity\User;
use App\Repository\DestinationRepository;
use App\Repository\SiteRepository;
use App\Service\ApplicationContext;

class TemplateManager extends ApplicationContext
{
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

    //Verification array data if containing information
    private function verifData(array $data){
        if ($data['user'] && $data['user']  instanceof User){
            $this->user = $data['user'];
        }

        if ($data['quote'] && $data['quote'] instanceof Quote) {
            $this->quote = $data['quote'];
            $this->destination = DestinationRepository::getInstance()->getById($this->quote->getDestinationId());
            $this->site = SiteRepository::getInstance()->getById($this->quote->getSiteId());
        }

    }

    //Replace text with data
    private function replacePlaceholder($text, array $data)
    {
        $this->verifData($data);

        if(strpos($text, '[quote:summary_html]') !== false) {
            $text = str_replace('[quote:summary_html]', $this->quote->renderHtml($this->quote), $text);
        }

        if(strpos($text, '[quote:summary]') !== false) {
            $text = str_replace('[quote:summary]', $this->quote->renderText($this->quote), $text);
        }

        if(strpos($text, '[quote:destination_name]') !== false) {
            $text = str_replace('[quote:destination_name]', $this->destination->getCountryName(),$text);
        }

        if(strpos($text, '[quote:destination_link]') !== false) {
            $text = str_replace('[quote:destination_link]', $this->site->getUrl() . '/' . $this->destination->getCountryName() . '/quote/' . $this->quote->getId(), $text);
        }

        //Change info user
        if(strpos($text, '[user:first_name]') !== false) {
            $text = str_replace('[user:first_name]', ucfirst(mb_strtolower($this->user->getFirstName())),$text);
        }

        if(strpos($text, '[user:last_name]') !== false) {
            $text = str_replace('[user:last_name]', ucfirst(mb_strtolower($this->user->getLastName())),$text);
        }

        if(strpos($text, '[user:last_email]') !== false) {
            $text = str_replace('[user:last_email]', ucfirst(mb_strtolower($this->user->getEmail())),$text);
        }

        return $text;
    }

}
