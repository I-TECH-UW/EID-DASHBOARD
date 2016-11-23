<?php
defined("BASEPATH") or exit("No direct script access allowed!");

/**
* 
*/
class Subcounties_model extends MY_Model
{
	function __construct()
	{
		parent:: __construct();;
	}

	function subcounties_outcomes($year=null,$month=null)
	{

		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}

		$sql = "CALL `proc_get_eid_top_subcounty_outcomes`('".$year."','".$month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();

		$data['sub_county_outcomes'][0]['name'] = 'Positive';
		$data['sub_county_outcomes'][1]['name'] = 'Negative';

		$count = 0;
		
		$data["sub_county_outcomes"][0]["data"][0]	= $count;
		$data["sub_county_outcomes"][1]["data"][0]	= $count;
		$data['categories'][0]					= 'No Data';

		foreach ($result as $key => $value) {
			$data['categories'][$key] 					= $value['name'];
			$data["sub_county_outcomes"][0]["data"][$key]	=  (int) $value['positive'];
			$data["sub_county_outcomes"][1]["data"][$key]	=  (int) $value['negative'];
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function country_tests($year=NULL,$month=NULL)
	{
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}
		
		$sql = "CALL `proc_get_county_suppression`('".$year."','".$month."')";
		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		$data;
		foreach ($result as $key => $value) {
			
				$data[$value['id']]['id'] = $value['id'];
				
				$data[$value['id']]['value'] = $value['tests'];
				
			
		}
		 // echo "<pre>";print_r($data);die();
		return $data;

	}

	function country_suppression($year=NULL,$month=NULL)
	{
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}
		
		$sql = "CALL `proc_get_county_suppression`('".$year."','".$month."')";
		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		$data;
		foreach ($result as $key => $value) {
			
				$data[$value['id']]['id'] = $value['id'];
				if($value['tests'] == 0){
					$data[$value['id']]['value'] = 0;
				}
				else{
					$data[$value['id']]['value'] = round((int) $value['suppressed'] / $value['tests'] * 100);
				}
			
		}
		 // echo "<pre>";print_r($data);die();
		return $data;

	}

	function country_non_suppression($year=NULL,$month=NULL)
	{
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}
		
		$sql = "CALL `proc_get_county_non_suppression`('".$year."','".$month."')";
		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		$data;
		foreach ($result as $key => $value) {
			
				$data[$value['id']]['id'] = $value['id'];
				if($value['tests'] == 0){
					$data[$value['id']]['value'] = 0;
				}
				else{
					$data[$value['id']]['value'] = 
					round((int) $value['non_suppressed'] / $value['tests'] * 100);
				}
			
		}
		 // echo "<pre>";print_r($data);die();
		return $data;

	}

	function country_rejects($year=NULL,$month=NULL)
	{
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}
		
		$sql = "CALL `proc_get_county_rejected`('".$year."','".$month."')";
		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		$data;
		foreach ($result as $key => $value) {
			
				$data[$value['id']]['id'] = $value['id'];
				if($value['tests'] == 0){
					$data[$value['id']]['value'] = 0;
				}
				else{
					$data[$value['id']]['value'] = round((int) $value['rejected'] / $value['tests'] * 100);
				}
			
		}
		 // echo "<pre>";print_r($data);die();
		return $data;

	}

	function country_pregnant($year=NULL,$month=NULL)
	{

		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = $this->session->userdata('filter_month');
			}else {
				$month = 0;
			}
		}
		
		$sql = "CALL `proc_get_county_pregnant_women`('".$year."','".$month."')";
		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		$data;
		foreach ($result as $key => $value) {
			
				$data[$value['id']]['id'] = $value['id'];
				
				$data[$value['id']]['value'] = $value['tests'];
				
				
			
		}
		 // echo "<pre>";print_r($data);die();
		return $data;

	}

	function country_lactating($year=NULL,$month=NULL)
	{
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}
		
		$sql = "CALL `proc_get_county_lactating_women`('".$year."','".$month."')";
		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		$data;
		foreach ($result as $key => $value) {
			
				$data[$value['id']]['id'] = $value['id'];
				
				$data[$value['id']]['value'] = $value['tests'];
				
				
			
		}
		 // echo "<pre>";print_r($data);die();
		return $data;

	}		

	function county_details($county=NULL,$year=NULL,$month=NULL)
	{
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}
		
		$sql = "CALL `proc_get_county_partner_details`('".$county."','".$year."','".$month."')";

		$result = $this->db->query($sql)->result_array();
		
		$data;
		$i = 0;

		foreach ($result as $key => $value) {
			
			$data[$i]['partner'] = $value['partner'];
			$data[$i]['facility'] = $value['facility'];
			$data[$i]['tests'] = $value['tests'];

			if($value['tests'] == 0){
					$data[$i]['suppressed'] = 0;
					$data[$i]['non_suppressed'] = 0;
					$data[$i]['rejected'] = $value['rejected'];
				}
			else{
				$data[$i]['suppressed'] = $value['suppressed'] . " (" . round((int) $value['suppressed'] / $value['tests'] * 100) . "%)";
				$data[$i]['non_suppressed'] = $value['non_suppressed'] . " (" . round((int) $value['non_suppressed'] / $value['tests'] * 100) . "%)";
				$data[$i]['rejected'] = $value['rejected'] . " (" . round((int) $value['rejected'] / $value['tests'] * 100) . "%)";

			}
			
			
			$data[$i]['adults'] = $value['adults'];
			$data[$i]['children'] = $value['children'];
			
			$i++;
		}		
		$table = '';
		foreach ($data as $key => $value) {
			$table .= '<tr>';
			$table .= '<td>'.$value['partner'].'</td>';
			$table .= '<td>'.$value['facility'].'</td>';
			$table .= '<td>'.$value['tests'].'</td>';
			$table .= '<td>'.$value['suppressed'].'</td>';
			$table .= '<td>'.$value['non_suppressed'].'</td>';
			$table .= '<td>'.$value['rejected'].'</td>';
			$table .= '<td>'.$value['adults'].'</td>';
			$table .= '<td>'.$value['children'].'</td>';
			$table .= '</tr>';
		}

		return $table;
	}
	
	
}
?>