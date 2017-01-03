<?php

namespace FromSelect;

use Slim\Http\Request;

class Pagination
{
    /**
     * @var int Current page.
     */
    private $currentPage;

    /**
     * @var int Rows per page.
     */
    private $perPage;

    /**
     * @var int Rows count.
     */
    private $count;

    /**
     * Pagination constructor.
     *
     * @param int $currentPage
     * @param int $perPage
     * @param int $count
     */
    public function __construct($currentPage, $perPage, $count = 0)
    {
        $this->currentPage = $currentPage;
        $this->perPage = $perPage;
        $this->count = $count;
    }

    /**
     * Creates Pagination instance from Request's query params.
     *
     * @param Request $request
     * @param int $count
     *
     * @return Pagination
     */
    public static function createFromRequest(Request $request, $count = 0)
    {
        return new self(
            (int) $request->getQueryParam('page', 1),
            (int) $request->getQueryParam('perPage', 25),
            $count
        );
    }

    /**
     * Returns current page.
     *
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * Returns rows count per page.
     *
     * @return int
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * Returns count of all rows.
     *
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Returns pages count.
     *
     * @return int
     */
    public function getPagesCount()
    {
        return ceil($this->count / ($this->perPage ?: 1));
    }

    /**
     * Returns index of first row.
     *
     * @return int
     */
    public function getFirstRow()
    {
        return $this->perPage * ($this->currentPage - 1);
    }
}
