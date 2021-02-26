<div class="content-wrapper">

  <section class="content-header">
    <h1>Edit Workplan</h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('workplan') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Workplan</li>
    </ol>
    <section>

      <br>

      <!----------------------------------------------------------------------------------------------------->
      <!--                                                                                                 -->
      <!--                                        Session variables                                        -->
      <!--                                                                                                 -->
      <!----------------------------------------------------------------------------------------------------->

      <!-- Creation of a temporary session to keep the directory and information necessary for the manipulation
                  of upload of documents -->

      <?php $this->session->unset_userdata('technical_advice_id'); ?>
      <?php if (empty($this->session->userdata('technical_advice_id'))) {
        $technical_advice_id = array('technical_advice_id' => $wkplan_data['workplan']['ta_id']);
        $this->session->set_userdata($technical_advice_id);
      } ?>

      <?php $this->session->unset_userdata('workplan_id'); ?>
      <?php if (empty($this->session->userdata('workplan_id'))) {
        $workplan_id = array('workplan_id' => $wkplan_data['workplan']['id']);
        $this->session->set_userdata($workplan_id);
      } ?>


      <!----------------------------------------------------------------------------------------------------->
      <!--                                                                                                 -->
      <!--                             Error messages generated by the submit                              -->
      <!--                                                                                                 -->
      <!----------------------------------------------------------------------------------------------------->


      <section class="content">

        <div class="row">
          <div class="col-md-12 col-xs-12">

            <div id="messages"></div>

            <?php if ($this->session->flashdata('success')) : ?>

              <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo $this->session->flashdata('success'); ?>
              </div>

            <?php elseif ($this->session->flashdata('error')) : ?>
              <div class="alert alert-error alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo $this->session->flashdata('error'); ?>
              </div>
            <?php endif; ?>
            <div class="tab-content">

              <!----------------------------------------------------------------------------------------------------->
              <!--                                                                                                 -->
              <!--                                        WORKPLAN                                                 -->
              <!--                                                                                                 -->
              <!----------------------------------------------------------------------------------------------------->


              <div class="box">

                <div class="box-body">
                  <form role="form" action="<?php base_url('workplan/update') ?>" method="post" enctype="multipart/form-data">

                    <?php echo validation_errors(); ?>

                    <div class="row">

                      <div class="col-md-6 col-xs-6">
                        <div class="form-group">
                          <label for="major_deliverable">Major Deliverable <font color="red">*</font></label>
                          <input type="text" class="form-control" id="major_deliverable" name="major_deliverable" autocomplete="off" value="<?php echo set_value('major_deliverable', isset($wkplan_data['workplan']['major_deliverable']) ? $wkplan_data['workplan']['major_deliverable'] : ''); ?>">
                        </div>
                      </div>

                      <div class="col-md-3 col-xs-3">
                        <div class="form-group">
                          <label for="start_date">Start date <font color="red">*</font></label>
                          <input type="date" class="form-control" id="start_date" name="start_date" autocomplete="off" value="<?php echo set_value('start_date', isset($wkplan_data['workplan']['start_date']) ? $wkplan_data['workplan']['start_date'] : ''); ?>" />
                        </div>
                      </div>


                      <div class="col-md-3 col-xs-3">
                        <div class="form-group">
                          <label for="end_date">End date <font color="red">*</font></label>
                          <input type="date" class="form-control" id="end_date" name="end_date" autocomplete="off" value="<?php echo set_value('end_date', isset($wkplan_data['workplan']['end_date']) ? $wkplan_data['workplan']['end_date'] : ''); ?>" />
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                      <a href="<?php echo base_url('workplan/') ?>" class="btn btn-warning">Close</a>
                    </div>
                  </form>

                  <div class="box-footer">
                    <div class="col-md-12 col-xs-12">
                      <?php if (in_array('createWorkPlan', $user_permission)) : ?>
                        <button id="addTaskButton" class="btn btn-primary" data-toggle="modal" data-target="#createModalTask">Add Task</button>
                      <?php endif; ?>
                      <table id="manageTableTask" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                          <tr>
                            <th>Task</th>
                            <th>Entity</th>
                            <th>Responsible Officer</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <?php if (in_array('updateWorkPlan', $user_permission) || in_array('deleteWorkPlan', $user_permission)) : ?>
                              <th>Action</th>
                            <?php endif; ?>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                  <!-- Add Work Plan Task -------------------------------------------------------------------------------->

                  <?php if (in_array('createWorkPlan', $user_permission)) : ?>
                    <div class="modal fade" tabindex="-1" role="dialog" id="createModalTask">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Add Task</h4>
                          </div>

                          <form role="form" action="<?php echo base_url('workplan/addWorkPlanTask') ?>" method="post" id="createFormTask">

                            <div class="modal-body">

                              <div class="form-group">
                                <label for="task">Task<font color="red"> *</font></label>
                                <textarea class="form-control" id="task" name="task" autocomplete="off"></textarea>
                              </div>

                              <div class="form-group">
                                <label for="entity">Entity</label>
                                <input type="text" class="form-control" id="entity" name="entity" autocomplete="off">
                              </div>

                              <div class="form-group">
                                <label for="responsible_officer">Responsible Officer</label>
                                <input type="text" class="form-control" id="responsible_officer" name="responsible_officer" autocomplete="off">
                              </div>

                              <div class="row">
                                <div class="col-md-6 col-xs-6">
                                  <div class="form-group">
                                    <label for="Email">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" autocomplete="off">
                                  </div>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                  <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" autocomplete="off">
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-6 col-xs-6">
                                  <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" class="form-control" id="s_date" name="s_date" autocomplete="off">
                                  </div>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                  <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="date" class="form-control" id="e_date" name="e_date" autocomplete="off">
                                  </div>
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="status">Status</label>
                                <input type="text" class="form-control" id="status" name="status" autocomplete="off">
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

                  <!-- Edit Work Plan Task --------------------------------------------------------------------------------->

                  <?php if (in_array('updateWorkPlan', $user_permission)) : ?>
                    <div class="modal fade" tabindex="-1" role="dialog" id="editModalTask">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Edit Inquiry</h4>
                          </div>

                          <form role="form" action="<?php echo base_url('workplan/updateWorkPlanTask') ?>" method="post" id="editFormTask">
                            <div class="modal-body">

                              <div class="form-group">
                                <label for="task">Task<font color="red"> *</font></label>
                                <textarea class="form-control" id="edit_task" name="edit_task" autocomplete="off"></textarea>
                              </div>

                              <div class="form-group">
                                <label for="entity">Entity</label>
                                <input type="text" class="form-control" id="edit_entity" name="edit_entity" autocomplete="off">
                              </div>

                              <div class="form-group">
                                <label for="responsible_officer">Responsible Officer</label>
                                <input type="text" class="form-control" id="edit_responsible_officer" name="edit_responsible_officer" autocomplete="off">
                              </div>

                              <div class="row">
                                <div class="col-md-6 col-xs-6">
                                  <div class="form-group">
                                    <label for="Email">Email</label>
                                    <input type="text" class="form-control" id="edit_email" name="edit_email" autocomplete="off">
                                  </div>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                  <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" id="edit_phone" name="edit_phone" autocomplete="off">
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-6 col-xs-6">
                                  <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" class="form-control" id="edit_s_date" name="edit_s_date" autocomplete="off">
                                  </div>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                  <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="date" class="form-control" id="edit_e_date" name="edit_e_date" autocomplete="off">
                                  </div>
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="status">Status</label>
                                <input type="text" class="form-control" id="edit_status" name="edit_status" autocomplete="off">
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

                  <!-- Delete Work Plan Task --------------------------------------------------------------------------------->

                  <?php if (in_array('deleteWorkPlan', $user_permission)) : ?>

                    <div class="modal fade" tabindex="-1" role="dialog" id="removeModalTask">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Delete Task</h4>
                          </div>

                          <form role="form" action="<?php echo base_url('workplan/removeTask') ?>" method="post" id="removeFormTask">
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

                  <div class="box-footer">
                    <div class="col-md-12 col-xs-12">
                      <?php if (in_array('createWorkPlan', $user_permission)) : ?>
                        <button id="addNoteButton" class="btn btn-primary" data-toggle="modal" data-target="#editModalNote">Add Note</button>
                        <br /> <br />
                      <?php endif; ?>
                      <table style="width:100%" id="manageTableNotes" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                          <tr>
                            <th style="width:60%">Notes</th>
                            <th style="width:20%">Date Updated</th>
                            <th style="width:20%">Updated By</th>
                            <!-- <?php if (in_array('updateWorkPlan', $user_permission) || in_array('deleteWorkPlan', $user_permission)) : ?>
                              <th>Action</th>
                            <?php endif; ?> -->
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>

                  <!-- Monitoring Notes for the Work Plan  -->
                  <?php if (in_array('createWorkPlan', $user_permission)) : ?>
                    <div class="modal fade" tabindex="-1" role="dialog" id="editModalNote">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Monitoring Note</h4>
                          </div>

                          <form role="form" action="<?php echo base_url('workplan/createMonitoringNote') ?>" method="post" id="editFormMonitoring">
                            <div class="modal-body">

                              <div class="form-group">
                                <label for="monitoring_note">Monitoring Note<font color="red"> *</font></label>
                                <textarea class="form-control" id="monitoring_note" name="monitoring_note" rows="3" autocomplete="off"></textarea>
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

                </div>
              </div>
            </div>
          </div>
      </section>
    </section>
  </section>
