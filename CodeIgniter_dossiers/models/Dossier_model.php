<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dossier_model extends CI_Model
{
    private $_dossier;
    private $_contacts;
    private $_files;
    private $_accounting;
    private $_content;
    private $_users;
    private $_texts;
    
    private $_external_contacts;
    private $_external_users;
    
    private $_dssr_contacts_images;
    private $_dssr_dossier_files;
    
    function __construct()
    {
        parent::__construct();
        
       
        $this->config->load('dossiers');
        $this->_dossier             =   $this->config->item('dssr_table');
        $this->_contacts            =   $this->config->item('dssr_contacts');
        $this->_files               =   $this->config->item('dssr_files');
        $this->_accounting          =   $this->config->item('dssr_accounting');
        $this->_content             =   $this->config->item('dssr_content');
        $this->_users               =   $this->config->item('dssr_userss');
        $this->_texts               =   $this->config->item('dssr_texts');
        $this->_external_contacts   =   $this->config->item('dssr_ext_contacts');
        $this->_external_users      =   $this->config->item('dssr_ext_users');
        $this->_dssr_contacts_images=   $this->config->item('dssr_contacts_images');
        $this->_dssr_dossier_files  =   $this->config->item('dssr_dossier_files');
        
        if( !is_dir(FCPATH.$this->_dssr_contacts_images) ) mkdir(FCPATH.$this->_dssr_contacts_images,0755,TRUE);
        if( !is_dir(FCPATH.$this->_dssr_dossier_files) ) mkdir(FCPATH.$this->_dssr_dossier_files,0755,TRUE);
    }
    
    function create_dossier($dossier_name,$owned_user)
    {
        return $this->db->insert($this->_dossier, array(
           'name'   =>  $dossier_name,
           'owned_user' => $owned_user
        ));
    }
    
    function get_dossiers($user=NULL)
    {
        if (is_null($user))
            return $this->db->get($this->_dossier)->result_array();
        else
            return $this->db->where('owned_user',$user)->get($this->_dossier)->result_array();
    }
    
    function get_dossier($id)
    {
        return $this->db->where('id',$id)->get($this->_dossier)->row_array();
    }
    
    function get_external_contacts()
    {
        return $this->db->get($this->_external_contacts)->result_array();
    }
    
    function write_dossier_contacts($array,$id_dossier)
    {
        if ( ! is_array($array) ) show_error("array must be an array");
        
        foreach($array as $contact)
        {
            if( $this->db->from($this->_contacts)->where('id_dossier',$id_dossier)->where('id_contact',(int) $contact)->count_all_results() == 0 )
            {
                $this->db->insert($this->_contacts,array(
                    'id_dossier'    => $id_dossier,
                    'id_contact'    => $contact
                ));
            }
        }
    }
    
    function write_accounting($array,$id=NULL)
    {
        if ( ! is_array($array) ) show_error('Array must be an array');
        if ( is_null($id) ) show_error('You must provide dossier.id');
        return $this->db->insert($this->_accounting,array(
                'id_dossier'    =>  $id,
                'date'          =>  date('Y-m-d',strtotime($this->input->post('date'))),
                'concept'       =>  trim(htmlspecialchars($this->input->post('concept'))),
                'debit'         =>  (real) $this->input->post('debit'),
                'credit'        =>  (real) $this->input->post('credit')                
        ));
    }
    
    function get_balance($id)
    {
        return $this->db
                        ->select_sum('debit')
                        ->select_sum('credit')
                        ->get_where($this->_accounting,array('id_dossier'=>$id))
                        ->row_array();
    }
    
    function get_dossier_accounting($id)
    {
        return $this->db
                        ->order_by('date','ASC')
                        ->order_by('date_creation','ASC')
                        ->where('id_dossier',$id)
                        ->get($this->_accounting)
                        ->result_array();
    }
    
    function get_balance_count($id)
    {
        return $this->db
                ->where('id_dossier',$id)
                ->from($this->_accounting)
                ->count_all_results();
    }
    
    function get_contacts_in($id)
    {
        return $this->db
                    ->query("SELECT * FROM (`dossier_contacts`, `contacts`) where contacts.id=dossier_contacts.id_contact and dossier_contacts.id_dossier=$id")
                    ->result_array();
    }
    
    function get_files_in($id)
    {
        $_file=array();
        $j=0;
        foreach($this->db->where(array('id_dossier'=>$id))->get($this->_files)->result_array() as $file)
        {
            $_file[$j]['id']            =   $file['id'];
            $_file[$j]['id_dossier']    =   $file['id_dossier'];
            $_file[$j]['file_name']     =   $file['file_name'];
            $_file[$j++]['array']       =   $this->untoken_it($file['file']);
        }
        //var_dump($_file); exit;
        return $_file;
    }
    
    function unlink_contact($iddossier,$iduser)
    {
        return ($this->db
                    ->where('id_dossier',$iddossier)
                    ->where('id_contact',$iduser)
                    ->delete($this->_contacts));
    }
    
    function declare_assets($id,$filearray)
    {
        if($this->db->where('id_dossier',$id)->where('file_name',$filearray['file_name'])->from($this->_files)->count_all_results()==0)
        {
            return $this->db->insert($this->_files, array(
               'id_dossier'     =>  $id,
               'file_name'      => $filearray['file_name'],
               'file'           => $this->token_it($filearray)
            ));
        } else {
            return TRUE;
        }
    }
    
    function unlink_files($id_file)
    {
        $_file=$this->db->where('id',$id_file)->get($this->_files)->row_array(); 
       
        $unlink=($this->untoken_it($_file['file']));
        
        unlink($unlink['full_path']); 
        
        return $this->db
                    ->where('id',$id_file)
                    ->delete($this->_files);
    }
    
    function write_text($id)
    {
        //var_dump($this->input->post('text')); exit;
        return $this->db
                    ->insert($this->_texts,array(
                        'id_dossier'    =>  $id,
                        'text'          =>  $this->input->post('text')
                    ));
    }
    
    function get_texts($id)
    {
        return $this->db->where('id_dossier',$id)->get($this->_texts)->result_array();
    }
    
    function get_text($text_id)
    {
        return $this->db->where('id',$text_id)->get($this->_texts)->row_array();
    }
    
    function text_update($text_id)
    {
        return  $this->db
            ->set('text',$this->input->post('text'))
            ->where('id',$text_id)
            ->update($this->_texts);
            
    }
    
    function text_delete($text_id)
    {
        return $this->db->where('id',$text_id)->delete($this->_texts);
    }
    
    private function token_it($array)
    {
        $str=NULL;
        foreach($array as $t => $v)
        {
            $str.="$t=$v&";
        }
        return $str;
    }
    
    private function untoken_it($string)
    {
        $array=array();
        parse_str($string,$array);
        return $array;
    }
}