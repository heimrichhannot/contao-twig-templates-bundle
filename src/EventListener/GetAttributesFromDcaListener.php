<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\EventListener;

use Contao\Config;
use HeimrichHannot\UtilsBundle\Container\ContainerUtil;
use HeimrichHannot\UtilsBundle\Date\DateUtil;
use Symfony\Component\Translation\TranslatorInterface;

class GetAttributesFromDcaListener
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var DateUtil
     */
    private $dateUtil;
    /**
     * @var ContainerUtil
     */
    private $containerUtil;

    /**
     * RenderListener constructor.
     */
    public function __construct(TranslatorInterface $translator, DateUtil $dateUtil, ContainerUtil $containerUtil)
    {
        $this->translator = $translator;
        $this->dateUtil = $dateUtil;
        $this->containerUtil = $containerUtil;
    }

    public function __invoke(array $attributes, $dc = null): array
    {
        if ($this->containerUtil->isBackend()) {
            return $attributes;
        }

        // add format placeholder for accessibility reasons
        if ('text' === $attributes['type'] && isset($attributes['rgxp']) && \in_array($attributes['rgxp'], ['datim', 'date', 'time'])) {
            $attributes['placeholder'] = $this->translator->trans('huh.twig.templates.placeholder.'.$attributes['rgxp'], [
                '{format}' => $this->dateUtil->transformPhpDateFormatToISO8601(Config::get($attributes['rgxp'].'Format')),
            ]);
        }

        return $attributes;
    }
}
