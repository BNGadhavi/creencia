<?php

Class Statemodel extends CI_Model {

	public function GetStateList($data)
	{
		if(empty($data)){

			$data['country_id']='101';
		}

		$condition = "country_id = " . "'" . $data['country_id'] . "'";
		$this->db->select('*');
		$this->db->from('mlm_states');
		$this->db->where($condition);
		$this->db->order_by("name", "asc");
		$query = $this->db->get();

		

		$state_array=array();
		$status=false;
		if ($query->num_rows() > 0) {
			$status=true;
			$result=$query->result();
			$state_array['result']=$result;
		} else {
			$status=false;
		}	
		$state_array['status']=$status;
		
		return $state_array;

	}


}

?>