<?php

/*
 * Copyright (c) 2020 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

$GLOBALS['TL_HOOKS']['getAttributesFromDca']['twig-templates'] = [\HeimrichHannot\TwigTemplatesBundle\EventListener\GetAttributesFromDcaListener::class, '__invoke'];
