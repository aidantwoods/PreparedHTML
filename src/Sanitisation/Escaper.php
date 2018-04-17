<?php
declare(strict_types=1);

namespace Aidantwoods\PreparedHTML\Sanitisation;

class Escaper
{
    protected $encoding;

    public function __construct(string $encoding = null)
    {
        $this->setEncoding($encoding);
    }

    public function htmlAttributeValue(string $text) : string
    {
        return static::escape($text);
    }

    public function htmlElementValue(string $text) : string
    {
        return static::escape($text, true);
    }

    public function setEncoding(string $encoding = null)
    {
        $this->encoding = $encoding ?? 'UTF-8';
    }

    protected function escape(string $text, bool $allowQuotes = false) : string
    {
        return htmlentities(
            $text,
            $allowQuotes ? ENT_NOQUOTES : ENT_QUOTES,
            $this->encoding
        );
    }
}
