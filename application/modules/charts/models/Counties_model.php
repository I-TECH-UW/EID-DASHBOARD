<?php
defined("BASEPATH") or exit("No direct script access allowed!");

/**
* 
*/
class Counties_model extends MY_Model
{
	function __construct()
	{
		parent:: __construct();;
	}

	function counties_details($year=NULL,$month=NULL,$to_month=NULL)
	{
		$table = '';
		$count = 1;
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
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}

		$sql = "CALL `proc_get_eid_countys_details`('".$year."','".$month."','".$to_month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		foreach ($result as $key => $value) {
			$table .= '<tr>';
			$table .= '<td>'.$count.'</td>';
			$table .= '<td>'.$value['county'].'</td>';
			$table .= '<td>'.$value['tests'].'</td>';
			$table .= '<td>'.$value['firstdna'].'</td>';
			$table .= '<td>'.$value['confirmdna'].'</td>';
			$table .= '<td>'.$value['positive'].'</td>';
			$table .= '<td>'.$value['negative'].'</td>';
			$table .= '<td>'.$value['redraw'].'</td>';
			$table .= '<td>'.$value['adults'].'</td>';
			$table .= '<td>'.$value['adultspos'].'</td>';
			$table .= '<td>'.$value['medage'].'</td>';
			$table .= '<td>'.$value['rejected'].'</td>';
			$table .= '<td>'.$value['infantsless2m'].'</td>';
			$table .= '<td>'.$value['infantsless2mpos'].'</td>';

			$table .= '</tr>';
			$count++;
		}
		
