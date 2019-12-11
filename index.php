<?php

require 'vendor/autoload.php';

use App\Entity\Template;
use App\Manager\TemplateManager;
use App\Service\RandomContext;

$subject = 'Votre voyage avec une agence locale [quote:destination_name]';
$content = "
Bonjour Mr [user:last_name] [user:first_name],
    
Merci d'avoir contacté un agent local pour votre voyage au [quote:destination_name].

Site de reservation : [quote:destination_link]

Bien cordialement,

L'équipe Evaneos.com

www.evaneos.com
";

$template = new Template(1, $subject, $content);
$templateManager = new TemplateManager();

$message = $templateManager->getTemplateComputed($template, [
        'quote' => RandomContext::getInstance()->getQuote(),
        'user' => RandomContext::getInstance()->getUser()
    ]);

echo $message->getSubject() . "\n" . $message->getContent();
