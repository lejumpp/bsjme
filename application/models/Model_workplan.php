<?php

class Model_workplan extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	//Get all workplan, for the technical advisor.
	public function getWorkPlanData_TA($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM  workplan WHERE ta_id=?";
			$query = $this->db->query($sql, array($id));
			return $query->result_array();
		}
	}

	//Get workplan for specific user. 
	public function getWorkPlanData($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM  workplan WHERE id=?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}
	}

	public function create($data)
	{
		$insert = $this->db->insert('workplan', $data);
		if ($insert == false) {
			return false;
		} else {
			$insert_id = $this->db->insert_id();
			return  $insert_id;
		}
	}


	public function remove($id)
	{
		if ($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('workplan');
			return ($delete == true) ? true : false;
		}
	}

	public function update($wkplan_data, $id)
	{
		if ($id) {
			$this->db->where('id', $id);
			$update = $this->db->update('workplan', $wkplan_data);
			return ($update == true) ? true : false;
		}
	}

	public function getWorkPlanTaskData($id = null)
	{
		if ($id) {
			$sql = "SELECT * from workplan_task WHERE wid=?";
			$query = $this->db->query($sql, array($id));
			return $query->result_array();
		}
	}

	public function getWorkPlanTaskById($id = null)
	{
		if ($id) {
			$sql = "SELECT * from workplan_task WHERE id=?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}
	}

	public function createTask($data)
	{
		$insert = $this->db->insert('workplan_task', $data);
		if ($insert == false) {
			return false;
		} else {
			$insert_id = $this->db->insert_id();
			return  $insert_id;
		}
	}

	public function updateTask($wkplan_data, $id)
	{
		if ($id) {
			$this->db->where('id', $id);
			$update = $this->db->update('workplan_task', $wkplan_data);
			return ($update == true) ? true : false;
		}
	}

	public function removeTask($id)
	{
		if ($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('workplan_task');
			return ($delete == true) ? true : false;
		}
	}

	public function getMonitoringNotes($id)
	{
		if ($id) {
			$sql = "SELECT `notes`,`date`, (SELECT name FROM user WHERE workplan_monitoring.created_by=user.id) as 'created_by' FROM workplan_monitoring WHERE wid=?";
			$query = $this->db->query($sql, array($id));
			return $query->result_array();
		}
	}

	public function createMonitoringNote($data)
	{
		$insert = $this->db->insert('workplan_monitoring', $data);
		if ($insert == false) {
			return false;
		} else {
			$insert_id = $this->db->insert_id();
			return  $insert_id;
		}
	}
}
