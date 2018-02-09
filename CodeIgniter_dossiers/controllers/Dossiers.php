<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dossiers extends MY_Controller
{
    private $iddossier;
    
    private $contacts_table;
    private $_dossier;
    private $_contacts;
    private $_files;
    private $_accounting;
    private $_content;
    private $_users;
    private $_texts;
    private $_dssr_contacts_images;
    private $_dssr_dossier_files;
    private $_dssr_file_types;
    
    private $_dssr_dateformat;
    
    function __construct()
    {
        parent::__construct();
        
        $this->load->helper(array('form', 'url'));
        $this->load->add_package_path(APPPATH.'third_party/CodeIgniter_dossiers');
        $this->config->load('dossiers');
        $this->load->model(array('dossier_model'=>'model'));
        
        $this->config->load('dossiers');
        $this->_dossier                 =   $this->config->item('dssr_table');
        $this->_contacts                =   $this->config->item('dssr_contacts');
        $this->_files                   =   $this->config->item('dssr_files');
        $this->_accounting              =   $this->config->item('dssr_accounting');
        $this->_content                 =   $this->config->item('dssr_content');
        $this->_users                   =   $this->config->item('dssr_userss');
        $this->_texts                   =   $this->config->item('dssr_texts');
        $this->_dssr_contacts_images    =   $this->config->item('dssr_contacts_images');
        $this->_dssr_dossier_files      =   $this->config->item('dssr_dossier_files');
        $this->_dssr_file_types         =   $this->config->item('dssr_file_types');
        $this->_dssr_dateformat         =   $this->config->item('dssr_dateformat');
        
        if(!$this->load->is_loaded('Ion_auth')) $this->load->library('ion_auth');
        
        $this->load->add_package_path(APPPATH.'third_party/contacts/');
        if(!$this->load->is_loaded('Contacts')) $this->load->library('contacts');
//exit(strip_tags("<p>Ma&ntilde;ana cenaremos con champi&ntilde;ones y cerveza especial.</p>"));       
    }
    
    function index()
    {
        $data = array(
            'dossiers'  =>  ($this->ion_auth->is_admin()) ? $this->model->get_dossiers() : $this->model->get_dossiers($this->ion_auth->user()->row()->id),
            'owner'     =>  sprintf('%s %s',
                                               $this->ion_auth->user()->row()->first_name,
                                               $this->ion_auth->user()->row()->last_name
                                               ),
            //'contacts'  =>  $this->contacts->get_contacts()
                           
            );
        $this->load->view('dssr_main',$data);
    }
    
    function new()
    {
        $this->load->helper(array('url','form'));
        $this->load->library(array('form_validation'=>'valid'));
        $this->valid->set_rules($this->validate_new());
        
        if($this->valid->run() == FALSE)
        {   
            $this->load->view('dssr_new');
        } else {
            $this->model->create_dossier($this->input->post('dssr_name'),$this->ion_auth->user()->row()->id);
            redirect('dossiers','refresh');
        }
        
    }
    
    function dossier($id) // routed
    {
            $data = array(
                'dossier'       =>  $this->model->get_dossier($id),
                'owner'         =>  sprintf('%s %s',
                                                   $this->ion_auth->user()->row()->first_name,
                                                   $this->ion_auth->user()->row()->last_name
                                                   ),
                'contacts'     =>  $this->model->get_contacts_in($id),
                'id'           => $id,
                'images'       => $this->_dssr_contacts_images,
                'file_folder'  => $this->_dssr_dossier_files,
                'files'        => $this->model->get_files_in($id),
                'texts'        => $this->model->get_texts($id)
                               
                );
            $accounting         =   $this->model->get_balance($id); 
            $data['debit']      =   $accounting['debit'];
            $data['credit']     =   $accounting['credit'];
            $data['total']      =   (real) ((real)$accounting['debit'])-((real)$accounting['credit']);
            $data['numlines']   =   $this->model->get_balance_count($id); 
    
            $this->load->view('dssr_dossier',$data);
    }
    
    function add_contact($id) //routed
    {
        $existing=array();
        $contacts=$this->db->select('id_contact')->where('id_dossier',$id)->get($this->_contacts)->result_array();
        foreach($contacts as $contact)
        {
            $existing[]= (int) $contact['id_contact'];
        }
        if ( ! $this->input->post('send') )
        {
            $data = array(
                'id'        =>  $id,
                'dossier'   =>  $this->model->get_dossier($id),
                'owner'     =>  sprintf('%s %s',
                                                   $this->ion_auth->user()->row()->first_name,
                                                   $this->ion_auth->user()->row()->last_name
                                                   ),
                'contacts'  =>  $this->model->get_external_contacts(),
                'images'    =>  $this->_dssr_contacts_images,
                'existing'  =>  $existing
                );
                        
            $this->load->view('dssr_add_contact',$data);
        }
        else
        {
            $this->model->write_dossier_contacts($this->input->post('contact'),$id);
            redirect(base_url("dossiers/dossier/$id/view.html"),'refresh');
        }
    }
    
    function unlink_contact($dossier = NULL, $iduser=NULL)
    {
        if( is_null($dossier) || is_null($iduser) ) show_error('dossier and idusser needed!');
        
        if ( $this->model->unlink_contact($dossier,$iduser) )
        redirect(base_url("dossiers/dossier/$dossier/view"),'refresh');
    }
    
    function add_files($id)
    {
        $data = array(
                'id'        =>  $id,
                'dossier'   =>  $this->model->get_dossier($id),
                'owner'     =>  sprintf('%s %s',
                                                   $this->ion_auth->user()->row()->first_name,
                                                   $this->ion_auth->user()->row()->last_name
                                                   ),
                'error'     =>  ''
                );
                        
            $this->load->view('dssr_upload_file',$data);
    }
    
    function do_upload_files($id)
    {
        $this->load->library('upload',array(
            'upload_path'           =>  $this->_dssr_dossier_files,
            'allowed_types'         =>  $this->_dssr_file_types,
            'max_size'              =>  20*1024,
            'encrypt_filename'      =>  TRUE,
            'remove_spaces'         =>  TRUE,
            'overwrite'             =>  TRUE
        ));
        
        if(!$this->upload->do_upload('userfile'))
        {
            $data=array(
                'id'        =>  $id,
                'dossier'   =>  $this->model->get_dossier($id),
                'owner'     =>  sprintf('%s %s',
                                                   $this->ion_auth->user()->row()->first_name,
                                                   $this->ion_auth->user()->row()->last_name
                                                   ),
                'error'     =>  $this->upload->display_errors()
                );
            $this->load->view('dssr_upload_file',$data);
        }
        else
        {
            if ($this->model->declare_assets($id,$this->upload->data())) redirect(base_url("dossiers/dossier/$id/view.html"),'refresh');
        }
    }
    
    function unlink_files($id_file)
    {
        if($this->model->unlink_files($id_file)) redirect(base_url("dossiers/dossier/$id_file/view.html"),'refresh');
        
    }
    
    function accounting($id) //routed
    { 
        $this->load->helper(array('url','form'));
        $this->load->library(array('form_validation'=>'valid'));
        $this->valid->set_rules($this->validate_accounting());
        
        if($this->valid->run() == FALSE)
        {               
            $data=array(
                'id'        =>  $id,
                'dossier'   =>  $this->model->get_dossier($id),
                'owner'     =>  sprintf('%s %s',
                                                   $this->ion_auth->user()->row()->first_name,
                                                   $this->ion_auth->user()->row()->last_name
                                                   ),  
                );
            $accounting         =   $this->model->get_balance($id); 
            $data['debit']      =   $accounting['debit'];
            $data['credit']     =   $accounting['credit'];
            $data['total']      =   (real) ((real)$accounting['debit'])-((real)$accounting['credit']);
            $data['numlines']   =   $this->model->get_balance_count($id); 
            $data['accounting'] =   $this->model->get_dossier_accounting($id); 
            $this->load->view('dssr_accounting',$data);
        }
        else
        {
            if ($this->model->write_accounting($this->input->post(),$id)) redirect(base_url("dossiers/accounting/$id/view"));
        }
    }
    
    function text($id)
    { 
        $this->load->helper(array('url','form'));
        $this->load->library(array('form_validation'=>'valid'));
        $this->valid->set_rules($this->validate_text());
        
        if($this->valid->run() == FALSE)
        {
            $data = array(
                'dossier'       =>  $this->model->get_dossier($id),
                'owner'         =>  sprintf('%s %s',
                                                   $this->ion_auth->user()->row()->first_name,
                                                   $this->ion_auth->user()->row()->last_name
                                                   ),
                'contacts'     =>  $this->model->get_contacts_in($id),
                'id'           => $id,
                
                               
                );
            $this->load->view('dssr_text',$data);
        } else {
            $this->model->write_text($id);
            redirect(base_url("dossiers/dossier/$id/view.html"),'refresh');
        }
    }
    
    function view_text($text_id,$id)
    {
        
        $data = array(
                'dossier'       =>  $this->model->get_dossier($id),
                'owner'         =>  sprintf('%s %s',
                                                   $this->ion_auth->user()->row()->first_name,
                                                   $this->ion_auth->user()->row()->last_name
                                                   ),
                //'contacts'     =>  $this->model->get_contacts_in($id),
                'id'           => $this->uri->segment(3),
                'text'         => $this->model->get_text($text_id,$this->uri->segment(3))
                
                               
                );

            $this->load->view('dssr_text',$data);
    }
    
    function text_update($text_id,$id)
    {
        $this->load->helper(array('url','form'));
        $this->load->library(array('form_validation'=>'valid'));
        $this->valid->set_rules($this->validate_text());
        
        if($this->valid->run() == FALSE)
        {
            $data = array(
                'dossier'       =>  $this->model->get_dossier($id),
                
                'id'           => $id,
                'text'         => $this->model->get_text($text_id,$this->uri->segment(3))
                               
                );
            $this->load->view('dssr_text_update',$data);
        } else {
            if ($this->model->text_update($text_id)) redirect(base_url("dossiers/dossier/$id/view.html"),'refresh');
        }
    }
    
    function text_delete($text_id,$id)
    {
        if ($this->model->text_delete($text_id)) redirect(base_url("dossiers/dossier/$id/view.html"),'refresh');
    }
    
    private function validate_new()
    {
        return array(
            array(
                'field' =>  'dssr_name',
                'label' =>  'Dossier name',
                'rules' =>  'required|min_length[5]|max_length[100]|trim|htmlspecialchars'
            )
        );
    }
    
    private function validate_accounting()
    {
        return array(
            array(
                'field' =>  'date',
                'label' =>  'Date',
                'rules' =>  'required|callback_date_check|trim|htmlspecialchars',
                array(
                    'date_check'=>'fecha debe ser dd-mm-yyyy'
                )
            ),
            array(
                'field' =>  'concept',
                'label' =>  'Concept',
                'rules' =>  'required|trim|htmlspecialchars'
            ),
            array(
                'field' =>  'debit',
                'label' =>  'Debit',
                'rules' =>  'callback_debit_check|trim'
            ),
            array(
                'field' =>  'credit',
                'label' =>  'Credit',
                'rules' =>  'callback_credit_check|trim'
            )
        );
    }
    
    public function date_check($date)
    {
        $day = (int) substr($date, 0, 2);
        $month = (int) substr($date, 3, 2);
        $year = (int) substr($date, 6, 4);
        if ( ! checkdate($month, $day, $year) )
        {
            $this->valid->set_message('date_check', 'The {field} isn\'t correctly formated');
            return  FALSE;
        }
        return TRUE;
    }
    
    public function debit_check($str)
    {
        $debit =   $this->input->post('debit');
        $credit =   $this->input->post('credit');
        if($debit xor $credit)
        {
            if(is_numeric($str) || strlen($str)==0) return TRUE;
        }
        $this->valid->set_message('debit_check', 'The {field} isn\'t correctly formated');
        return FALSE;
    }
    
    public function credit_check($str)
    {
        $debit =   $this->input->post('debit');
        $credit =   $this->input->post('credit');
        if($debit xor $credit)
        {
            if(is_numeric($str) || strlen($str)==0) return TRUE;
        }
        $this->valid->set_message('credit_check', 'The {field} isn\'t correctly formated');
        return FALSE;
        
    }
    
    private function validate_text()
    {
        return array(
            array(
                'field' =>  'text',
                'label' =>  'Text',
                'rules' =>  'required|trim|htmlspecialchars',
            ));
    }
}