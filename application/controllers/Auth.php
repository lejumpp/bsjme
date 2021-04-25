<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
	}


	//--> Check if the login form is submitted, and validates the user credential
	//    If not submitted it redirects to the login page

	public function login()
	{

		$this->logged_in();

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run() == TRUE) {
			// true case
			$username_exists = $this->model_auth->check_username($this->input->post('username'));

			if ($username_exists == TRUE) {
				$login = $this->model_auth->login($this->input->post('username'), $this->input->post('password'));
				if ($login) {

					$logged_in_sess = array(
						'user_id' => $login['id'],
						'profile'  => $login['profile_id'],
						'name' => $login['name'],
						'username' => $login['username'],
						'logged_in' => TRUE
					);

					$this->session->set_userdata($logged_in_sess);
					redirect('dashboard', 'refresh');
				} else {
					$this->data['errors'] = 'Incorrect username/password combination';
					$this->load->view('login', $this->data);
				}
			} else {
				$this->data['errors'] = 'Username does not exists';
				$this->load->view('login', $this->data);
			}
		} else {
			// false case
			$this->load->view('login');
		}
	}


	//--> Clears the session and redirects to login page

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('auth/login', 'refresh');
	}

	// Password Reset
	public function password_reset()
	{
		$response = array();
		$this->form_validation->set_rules('email', 'Email', 'valid_email|trim|required');
		if ($this->form_validation->run() == TRUE) {
			$email = trim($this->input->post('email'));
			$result = $this->model_auth->check_email($email);
			if ($result) {
				if ($this->model_auth->updatedAt($result->id)) {
					//if we found the email, $result is the row
					if ($this->send_password_reset($email, $result->username)) {
						$this->data['success'] = 'Please check your email for password reset link; link is valid for 15 mins.';
						$this->load->view('password_reset', $this->data);
					} else {
						$this->data['errors'] = 'Error sending password';
						$this->load->view('password_reset', $this->data);
					}
				} else {
					$this->data['errors'] = 'Sorry unable to update at this time.';
					$this->load->view('password_reset', $this->data);
				}
			} else {
				$this->data['errors'] = 'Email provided does not exist';
				$this->load->view('password_reset', $this->data);
			}
		} else {
			$this->load->view('password_reset');
		}
	}

	public function send_password_reset($email, $username)
	{
		$this->email->set_mailtype('html');
		$email_code = hash("sha256", $username);
		$from_email = "no-reply@bsj.org.jm";
		$this->email->from($from_email, 'BSJ Client Servicing');
		$this->email->to($email);
		$this->email->subject('BSJ Client Servicing Password Reset');
		$this->email->message('<!doctype html>
	    <html lang="en-US">

	    <head>
	        <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	        <style type="text/css">
	            a:hover {text-decoration: underline !important;}
	        </style>
	    </head>

	    <body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">
	        <!--100% body table-->
	        <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8"
	            style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: "Open Sans", sans-serif;">
	            <tr>
	                <td>
	                    <table style="background-color: #f2f3f8; max-width:670px;  margin:0 auto;" width="100%" border="0"
	                        align="center" cellpadding="0" cellspacing="0">
	                        <tr>
	                            <td style="height:80px;">&nbsp;</td>
	                        </tr>
	                        <tr>
	                            <td style="height:20px;">&nbsp;</td>
	                        </tr>
	                        <tr>
	                            <td>
	                                <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
	                                    style="max-width:670px;background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
	                                    <tr>
	                                        <td style="height:40px;">&nbsp;</td>
	                                    </tr>
	                                    <tr>
	                                        <td style="padding:0 35px;">
	                                            <h1 style="color:#1e1e2d; font-weight:500; margin:0;font-size:32px;font-family:"Rubik",sans-serif;">You have
	                                                requested to reset your password</h1>
	                                            <span
	                                                style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;"></span>
	                                            <p style="color:#455056; font-size:15px;line-height:24px; margin:0;">
	                                                A unique link to reset your password has been generated for you. You have 15 mins to reset your password, click the
	                                                following link and follow the instructions.
	                                            </p>
	                                            <a href="' . base_url() . 'auth/reset_password_form/' . $email . '/' . $email_code . '"
	                                                style="background:#20e277;text-decoration:none !important; font-weight:500; margin-top:35px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;">Reset
	                                                Password</a>
	                                        </td>
	                                    </tr>
	                                    <tr>
	                                        <td style="height:40px;">&nbsp;</td>
	                                    </tr>
	                                </table>
	                            </td>
	                        <tr>
	                            <td style="height:20px;">&nbsp;</td>
	                        </tr>
	                        <tr>
	                            <td style="height:80px;">&nbsp;</td>
	                        </tr>
	                    </table>
	                </td>
	            </tr>
	        </table>
	        <!--/100% body table-->
	    </body>

	    </html>');
		if ($this->email->send()) {
			return true;
		} else {
			return false;
		}
	}

	public function checkExpiryDate($time)
	{
		$timeDiff = strtotime(date("Y-m-d h:i:s")) - strtotime($time);
		if ($timeDiff < 900) {
			return true;
		} else {
			return false;
		}
	}

	public function reset_password_form($email = null, $email_code = null)
	{
		if (isset($email, $email_code)) {
			$email = trim($email);
			$email_hash = hash("sha256", $email . $email_code);
			$verified = $this->model_auth->verify_reset_password_code($email, $email_code);
			if ($verified) {
				if ($this->checkExpiryDate($verified->updated_date)) {
					$this->load->view('update_password', array('email_hash' => $email_hash, 'email_code' => $email_code, 'email' => $email));
				} else {
					$this->load->view('password_reset', array('errors' => 'Password reset link has expired.'));
				}
			} else {
				$this->load->view('password_reset', array('errors' => 'There was a problem with your link. Please click the link again or request to reset your password again', 'email' => $email));
			}
		}
	}

	public function update_password()
	{
		if (!isset($_POST['email'], $_POST['email_hash']) || $_POST['email_hash'] !== hash("sha256", $_POST['email'] . $_POST['email_code'])) {
			$this->load->view('password_reset', array('errors' => 'There was a problem updating your password. Please click the link again or request to reset your password again'));
		} else {
			$this->form_validation->set_rules('email_hash', 'Email Hash', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('password_conf', 'Confirmed Password', 'trim|required|matches[password]');
			if ($this->form_validation->run() == FALSE) {
				// user didn't validate, send back to update password form and show errors
				$this->load->view('update_password', array('email_hash' => $_POST['email_hash'], 'email_code' => $_POST['email_code'], 'email' => $_POST['email']));
			} else {
				//successful update
				//return true if successful
				$result = $this->model_auth->update_password($this->input->post('email'), password_hash($this->input->post('password'), PASSWORD_DEFAULT));
				if ($result) {
					$this->load->view('login', array('success' => 'Password updated successfully'));
				} else {
					$this->load->view('password_reset', array('errors' => 'There was a problem updating your password. Please click the link again or request to reset your password again'));
				}
			}
		}
	}
}
