<?php

namespace CyberWorks\Extension;

use Illuminate\Translation\Translator;

class TranslationExtension extends \Twig_Extension
{
    /**
     * @var Translator
     */
    private $translator;

    public function __construct(Translator $translator) {
        $this->translator = $translator;
    }

    public function getName() {
        return 'slim_translator';
    }

    public function getFunctions() {
        return [
            new \Twig_SimpleFunction('translate', array($this->translator, 'trans')),
            new \Twig_SimpleFunction('trans', array($this->translator, 'trans')),
        ];
    }
}