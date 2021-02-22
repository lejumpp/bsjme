
<div class="content-wrapper">
  <section class="content-header">
    <h1>Create Workplan</h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('workplan') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Workplan</li>
    </ol>
    <br>
  </section>



<section class="content">

  <div class="row">
    <div class="col-md-12 col-xs-12">
      <div id="messages"></div>

        <?php if($this->session->flashdata('success')): ?>

          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
                <?php elseif($this->session->flashdata('error')): ?>
                  <div class="alert alert-error alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo $this->session->flashdata('error'); ?>
                  </div>

        <?php endif; ?>



          <div class="box">
          <div class="box-header">
          </div>

    
          <form role="form" action="<?php base_url('workplan/create') ?>" method="post" enctype="multipart/form-data">
          <div class="box-body">
          <?php echo validation_errors(); ?>

          <div class="row">

                <div class="col-md-3 col-xs-3">
                  <div class="form-group">
                      <label for="major_deliverable">Major Deliverables <font color="red">*</font></label>
                      <input type="text" class="form-control" id="major_deliverable" name="major_deliverable" autocomplete="off"
                      value="<?php echo set_value('major_deliverable'); ?>"/>
                  </div>
                </div>

              


                  <div class="col-md-3 col-xs-3">
                  <div class="form-group">
                    <label for="start_date">Start date <font color="red">*</font></label>
                    <input type="date" class="form-control" id="start_date" name="start_date" autocomplete="off"
                    value="<?php echo set_value('start_date'); ?>"/>
                  </div>
                  </div> 


                  <div class="col-md-3 col-xs-3">
                  <div class="form-group">
                    <label for="end_date">End date <font color="red">*</font></label>
                    <input type="date" class="form-control" id="end_date" name="end_date" autocomplete="off"
                    value="<?php echo set_value('end_date'); ?>"/>
                  </div>
                  </div>  


            </div>
        


<!--Tasks Table -->

<div class=row>
 <div class="form-group">
  <table  class="table table-bordered" id="tb">
    <tr>
    <th>Task</th>
    <th>Entity</th>
    <th>Responsible Officer</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Task Start Date</th>
    <th>Task End Date</th>
    <th>Status</th>
    <th><a href="javascript:void(0);" style="font-size:18px;" id="addMore" title="addMoretask"><span class="glyphicon glyphicon-plus"></span></a></th>
    </tr>

    <tr>

    <td>
      <div class="form-group">
        <input type="text" class="form-control" id="task" name="task[]" autocomplete="off"
        value="<?php echo set_value('task'); ?>"/>
      </div>
    </td>

   <td>
    <div class="form-group">
      <input type="text" class="form-control" id="entity" name="entity[]" autocomplete="off"
      value="<?php echo set_value('entity'); ?>"/>
    </div>
  </td>

  <td>
    <div class="form-group">
      <input type="text" class="form-control" id="responsible_officer" name="responsible_officer[]" autocomplete="off"
      value="<?php echo set_value('responsible_officer'); ?>"/>
    </div>
  </td>

  <td>
    <div class="form-group">
      <input type="text" class="form-control" id="email" name="email[]" autocomplete="off"
      value="<?php echo set_value('email'); ?>"/>
    </div>
  </td>

  <td>
    <div class="form-group">
      <input type="text" class="form-control" id="phone" name="phone[]" autocomplete="off"
      value="<?php echo set_value('phone'); ?>"/>
    </div>
  </td>

  <td>
    <div class="form-group">
      <input type="date" class="form-control" id="task_start" name="task_start[]" autocomplete="off"
      value="<?php echo set_value('task_start');?>"/>            
    </div>
  </td>

 <td>
    <div class="form-group">
      <input type="date" class="form-control[]" id="task_end" name="task_end" autocomplete="off"
      value="<?php echo set_value('task_end');?>"/>            
    </div>
  </td>

  <td>
    <select name="status[]" class="form-control">
      <option value="Incomplete" selected>Incomplete</option>
      <option value="Complete">Complete</option>
      <option value="InProgress">In Progress</option>
    </select>
  </td>
    
    <td><a href='javascript:void(0);'  class='remove'><span class='glyphicon glyphicon-remove'></span></a></td>
    </tr>
  </table>
</div>
</div>

        
<div class="row">
      <div class="col-sm">
      <div class="form-group">
          <label for="monitoring_notes">
                 Monitoring 
          </label>
            <textarea type="text" class="form-control" rows="3" id="monitoring_notes" name="monitoring_notes" autocomplete="off">
                 <?php echo set_value('monitoring_notes'); ?>
            </textarea>
      </div>
      </div>
 </div>           
   

<div class="box-footer">
  <button type="submit" class="btn btn-primary">Save Changes</button>
  <a href="<?php echo base_url('workplan/') ?>" class="btn btn-warning">Close</a>
</div>
                
</div>
</form>  
</div>
</div>
</div>
</section>
</div>
   
        




<!-----------------------------------------  JQuery  --------------------------------------->

<script>
  $(
    function()
    {
      $('#addMore').on('click', function()
       {
          var data = $("#tb tr:eq(1)").clone(true).appendTo("#tb");
          data.find("input").val('');
       });

      $(document).on('click', '.remove', function() 
       {
         var trIndex = $(this).closest("tr").index();
         if(trIndex>1) {
         $(this).closest("tr").remove();
       } 

       else 
       {
         alert("Sorry!! The first row cannot be removed");
       }

      });
    }
  );      
  </script>