</div>


<!-----------------------------------------   Javascript  --------------------------------------->
<script type="text/javascript">
  var manageTableTask;
  var manageTableNotes;
  var monitoring_note = document.getElementById("monitoring_note");
  var base_url = "<?php echo base_url(); ?>";



  $(document).ready(function() {

    // initialize the datatable for Tasks
    manageTableTask = $('#manageTableTask').DataTable({
      'ajax': base_url + 'workplan/fetchWorkPlanTaskData/' + <?php echo $wkplan_data['workplan']['id']; ?>,
      'order': [
        [0, 'desc']
      ],
      "scroolY": "200px",
      "scrollCollaps": true,
      "paging": false
    });

    // initialize the datatable for Tasks
    manageTableNotes = $('#manageTableNotes').DataTable({
      'ajax': base_url + 'workplan/fetchMonitoringNotes/' + <?php echo $wkplan_data['workplan']['id']; ?>,
      'order': [
        [0, 'desc']
      ]
    });


    //--> Submit Create Form
    $("#createFormTask").unbind('submit').on('submit', function() {
      var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: form.serialize(), // /converting the form data into array and sending it to server
        dataType: 'json',
        success: function(response) {

          manageTableTask.ajax.reload(null, false);

          if (response.success === true) {

            // hide the modal
            $("#createModalTask").modal('hide');

            // reset the form
            $("#createFormTask")[0].reset();
            $("#createFormTask .form-group").removeClass('has-error').removeClass('has-success');

          } else {

            if (response.messages instanceof Object) {
              $.each(response.messages, function(index, value) {
                var id = $("#" + index);

                id.closest('.form-group')
                  .removeClass('has-error')
                  .removeClass('has-success')
                  .addClass(value.length > 0 ? 'has-error' : 'has-success');

                id.after(value);

              });
            } else {
              $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.messages +
                '</div>');
            }
          }
        }
      });

      return false;
    });

  });

  //--> Submit Create Form for Notes
  $("#editFormMonitoring").unbind('submit').on('submit', function() {
    var form = $(this);

    // remove the text-danger
    $(".text-danger").remove();

    $.ajax({
      url: form.attr('action'),
      type: form.attr('method'),
      data: form.serialize(), // /converting the form data into array and sending it to server
      dataType: 'json',
      success: function(response) {

        manageTableNotes.ajax.reload(null, false);

        if (response.success === true) {

          // hide the modal
          $("#editModalNote").modal('hide');

          // reset the form
          $("#editFormMonitoring")[0].reset();
          $("#editFormMonitoring .form-group").removeClass('has-error').removeClass('has-success');

        } else {

          if (response.messages instanceof Object) {
            $.each(response.messages, function(index, value) {
              var id = $("#" + index);

              id.closest('.form-group')
                .removeClass('has-error')
                .removeClass('has-success')
                .addClass(value.length > 0 ? 'has-error' : 'has-success');

              id.after(value);

            });
          } else {
            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.messages +
              '</div>');
          }
        }
      }
    });

    return false;
  });


  //---> Edit function for work plan task

  function editTask(id) {
    $.ajax({
      url: base_url + 'workplan/fetchWorkPlanTaskDataById/' + id,
      type: 'post',
      dataType: 'json',
      success: function(response) {
        $("#edit_task").val(response.task);
        $("#edit_entity").val(response.entity);
        $("#edit_responsible_officer").val(response.responsible_officer);
        $("#edit_email").val(response.email);
        $("#edit_phone").val(response.phone);
        $("#edit_s_date").val(response.s_date);
        $("#edit_e_date").val(response.e_date);
        $("#edit_status").val(response.status_id);


        // submit the update form
        $("#editFormTask").unbind('submit').bind('submit', function() {
          var form = $(this);

          // remove the text-danger
          $(".text-danger").remove();

          $.ajax({
            url: form.attr('action') + '/' + id,
            type: form.attr('method'),
            data: form.serialize(), // converting the form data into array and sending it to server
            dataType: 'json',
            success: function(response) {

              manageTableTask.ajax.reload(null, false);

              if (response.success === true) {

                // hide the modal
                $("#editModalTask").modal('hide');
                // reset the form
                $("#editFormTask .form-group").removeClass('has-error').removeClass('has-success');

              } else {

                if (response.messages instanceof Object) {
                  $.each(response.messages, function(index, value) {
                    var id = $("#" + index);

                    id.closest('.form-group')
                      .removeClass('has-error')
                      .removeClass('has-success')
                      .addClass(value.length > 0 ? 'has-error' : 'has-success');

                    id.after(value);

                  });
                } else {
                  $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                    '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.messages +
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

  //---> Delete function for workplan task
  function removeFunc(id) {
    if (id) {
      $("#removeFormTask").on('submit', function() {

        var form = $(this);

        // remove the text-danger
        $(".text-danger").remove();

        $.ajax({
          url: form.attr('action'),
          type: form.attr('method'),
          data: {
            task_id: id
          },
          dataType: 'json',
          success: function(response) {

            manageTableTask.ajax.reload(null, false);

            if (response.success === true) {
              // hide the modal
              $("#removeModalTask").modal('hide');
            } else {
              $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.messages +
                '</div>');
            }

          }
        });

        return false;
      });
    }
  }

  function createNote(id) {

  }
</script>