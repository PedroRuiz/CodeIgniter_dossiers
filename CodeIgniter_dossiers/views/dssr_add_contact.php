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
          <small>Add new contacts</small>
        </div>
      </div>

      <div class="my-3 p-3 bg-white rounded box-shadow">
        <?php if($contacts):?>
        <?php echo form_open( base_url("dossiers/add_contact/$id/add") )?>
        <table class="table table-striped table-bordered table-hover">
          <thead>
            <tr>
                <th>Add to dossier</th>
                <th>Mobile</th>
                
                <th>Image</th>
            </tr>
          </thead>  
            <tbody>
            
            <?php foreach($contacts as $contact):
              if( ! in_array($contact['id'],$existing) ):?>
            <tr  style="cursor: pointer" title="edit <?=$contact['shown_name']?>">
                <td><input type="checkbox" name="contact[<?=$contact['id']?>]" value="<?=$contact['id']?>"> <?=$contact['shown_name']?></td>
                <td><?=$contact['mobile']?></td>
                
                <td class="rowlink-skip"><?=(!$contact['image'])
                  ?
                  '<a href="'.base_url('/contacts/get_photo/'.$contact['id'].'/image.html').'"><i class="fas fa-user-secret"></i></a>'
                  :
                  '<img src="'.base_url($images.$contact['image']).'" width="32">' ;?></td>
            </tr>
            <?php endif; endforeach;?>
            </tbody>
        </table>
        <input type="submit" name="send" class="btn btn-lg btn-primary btn-block" value="Send">
        <?php echo form_close()?>
        <?php endif;?>
        
      </div>
    </main>
    
    <?php
          $this->load->view('inc/footer');
          $this->load->view('inc/scaffolding');
    ?>

    
  </body>
</html>
