<?php
declare(strict_types=1);

namespace Aidantwoods\PreparedHTML;

trait AttributesTrait
{
    private $attributes;

    public function hasAttribute(?string $name) : bool
    {
        return array_key_exists($name, $this->attributes);
    }

    public function getAttribute(string $name) : string
    {
        return $this->attributes[$name];
    }

    public function setAttribute(string $name, ?string $value) : void
    {
        $this->attributes[$name] = $value;
    }

    public function unsetAttribute(string $name) : void
    {
        unset($this->attributes[$name]);
    }
}
