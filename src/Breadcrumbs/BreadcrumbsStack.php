<?php

namespace FromSelect\Breadcrumbs;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

class BreadcrumbsStack implements IteratorAggregate
{
    /**
     * @var Breadcrumb[] A stack of breadcrumbs.
     */
    private $crumbs = [];

    /**
     * Pushes Breadcrumbs to stack.
     *
     * @param Breadcrumb[] $crumbs
     */
    public function push(Breadcrumb ...$crumbs)
    {
        foreach ($crumbs as $crumb) {
            $this->crumbs[] = $crumb;
        }
    }

    /**
     * Returns iterator which traverses on breadcrumbs.
     *
     * @return Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->crumbs);
    }
}
