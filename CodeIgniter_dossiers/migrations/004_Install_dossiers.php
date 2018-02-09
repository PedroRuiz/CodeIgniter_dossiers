<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Install_dossiers extends CI_Migration {
	private $tables;

	public function __construct() {
		parent::__construct();
		$this->load->dbforge();

		$this->load->add_package_path(APPPATH.'third_party/CodeIgniter_dossiers');
		$this->load->config('dossiers', TRUE);
		
		$this->tables = array(
            'table'             =>  $this->config->item('dssr_table', 'dossiers'),
            'contacts'          =>  $this->config->item('dssr_contacts', 'dossiers'),
            'files'             =>  $this->config->item('dssr_files', 'dossiers'),
            'accounting'        =>  $this->config->item('dssr_accounting', 'dossiers'),
            'users'             =>  $this->config->item('dssr_users', 'dossiers'),
            'content'           =>  $this->config->item('dssr_content', 'dossiers'),
            'text'              =>  $this->config->item('dssr_texts', 'dossiers'),
        );
	}

	public function up() {
		// Drop table 'table' if it exists
		$this->dbforge->drop_table($this->tables['table'], TRUE);

		// Table structure for table 'table'
		$this->dbforge->add_field(array(
			'id' => array(
				'type'           => 'MEDIUMINT',
				'constraint'     => '8',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
			'date_creation' => array(
				'type'      => 'timestamp',
			),
			'name' => array(
				'type'       => 'VARCHAR',
				'constraint' => '100',
				'null'		 =>	FALSE,
			),
            'status'    =>  array(
                'type'              =>  "ENUM",
                'constraint'        =>  'Active','Inactive',
                'default'           =>  'Active'
            ),
			'owned_user' => array(
                'type'           => 'MEDIUMINT',
				'constraint'     => '8',
				'unsigned'       => TRUE,        
            ),
		));
		
		
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table($this->tables['table']);
        
        // Drop table 'contacts' if it exists
		$this->dbforge->drop_table($this->tables['contacts'], TRUE);

		// Table structure for table 'contacts'
		$this->dbforge->add_field(array(
			'id' => array(
				'type'           => 'MEDIUMINT',
				'constraint'     => '8',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
			'id_dossier' => array(
				'type'           => 'MEDIUMINT',
				'constraint'     => '8',
				'unsigned'       => TRUE,
			),
			'id_contact' => array(
                'type'           => 'MEDIUMINT',
				'constraint'     => '8',
				'unsigned'       => TRUE,
            ),
			
		));
		
		
		$this->dbforge->add_key('id', TRUE);
        $this_table=$this->tables['contacts'];
		$this->dbforge->create_table($this_table,TRUE);
		
        
        $this->db->query("ALTER TABLE `$this_table` ADD UNIQUE INDEX `index_unique` (`id_dossier`,`id_contact`)");
        //$this->db->query("ALTER TABLE `$this_table` ADD FOREIGN KEY(id_contact) REFERENCES contacts(id) ON UPDATE CASCADE ON DELETE RESTRICT");
        
        // Drop table 'files' if it exists
		$this->dbforge->drop_table($this->tables['files'], TRUE);

		// Table structure for table 'files'
		$this->dbforge->add_field(array(
			'id' => array(
				'type'           => 'MEDIUMINT',
				'constraint'     => '8',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
            'id_dossier' => array(
                'type'           => 'MEDIUMINT',
				'constraint'     => '8',
				'unsigned'       => TRUE,
				'null'			 =>	FALSE
            ),
			'file_name'	=> array(
				'type'			=>	'varchar',
				'constraint'     => '200',
				'null'           => FALSE
			),
			'file' => array(
                'type'           => 'blob',
				'null'           => FALSE
            ),
		));
		
		
		$this->dbforge->add_key('id', TRUE);
        $this_table=$this->tables['files'];
        $this_dossier=$this->tables['table'];
		$this->dbforge->create_table($this_table);
               
        //$this->db->query("ALTER TABLE `$this_table` ADD FOREIGN KEY(id_dossier) REFERENCES $this_dossier(id) ON UPDATE CASCADE ON DELETE RESTRICT");
		
		// Drop table 'accounting' if it exists
		$this->dbforge->drop_table($this->tables['accounting'], TRUE);

		// Table structure for table 'accounting'
		$this->dbforge->add_field(array(
			'id' => array(
				'type'           => 'MEDIUMINT',
				'constraint'     => '8',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
			'id_dossier' => array(
				'type'           => 'MEDIUMINT',
				'constraint'     => '8',
				'unsigned'       => TRUE
			),
			'date_creation' => array(
				'type'      => 'timestamp'
			),
			'date'	=>	array(
				'type'		=>	'date',
				'null'		=>	FALSE
			),
			'concept'		=>	array(
				'type'			=>	'varchar',
				'constraint'    => '100',
				'null'			=>	FALSE
			),
            'debit' => array(
                'type'           => 'decimal',
				'constraint'     => '6,2',
				'null'			 =>	FALSE,
				'default'		 => '0.0'
            ),
			'credit' => array(
                'type'           => 'decimal',
				'constraint'     => '6,2',
				'null'			 =>	FALSE,
				'default'		 => '0.0'
            ),
		));
		
		
		$this->dbforge->add_key('id', TRUE);
        $this_table=$this->tables['accounting'];
        $this_dossier=$this->tables['table'];
		$this->dbforge->create_table($this_table);
               
        //$this->db->query("ALTER TABLE `$this_table` ADD FOREIGN KEY(id_dossier) REFERENCES $this_dossier(id) ON UPDATE CASCADE ON DELETE RESTRICT");
		
		
		// Drop table 'contacts' if it exists
		$this->dbforge->drop_table($this->tables['contacts'], TRUE);

		// Table structure for table 'content'
		$this->dbforge->add_field(array(
			'id' => array(
				'type'           => 'MEDIUMINT',
				'constraint'     => '8',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
            'id_dossier' => array(
                'type'           => 'MEDIUMINT',
				'constraint'     => '8',
				'unsigned'       => TRUE,
            ),
			'id_contact' => array(
                'type'           => 'MEDIUMINT',
				'constraint'     => '8',
				'unsigned'       => TRUE,
            ),
		));
		
		
		$this->dbforge->add_key('id', TRUE);
        $this_table=$this->tables['contacts'];
        $this_dossier=$this->tables['table'];
		$this->dbforge->create_table($this_table);
               
        //$this->db->query("ALTER TABLE `$this_table` ADD FOREIGN KEY(id_dossier) REFERENCES $this_dossier(id) ON UPDATE CASCADE ON DELETE RESTRICT");
		
		
		// Drop table 'texts' if it exists
		$this->dbforge->drop_table($this->tables['text'], TRUE);

		// Table structure for table 'content'
		$this->dbforge->add_field(array(
			'id' => array(
				'type'           => 'MEDIUMINT',
				'constraint'     => '8',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
            'id_dossier' => array(
                'type'           => 'MEDIUMINT',
				'constraint'     => '8',
				'unsigned'       => TRUE,
            ),
			'text' => array(
                'type'           => 'blob',				
            ),
		));
		
		
		$this->dbforge->add_key('id', TRUE);
        $this_table=$this->tables['text'];
        $this_dossier=$this->tables['table'];
		$this->dbforge->create_table($this_table);
               
        //$this->db->query("ALTER TABLE `$this_table` ADD FOREIGN KEY(id_dossier) REFERENCES $this_dossier(id) ON UPDATE CASCADE ON DELETE RESTRICT");
	}

	public function down()
	{
		foreach($this->tables as $table)
		{
			$this->dbforge->drop_table($table, TRUE);
		}
	}
}
