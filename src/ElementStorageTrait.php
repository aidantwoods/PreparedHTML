<?php
declare(strict_types=1);

namespace Aidantwoods\PreparedHTML;

use SplFixedArray;

trait ElementStorageTrait
{
    protected $FixedArray;

    public function addElement(BaseElement $Element) : Element
    {
        $initSize = $this->FixedArray->getSize();

        $this->FixedArray->setSize($initSize + 1);

        $this->FixedArray[$initSize] = clone($Element);

        return $this;
    }

    public function removeElement(BaseElement $Element) : Element
    {
        foreach ($this as $key => $E)
        {
            if ($Element == $E)
            {
                $this->removeAndCloseGap($key);
            }
        }

        return $this;
    }

    public function current() : BaseElement
    {
        return $this->FixedArray->current();
    }

    public function key() : int
    {
        return $this->FixedArray->key();
    }

    public function next()
    {
        $this->FixedArray->next();
    }

    public function rewind()
    {
        $this->FixedArray->rewind();
    }

    public function valid() : bool
    {
        return $this->FixedArray->valid();
    }

    public function count() : int
    {
        return $this->FixedArray->count();
    }

    private function removeAndCloseGap(int $n)
    {
        $newSize = $this->FixedArray->getSize() - 1;

        if ($newSize < 0)
        {
            throw new \UnexpectedValueException(
                'Cannot reduce size to below zero'
            );
        }
        elseif ($n < 0)
        {
            throw new \UnexpectedValueException(
                'Cannot unset item with key below zero'
            );
        }

        unset($this->FixedArray[$n]);

        # if we are not the last item, need to close a gap
        if ($n < $newSize)
        {
            for ($i = $n; $i < $newSize + 1; $i++)
            {
                $this->FixedArray[$i] = $this->FixedArray[$i + 1];
            }
        }

        $this->FixedArray->setSize($newSize);
    }
}
