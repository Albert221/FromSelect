<?php

namespace FromSelect\Twig;

use Kadet\Highlighter\KeyLighter;
use Kadet\Highlighter\Language\Language;
use Twig_Extension;

class KeyLighterExtension extends Twig_Extension
{
    /**
     * @var KeyLighter
     */
    private $keyLighter;

    public function __construct()
    {
        $this->keyLighter = new KeyLighter();
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('highlight', [$this, 'highlight'])
        ];
    }

    public function highlight($source, $language)
    {
        $language = Language::byName($language);

        // Delete trailing white space and remove more than one of them.
        $source = trim(preg_replace('/\s+/', ' ', $source));

        return $this->keyLighter->highlight($source, $language);
    }
}
