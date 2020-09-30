
<div class="content-wrapper">

<section class="content-header">
    <h1>Edit Technical Advice - <?php echo $technical_advice_data['company_name']; ?> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('technical_advice') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Technical Advice</li>
        <li><img width="25" height="25" data-toggle="tooltip" data-placement="bottom" title="Some information about the tehnical advice." 
            src="<?php echo base_url('assets/images/question.png'); ?>" /></li>
    </ol>
</section>





<!----------------------------------------------------------------------------------------------------->
<!--                                                                                                 -->
<!--                                       Tab section                                               -->
<!--                                                                                                 -->
<!----------------------------------------------------------------------------------------------------->


<section class="content">
  <ul class="nav nav-tabs">
    <li class="<?php echo (($active_tab === 'technical_advice') ? 'active' : '') ?>"><a data-toggle="tab" href="#technical_advice">Technical Advice</a></li>
    <li class="<?php echo (($active_tab === 'needs_assessment') ? 'active' : '') ?>"><a data-toggle="tab" href="#needs_assessment">Needs Assessment</a></li>
    <li class="<?php echo (($active_tab === 'client_work_plan') ? 'active' : '') ?>"><a data-toggle="tab" href="#client_work_plan">Work Plan</a></li>		
    <li class="<?php echo (($active_tab === 'internal_cost_plan') ? 'active' : '') ?>"><a data-toggle="tab" href="#internal_cost_plan">Cost Plan</a></li>
    <li class="<?php echo (($active_tab === 'document') ? 'active' : '') ?>"><a data-toggle="tab" href="#document">Document</a></li>
  </ul>





<!----------------------------------------------------------------------------------------------------->
<!--                                                                                                 -->
<!--                             Error messages generated by the submit                              -->
<!--                                                                                                 -->
<!----------------------------------------------------------------------------------------------------->


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
            <?php elseif($this->session->flashdata('warning')): ?>
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo $this->session->flashdata('warning'); ?>
                </div>
            <?php endif; ?>

            <div class="tab-content">


<!----------------------------------------------------------------------------------------------------->
<!--                                                                                                 -->
<!--                                        Session variables                                        -->
<!--                                                                                                 -->
<!----------------------------------------------------------------------------------------------------->

<!-- Creation of a temporary session to keep the directory and information necessary for the manipulation
              of upload of documents -->

    <?php $this->session->unset_userdata('directory');?>
        <?php if(empty($this->session->userdata('directory'))) {
                $directory = array('directory' => '/upload/documents/'.$technical_advice_data['directory'].'/');
                $this->session->set_userdata($directory);
                } ?>

          <!-- <?php $this->session->unset_userdata('technical_advice_id');?>
          <?php if(empty($this->session->userdata('technical_advice_id'))) {
                $consultation_id = array('technical_advice_id' => $technical_advice_data['id']);
                $this->session->set_userdata($technical_advice_id);} ?> -->

          <?php $this->session->unset_userdata('client_id');?>
          <?php if(empty($this->session->userdata('client_id'))) {
                $client_id = array('client_id' => $technical_advice_data['client_id']);
                $this->session->set_userdata($client_id);} ?>






<!----------------------------------------------------------------------------------------------------->
<!--                                                                                                 -->
<!--                                        TECHNICAL ADVICE                                         -->
<!--                                                                                                 -->
<!----------------------------------------------------------------------------------------------------->


