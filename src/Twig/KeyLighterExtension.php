<?php

namespace FromSelect\Twig;

use Kadet\Highlighter\KeyLighter;
use Kadet\Highlighter\Language\Language;
use Twig_Extension;
use Twig_SimpleFilter;

class KeyLighterExtension extends Twig_Extension
{
    /**
     * @var KeyLighter
     */
    private $keyLighter;

    /**
     * KeyLighterExtension constructor.
     */
    public function __construct()
    {
        $this->keyLighter = new KeyLighter();
    }

    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return Twig_SimpleFilter[]
     */
    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('highlight', [$this, 'highlight'])
        ];
    }

    /**
     * Returns text highlighted based on specified language.
     *
     * @param string $source
     * @param string $language
     * @return string
     */
    public function highlight($source, $language)
    {
        $language = Language::byName($language);

        // Delete trailing white space and remove more than one of them.
        $source = trim(preg_replace('/\s+/', ' ', $source));

        return $this->keyLighter->highlight($source, $language);
    }
}
