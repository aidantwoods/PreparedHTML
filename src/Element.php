<?php
declare(strict_types=1);

namespace Aidantwoods\PreparedHTML;

use ArrayAccess;
use Countable;
use Iterator;
use SplFixedArray;

class Element extends BaseElement implements ArrayAccess, Countable, Iterator
{
    use ElementStorageTrait;

    public function __construct(?string $name = null, ?string $contents = null)
    {
        parent::__construct($name);

        $this->FixedArray = new SplFixedArray;

        if (isset($contents))
        {
            $this->addElement(new BaseElement(null, $contents));
        }
    }

    protected function getContents() : string
    {
        $html = '';

        foreach ($this as $Element)
        {
            $html .= $Element->getHtml();
        }

        return $html;
    }
}
