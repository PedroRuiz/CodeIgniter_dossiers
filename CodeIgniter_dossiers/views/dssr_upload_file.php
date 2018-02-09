<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!doctype html>
<html lang="en">
  <?=$this->load->view('inc/head.php',array('page_title'=>'Kybalion | Dossiers'),TRUE)?>

  <body class="bg-light">

    <?$this->load->view('inc/nav.main.php',array('dossiers_active'=>TRUE))?>
    <?$this->load->view('dssr_dossier_subnav')?>

    
    <main role="main" class="container">
    
      <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-dossier rounded box-shadow">
        <img class="mr-3" src="/assets/img/logo.svg" alt="" width="48" height="48">
        <div class="lh-100">
          <h6 class="mb-0 text-white lh-100"><?=$dossier['name']?></h6>
          <small>dossier at a glance</small>
        </div>
      </div>
      <div class="my-3 p-3 bg-white rounded box-shadow">
        <h6 class="border-bottom border-gray pb-2 mb-0">Upload files in dossier</h6>
        <?php echo $error;?>

        <?php echo form_open_multipart(base_url("dossiers/do_upload_files/$id"));?>
        
        <input type="file" name="userfile" size="20" />
        
        <br /><br />
        
        <input type="submit" value="upload" />
        
        <?=form_close()?>
        
      </div>
    </main>
    
    <?php
          $this->load->view('inc/footer');
          $this->load->view('inc/scaffolding');
    ?>

    
  </body>
</html>
