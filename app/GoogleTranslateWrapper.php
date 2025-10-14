<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Stichoza\GoogleTranslate\GoogleTranslate;

class GoogleTranslateWrapper
{
    private $tr;

    public function __construct($target = 'en')
    {
        $this->tr = new GoogleTranslate($target);
    }

    public function translate($text, $target = null)
    {
        try {
            if ($target) $this->tr->setTarget($target);

            $translated = $this->tr->translate($text);

            echo "<!-- Translating: {$text} -->";
            echo "<!-- Translated: {$translated} -->";

            return $translated;
        } catch (\Exception $e) {
            echo "<pre>GoogleTranslate Exception: " . $e->getMessage() . "</pre>";
            return $text;
        }
    }
}
