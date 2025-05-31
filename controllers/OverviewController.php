<?php

require_once 'BaseController.php';

class OverviewController extends BaseController {
    private $model;
    public function __construct() {
        $this->loadModels("OverviewModel");
        $this->model = new OverviewModel();
    }

    public function index() {
        $data = $this->model->get_overview();
        $this->layout_view('overview/index', isClient: false, params: [
            'data' => $data
        ]);
    }

    public function amount_by_duration() {
        $start_date = $_REQUEST['start_date'];
        $end_date = $_REQUEST['end_date'];
        $data = $this->model->analysis_amount($start_date, $end_date);
        $this->return_success(null, $data);
    }

    public function amount_each_12_mon_over() {
        $data = $this->model->analysis_amount_12_mon_over();
        $this->return_success(null, $data);
    }

    public function get_max_item_providers() {
        $data = $this->model->getTopSuppliersMaxTime();
        $this->return_success(null, $data);
    }

    public function get_random_10_provider() {
        $data = $this->model->getRandom10Pro();
        $this->return_success(null, $data);
    }
}