<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!doctype html>
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
          <small>dossier at a glance</small>
        </div>
      </div>
      <div class="my-3 p-3 bg-white rounded box-shadow">
        <h6 class="border-bottom border-gray pb-2 mb-0">Contacts in dossier</h6>
        <?php foreach($contacts as $contact):?>
        <div class="media text-muted pt-3">
          <img src="<?=base_url("$images{$contact['image']}")?>" alt="" class="mr-2 rounded" width="32">
          <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray" onclick="window.location.href='<?=base_url('contacts/edit/'.$contact['id'].'/contact.html')?>'" style="cursor: pointer" title="Edit: <?=sprintf('%s %s',$contact['first_name'],$contact['last_name'])?>">
            <strong class="d-block text-gray-dark">
            <?=sprintf("%s %s %s %s %s<br>%s%s",
                       $contact['first_name'],
                       $contact['last_name'],
                       ($contact['mobile']) ? '(Mobile:'.$contact['mobile'].')' : NULL,
                       ($contact['home_phone']) ? '(Home phone:'.$contact['home_phone'].')' : NULL,
                       ($contact['work_phone']) ? '(Work phone:'.$contact['work_phone'].')' : NULL,
                       ($contact['first_email'])? $contact['first_email'] : NULL,
                       ($contact['second_email'])? ', '.$contact['second_email'] : NULL
                       )
            ?>
            </strong>
          </p>
          <p><small><a class="btn btn-sm btn-danger" href="<?=base_url("dossiers/unlink_contact/$id/".$contact['id'])?>">unlink of project</a></small></p>
        </div>
       
        <?php endforeach;?>
        
      </div>
      
      <?php if($files):?>
      <div class="my-3 p-3 bg-white rounded box-shadow">
        <h6 class="border-bottom border-gray pb-2 mb-0">Files in dossier</h6>
        <?php foreach($files as $file): ?>
        <div class="media text-muted pt-3">
          <img src="<?=base_url("assets/dossiers/files/".$file['file_name'])?>" alt="" class="mr-2 rounded" width="64">
          <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray" onclick="window.location.href='<?=base_url("$file_folder/".$file['file_name'])?>'" style="cursor: pointer" title="View: <?=sprintf('%s',$file['file_name'])?>">
            <strong class="d-block text-gray-dark">
            <?=sprintf("%s %s<br>%s",
                       $file['file_name'],
                       '',//$file['file_ext'],
                       ($file['array']['image_type']) ? '(Image Type:'.$file['array']['image_type'].')' : NULL,
                       ($file['array']['image_size_str']) ? '(Size:'.$file['array']['image_size_str'].')' : NULL
                       )
            ?>
            </strong>
          </p>
          <p><small><a class="btn btn-sm btn-danger" href="<?=base_url('dossiers/unlink_files/'.$file['id'])?>">unlink of project</a></small></p>
        </div>
       
        <?php endforeach;?>
        
      </div>
      <?php endif;?>
      
      <?php  if($numlines!=0): setlocale(LC_MONETARY, 'es_ES');?>
      <div class="my-3 p-3 bg-white rounded box-shadow">
        <h6 class="border-bottom border-gray pb-2 mb-0">Accounting Balance</h6>
         <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
          <?=
            sprintf("Debit: %'.19G\n<br>Credit: %'.18G\n<br>Balance: <strong>%'.14G\n</strong>",
                      0.0+$debit,
                      0.0+$credit,
                      $total
                    );
          ?>
         </p>
      <?php endif;?>
      
      <?php if(count($texts)>0):?>
      <div class="my-3 p-3 bg-white rounded box-shadow">
        <h6 class="border-bottom border-gray pb-2 mb-0">Texts in dossier</h6>
        <?php foreach($texts as $text): ?>
        <!--div class="media text-muted pt-3"-->
         <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
          <?php
            $_text=html_entity_decode($text['text']);
            echo (strlen($_text)>50) ? substr($_text,0,50).'  <small class="text-muted">...(more)</small>' : $_text;
            ?>
          <a href="<?=base_url("dossiers/text_update/{$text['id']}/{$text['id_dossier']}")?>" class="btn btn-sm btn-warning">Edit</a>&nbsp;
          <a href="<?=base_url("dossiers/text_delete/{$text['id']}/{$text['id_dossier']}")?>" class="btn btn-sm btn-danger">Unlink</a>
         </p>
        <!--/div-->
       
        <?php endforeach;?>
        
      </div>
      <?php endif;?>
    </main>
    
    <?php
          $this->load->view('inc/footer');
          $this->load->view('inc/scaffolding');
    ?>
    <script>
      $('#summernote').summernote({
        placeholder: 'Enter your wonderfull text here',
        tabsize: 2,
        height: 100
      });
    </script>
    
  </body>
</html>