<div id="technical_advice" class="tab-pane fade <?php echo (($active_tab === 'technical_advice') ? 'in active' : '') ?>">	

    <div class="box">  <!-- BIG box -->    
    <form role="form" action="<?php base_url('technical_advice/update') ?>" method="post" enctype="multipart/form-data">
        <div class="box-body">

            <?php echo validation_errors(); ?>

        <div class="row">
            <div class="col-md-2 col-xs-2">

            <!---------------------------------------------------- box 1 --------------------------------------------->
            <div class="box box-solid box-default">
            <div class="box-body">
                <div class="form-group">
                <label for="company">Client</label> 

                <!-- you must have the permission to update the clien -->   
                <?php if(in_array('updateTechnicalAdvice', $user_permission)): ?>      
                    <?php echo '<a href="'.base_url('technical_advice/update/'.$technical_advice_data['client_id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>'; ?>
                <?php endif; ?>

                <br>
                <?php echo $technical_advice_data['client_name']; ?><br>
                <?php echo 'Mobile: '.$technical_advice_data['mobile']; ?><br>
                <?php echo 'Phone:  '.$technical_advice_data['phone']; ?><br>
                
                </div>
                <div class="form-group">
                <label for="address">Address</label><br>  
                <?php echo $technical_advice_data['address']; ?><br>
                <?php echo $technical_advice_data['county_name'].', '.$technical_advice_data['parish_name']; ?><br>
                <?php echo $technical_advice_data['postal_code']; ?>
                </div>

                <a href="mailto:<?php echo $technical_advice_data['email']; ?>" class="btn btn-warning">Send Mail</a>


            </div>  <!-- /box-body -->   
    
            </div>  
            <!----------------------------------------------------end box 1 ------------------------------------------->



        <div class="row">
            <div class="col-md-12 col-xs-12">
                <!-- you must have the permission to give access to a client -->   
                <?php if(in_array('updateTechnicalAdvice', $user_permission)): ?>      
                    <?php echo '<a href="'.base_url('user/createUserClient/'.$technical_advice_data['client_id']).'" class="btn btn-primary">Give Access Client</a>'; ?> 
                <?php endif; ?>
                </div>
        </div>
        <br> 

        <div class="row">
            <div class="col-md-12 col-xs-12">           
            <?php echo '<a href="'.base_url('report_consultation/REP0I/'.$technical_advice_data['id']).'" target="_blank"  class="btn btn-success">Print Consultation</a>'; ?>
            </div> 
        </div>
        <br>

        <div class="row">
            <div class="col-md-12 col-xs-12">
            <?php echo '<a href="'.base_url('Manual01/QPM01/'.$technical_advice_data['id']).'" target="_blank"  
            class="btn btn-success">Print the Manual&nbsp;&nbsp;&nbsp;&nbsp;</a>'; ?>
            </div>
        </div>
        <br>
        <div class="row">           
            <div class="col-md-12 col-xs-12">
                Last update <!--<?php echo $technical_advice_data['updated_date']; ?>--> by <?php echo $technical_advice_data['updated_by']; ?>
            </div>    
        </div>  <!-- /end row submit -->


        </div>  <!-- /col1 -->



        <div class="col-md-10 col-xs-10">  <!-- col2 -->

            <!---------------------------------------------------- box 2 --------------------------------------------->
            <div class="box box-solid box-default">
            <div class="box-body">


                <div class="row">  <!-- row 1 -->

                <div class="col-md-6 col-xs-6">
                    <div class="form-group">                 
                    <label for="client">Company <font color="red">*</font></label>
                    <select class="form-control select_group" id="client" name="client">
                            <option value=""></option>
                            <?php foreach ($client as $k => $v): ?>
                            <option value="<?php echo $v['id'] ?>"
                                <?php if(set_value('client', isset($technical_advice_data['client_id']) ? $technical_advice_data['client_id'] : '') == $v['id']) { echo "selected='selected'"; } ?> >
                                <?php echo $v['company_name'] ?><?php echo ' - trn '.$v['trn']; ?></option>
                            <?php endforeach ?>
                    </select>
                    </div>
                </div>
                <div class="col-md-6 col-xs-6">
                    <div class="form-group">
                    <label for="consultant">Consultant(s)</label>
                    <?php $consultant_data = json_decode($technical_advice_data['consultant_id']); ?>
                    <select class="form-control select_group" id="consultant" name="consultant[]" multiple="multiple">
                        <option value=""></option>
                        <?php foreach ($consultant as $k => $v): ?>
                        <option value="<?php echo $v['id'] ?>" 
                        <?php if ($consultant_data===Null) {} else {if(in_array($v['id'], $consultant_data)) { echo 'selected="selected"'; }} ?>><?php echo $v['name'] ?></option>
                        <?php endforeach ?>
                    </select>
                    </div>
                </div>               

                </div>  <!-- / end row 1 -->

                
                <div class="row">  <!-- row 2 -->

                    <div class="col-md-3 col-xs-3">
                        <div class="form-group">
                            <label for="activity">Activity <font color="red">*</font></label>
                            <select class="form-control select_group" id="activity" name="activity">
                                    <?php foreach ($activity as $k => $v): ?>
                                    <option value="<?php echo $v['id'] ?>"
                                    <?php if(set_value('activity', isset($technical_advice_data['activity']) ? $technical_advice_data['activity'] : '') == $v['id']) { echo "selected='selected'"; } ?> ><?php echo $v['name'] ?></option>
                                    <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 col-xs-3">
                        <div class="form-group">
                            <label for="date_created">Date Created</label>
                            <input type="date" class="form-control" id="date_created" name="date_created" autocomplete="off"
                            value="<?php echo set_value('date_created', isset($technical_advice_data['date_created']) ? $technical_advice_data['date_created'] : ''); ?>" readonly>
                        </div>
                    </div> 

                    <div class="col-md-3 col-xs-3">
                        <div class="form-group">
                            <label for="date_begin">Date begin</label>
                            <input type="date" class="form-control" id="date_begin" name="date_begin" autocomplete="off"
                            value="<?php echo set_value('date_begin', isset($technical_advice_data['date_begin']) ? $technical_advice_data['date_begin'] : ''); ?>">
                        </div>
                    </div>   

                    <div class="col-md-3 col-xs-3">
                        <div class="form-group">
                            <label for="date_end">Date end</label>
                            <input type="date" class="form-control" id="date_end" name="date_end" autocomplete="off"
                            value="<?php echo set_value('date_end', isset($technical_advice_data['date_ended']) ? $technical_advice_data['date_ended'] : ''); ?>">
                        </div>
                    </div>             
                
                </div>  <!-- end /row 2 -->        
                

                <div class="form-group">
                <label for="work_scope">Scope of Work</label>
                <textarea type="text" class="form-control" id="work_scope" name="work_scope" rows="3" autocomplete="off"><?php echo set_value('work_scope', isset($technical_advice_data['work_scope']) ? $technical_advice_data['work_scope'] : ''); ?></textarea>
                </div>


            </div> <!-- /end box body -->

            <div class="box-footer">
                <?php if(in_array('updateTechnicalAdvice', $user_permission)): ?>   <!-- you must have the permission to update to get the Save button --> 
                <button type="submit" class="btn btn-primary">Save</button>
            <?php endif; ?>   
                <a href="<?php echo base_url('technical_advice/') ?>" class="btn btn-warning">Close</a>
            </div>

            </div> 
            <!----------------------------------------------------end  box 2 --------------------------------------------->

        </div>
        </div>
    </div>
    </form>

    </div>
        
</div>


<!--Javascript for Technical Advice--->


<script type="text/javascript">

$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
    $(".select_group").select2({width: '100%'});
    // $("#mainClientNav").addClass('active');
    // $("#manageClientNav").addClass('active');	

});
</script>



