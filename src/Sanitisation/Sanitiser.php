<?php
declare(strict_types=1);

namespace Aidantwoods\PreparedHTML\Sanitisation;

class Sanitiser
{
    protected $Escaper;

    public function __construct(string $encoding = null)
    {
        $this->Escaper = new Escaper;

        $this->setEncoding($encoding);
    }

    public function htmlAttributeName(string $text) : string
    {
        return CharacterFilter::htmlAttributeName($text);
    }

    public function htmlAttributeValue(string $text) : string
    {
        return $this->Escaper->htmlAttributeValue($text);
    }

    public function htmlElementName(string $text) : string
    {
        return CharacterFilter::htmlElementName($text);
    }

    public function htmlElementValue(string $text) : string
    {
        return $this->Escaper->htmlElementValue($text);
    }

    public function setEncoding(string $encoding = null)
    {
        $this->Escaper->setEncoding($encoding);
    }
}
