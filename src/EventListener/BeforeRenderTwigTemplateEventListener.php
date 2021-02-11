<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\EventListener;

use HeimrichHannot\TwigSupportBundle\Event\BeforeRenderTwigTemplateEvent;

class BeforeRenderTwigTemplateEventListener
{
    public function __invoke(BeforeRenderTwigTemplateEvent $event)
    {
        $templateData = $event->getTemplateData();
        $templateData['_entity'] = $event->getContaoTemplate();

        $event->setTemplateData($templateData);
    }
}