<!----------------------------------------------------------------------------------------------------->
<!--                                                                                                 -->
<!--                                     Internal Cost Plan                                          -->
<!--                                                                                                 -->
<!----------------------------------------------------------------------------------------------------->

<div id="internal_cost_plan" class="tab-pane fade <?php echo (($active_tab === 'internal_cost_plan') ? 'in active' : '') ?>">	
    <div class="box">
        <div class="box-body">
            <div class="row">  <!-- /row divide by 2-->
                 <div class="col-md-12 col-xs-12">

                <?php if(in_array('createInternalCostPlan', $user_permission)): ?>
                  <button class="btn btn-primary" data-toggle="modal" data-target="#createModalInternalCostPlan">
                  Add Revenue/Expense Item</button>
                  <br /> <br />
                <?php endif; ?>

                <table id="manageTableInternalCostPlan" class="table table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Budget Type</th>
                            <th>Item</th>
                            <th>Estimate Amount</th>								
                            <th>Actual Amount</th>
                            <th>Created/Updated by</th>
                            <th>Date Created/Updated</th>
                            <?php if(in_array('updateInternalCostPlan', $user_permission) || in_array('deleteInternalCostPlan', $user_permission)): ?>
                            <th>Action</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                </table>
                </div>
             </div>
        </div>
    </div>
</div>


<!-- Add internal cost plan item--------------------------------------------------------------------------------->

<?php if(in_array('createInternalCostPlan', $user_permission)): ?>

