<div class="content-wrapper">
  <section class="content-header">
    <h1>Edit Post </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('post') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Post </li>
    </ol>
  </section>


  <!-- Main content -->
  <section class="content">



<!----------------------------------------------------------------------------------------------------->
<!--                                                                                                 -->
<!--                                       Tab section                                               -->
<!--                                                                                                 -->
<!----------------------------------------------------------------------------------------------------->


      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#post">Post</a></li>
        <li><a data-toggle="tab" href="#document">Document</a></li>
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


         <!-- Creation of a temporary session to keep the information necessary for the manipulation
              of upload of documents -->

          <?php $this->session->unset_userdata('post_id');?>
          <?php if(empty($this->session->userdata('post_id'))) {
                $post_id = array('post_id' => $post_data['id']);
                $this->session->set_userdata($post_id);} ?>





<!----------------------------------------------------------------------------------------------------->
<!--                                                                                                 -->
<!--                                       P O S T                                                   -->
<!--                                                                                                 -->
<!----------------------------------------------------------------------------------------------------->


<div id="post" class="tab-pane fade in active">

      <div class="box">
        <form role="form" action="<?php base_url('post/update') ?>" method="post" enctype="multipart/form-data">
        <div class="box-body">

          <?php echo validation_errors(); ?>

          <!-- /row divide by 2 -->
          <div class="row">
					  <div class="col-md-4 col-xs-4">
              <div class="form-group">
                <label for="category">Category <font color="red">*</font></label>
                <select class="form-control select_group" id="category" name="category">
                  <option value=""></option>
                  <?php foreach ($category as $k => $v): ?>
                    <option value="<?php echo $v['id'] ?>"
                    <?php if(set_value('category', isset($post_data['category_id']) ? $post_data['category_id'] : '') == $v['id']) { echo "selected='selected'"; } ?> ><?php echo $v['name'] ?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>

  				   <div class="col-md-4 col-xs-4">
              <div class="form-group">
                <label for="date_from">Date from <font color="red">*</font></label>
                <input type="date" class="form-control" id="date_from" name="date_from" autocomplete="off"
                value="<?php echo set_value('date_from', isset($post_data['date_from']) ? $post_data['date_from'] : ''); ?>" />
              </div>
            </div>

				    <div class="col-md-4 col-xs-4">
              <div class="form-group">
                <label for="date_to">Date to <font color="red">*</font></label>
                <input type="date" class="form-control" id="date_to" name="date_to" autocomplete="off"
                value="<?php echo set_value('date_to', isset($post_data['date_to']) ? $post_data['date_to'] : ''); ?>" />
              </div>
            </div>
          </div>


  			  <div class="row">
      			<div class="col-md-12 col-xs-12">
              <div class="form-group">
                <label for="post_title">Title <font color="red">*</font></label>
                <input type="text" class="form-control" id="post_title" name="post_title" autocomplete="off"
                  value="<?php echo set_value('post_title', isset($post_data['post_title']) ? $post_data['post_title'] : ''); ?>" />
              </div>
            </div>
			    </div>


          <div class="row">

            <div class="col-md-12 col-xs-12">
              <div class="form-group">
                <label for="posted_by">Posted by <font color="red">*</font></label>
                <input type="text" class="form-control" id="posted_by" name="posted_by" autocomplete="off"
                value="<?php echo set_value('posted_by', isset($post_data['posted_by']) ? $post_data['posted_by'] : ''); ?>" />
              </div>
            </div>

          </div>


          <div class="form-group">
            <label for="post_text">Text <font color="red">*</font></label>
            <textarea type="text" class="ckeditor" id="post_text" name="post_text" autocomplete="off">
              <?php echo set_value('post_text', isset($post_data['post_text']) ? $post_data['post_text'] : ''); ?>
            </textarea>
          </div>

          <div class="row">
            <div class="col-md-4 col-xs-4">
              <div class="form-group">
                <input type="hidden" class="form-control" id="post_image" name="post_image"
                  value="<?php echo set_value('post_image', isset($post_data['post_image']) ? $post_data['post_image'] : ''); ?>" />
                <input type="hidden" class="form-control" id="doc_type" name="doc_type"
                  value="<?php echo set_value('doc_type', isset($post_data['doc_type']) ? $post_data['doc_type'] : ''); ?>" />  
                <label>Upload image</label>
                <?php echo set_value('post_image', isset($post_data['post_image']) ? $post_data['post_image'] : ''); ?>
                <input type="file" name="new_image" size="20" />
              </div>
             </div>

             <div class="col-md-4 col-xs-4">
              <div class="form-group">
                <label for="client_visibility">Client visibility</label>
                  <div class="radio">
                    <label><input type="radio" name="client_visibility" id="client_visibility" value=1 <?php if($post_data['client_visibility'] == 1) { echo "checked"; } ?> /> 
                    Visible&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    <label><input type="radio" name="client_visibility" id="client_visibility" value=2 <?php if($post_data['client_visibility'] == 2) { echo "checked"; } ?> /> 
                    Non Visible</label>
                  </div>
              </div>
            </div>  

            <div class="col-md-4 col-xs-4">
              <div class="form-group">
                <label for="active">Active</label>
                  <div class="radio">
                    <label><input type="radio" name="active" id="active" value=1 <?php if($post_data['active'] == 1) { echo "checked"; } ?> />
                    Active&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    <label><input type="radio" name="active" id="active" value=2 <?php if($post_data['active'] == 2) { echo "checked"; } ?> />
                    Inactive</label>
                  </div>
              </div>
            </div>
          </div>



        </div> <!-- /end box -->

        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Save</button>
          <a href="<?php echo base_url('post/') ?>" class="btn btn-warning">Close</a>
        </div>

      </form>
    </div>
  </div>


