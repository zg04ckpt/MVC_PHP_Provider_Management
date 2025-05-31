<?php 

class PaginatedDto {
    public $page;
    public $size;
    public $totalPages;
    public $totalItems;
    public $items;

    public function __construct($page, $size, $totalItems, $data) {
        $this->totalPages = max(1, ceil($totalItems / $size));
        $this->page = min($page, $this->totalPages);
        $this->size = $size;
        $this->items = $data;
        $this->totalItems = $totalItems;
    }
}