<div class="modal fade" tabindex="-1" role="dialog" id="createModalInternalCostPlan">
<div class="modal-dialog" role="document">
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Add Revenue/Expense Item</h4>
  </div>

  <form role="form" action="<?php echo base_url('internal_cost_plan/create') ?>" method="post" id="createFormInternalCostPlan">

    <div class="modal-body">

      <div class="form-group">
        <label>Budget Type (Revenue/Expense)<font color="red"> *</font></label>
          <select name="budget_type" id="budget_type" class="form-control select2" style="width: 100%;">
          <option value=""></option>
          <option value="0">Revenue</option>
          <option value="1">Expense</option>
          </select>
      </div>

      <div class="form-group">
        <label>Item<font color="red"> *</font></label>
          <select name="item_name" id="item_name" class="form-control select2" style="width: 100%;">
          </select>
      </div>

      <div class="form-group">
      <label for="cost">Cost $JMD</label>
            <input type="number" class="form-control" id="cost" name="cost" autocomplete="off" READONLY>
      </div>

      <div class="row">
        <div class="col-md-6 col-xs-6">
          <div class="form-group">
            <label for="p_amount">Planned Estimate ($JMD)</label>
            <input type="number" class="form-control" id="p_amount" name="p_amount" autocomplete="off">
          </div>
        </div>
        <div class="col-md-6 col-xs-6">
          <div class="form-group">
          <label for="a_amount">Actual Spent ($JMD)</label>
            <input type="number" class="form-control" id="a_amount" name="a_amount" autocomplete="off">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 col-xs-6">
          <div class="form-group">
            <label for="created_by">Created by</label>
            <input type="text" class="form-control" id="created_by" name="created_by" autocomplete="off" READONLY>
          </div>
        </div>
        <div class="col-md-6 col-xs-6">
          <div class="form-group">
            <label for="date_updated">Date</label>
            <input type="date" class="form-control" id="date_updated" name="date_updated" value="<?php echo date('Y-m-d'); ?>" autocomplete="off" READONLY> 
          </div>
        </div>
      </div>

    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-primary">Save</button>
    </div>

  </form>

</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>




<!-- Edit Inquiry ------------------------------------------------------------------------------------->

<?php if(in_array('updateInternalCostPlan', $user_permission)): ?>
<div class="modal fade" tabindex="-1" role="dialog" id="editModalInquiry">
<div class="modal-dialog" role="document">
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Edit Inquiry</h4>
  </div>

  <form role="form" action="<?php echo base_url('inquiry/update') ?>" method="post" id="editFormInquiry">

    <div class="modal-body">
      <div id="messages"></div>

      <div class="form-group">
        <label>Budget Type (Revenue/Expense)<font color="red"> *</font></label>
          <select name="edit_inquiry_type" id="budget_type" class="form-control select2" style="width: 100%;">
          </select>
      </div>

      <div class="form-group">
        <label>Item<font color="red"> *</font></label>
          <select name="edit_support_type" id="item_name" class="form-control select2" style="width: 100%;">
          </select>
      </div>

      <div class="form-group">
        <label for="edit_request">Cost $JMD</label>
        <input type="number" class="form-control" id="edit_request" name="edit_request" autocomplete="off"></input>
      </div>

      <div class="row">
        <div class="col-md-6 col-xs-6">
            <div class="form-group">
                <label for="edit_feedback">Planned Estimate ($JMD)</label>
                <input type="number" class="form-control" id="edit_feedback" name="edit_feedback" autocomplete="off"></input>
            </div>
        </div>
        <div class="col-md-6 col-xs-6">
            <div class="form-group">
                <label for="edit_feedback">Actual Spent ($JMD)</label>
                <input type="number" class="form-control" id="edit_feedback" name="edit_feedback" autocomplete="off"></input>
            </div>
        </div>        
      </div>
      
      <div class="row">
        <div class="col-md-6 col-xs-6">
          <div class="form-group">
            <label for="edit_answered_by">Updated by</label>
            <input type="text" class="form-control" id="edit_answered_by" name="edit_answered_by" autocomplete="off">
          </div>
        </div>
        <div class="col-md-6 col-xs-6">
          <div class="form-group">
            <label for="edit_inquiry_date">Date</label>
            <input type="date" class="form-control" id="edit_inquiry_date" name="edit_inquiry_date" autocomplete="off">
          </div>
        </div>
      </div>

    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-primary">Save</button>
    </div>

  </form>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>


<!-- Delete Inquiry --------------------------------------------------------------------------------->

<?php if(in_array('deleteInternalCostPlan', $user_permission)): ?>

<div class="modal fade" tabindex="-1" role="dialog" id="removeModalInquiry">
<div class="modal-dialog" role="document">
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Delete Inquiry</h4>
  </div>

  <form role="form" action="<?php echo base_url('inquiry/remove') ?>" method="post" id="removeFormInquiry">
    <div class="modal-body">
      <p>Do you really want to delete?</p>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-primary">Delete</button>
    </div>
  </form>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>


<!------------------------------------->
<!-- Javascript part of Inquiry    --->
<!------------------------------------->

<script type="text/javascript">
var manageTableInternalCostPlan;
var base_url = "<?php echo base_url(); ?>";

//---> Prepare the view list

