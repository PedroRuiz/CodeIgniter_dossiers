<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
  <?=$this->load->view('inc/text_head.php',array('page_title'=>'Kybalion | Dossiers'),TRUE)?>

  <body class="bg-light">

    <?$this->load->view('inc/nav.main.php',array('dossiers_active'=>TRUE))?>
    <?$this->load->view('dssr_dossier_subnav')?>

    
    <main role="main" class="container">
      <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-dossier rounded box-shadow">
        <img class="mr-3" src="/assets/img/logo.svg" alt="" width="48" height="48">
        <div class="lh-100">
          <h6 class="mb-0 text-white lh-100"><?=$dossier['name']?></h6>
          <small></small>
        </div>
      </div>
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <h6 class="border-bottom border-gray pb-2 mb-0">Text WYSIWYG</h6>
        <div class="media text-muted pt-3 col-md-12">
        <?=form_open(base_url("dossiers/text_update/{$text['id']}/{$dossier['id']}"),array('id'=>'frmArticle','role'=>'form'))?>                    
                    <label>Content</label>
                    <textarea id="article" name="text" rows="8" class="form-control"><?=(!is_null($text['text'])) ? $text['text'] : NULL;?></textarea>
                    <input class="btn btn-info btn-block" type="submit" value="Send text" name="submit">
                   
        <?=form_close()?>
   
        
    </div>
      
    </main>
    
    <?php
          $this->load->view('inc/footer');
          $this->load->view('inc/scaffolding');
    ?>
    
    
  </body>
</html>
