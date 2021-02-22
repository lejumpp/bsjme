<?php 

class Model_workplan extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

//Get all workplan, for the technical advisor.
	public function getWorkPlanData_TA($id=null)
	{
		if($id) {
			$sql = "SELECT * FROM  workplan WHERE ta_id=?";
			$query = $this->db->query($sql, array($id));
			return $query->result_array();
		}
	}

//Get workplan for specific user. 
	public function getWorkPlanData($id=null)
	{
		if($id) {
			$sql = "SELECT * FROM  workplan WHERE id=?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}
	}


	public function create($data)
	{  
		$insert = $this->db->insert('workplan', $data);
		return ($insert) ? $insert : false;
	}

	


	public function remove($id)
	{
		if($id) 
		{
			$this->db->where('id', $id);
			$delete = $this->db->delete('workplan');
			return ($delete == true) ? true : false;
		}
	}

    public function update($wkplan_data, $id)
	{
		if($id) {
			$this->db->where('id', $id);
			$update = $this->db->update('workplan', $wkplan_data);
			return ($update == true) ? true : false;
		}
    }


}