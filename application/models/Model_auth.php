<?php

class Model_auth extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	//-->	This function checks if the username exists in the database

	public function check_username($username)
	{
		if ($username) {
			$sql = 'SELECT * FROM user WHERE username = ?';
			$query = $this->db->query($sql, array($username));
			$result = $query->num_rows();
			return ($result == 1) ? true : false;
		}

		return false;
	}


	//-->	This function checks if the username and password matches with the database

	public function login($username, $password)
	{
		if ($username && $password) {
			$sql = "SELECT user.*
					FROM user 
					WHERE username = ?";
			$query = $this->db->query($sql, array($username));

			if ($query->num_rows() == 1) {
				$result = $query->row_array();

				$hash_password = password_verify($password, $result['password']);
				if ($hash_password === true) {
					return $result;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
	}

	public function check_email($email)
	{
		if ($email) {
			$sql = "SELECT id, username,email FROM user WHERE email ='" . $email . "' LIMIT 1";
			$result = $this->db->query($sql);
			$row = $result->row();
			return ($result->num_rows() === 1 && $row->email) ? $row : false;
		}
		return false;
	}

	public function verify_reset_password_code($email, $code)
	{
		$sql = "SELECT id, username,email,updated_date FROM user WHERE email='{$email}' LIMIT 1";
		$result = $this->db->query($sql);
		$row = $result->row();
		if ($result->num_rows() === 1) {
			return ($code == hash("sha256", $row->username)) ? $row : false;
		} else {
			return false;
		}
	}

	public function update_password($email, $password)
	{
		$sql = "UPDATE `user` SET `password` ='{$password}' where `email`='{$email}'";
		$this->db->query($sql);
		if ($this->db->affected_rows() === 1) {
			return true;
		} else {
			return false;
		}
	}

	public function updatedAt($id)
	{
		$sql = "UPDATE user SET updated_date = CURRENT_TIMESTAMP where id=$id";
		$this->db->query($sql);
		if ($this->db->affected_rows() === 1) {
			return true;
		} else {
			return false;
		}
	}
}