$(document).ready(function() {

//---> creation of the drop-down list budget names
// $budget_type = $('[id="budget_type"]');

// $cost = $('[id=cost');
$item_name = $('[id="item_name"]');
$.ajax({
    url: base_url+'billing/fetchBillingInfo',
    dataType: "JSON",
    success: function (data) 
    { 
      $item_name.html('<option value=""></option>');
      //iterate over the data and append a select option
      $.each(data, function (key, val) {
        $item_name.append('<option value="' + val.id + '">' + val.name + '</option>');
      });

    },
    error: function () {
    // if there is an error append a 'none available' option
    $item_name.html('<option id="-1">none available</option>');
    }
});

var budget_type= document.getElementById('budget_type');
budget_type.onchange=function(){
  var x = document.getElementById("budget_type").value;
  console.log(x);
}


// $("#inquiryClientNav").addClass('active');

// initialize the datatable
manageTableInternalCostPlan = $('#manageTableInternalCostPlan').DataTable({
    'ajax': base_url+'inquiry/fetchInquiryClient/23',
    'order': [[0, 'desc']]
});

//---> Submit the create form

$("#createFormInternalCostPlan").unbind('submit').on('submit', function() {
var form = $(this);

// remove the text-danger
$(".text-danger").remove();

$.ajax({
  url: form.attr('action'),
  type: form.attr('method'),
  data: form.serialize(), // /converting the form data into array and sending it to server
  dataType: 'json',
  success:function(response) {

    manageTableInternalCostPlan.ajax.reload(null, false);

    if(response.success === true) {

      // hide the modal
      $("#createModalInternalCostPlan").modal('hide');

      // reset the form
      $("#createFormInternalCostPlan")[0].reset();
      $("#createFormInternalCostPlan .form-group").removeClass('has-error').removeClass('has-success');

    } else {

      if(response.messages instanceof Object) {
        $.each(response.messages, function(index, value) {
          var id = $("#"+index);

          id.closest('.form-group')
          .removeClass('has-error')
          .removeClass('has-success')
          .addClass(value.length > 0 ? 'has-error' : 'has-success');

          id.after(value);

        });
      } else {
        $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
          '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
        '</div>');
      }
    }
  }
});

return false;
});

});

//---> Edit function

function editInquiry(id)

{
$.ajax({
url: base_url + 'inquiry/fetchInquiryDataById/'+id,
type: 'post',
dataType: 'json',
success:function(response) {
     $('[name="edit_inquiry_type"]').val(response.inquiry_type_id);
     $('[name="edit_support_type"]').val(response.support_type_id);
     $("#edit_request").val(response.request);
     $("#edit_feedback").val(response.feedback);
     $("#edit_answered_by").val(response.answered_by);
     $("#edit_inquiry_date").val(response.inquiry_date);




     // submit the update form
     $("#editFormInquiry").unbind('submit').bind('submit', function() {
        var form = $(this);

    // remove the text-danger
    $(".text-danger").remove();

    $.ajax({
      url: form.attr('action') + '/' + id,
      type: form.attr('method'),
      data: form.serialize(), // converting the form data into array and sending it to server
      dataType: 'json',
      success:function(response) {

        manageTableInternalCostPlan.ajax.reload(null, false);

        if(response.success === true) {

          // hide the modal
          $("#editModalInquiry").modal('hide');
          // reset the form
          $("#editFormInquiry .form-group").removeClass('has-error').removeClass('has-success');

        } else {

          if(response.messages instanceof Object) {
            $.each(response.messages, function(index, value) {
              var id = $("#"+index);

              id.closest('.form-group')
              .removeClass('has-error')
              .removeClass('has-success')
              .addClass(value.length > 0 ? 'has-error' : 'has-success');

              id.after(value);

            });
          } else {
            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>');
          }
        }
      }
    });

    return false;
  });

}
});
}

//---> Delete functions

function removeInquiry(id)
{
if(id) {
$("#removeFormInquiry").on('submit', function() {

  var form = $(this);

  // remove the text-danger
  $(".text-danger").remove();

  $.ajax({
    url: form.attr('action'),
    type: form.attr('method'),
    data: { inquiry_id:id },
    dataType: 'json',
    success:function(response) {

      manageTableInternalCostPlan.ajax.reload(null, false);

      if(response.success === true) {
       // hide the modal
        $("#removeModalInquiry").modal('hide');
      } else {
        $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
          '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
        '</div>');
      }

    }
  });

  return false;
});
}
}

</script>




