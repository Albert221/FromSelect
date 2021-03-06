<?php

namespace FromSelect;

use Psr\Http\Message\ServerRequestInterface;

class Pagination
{
    const SORT_ASC = 0;
    const SORT_DESC = 1;

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
     * @var string Field to sort on.
     */
    private $sortField;

    /**
     * @var int Order of sort.
     */
    private $sortOrder;

    /**
     * Pagination constructor.
     *
     * @param int $currentPage
     * @param int $perPage
     * @param int $count
     * @param string $sortField
     * @param int $sortOrder
     */
    public function __construct($currentPage, $perPage, $count = 0, $sortField = '', $sortOrder = self::SORT_ASC)
    {
        $this->currentPage = $currentPage;
        $this->perPage = $perPage;
        $this->count = $count;
        $this->sortField = $sortField;
        $this->sortOrder = $sortOrder;
    }

    /**
     * Creates Pagination instance from Request's query params.
     *
     * @param ServerRequestInterface $request
     * @param int $count
     *
     * @return Pagination
     */
    public static function createFromRequest(ServerRequestInterface $request, $count = 0)
    {
        $params = $request->getQueryParams();

        return new self(
            isset($params['page']) ? (int) $params['page'] : 1,
            isset($params['perPage']) ? (int) $params['perPage'] : 25,
            $count,
            isset($params['sort']) ? $params['sort'] : '',
            isset($params['order']) ? (int) $params['order'] : self::SORT_ASC
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
     * Sets count of all rows.
     *
     * @param int $count
     */
    public function setCount($count)
    {
        $this->count = $count;
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

    /**
     * Returns field to sort on.
     *
     * @return string
     */
    public function getSortField()
    {
        return $this->sortField;
    }

    /**
     * Returns order of sorting, either ascendant (`self::SORT_ASC`)
     * or descendant (`self::SORT_DESC`).
     *
     * @return int
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }
}
