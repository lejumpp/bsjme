<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Workplan extends Admin_Controller 
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Work Plan';
        
    }

    public function index()
    {
        if(!in_array('viewWorkPlan
            ', $this->permission)) {redirect('dashboard', 'refresh');}

        $this->render_template('workplan/index', $this->data);   
    }



   
     // THE UPDATE AND PRINT ICONS ARE HERE

    public function fetchWorkPlanData($id)
    {
        $result = array('data' => array());


        $data = $this->model_workplan->getWorkPlanData_TA($id);
        
        // var_dump($data);

        // foreach ($data as $key => $value) {


        //     // $buttons = '';

        //     // if(in_array('updateWorkPlan', $this->permission)) {
        //     //     $buttons .= '<a href="'.base_url('workplan/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
        //     // }
              
        //     // if(in_array('deleteWorkPlan', $this->permission)) { 
        //     //   $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';    
        //     // }


        //     // if(in_array('viewWorkPlan', $this->permission)) { 
        //     //     $buttons .= '<a href="'.base_url('report_workplan/REP0W/'.$value['id']).'"target="_blank" class="btn btn-default"><i class="fa fa-print"></i></a>';
        //     //         }


        //     $result['data'][$key] = array(  
        //         $value['major_deliverable'],    
        //         $value['start_date'],
        //         $value['end_date'], 
        //         $value['task'],
        //         $value['entity'], 
        //         $value['res_off'], 
        //         $value['email'], 
        //         $value['phone'], 
        //         $value['task_start'], 
        //         $value['task_end'], 
        //         $value['status'], 
        //         $value['monitoring_notes'],  
        //     );
        // } // /foreach
        $result['data']=$data;
        echo json_encode($result);

    }   

    public function fetchWorkPlanDataExpansion($id)
    {
        $result = array('data' => array());


        $data = $this->model_workplan->getWorkPlanData_TA($id);
        


        foreach ($data as $key => $value) {


            $buttons = '';

            if(in_array('updateWorkPlan', $this->permission)) {
                $buttons .= '<a href="'.base_url('workplan/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
            }
              
            if(in_array('deleteWorkPlan', $this->permission)) { 
              $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';    
            }


            if(in_array('viewWorkPlan', $this->permission)) { 
                $buttons .= '<a href="'.base_url('report_workplan/REP0W/'.$value['id']).'"target="_blank" class="btn btn-default"><i class="fa fa-print"></i></a>';
                    }


            $result['data'][$key] = array(  
                $value['major_deliverable'],    
                $value['start_date'],
                $value['end_date'], 
                $value['task'],
                $value['entity'], 
                $value['res_off'],               
                $buttons
            );
        } // /foreach
        echo json_encode($result);

    }   


    public function create()
    {
        if(!in_array('createWorkPlan', $this->permission)) {redirect('dashboard', 'refresh');}
        $this->form_validation->set_rules('major_deliverable', 'Major Deliverable', 'trim|required');
        $this->form_validation->set_rules('start_date', 'Start Date','required');
        $this->form_validation->set_rules('end_date', 'EndDate','required');
        $this->form_validation->set_rules('task', 'Task','required');
        $this->form_validation->set_rules('entity', 'Entity','required');
        $this->form_validation->set_rules('responsible_officer', 'Responsible Officer','required');
        $this->form_validation->set_rules('email', 'Email','required');
        $this->form_validation->set_rules('phone', 'Phone','required');
        $this->form_validation->set_rules('task_start', 'Task Start','required');
        $this->form_validation->set_rules('task_end', 'Task End','required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_rules('monitoring_notes', 'Monitorring Notes', 'required');



        $this->form_validation->set_error_delimiters('<p class="alert alert-warning">','</p>');


        if ($this->form_validation->run() == TRUE) 
        { 
            if (!empty($this->input->post('major_deliverable'))) 
            {
                $count_major_deliverable = count($this->input->post('major_deliverable'));
                $major_deliverable = array();
                for($x = 0; $x < $count_major_deliverable; $x++) 
                {
                    array_push($major_deliverable,$this->input->post('major_deliverable')[$x]);
                }  
            }
            else
            {
                $major_deliverable=null; 
            }


            if (!empty($this->input->post('start_date'))) 
            {
                $count_start_date = count($this->input->post('start_date'));
                $start_date = array();
                for($x = 0; $x < $count_start_date; $x++) 
                {
                    array_push($start_date,$this->input->post('start_date')[$x]);
                }  
            }
            else
            {
                $start_date=null; 
            }

            
            if (!empty($this->input->post('end_date'))) 
            {
                $count_end_date = count($this->input->post('end_date'));
                $end_date = array();
                for($x = 0; $x < $count_end_date; $x++) 
                {
                    array_push($end_date,$this->input->post('end_date')[$x]);
                }  
            }
            else
            {
                $end_date=null; 
            }


            if (!empty($this->input->post('task'))) 
            {
                $count_task = count($this->input->post('task'));
                $task = array();
                for($x = 0; $x < $count_task; $x++) 
                {
                    array_push($task,$this->input->post('task')[$x]);
                }  
            }
            else
            {
                $task=null; 
            }


             if (!empty($this->input->post('entity'))) 
            {
                $count_entity = count($this->input->post('entity'));
                $entity = array();
                for($x = 0; $x < $count_entity; $x++) 
                {
                    array_push($entity,$this->input->post('entity')[$x]);
                }  
            }
            else
            {
                $entity=null; 
            }
            

             if (!empty($this->input->post('responsible_officer'))) 
            {
                $count_responsible_officer = count($this->input->post('responsible_officer'));
                $responsible_officer = array();
                for($x = 0; $x < $count_responsible_officer; $x++) 
                {
                    array_push($responsible_officer,$this->input->post('responsible_officer')[$x]);
                }  
            }
            else
            {
                $responsible_officer=null; 
            }


             if (!empty($this->input->post('email'))) 
            {
                $count_email = count($this->input->post('email'));
                $email = array();
                for($x = 0; $x < $count_email; $x++) 
                {
                    array_push($email,$this->input->post('email')[$x]);
                }  
            }
            else
            {
                $email=null; 
            }


            if (!empty($this->input->post('phone'))) 
            {
                $count_phone = count($this->input->post('phone'));
                $phone= array();
                for($x = 0; $x < $count_phone; $x++) 
                {
                    array_push($phone,$this->input->post('phone')[$x]);
                }  
            }
            else
            {
                $phone=null; 
            }


            if (!empty($this->input->post('task_start'))) 
            {
                $count_task_start = count($this->input->post('task_start'));
                $task_start= array();
                for($x = 0; $x < $count_task_start; $x++) 
                {
                    array_push($task_start,$this->input->post('task_start')[$x]);
                }  
            }
            else
            {
                $task_start=null; 
            }


            if (!empty($this->input->post('task_end'))) 
            {
                $count_task_end = count($this->input->post('task_end'));
                $task_end= array();
                for($x = 0; $x < $count_task_end; $x++) 
                {
                    array_push($task_end,$this->input->post('task_end')[$x]);
                }  
            }
            else
            {
                $task_end=null; 
            }


            if (!empty($this->input->post('status'))) 
            {
                $count_status = count($this->input->post('status'));
                $status= array();
                for($x = 0; $x < $count_status; $x++) 
                {
                    array_push($status,$this->input->post('status')[$x]);
                }  
            }
            else
            {
                $status=null; 
            }
              

            $data = array(
               'major_deliverable'=>json_encode('major_deliverable'),
               'start_date'=>json_encode('start_date'),
               'end_date'=>json_encode('end_date'),
               'task'=>json_encode('task'),
               'entity'=>json_encode('entity'),
               'res_off'=>json_encode('res_off'),
               'email'=>json_encode('email'),
               'phone'=>json_encode('phone'),
               'task_start'=>json_encode('task_start'),
               'task_end'=>json_encode('task_end'),
               'status'=>json_encodet('status'),
               'monitoring_notes'=>$this->input->post('monitoring_notes')
             );
              

             
            $success = $this->model_workplan->create($data);

            if($success)
            {
                $this->session->set_flashdata('success', 'Successfully created');
                redirect('requirement/', 'refresh');
            }

            else

            {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('requirement/', 'refresh');
            }
        }
        else 
        {
            // false case     
            // $this->data['workplan'] = $this->model_workplan->getCurrentWorkPlan();  
            $this->render_template('workplan/create', $this->data);
        }   
    }

   

     public function update($id)
    {
        if(!in_array('updateWorkPlan', $this->permission)AND !in_array('viewWorkPlan', $this->permission))
        {
        redirect('dashboard', 'refresh');
        }

        if(!$id) {redirect('dashboard', 'refresh');}

        $this->form_validation->set_rules('major_deliverable', 'Major Deliverable', 'trim|required');
        $this->form_validation->set_rules('duration', 'Duration','required');
        $this->form_validation->set_rules('start_date', 'Start Date','required');
        $this->form_validation->set_rules('end_date', 'EndDate','required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_rules('personnel_role', 'Personnel Role', 'required');
        $this->form_validation->set_error_delimiters('<p class="alert alert-warning">','</p>');

            if ($this->form_validation->run() == TRUE) 
           {
               
                if (!empty($this->input->post('task'))) 
            {
                $count_task = count($this->input->post('task'));
                $task = array();
                for($x = 0; $x < $count_task; $x++) 
                {
                    array_push($task,$this->input->post('task')[$x]);
                }  
            }
               else
                {
                     $task=null; 
                }

                $wkplan_data = array(               
               'major_deliverable'=> $this->input->post('major_deliverable'), 
               'task' => json_encode($task),
               'duration'=> $this->input->post('duration'),
               'start_date'=> $this->input->post('start_date'),
               'end_date'=> $this->input->post('end_date'),
               'status'=> $this->input->post('status'),
               'personnel_role'=> $this->input->post('personnel_role'),
               'reschedule_start_date'=> $this->input->post('reschedule_start_date'),
               'reschedule_end_date'=> $this->input->post('reschedule_end_date'),
               'consultant_comment'=> $this->input->post('consultant_comment'),
               'consultant_update'=> $this->input->post('consultant_update'),
               'client_comment'=> $this->input->post('client_comment'),
               'client_update'=> $this->input->post('client_update'),
               'monitoring_notes'=> $this->input->post('monitoring_notes'),
               'monitoring_dates'=> $this->input->post('monitoring_dates')
                );          

               $update = $this->model_workplan->update($wkplan_data,$id);



               if($update == true) {
                $this->session->set_flashdata('success', 'Successfully updated');
                redirect('workplan/', 'refresh');
                }

               else
                {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('workplan/', 'refresh');
                }
           }

               else 

               {
                 $result = array();
                 $data_wkplan = $this->model_workplan->getWorkPlanData($id);
                 $result['workplan'] = $data_wkplan;
                 $task=json_decode($data_wkplan['task'],true);
                 if($task!=null){
                 foreach($task as $k => $v) 
                 {
                    $result['task'][] = $v;
                 }
               }
               $this->data['wkplan_data'] = $result;
               $this->render_template('workplan/edit', $this->data);

               }
        
     }




    public function remove()
    {
        if(!in_array('deleteWorkPlan', $this->permission)) {redirect('dashboard', 'refresh');}
        
        $id = $this->input->post('workplan_id');

        $response = '';
        $response = array();

        if($id) {
            $delete = $this->model_workplan->remove($id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed"; 
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the Work Plan";
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refresh the page again!!";
        }
        echo json_encode($response);
    }


}