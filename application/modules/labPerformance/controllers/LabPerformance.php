<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LabPerformance extends MY_Controller {

	public $data = array();

	function __construct()
	{
		parent:: __construct();
		$this->data	=	array_merge($this->data,$this->load_libraries(array('material','highstock','highmaps','highcharts','custom','select2','tablecloth')));
		$this->session->set_userdata('partner_filter', NULL);
		$this->load->module('charts/labperformance');
	}

	public function index()
	{
		$this->data['labs'] = TRUE;
		$this->data['content_view'] = 'labPerformance/performance_view';
		// echo "<pre>";print_r($this->data);die();
		$this -> template($this->data);
	}
}