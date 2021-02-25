
<div class="content-wrapper">
  <section class="content-header">
    <h1>Create Deliverable</h1>
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
          <form role="form" action="<?php base_url('workplan/create') ?>" method="post" enctype="multipart/form-data">
          <div class="box-body">
          <?php echo validation_errors(); ?>

          <div class="row">
            <div class="col-md-6 col-xs-6">
              <div class="form-group">
                  <label for="major_deliverable">Major Deliverable <font color="red">*</font></label>
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
   
        