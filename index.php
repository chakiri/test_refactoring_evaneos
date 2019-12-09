<?php

require 'vendor/autoload.php';

use App\Entity\Template;
use App\Manager\TemplateManager;
use App\Service\RandomContext;

$faker = \Faker\Factory::create();

$template = new Template(
    1,
    'Votre voyage avec une agence locale [quote:destination_name]',
    "
Bonjour Mr [user:last_name] [user:first_name],

Merci d'avoir contacté un agent local pour votre voyage [quote:destination_name].

Site de reservation : [quote:destination_link]

Bien cordialement,

L'équipe Evaneos.com
www.evaneos.com
");
$templateManager = new TemplateManager();

$randomContext = new RandomContext();

$message = $templateManager->getTemplateComputed(
    $template,
    [
        'quote' => $randomContext->getCurrentQuote()
    ]
);

echo $message->getSubject() . "\n" . $message->getContent();
