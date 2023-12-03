<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class BadWordsListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::SUBMIT => 'onFormSubmit',
        ];
    }

    public function onFormSubmit(FormEvent $event)
    {
        $data = $event->getData();

        // Replace bad words in the title
        $title = $data->getTitre();
        $title = $this->replaceBadWords($title);
        $data->setTitre($title);

        // Replace bad words in the fonction
        $fonction = $data->getFonction();
        $fonction = $this->replaceBadWords($fonction);
        $data->setFonction($fonction);

        // Replace bad words in the description
        $description = $data->getDescreption();
        $description = $this->replaceBadWords($description);
        $data->setDescreption($description);
    }

    private function replaceBadWords($text)
    {
        $badWords = ['fuck', 'sex', 'cook','ass-pirate','assbag','assbandit','assbanger','assbite','assclown','asscock','asscracker','asses','assface','assfuck','assfucker','assfukka','assgoblin','asshat','asshead','asshole','assholes','asshopper','assjacker','asslick','asslicker','assmonkey','assmunch','assmuncher','assnigger','asspirate','assshit','assshole','asssucker','asswad','asswhole','asswipe','auto erotic','autoerotic','axwound','b!tch','b00bs','b17ch','b1tch','ball gravy','ball kicking','ball licking','ball sack','ball sucking','ballbag','bitches','bitchin'];
        $text = str_ireplace($badWords, '****', $text);

        return $text;
    }
}
