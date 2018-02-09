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
          <small>Accounting</small>
        </div>
      </div>
      <div class="my-3 p-3 bg-white rounded box-shadow">
        <h6 class="border-bottom border-gray pb-2 mb-0">Enter Annotation</h6>
        

        
        <?php echo form_open(base_url("dossiers/accounting/$id/view.html"),array('class'=>'form-inline','role'=>'form')); ?>
          <div class="form-group">
            <label class="sr-only" for="date">Date</label>
            <input type="text" class="form-control" id="date" name="date" value="<?php echo set_value('date'); ?>"
                   placeholder="Date" autofocus>
            <div class="text-danger"><?=form_error('date')?></div>
          </div>
          <div class="form-group">
            <label class="sr-only" for="concept">Concept</label>
            <input type="text" class="form-control" id="concept" name="concept" value="<?php echo set_value('concept'); ?>"
                   placeholder="Concept" size="40">
            <div class="text-danger"><?=form_error('concept')?></div>
          </div>
           <div class="form-group">
            <label class="sr-only" for="debit">Debit</label>
            <input type="text" class="form-control" id="debit" name="debit" value="<?php echo set_value('debit'); ?>"
                   placeholder="Debit">
            <div class="text-danger"><?=form_error('debit')?></div>
          </div>
          <div class="form-group">
            <label class="sr-only" for="credit">Credit</label>
            <input type="text" class="form-control" id="credit" name="credit" value="<?php echo set_value('credit'); ?>"
                   placeholder="Credit">
            <div class="text-danger"><?=form_error('credit')?></div>
          </div>
          
            
          <button type="submit" class="btn btn-primary">Send</button>
        <?php echo form_close(); ?>
      </div>
      <?php if($numlines=!0): $j=0;?>
      <div class="my-3 p-3 bg-white rounded box-shadow">
        <h6 class="border-bottom border-gray pb-2 mb-0">Dossier accounting details</h6>
      
      <table class="table table-responsive table-striped">
        <thead>
          <tr>
            <td><strong>#</strong></td>
            <td><strong>D. Enter</strong></td>
            <td><strong>Date</strong></td>
            <td><strong>Concept</strong></td>
            <td class="text-right"><strong><?=sprintf('%10s','Debit')?></strong></td>
            <td class="text-right"><strong><?=sprintf('%10s','Credit')?></strong></td>
            <td class="text-right"><strong><?=sprintf('%10s','Balance')?></strong></td>
          </tr>
        </thead>
        
        <tbody>
          <?php foreach($accounting as $row):?>
          <tr>
            <td><?=++$j?></td>
            <td><?=date('d-m-Y',strtotime($row['date_creation']))?></td>
            <td><?=date('d-m-Y',strtotime($row['date']))?></td>
            <td><?=sprintf('%10s',$row['concept'])?></td>
            <td class="text-right"><?=$row['debit']?></td>
            <td class="text-right"><?=$row['credit']?></td>
            <td></td>
          </tr>
          <?php endforeach;?>
        </tbody>
        
        <tfoot>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right"><strong><?=$debit?></strong></td>
            <td class="text-right"><strong><?=$credit?></strong></td>
            <td class="text-right"><strong><?=(real) $total?></strong></td>
          </tr>
        </tfoot>
      </table>
      </div>
      <?php endif;?>
    </main>
    
    <?php
          $this->load->view('inc/footer');
          $this->load->view('inc/scaffolding');
    ?>

    
  </body>
</html>
