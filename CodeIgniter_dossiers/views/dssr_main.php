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
          <small></small>
        </div>
      </div>

      <?php if ($dossiers):?>
      <div class="my-3 p-3 bg-white rounded box-shadow">
        <h6 class="border-bottom border-gray pb-2 mb-0">Dossiers</h6>
        
        <?php foreach($dossiers as $dossier):?>
        <a href="<?=base_url('dossiers/dossier/'.$dossier['id'].'/view.html')?>">
        <div class="media text-muted pt-3">
          <img data-src="holder.js/32x32?theme=thumb&bg=FA5882&fg=FA5882&size=1" alt="" class="mr-2 rounded">
          <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
            <strong class="d-block text-gray-dark"><?=sprintf('%s %s',$dossier['name'],'')?></strong>
            <?=sprintf('Date creation: <strong>%s</strong>, <br>Status: <strong>%s</strong>,<br>Owner: <strong>%s</strong>.',
                       date('d-m-Y',strtotime($dossier['date_creation'])),
                       $dossier['status'],
                       sprintf('%s %s',$this->ion_auth->user($dossier['owned_user'])->row()->first_name,$this->ion_auth->user($dossier['owned_user'])->row()->last_name)
            )?>
          </p>
        </div>
        </a>
        <?php endforeach;?>        
      </div>
      <?php endif;?>
    </main>
    
    <?php
          $this->load->view('inc/footer');
          $this->load->view('inc/scaffolding');
    ?>

    
  </body>
</html>
