<?php
/* 
 * @author  Vincent
 * @version CI3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {

    public function __construct()
    {
      parent::__construct();
      $this->load->database();
    }
 
    private function _call_grading_api( $Vuiopzwyzw2h )
    {
      $V44m3d3j5qsi = json_decode( $Vuiopzwyzw2h );
      if ( $V44m3d3j5qsi === null ) return false;
      
      set_time_limit(0);
      
      $Vqpdc4xsyszx = "http://10.90.2.67/grading_api/getReport.php";
      $V3uio3xk0gdx = curl_init();
      curl_setopt( $V3uio3xk0gdx, CURLOPT_URL, $Vqpdc4xsyszx );
      curl_setopt( $V3uio3xk0gdx, CURLOPT_POST, 1 );
      curl_setopt( $V3uio3xk0gdx, CURLOPT_POSTFIELDS, $Vuiopzwyzw2h );
      curl_setopt( $V3uio3xk0gdx, CURLOPT_RETURNTRANSFER, TRUE );
      curl_setopt( $V3uio3xk0gdx, CURLOPT_CONNECTTIMEOUT, 0 ); 
      $Vq3gnhj24xh1 = curl_exec( $V3uio3xk0gdx );
      $Vycukm2g435s = json_decode( $Vq3gnhj24xh1 );
      curl_close( $V3uio3xk0gdx );

      return $Vycukm2g435s;
    }
    
    private function _get_num_of_holiday( $Vukjf0c5hzu0 )
    {
      $this->db->select( 'COUNT(holiday_date) as num_of_holiday' );
      $this->db->from( 'holiday_mst' );
      $this->db->where( 'holiday_date >=', $Vukjf0c5hzu0['start_day'] );
      $this->db->where( 'holiday_date <=', $Vukjf0c5hzu0['end_day'] );
      $this->db->where( 'mill_code', $Vukjf0c5hzu0['mill_code'] );
      $Vonbvky11c1w = $this->db->get();
      return $Vonbvky11c1w->row()->num_of_holiday;
    } 
    
    private function _get_sampling_percent( $Vukjf0c5hzu0 )
    {
      $this->db->select( 'monthly_sampling_percent' );
      $this->db->from( 'grading_params' );
      $this->db->where( 'mill_code', $Vukjf0c5hzu0['mill_code'] );
      $Vonbvky11c1w = $this->db->get();
      return $Vonbvky11c1w->row()->monthly_sampling_percent;
    } 
    
    public function filter_data( $Vwv3ccq3tlr4, $Vqhvd4ymj5p3 = 'history' )
    {
      if ( $Vqhvd4ymj5p3 == 'target' )
      {        
        $Vklpjm3eoyar = date( 'd', strtotime($Vwv3ccq3tlr4['start_date']) );
        $Vgjtki2sha1m = date( 't', strtotime($Vwv3ccq3tlr4['start_date']) );
        $Vkq1lhusmaon = date( 'Y-m-01', strtotime($Vwv3ccq3tlr4['start_date']) );
        $Vnggr2hf123a = date( 'Y-m-t', strtotime($Vwv3ccq3tlr4['start_date']) );
        $Vsdhv5gn4s0w = $Vwv3ccq3tlr4['start_date'];
        $Vjgjok5a4gci = $Vwv3ccq3tlr4['mill_code'];
        
        $Vukjf0c5hzu01 = array('start_day' => $Vkq1lhusmaon, 'end_day' => $Vsdhv5gn4s0w, 'mill_code' => $Vjgjok5a4gci);
        $Vmfbir5xerii = $this->_get_num_of_holiday( $Vukjf0c5hzu01 );
        $Vusc1vxz3wgu = $Vklpjm3eoyar - $Vmfbir5xerii;
        
        $Vukjf0c5hzu02 = array('start_day' => $Vkq1lhusmaon, 'end_day' => $Vnggr2hf123a, 'mill_code' => $Vjgjok5a4gci);
        $Vmfbir5xerii = $this->_get_num_of_holiday( $Vukjf0c5hzu02 );
        $Vgb3gvwdsg1o = $Vgjtki2sha1m - $Vmfbir5xerii;
        
        $Vukjf0c5hzu03 = array('mill_code' => $Vjgjok5a4gci);
        $Vusbgdyhsy10 = $this->_get_sampling_percent( $Vukjf0c5hzu03 );
        
        $Vonbvky11c1w = "
          SELECT 
            esm.estate_short_name,
            dim.division_name,  
            temp.num_of_truck_last_month, 
            IFNULL( act.TotalTruck, 0 ) as actual_num_of_truck_coming, 
            IFNULL(
              IF( ROUND(
                  IF (temp.num_of_truck_last_month > IFNULL( act.TotalTruck, 0 ), 
                      temp.num_of_truck_last_month, 
                      act.TotalTruck
                  ) * $Vusbgdyhsy10 / 100, 0 ) = 0, 
                  1, 
                  ROUND(
                    IF (temp.num_of_truck_last_month > IFNULL( act.TotalTruck, 0 ), 
                        temp.num_of_truck_last_month, 
                        act.TotalTruck
                    ) * $Vusbgdyhsy10 / 100, 0 
                  )
              ), 0) as estimate_sampling, 
            '$Vklpjm3eoyar' as on_days, 
            IFNULL(
              CEIL($Vusc1vxz3wgu / $Vgb3gvwdsg1o * IF (temp.num_of_truck_last_month > IFNULL( act.TotalTruck, 0 ), 
                                                  temp.num_of_truck_last_month, 
                                                  act.TotalTruck
                                              ) * $Vusbgdyhsy10 / 100), 0 ) as estimate_num_of_sampling,
            IFNULL( x.JmlGrading, 0 ) as actual_num_of_sampling,
            IFNULL( ROUND(
              IFNULL( x.JmlGrading, 0 ) / IF( ROUND(
                                                  IF (temp.num_of_truck_last_month > IFNULL( act.TotalTruck, 0 ), 
                                                      temp.num_of_truck_last_month, 
                                                      act.TotalTruck
                                                  ) * $Vusbgdyhsy10 / 100, 0 ) = 0,
                                                  1,
                                                  ROUND(
                                                    IF (temp.num_of_truck_last_month > IFNULL( act.TotalTruck, 0 ), 
                                                            temp.num_of_truck_last_month, 
                                                            act.TotalTruck
                                                    ) * $Vusbgdyhsy10 / 100, 0
                                                  ) ) * 100, 2 
                                          ), 0) as achievement
          FROM 
            (SELECT * FROM temp_last_month_truck_per_estate WHERE period = DATE_SUB('$Vsdhv5gn4s0w' , INTERVAL DAYOFMONTH('$Vsdhv5gn4s0w') DAY)) temp
            LEFT JOIN estate_mst esm on temp.estate_code = esm.estate_code
            LEFT JOIN division_mst dim on temp.division_code = dim.division_code
            LEFT JOIN (
              SELECT s.division_code, count(*) as TotalTruck 
              FROM spb s 
                INNER JOIN division_mst d on d.division_code = s.division_code 
                INNER JOIN estate_mst e on e.estate_Code = d.estate_code 
                INNER JOIN region_mst r on r.region_Code = e.region_code	
                INNER JOIN group_mst gr on gr.group_Code = r.group_code 
              WHERE 
                s.spb_date between '$Vkq1lhusmaon' and '$Vsdhv5gn4s0w' 
              GROUP BY 
                s.division_code
            ) act ON temp.division_code = act.division_code 			
            LEFT JOIN (
              SELECT s.division_code, count(*) as JmlGrading 
              FROM spb s 
                INNER JOIN division_mst d on d.division_code = s.division_code 
                INNER JOIN estate_mst e on e.estate_Code = d.estate_code 
                INNER JOIN region_mst r on r.region_Code = e.region_code 
                INNER JOIN group_mst gr on gr.group_Code = r.group_code 
              WHERE 
                s.spb_date between '$Vkq1lhusmaon' AND '$Vsdhv5gn4s0w' 
                AND d.mill_code = $Vjgjok5a4gci 
                AND is_grading = 1 
              GROUP BY 
                s.division_code
            ) x on temp.division_code = x.division_code 		
          WHERE 
            temp.division_code IN (
              SELECT 
                d.division_code 
              FROM division_mst d 
                INNER JOIN estate_mst e on e.estate_code = d.estate_code 
                INNER JOIN region_mst r on r.region_code = e.region_code 
                INNER JOIN group_mst gr on gr.group_code = r.group_code 
              WHERE 
                d.mill_code = $Vjgjok5a4gci
            )
          ORDER BY 
            achievement DESC";
        $Vonbvky11c1w = $this->db->query( $Vonbvky11c1w );
        return $Vonbvky11c1w->result_array();
      }
      else
      {
        $V2pcrsa3krxy = $this->_call_grading_api( $Vwv3ccq3tlr4 );
        if ( empty($V2pcrsa3krxy) ) return false;
        $Vonbvky11c1w1 = $this->db->query( $V2pcrsa3krxy->query1 );
        $Vonbvky11c1w2 = $this->db->query( $V2pcrsa3krxy->query2 );
        $Vonbvky11c1w3 = $this->db->query( $V2pcrsa3krxy->query3 );
        $Vonbvky11c1w4 = $this->db->query( $V2pcrsa3krxy->query4 );
        $Vonbvky11c1w5 = $this->db->query( $V2pcrsa3krxy->query5 );
        $Vonbvky11c1w6 = $this->db->query( $V2pcrsa3krxy->query6 );
        $V1o3h3a3nyhf = array(
          'data_one' => $Vonbvky11c1w1->result_array(),
          'data_two' => $Vonbvky11c1w2->result_array(),
          'data_three' => $Vonbvky11c1w3->result_array(),
          'data_four' => $Vonbvky11c1w4->result_array(),
          'data_five' => $Vonbvky11c1w5->result_array(),
          'data_six' => $Vonbvky11c1w6->result_array()
        );
        return $V1o3h3a3nyhf;
      }
    }
}

