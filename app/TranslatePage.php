<?php
require_once __DIR__ . '/GoogleTranslateWrapper.php';
$config = require __DIR__ . '/config.php';

class TranslatePage
{
    private $translator;
    private $targetLang;
    private $cacheDir;
    private $supportedLangs;
    private $skipTranslate = false;

    private $noTranslate = ['Ina Ndao', 'Tenun Ikat', 'Sarung'];

    public function __construct($targetLang = null)
    {
        global $config;

        $this->supportedLangs = $config['supported_languages'];
        $this->cacheDir = $config['cache_dir'];

        if (!is_dir($this->cacheDir)) mkdir($this->cacheDir, 0777, true);

        $targetLang = strtolower($targetLang ?? '');
        if ($targetLang && in_array($targetLang, $this->supportedLangs)) {
            $this->targetLang = $targetLang;
        } else {
            $this->targetLang = $this->detectUserLanguage() ?? $config['default_language'];
        }

        $this->skipTranslate = $this->targetLang === 'id';
        $this->translator = new GoogleTranslateWrapper($this->targetLang);
    }

    private function detectUserLanguage()
    {
        if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) return null;
        $langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        foreach ($langs as $lang) {
            $code = strtolower(substr(trim($lang), 0, 2));
            if (in_array($code, $this->supportedLangs)) return $code;
        }
        return null;
    }

    private function getCacheFile($text)
    {
        return $this->cacheDir . '/' . md5($text . '_' . $this->targetLang) . '.txt';
    }

    private function getFromCache($text)
    {
        $file = $this->getCacheFile($text);
        if (file_exists($file)) return file_get_contents($file);
        return null;
    }

    private function saveToCache($text, $translated)
    {
        $file = $this->getCacheFile($text);
        file_put_contents($file, $translated);
    }

    private function fixSpacing($text)
    {
        $text = preg_replace('/([a-z0-9])([A-Z])/', '$1 $2', $text);
        $text = preg_replace('/([A-Za-z])([A-Z][a-z]+)/', '$1 $2', $text);
        $text = preg_replace('/\s+/', ' ', $text);
        return trim($text);
    }

    public function translateText($text, $forceUpdate = false, $extraNoTranslate = [])
    {
        if ($this->skipTranslate || trim($text) === '') return $text;

        $placeholders = [];

        $allNoTranslate = array_merge($this->noTranslate, $extraNoTranslate);

        foreach ($allNoTranslate as $i => $word) {
            if (stripos($text, $word) !== false) {
                $ph = "__NO_TRANSLATE_{$i}__";
                $text = str_ireplace($word, $ph, $text);
                $placeholders[$ph] = $word;
            }
        }

        $cached = !$forceUpdate ? $this->getFromCache($text) : null;
        if ($cached !== null) {
            foreach ($placeholders as $ph => $word) {
                $cached = str_ireplace($ph, $word, $cached);
            }
            return $cached;
        }

        try {
            $translated = $this->translator->translate($text, $this->targetLang);
        } catch (\Exception $e) {
            $translated = $text;
        }

        foreach ($placeholders as $ph => $word) {
            $translated = str_ireplace($ph, $word, $translated);
        }

        $translated = $this->fixSpacing($translated);

        $this->saveToCache($text, $translated);

        return $translated;
    }

    public function translateHtml($html, $extraNoTranslate = [])
    {
        if ($this->skipTranslate) return $html;

        $allNoTranslate = array_unique(array_merge($this->noTranslate, $extraNoTranslate));
        $placeholderMap = [];
        foreach ($allNoTranslate as $word) {
            if (trim($word) === '') continue;
            $ph = "__NO_TRANSLATE_" . md5($word) . "__";
            $placeholderMap[$ph] = $word;
            $html = preg_replace('/' . preg_quote($word, '/') . '/iu', $ph, $html);
        }

        $phpPlaceholders = [];
        $html = preg_replace_callback('/<\?= .*? \?>/s', function ($m) use (&$phpPlaceholders) {
            $ph = "__PHP_PLACEHOLDER_" . count($phpPlaceholders) . "__";
            $phpPlaceholders[$ph] = $m[0];
            return $ph;
        }, $html);

        $html = preg_replace_callback(
            '/>([^><]+)</s',
            function ($matches) use ($extraNoTranslate) {
                $text = html_entity_decode(trim($matches[1]));
                if ($text === '') return '><';
                $translated = $this->translateText($text, false, $extraNoTranslate);
                return '>' . htmlspecialchars($translated) . '<';
            },
            $html
        );

        foreach ($phpPlaceholders as $ph => $original) {
            $html = str_replace($ph, $original, $html);
        }

        foreach ($placeholderMap as $ph => $orig) {
            $html = str_replace($ph, $orig, $html);
        }

        $html = preg_replace('/([a-zA-Z0-9])(<span)/', '$1 $2', $html);
        $html = preg_replace('/(<\/span>)([a-zA-Z0-9])/', '$1 $2', $html);
        $html = preg_replace('/(?<!\s)><span/', '> <span', $html);
        $html = preg_replace('/<\/span>(?=[^\s<])/', '</span> ', $html);

        return $html;
    }

    public function start()
    {
        ob_start();
    }

    public function translateOutput($extraNoTranslate = [])
    {
        $html = ob_get_clean();
        echo $this->translateHtml($html, $extraNoTranslate);
    }
}