		// echo "<pre>";print_r($table);die();
		return $table;
	}

	function download_counties_details($year=NULL,$month=NULL,$to_month=NULL){
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
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}

		$sql = "CALL `proc_get_eid_countys_details`('".$year."','".$month."','".$to_month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();

		$this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";

	    /** open raw memory as file, no need for temp files, be careful not to run out of memory thought */
	    $f = fopen('php://memory', 'w');
	    /** loop through array  */

	    $b = array('County', 'Tests', '1st DNA PCR', 'Repeat Confirmatory PCR', '+', '-', 'Redraws', 'Adults Tests', 'Adults Tests Positives', 'Median Age', 'Rejected', 'Infants < 2m', 'Infants < 2m +');

	    fputcsv($f, $b, $delimiter);

	    foreach ($result as $line) {
	        /** default php csv handler **/
	        fputcsv($f, $line, $delimiter);
	    }
	    /** rewrind the "file" with the csv lines **/
	    fseek($f, 0);
	    /** modify header to be downloadable csv file **/
	    header('Content-Type: application/csv');
	    header('Content-Disposition: attachement; filename="county_details.csv";');
	    /** Send file to browser for download */
	    fpassthru($f);
	}

	function sub_county_outcomes($year=null,$month=null,$county=null,$to_month=NULL)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}

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
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}

		$sql = "CALL `proc_get_eid_subcounty_outcomes`('".$county."','".$year."','".$month."','".$to_month."')";
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

	function county_subcounties_details($year=null,$month=null,$county=null,$to_month=NULL)
	{
		$table = '';
		$count = 1;
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
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
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}

		$sql = "CALL `proc_get_eid_county_subcounties_details`('".$county."','".$year."','".$month."','".$to_month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($sql);die();
		foreach ($result as $key => $value) {
			$table .= '<tr>';
			$table .= '<td>'.$count.'</td>';
			$table .= '<td>'.$value['subcounty'].'</td>';
			$table .= '<td>'.$value['tests'].'</td>';
			$table .= '<td>'.$value['firstdna'].'</td>';
			$table .= '<td>'.$value['confirmdna'].'</td>';
			$table .= '<td>'.$value['positive'].'</td>';
			$table .= '<td>'.$value['negative'].'</td>';
			$table .= '<td>'.$value['redraw'].'</td>';
			$table .= '<td>'.$value['adults'].'</td>';
			$table .= '<td>'.$value['adultspos'].'</td>';
			$table .= '<td>'.$value['medage'].'</td>';
			$table .= '<td>'.$value['rejected'].'</td>';
			$table .= '<td>'.$value['infantsless2m'].'</td>';
			$table .= '<td>'.$value['infantsless2mpos'].'</td>';
			$table .= '</tr>';
			$count++;
		}
		

		return $table;
	}

	function download_county_subcounty_outcomes($year=null,$month=null,$county=null,$to_month=NULL)
	{
		
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
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
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}

		$sql = "CALL `proc_get_eid_county_subcounties_details`('".$county."','".$year."','".$month."','".$to_month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();

		$this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";

	    /** open raw memory as file, no need for temp files, be careful not to run out of memory thought */
	    $f = fopen('php://memory', 'w');
	    /** loop through array  */

	    $b = array('Subcounty', 'County', 'Tests', '1st DNA PCR', 'Confirmed PCR', '+', '-', 'Redraws', 'Adults Tests', 'Adults Tests Positives', 'Median Age', 'Rejected', 'Infants < 2m', 'Infants < 2m +');

	    fputcsv($f, $b, $delimiter);

	    foreach ($result as $line) {
	        /** default php csv handler **/
	        fputcsv($f, $line, $delimiter);
	    }
	    /** rewrind the "file" with the csv lines **/
	    fseek($f, 0);
	    /** modify header to be downloadable csv file **/
	    header('Content-Type: application/csv');
	    header('Content-Disposition: attachement; filename="county_subcounty_details.csv";');
	    /** Send file to browser for download */
	    fpassthru($f);
		
	}



	// function country_tests($year=NULL,$month=NULL)
	// {
	// 	if ($year==null || $year=='null') {
	// 		$year = $this->session->userdata('filter_year');
	// 	}
	// 	if ($month==null || $month=='null') {
	// 		if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
	// 			$month = 0;
	// 		}else {
	// 			$month = $this->session->userdata('filter_month');
	// 		}
	// 	}
		
	// 	$sql = "CALL `proc_get_county_suppression`('".$year."','".$month."')";
		
	// 	// echo "<pre>";print_r($sql);die();
	// 	$result = $this->db->query($sql)->result_array();
	// 	$data;
	// 	foreach ($result as $key => $value) {
			
	// 			$data[$value['id']]['id'] = $value['id'];
				
	// 			$data[$value['id']]['value'] = $value['tests'];
				
			
	// 	}
	// 	 // echo "<pre>";print_r($data);die();
	// 	return $data;

	// }

	// function country_suppression($year=NULL,$month=NULL)
	// {
	// 	if ($year==null || $year=='null') {
	// 		$year = $this->session->userdata('filter_year');
	// 	}
	// 	if ($month==null || $month=='null') {
	// 		if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
	// 			$month = 0;
	// 		}else {
	// 			$month = $this->session->userdata('filter_month');
	// 		}
	// 	}
		
	// 	$sql = "CALL `proc_get_county_suppression`('".$year."','".$month."')";
		
	// 	// echo "<pre>";print_r($sql);die();
	// 	$result = $this->db->query($sql)->result_array();
	// 	$data;
	// 	foreach ($result as $key => $value) {
			
	// 			$data[$value['id']]['id'] = $value['id'];
	// 			if($value['tests'] == 0){
	// 				$data[$value['id']]['value'] = 0;
	// 			}
	// 			else{
	// 				$data[$value['id']]['value'] = round((int) $value['suppressed'] / $value['tests'] * 100);
	// 			}
			
	// 	}
	// 	 // echo "<pre>";print_r($data);die();
	// 	return $data;

	// }

	// function country_non_suppression($year=NULL,$month=NULL)
	// {
	// 	if ($year==null || $year=='null') {
	// 		$year = $this->session->userdata('filter_year');
	// 	}
	// 	if ($month==null || $month=='null') {
	// 		if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
	// 			$month = 0;
	// 		}else {
	// 			$month = $this->session->userdata('filter_month');
	// 		}
	// 	}
		
	// 	$sql = "CALL `proc_get_county_non_suppression`('".$year."','".$month."')";
		
	// 	// echo "<pre>";print_r($sql);die();
	// 	$result = $this->db->query($sql)->result_array();
	// 	$data;
	// 	foreach ($result as $key => $value) {
			
	// 			$data[$value['id']]['id'] = $value['id'];
	// 			if($value['tests'] == 0){
	// 				$data[$value['id']]['value'] = 0;
	// 			}
	// 			else{
	// 				$data[$value['id']]['value'] = 
	// 				round((int) $value['non_suppressed'] / $value['tests'] * 100);
	// 			}
			
	// 	}
	// 	 // echo "<pre>";print_r($data);die();
	// 	return $data;

	// }

	// function country_rejects($year=NULL,$month=NULL)
	// {
	// 	if ($year==null || $year=='null') {
	// 		$year = $this->session->userdata('filter_year');
	// 	}
	// 	if ($month==null || $month=='null') {
	// 		if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
	// 			$month = 0;
	// 		}else {
	// 			$month = $this->session->userdata('filter_month');
	// 		}
	// 	}
		
	// 	$sql = "CALL `proc_get_county_rejected`('".$year."','".$month."')";
		
	// 	// echo "<pre>";print_r($sql);die();
	// 	$result = $this->db->query($sql)->result_array();
	// 	$data;
	// 	foreach ($result as $key => $value) {
			
	// 			$data[$value['id']]['id'] = $value['id'];
	// 			if($value['tests'] == 0){
	// 				$data[$value['id']]['value'] = 0;
	// 			}
	// 			else{
	// 				$data[$value['id']]['value'] = round((int) $value['rejected'] / $value['tests'] * 100);
	// 			}
			
	// 	}
	// 	 // echo "<pre>";print_r($data);die();
	// 	return $data;

	// }

	// function country_pregnant($year=NULL,$month=NULL)
	// {

	// 	if ($year==null || $year=='null') {
	// 		$year = $this->session->userdata('filter_year');
	// 	}
	// 	if ($month==null || $month=='null') {
	// 		if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
	// 			$month = $this->session->userdata('filter_month');
	// 		}else {
	// 			$month = 0;
	// 		}
	// 	}
		
	// 	$sql = "CALL `proc_get_county_pregnant_women`('".$year."','".$month."')";
		
	// 	// echo "<pre>";print_r($sql);die();
	// 	$result = $this->db->query($sql)->result_array();
	// 	$data;
	// 	foreach ($result as $key => $value) {
			
	// 			$data[$value['id']]['id'] = $value['id'];
				
	// 			$data[$value['id']]['value'] = $value['tests'];
				
				
			
	// 	}
	// 	 // echo "<pre>";print_r($data);die();
	// 	return $data;

	// }

	// function country_lactating($year=NULL,$month=NULL)
	// {
	// 	if ($year==null || $year=='null') {
	// 		$year = $this->session->userdata('filter_year');
	// 	}
	// 	if ($month==null || $month=='null') {
	// 		if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
	// 			$month = 0;
	// 		}else {
	// 			$month = $this->session->userdata('filter_month');
	// 		}
	// 	}
		
	// 	$sql = "CALL `proc_get_county_lactating_women`('".$year."','".$month."')";
		
	// 	// echo "<pre>";print_r($sql);die();
	// 	$result = $this->db->query($sql)->result_array();
	// 	$data;
	// 	foreach ($result as $key => $value) {
			
	// 			$data[$value['id']]['id'] = $value['id'];
				
	// 			$data[$value['id']]['value'] = $value['tests'];
				
				
			
	// 	}
	// 	 // echo "<pre>";print_r($data);die();
	// 	return $data;

	// }		

	// function county_details($county=NULL,$year=NULL,$month=NULL)
	// {
	// 	if ($year==null || $year=='null') {
	// 		$year = $this->session->userdata('filter_year');
	// 	}
	// 	if ($month==null || $month=='null') {
	// 		if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
	// 			$month = 0;
	// 		}else {
	// 			$month = $this->session->userdata('filter_month');
	// 		}
	// 	}
		
	// 	$sql = "CALL `proc_get_county_partner_details`('".$county."','".$year."','".$month."')";

	// 	$result = $this->db->query($sql)->result_array();
		
	// 	$data;
	// 	$i = 0;

	// 	foreach ($result as $key => $value) {
			
	// 		$data[$i]['partner'] = $value['partner'];
	// 		$data[$i]['facility'] = $value['facility'];
	// 		$data[$i]['tests'] = $value['tests'];

	// 		if($value['tests'] == 0){
	// 				$data[$i]['suppressed'] = 0;
	// 				$data[$i]['non_suppressed'] = 0;
	// 				$data[$i]['rejected'] = $value['rejected'];
	// 			}
	// 		else{
	// 			$data[$i]['suppressed'] = $value['suppressed'] . " (" . round((int) $value['suppressed'] / $value['tests'] * 100) . "%)";
	// 			$data[$i]['non_suppressed'] = $value['non_suppressed'] . " (" . round((int) $value['non_suppressed'] / $value['tests'] * 100) . "%)";
	// 			$data[$i]['rejected'] = $value['rejected'] . " (" . round((int) $value['rejected'] / $value['tests'] * 100) . "%)";

	// 		}
			
			
	// 		$data[$i]['adults'] = $value['adults'];
	// 		$data[$i]['children'] = $value['children'];
			
	// 		$i++;
	// 	}		
	// 	$table = '';
	// 	foreach ($data as $key => $value) {
	// 		$table .= '<tr>';
	// 		$table .= '<td>'.$value['partner'].'</td>';
	// 		$table .= '<td>'.$value['facility'].'</td>';
	// 		$table .= '<td>'.$value['tests'].'</td>';
	// 		$table .= '<td>'.$value['suppressed'].'</td>';
	// 		$table .= '<td>'.$value['non_suppressed'].'</td>';
	// 		$table .= '<td>'.$value['rejected'].'</td>';
	// 		$table .= '<td>'.$value['adults'].'</td>';
	// 		$table .= '<td>'.$value['children'].'</td>';
	// 		$table .= '</tr>';
	// 	}

	// 	return $table;
	// }

	
	
	
}
?>