<!-- Javascript part of Post  -->

<script type="text/javascript">

  $(document).ready(function() {
    $(".select_group").select2();
  //  $("#post_text").wysihtml5();

    $("#mainPostNav").addClass('active');
    $("#managePostNav").addClass('active');

  });
</script>



<!----------------------------------------------------------------------------------------------------->
<!--                                                                                                 -->
<!--                                        D O C U M E N T                                         -->
<!--                                                                                                 -->
<!----------------------------------------------------------------------------------------------------->


 <div id="document" class="tab-pane fade">

      <div class="box">
        <div class="box-body">
          <div class="row">
            <div class="col-md-12 col-xs-12">


              <?php echo form_open_multipart('post/uploadDocument') ?>
              <?php echo "<table width='100%'>" ?>
              <?php echo "<tr>" ?>
              <?php echo "<td width='10%' align=left><input type='file' required='required' name='post_document' id='post_document' size='60'  /></td>" ?>
              <?php echo "<td><input type='submit' name='submit' class='btn btn-primary' value='Add Document' /></td>" ?>
              <?php echo "</tr>" ?>
              <?php echo "</table>" ?>
              <?php echo "</form>"?>

              <br>

              <div class="col-md-12 col-xs-12">
                <table id="manageTableDocument" class="table table-bordered table-striped" style="width:100%">
                  <thead>
                    <tr>
                      <th>Document</th>
                      <th>Size</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                </table>
            </div>
          </div>
        </div>

        <div class="box-footer">

            <a href="<?php echo base_url('post/') ?>" class="btn btn-default">Close</a>
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
      <form role="form" action="<?php echo base_url('post/removeDocument') ?>" method="post" id="removeFormDocument">
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
<!-- Javascript part of Document    --->
<!------------------------------------->


<script type="text/javascript">
var manageTableDocument;
var base_url = "<?php echo base_url(); ?>";


  $("#DocumentPostNav").addClass('active');

  // initialize the datatable
  manageTableDocument = $('#manageTableDocument').DataTable({
    'ajax': base_url+'post/fetchPostDocument/'+'<?php echo $post_data['id']; ?>',
    'order': [[0, "asc"]]
  });



function removeDocument(id)
{
  if(id) {
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
