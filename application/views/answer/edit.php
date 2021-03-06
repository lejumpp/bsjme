<div class="content-wrapper">

<!-----------------------------------------------------------------------------------------------------> 
<!--                                                                                                 --> 
<!--                             Error messages generated by the submit                              -->  
<!--                                                                                                 -->  
<!-----------------------------------------------------------------------------------------------------> 

       <!-- Main content -->
    <section class="content">

    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

        <?php if($this->session->flashdata('success')): ?>
          <!--<div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>--> 
        <?php elseif($this->session->flashdata('error')): ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>

        <div class="tab-content">




<!-----------------------------------------------------------------------------------------------------> 
<!--                                                                                                 --> 
<!--                                        Q U E S T I O N                                          -->  
<!--                                                                                                 -->  
<!----------------------------------------------------------------------------------------------------->        




      <div class="box">
          <form role="form" action="<?php base_url('consultation/answerQuestion') ?>" method="post" enctype="multipart/form-data">
              <div class="box-body">

                <?php echo validation_errors(); ?>  

                <div class="row"> 

                   <div class="col-md-8 col-xs-8">
                     <div class="form-group">
                        <br>
                        <label for="question"><?php echo $question_data['question']['question']; ?></label>
                        <br><br>
                        <?php
                            //echo ;
                            if($question_data['question']['question_type_id']==1 || $question_data['question']['question_type_id']==2)//CHECK IF QUESTION TYPE IS A TEXT OR TEXTAREA
                            {
                                echo"
                                    <textarea style='overflow:auto;resize:none' class='form-control' rows='1' name='response".'[]'."'>".set_value('response', isset($question_data['question_response'][0]) ? $question_data['question_response'][0] : '' )."</textarea>
                                ";
                            }
                            elseif($question_data['question']['question_type_id']==3 || $question_data['question']['question_type_id']==4)//CHECK IF QUESTION TYPE IS A BOOLEAN OR RADIO
                            {
                                if(array_key_exists('question_option', $question_data) && !empty($question_data['question_option']))
                                {
                                  foreach($question_data['question_option'] as $option)
                                  {
                                    echo"
                                    <div class='radio'>
                                        <label>
                                            <input type='radio' name='response".'[]'."'  value='".$option['id']."' "; if(array_key_exists('question_response', $question_data) && !empty($question_data['question_response'])){if($question_data['question_response'][0]==$option['id']){echo "checked='checked'";}} echo">".$option['ques_option']."
                                        </label>
                                    </div>
                                    ";
                                  }
                                }
                            }
                            elseif($question_data['question']['question_type_id']==5)//CHECK IF QUESTION TYPE IS A DROP DOWN LIST
                            {
                              if(array_key_exists('question_option', $question_data) && !empty($question_data['question_option']))
                              {
                                echo"
                                  <select class='form-control select_group' name='response".'[]'."'>
                                    <option value='' selected>Select One</option>";
                                    foreach($question_data['question_option'] as $option)
                                    {
                                      echo"
                                      <option value='".$option['id']."'"; if(array_key_exists('question_response', $question_data) && !empty($question_data['question_response'])){if($question_data['question_response'][0]==$option['id']){echo "selected='selected'";}} echo ">".$option['ques_option']."</option>
                                      ";
                                    }
                                  echo"
                                  </select>
                                ";
                              }
                            }
                            elseif($question_data['question']['question_type_id']==6)//CHECK IF QUESTION TYPE IS A CHECKBOX
                            {
                              if(array_key_exists('question_option', $question_data) && !empty($question_data['question_option']))
                              {
                                $x=0;
                                foreach($question_data['question_option'] as $option)
                                {
                                  echo"
                                  <div class='form-check'>
                                    <label class='form-check-label'>
                                        <input type='checkbox' class='form-check-input' name='response".'[]'."' value='".$option['id']."'";if(array_key_exists('question_response', $question_data) && !empty($question_data['question_response'])){if($question_data['question_response'][$x]==$option['id']){echo "checked='checked'"; $x++;}} echo ">".$option['ques_option']."
                                    </label>
                                  </div>
                                  ";                                  
                                }
                              }                                
                            }
                        ?>
                    </div>
                  </div>                
                </div>                   
              </div>    <!-- /.box-body -->

              <div class="box-footer">
              <?php if(in_array('updateAnswers', $user_permission)): ?>
                <button type="submit" class="btn btn-primary">Save Changes</button>
              <?php endif; ?>
                <a href="<?php echo base_url('consultation/update/'.$consultationId); ?>" class="btn btn-warning">Close</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>







