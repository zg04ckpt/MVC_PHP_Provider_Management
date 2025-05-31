<?php

require_once 'BaseController.php';

class AnalystController extends BaseController {
    public function dataError(DataException $ex) {
        $this->layout_view('home/index', isClient: true);
    }
}