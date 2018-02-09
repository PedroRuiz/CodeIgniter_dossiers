<div class="nav-scroller bg-white box-shadow">
      <nav class="nav nav-underline">
           
      <strong><?php echo anchor('dossiers/dossier/'.$id.'/view', $dossier['name'], array('class'=>'nav-link'))?></strong>
        <?php echo anchor('dossiers/add-contact/'.$id.'/add', 'Add contact', array('class'=>'nav-link'))?>
        <?php echo anchor('dossiers/add_files/'.$id.'/add', 'Add file', array('class'=>'nav-link'))?>
        <?php echo anchor('dossiers/accounting/'.$id.'/view', 'Accounting', array('class'=>'nav-link'))?>
        <?php echo anchor('dossiers/text/'.$id.'/view', 'Text', array('class'=>'nav-link'))?>
        
        <?php /*
        <a class="nav-link" href="#">Link</a>
        <a class="nav-link" href="#">Link</a>
        <a class="nav-link" href="#">Link</a>
        <a class="nav-link" href="#">Link</a>
        */?>
      </nav>
    </div>