<?php
defined('BASEPATH') or exit('No direct script access allowed!');
/**
* 
*/
class Partner_summaries extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('partner_summaries_model');
	}

	function testing_trends($year=NULL,$partner=NULL)
	{
		$data['trends'] = $this->partner_summaries_model->test_trends($year,$partner);
		$data['div_name'] = "partner_yearly_summary";
		$data['export'] = TRUE;
		$link = $year . '/' . $partner;

		$data['link'] = base_url('charts/partner_summaries/download_testing_trends/' . $link);

		$this->load->view('trends_outcomes_view', $data);
	}

	function download_testing_trends($year=NULL,$partner=NULL)
	{
		$this->partner_summaries_model->download_testing_trends($year,$partner);
	}

	function eid_outcomes($year=NULL,$month=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] =$this->partner_summaries_model->eid_outcomes($year,$month,$partner,$to_year,$to_month);

		$this->load->view('eid_outcomes_view', $data);
	}

	function hei_validation($year=NULL,$month=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] =$this->partner_summaries_model->hei_validation($year,$month,$partner,$to_year,$to_month);

		$this->load->view('hei_validation_pie', $data);
	}

	function hei_follow($year=NULL,$month=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] =$this->partner_summaries_model->hei_follow($year,$month,$partner,$to_year,$to_month);

		$this->load->view('hei_view', $data);
	}

	function agegroup($year=NULL,$month=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] =$this->partner_summaries_model->age($year,$month,$partner,$to_year,$to_month);

		$this->load->view('agegroup_view', $data);
	}

	function entry_points($year=NULL,$month=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] =$this->partner_summaries_model->entry_points($year,$month,$partner,$to_year,$to_month);

		$this->load->view('entry_point_view', $data);
	}

	function mprophyalxis($year=NULL,$month=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] =$this->partner_summaries_model->mprophylaxis($year,$month,$partner,$to_year,$to_month);

		$this->load->view('mprophylaxis_view', $data);
	}

	function iprophyalxis($year=NULL,$month=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] =$this->partner_summaries_model->iprophylaxis($year,$month,$partner,$to_year,$to_month);

		$this->load->view('iprophylaxis_view', $data);
	}

	function partner_outcomes($year=NULL,$month=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['trends'] = $this->partner_summaries_model->partner_outcomes($year,$month,$partner,$to_year,$to_month);
		$data['div_name'] = "partner_outcomes_summary";

		$this->load->view('trends_outcomes_view', $data);
	}

	function partner_county($year=NULL,$month=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['trends'] = $this->partner_summaries_model->partner_counties($year,$month,$partner,$to_year,$to_month);
		$data['div_name'] = "partner_counties_summary";

		$this->load->view('trends_outcomes_view', $data);
	}

	function partner_counties($year=NULL,$month=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] = $this->partner_summaries_model->partner_counties_outcomes($year,$month,$partner,$to_year,$to_month);

		$link = $year . '/' . $month . '/' . $partner . '/' . $to_year . '/' . $to_month;
		$link2 = $partner;
		//$data['link'] = anchor('charts/sites/download_partner_sites/' . $link, 'Download List');

		$data['link'] = "<a href='" . base_url('charts/partner_summaries/download_partner_counties/' . $link) . "'><button class='btn btn-primary' style='background-color: #009688;color: white;'>Export to Excel</button></a>";
		$data['link2'] = "<a href='" . base_url('charts/sites/download_partner_supported_sites/' . $link2) . "'><button class='btn btn-primary' style='background-color: #009688;color: white;'>DOWNLOAD LIST OF ALL SUPPORTED SITES</button></a>";

    	$this->load->view('partner__site__view',$data);
	}

	function download_partner_counties($year=NULL,$month=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$this->partner_summaries_model->partner_counties_download($year,$month,$partner,$to_year,$to_month);
	}
	

	function get_patients($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data = $this->partner_summaries_model->get_patients($year,$month,$county,$partner,$to_year,$to_month);

    	$this->load->view('patients_view',$data);
	}

	function get_patients_outcomes($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data = $this->partner_summaries_model->get_patients_outcomes($year,$month,$county,$partner,$to_year,$to_month);

    	$this->load->view('patients_outcomes_graph',$data);
	}

	function get_patients_graph($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data = $this->partner_summaries_model->get_patients_graph($year,$month,$county,$partner,$to_year,$to_month);

    	$this->load->view('patients_graph',$data);
	}



}
?>