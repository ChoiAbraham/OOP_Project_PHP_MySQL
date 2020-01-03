<?php

namespace App\Helper;

use App\Repository\UserRepository;

class Pagination
{
    /*
     * @var array of objects, result of AbstractRepository
     */
    private $results = [];

    /**
     * maximum of lines per Page
     * @var int
     */
    private $lines;

    private $linesRemaining;

    private $limit;

    private $currentPage;

    public function __construct(array $results, int $currentpage, int $numberOfLines)
    {
        $this->results = $results;
        $this->currentPage = $currentpage;
        $this->lines = $numberOfLines;
        $this->setLimit($this->lines);
    }

    /**
     * max page number
     * @return int
     */
    public function countPage()
    {
        $pdoCount = count($this->results);

        $result = intdiv($pdoCount, $this->lines);

        if ($pdoCount % $this->lines) {
            $result++;
        }

        $this->linesRemaining = $pdoCount % $this->lines;

        if ($this->linesRemaining == 0) {
            $this->linesRemaining = $this->lines;
        }

        return $result;
    }

    /**
     * return an array of the number of the pages
     * @param  int $currentpage
     * @return array, for $currentpage = 1 returns [1, 2, 3], for $currentpage = 3 returns [2, 3, 4]
     */
    public function arrayPage()
    {
        $current = $this->currentPage;

        $previous = $current - 1;
        if ($previous != -1 && $current != 1) {
            $arrayPage[] = $previous;
        }

        $arrayPage[] = (int)$current;

        $next = $current + 1;

        if ($this->countPage() >= $next) {
            $arrayPage[] = $next;
        }

        return $arrayPage;
    }

    /**
     * defines the $limit for the sql query
     * equals $numberoflines, if its the last page, equals linesremaining
     * @param  $numberoflines
     * @return int
     */
    public function setLimit($numberOfLines)
    {
        $this->limit = $numberOfLines;
        if ($this->currentPage === $this->countPage()) {
            $this->limit = $this->linesRemaining;
        }
    }

    public function getLimit()
    {
        return $this->limit;
    }
}
