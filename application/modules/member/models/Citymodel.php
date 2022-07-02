<?php

Class Citymodel extends CI_Model {

	public function GetCityList($data)
	{
		

		if(isset($data['city_id']))
		{
			$condition = "id = " . "'" . $data['city_id'] . "'";
		}
		if(isset($data['city_id']) && isset($data['state_id']))
		{
			$condition =$condition. " and";
		}
		if(isset($data['state_id']))
		{
			$condition = "state_id = " . "'" . $data['state_id'] . "'";
		}


		$this->db->select('*');
		$this->db->from('mlm_cities');
		$this->db->where($condition);
		$this->db->order_by("name", "asc");
		$query = $this->db->get();

		

		$city_array=array();
		$status=false;
		if ($query->num_rows() > 0) {
			$status=true;
			$result=$query->result();
			$city_array['result']=$result;
		} else {
			$status=false;
		}	
		$city_array['status']=$status;
		return $city_array;

	}


}

?>