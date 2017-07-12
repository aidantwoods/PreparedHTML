<?php
declare(strict_types=1);

namespace Aidantwoods\PreparedHTML;

use ArrayAccess;
use Aidantwoods\PreparedHTML\Sanitisation\Sanitiser;

class BaseElement implements ArrayAccess
{
    use AttributesTrait;

    protected $name;
    protected $Sanitiser;
    protected $contents;

    public function __construct(?string $name = null, ?string $contents = null)
    {
        $this->name      = $name;
        $this->contents  = $contents;
        $this->Sanitiser = new Sanitiser;
    }

    public function offsetExists($offset) : bool
    {
        return $this->hasAttribute($offset);
    }

    public function offsetGet($offset) : string
    {
        return $this->getAttribute($offset);
    }

    public function offsetSet($offset, $value) : void
    {
        $this->setAttribute($offset, $value);
    }

    public function offsetUnset($offset) : void
    {
        $this->unsetAttribute($offset);
    }

    public function setEncoding(?string $encoding = null) : void
    {
        $this->Sanitiser->setEncoding($encoding);
    }

    public function getHtml() : string
    {
        $E = $this->Sanitiser;

        $elementName = ! empty($this->name) ?
            $E->htmlElementName($this->name) : null;

        $html = '';

        $contents = $this->getContents();

        if (isset($elementName))
        {
            $html .= "<$elementName";

            if ( ! empty($this->attributes))
            {
                foreach($this->attributes as $name => $value)
                {
                    $name = $E->htmlAttributeName($name);

                    if (empty($name))
                    {
                        continue;
                    }

                    $value = isset($value) ?
                        $E->htmlAttributeValue($value) : null;

                    $html .= " $name".(isset($value) ? "='$value'" : '');
                }
            }

            if (empty($contents))
            {
                $html .= ' />';

                return $html;
            }
            else
            {
                $html .= '>';
            }
        }

        $html .= $contents;

        if (isset($elementName))
        {
            $html .= "</$elementName>";
        }

        return $html;
    }

    public function __toString() : string
    {
        return $this->getHtml();
    }

    protected function getContents() : string
    {
        return $this->Sanitiser->htmlElementValue($this->contents);
    }
}
