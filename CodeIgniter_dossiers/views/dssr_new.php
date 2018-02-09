<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!doctype html>
<html lang="en">
  <?=$this->load->view('inc/head.php',array('page_title'=>'Kybalion | Dossiers'),TRUE)?>

  <body class="bg-light">

    <?$this->load->view('inc/nav.main.php',array('dossiers_active'=>TRUE))?>
    <?$this->load->view('dssr_subnav')?>

    
    <main role="main" class="container">
      <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-dossier rounded box-shadow">
        <img class="mr-3" src="/assets/img/logo.svg" alt="" width="48" height="48">
        <div class="lh-100">
          <h6 class="mb-0 text-white lh-100">Dossiers</h6>
          <small>New</small>
        </div>
      </div>

      <div class="my-3 p-3 bg-white rounded box-shadow">
        <h6 class="border-bottom border-gray pb-2 mb-0">Create a new dossier</h6>
        
        <div class="my-3 p-3 bg-white rounded box-shadow">
        
            <?=form_open(base_url('dossiers/new'),array('class'=>'form-horizontal','role'=>'form'))?>
              <div class="form-group">
                <label for="dssr_name" class="col-lg-2 control-label">Dossier name</label>
                <div class="col-lg-10">
                  <input type="text" class="form-control" name="dssr_name" value="<?=(isset($dsr_name)) ? $dssr_name : set_value('dssr_name');?>" id="dssr_name" placeholder="Dossier name" autofocus>
                  <div class="text-danger"><?php echo form_error('dssr_name'); ?></div>
                </div>
              </div>
              
              
              <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                  <button class="btn btn-lg btn-primary btn-block" type="submit">Create</button>
                </div>
              </div>
            <?=form_close()?>


      </div>
        
        <small class="d-block text-right mt-3">
          <a href="#">All updates</a>
        </small>
      </div>

      
      
    </main>
    
    <?php
          $this->load->view('inc/footer');
          $this->load->view('inc/scaffolding');
    ?>

    
  </body>
</html>
