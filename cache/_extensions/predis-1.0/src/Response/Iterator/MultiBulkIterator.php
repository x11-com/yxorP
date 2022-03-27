<?php /* yxorP */


namespace Predis\Response\Iterator;

use Countable;
use Iterator;
use Predis\Response\ResponseInterface;


abstract class MultiBulkIterator implements Iterator, Countable, ResponseInterface
{
    protected $current;
    protected $position;
    protected $size;


    public function rewind()
    {
        // NOOP
    }


    public function current()
    {
        return $this->current;
    }


    public function key()
    {
        return $this->position;
    }


    public function next()
    {
        if (++$this->position < $this->size) {
            $this->current = $this->getValue();
        }
    }

    abstract protected function getValue();

    public function valid(): bool
    {
        return $this->position < $this->size;
    }

    public function count(): int
    {
        return $this->size;
    }

    public function getPosition()
    {
        return $this->position;
    }
}