<!----------------------------------------------------------------------------------------------------->
<!--                                                                                                 -->
<!--                                        D O C U M E N T                                         -->
<!--                                                                                                 -->
<!----------------------------------------------------------------------------------------------------->


<div id="document" class="tab-pane fade <?php echo (($active_tab === 'document') ? 'in active' : '') ?>">	

        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12 col-xs-12">


        <?php echo form_open_multipart('client/uploadDocument/') ?>

        <?php echo "<table width='100%'>" ?>
        <?php echo "<tr>" ?>

        <?php if(in_array('createDocument', $user_permission)): ?>

            <?php echo "<td width='25%'><div class='form_group'>" ?>
            <?php echo "<label for='document_type'>Type of document" ?>
            <?php echo "<select class='form-control select_group' id='document_type' name='document_type'>" ?>
            <?php echo "<option value=''></option>" ?>
                    <?php foreach ($document_type as $k => $v): ?>
                        <option value="<?php echo $v['id'] ?>" ><?php echo $v['name'] ?></option>
                    <?php endforeach ?> 
            <?php echo " </select></div>" ?>
            <?php echo "&nbsp;&nbsp;&nbsp;</label></td>" ?>

                    <?php echo "<td width='20%'><div class='form_group'>" ?>
            <?php echo "<label for='document_class'>Classification" ?>
            <?php echo "<select class='form-control select_group' id='document_class' name='document_class'>" ?>
            <?php echo "<option value=''></option>" ?>
                    <?php foreach ($document_class as $k => $v): ?>
                        <option value="<?php echo $v['id'] ?>" ><?php echo $v['name'] ?></option>
                    <?php endforeach ?> 
            <?php echo " </select></div>" ?>
            <?php echo "&nbsp;&nbsp;&nbsp;</label></td>" ?>

            <?php echo "<td width='40%' align=left><input type='file' required='required' name='client_document' id='client_document' size='60'  /></td>" ?> 
            <?php echo "<td width='15%'><input type='submit' name='submit' class='btn btn-primary' value='Add Document' /></td>" ?>
        <?php endif; ?>

        <?php echo "</tr>" ?>
        <?php echo "</table>" ?>
        <?php echo "</form>"?>



          <br>

          <div class="col-md-12 col-xs-12">
            <table id="manageTableDocument" class="table table-bordered table-striped" style="width:100%">
              <thead>
                <tr>
                  <th>Document</th>
                  <th>Type</th>
                  <th>Classification</th>
                  <th>Consultation No</th>
                  <th>Action</th>
                </tr>
              </thead>
            </table>
        </div>

      </div>
    </div>

    <div class="box-footer">
        <a href="<?php echo base_url('client/') ?>" class="btn btn-warning">Close</a>
    </div>

  </form>
</div>
</div>
</div>



<!--  End of the form  -->
                </div>
            </div>
        </div>
    </div>
</div>
</section>
</div>



<!-- Delete Document -->

<?php if(in_array('deleteDocument', $user_permission)): ?>

<div class="modal fade" tabindex="-1" role="dialog" id="removeDocumentModal">
<div class="modal-dialog" role="document">
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Delete Document</h4>
  </div>
  <form role="form" action="<?php echo base_url('client/removeDocument') ?>" method="post" id="removeFormDocument">
    <div class="modal-body">
      <p>Do you really want to delete?</p>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-primary">Delete</button>
    </div>
  </form>
</div>
</div>
</div>

<?php endif; ?>


<!------------------------------------->
<!-- Javascript part of Document    --->
<!------------------------------------->


<script type="text/javascript">
var manageTableDocument;
var base_url = "<?php echo base_url(); ?>";


$("#DocumentClientNav").addClass('active');


// initialize the datatable
manageTableDocument = $('#manageTableDocument').DataTable({
'ajax': base_url+'client/fetchClientDocument/'+'<?php echo $client_data['id']; ?>',
'order': [[0, "asc"]]
});


function removeDocument(id)
{
if(id) 
{
$("#removeFormDocument").on('submit', function() {

  var form = $(this);

  // remove the text-danger
  $(".text-danger").remove();

  $.ajax({
    url: form.attr('action'),
    type: form.attr('method'),
    data: { document_id:id },
    dataType: 'json',
    success:function(response) {

      manageTableDocument.ajax.reload(null, false);

      if(response.success === true) {
        // hide the modal
        $("#removeDocumentModal").modal('hide');

      } else {

        $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
          '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
        '</div>');
      }
    }
  });

  return false;
});
}
}
</script>