<?php

class SearchResult
{

    private array $result;

    public function __construct(array $result)
    {
        $this->result = $result;
    }

    public function first()
    {
        return $this->result[0] ?? null;
    }

}