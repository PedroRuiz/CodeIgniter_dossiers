<?php
/**
 * Name:    Dossier
 * Author:  Pedro Ruiz Hidalgo
 *           correo@pedroruizhidalgo.es
 *           @pedroruizhidalg
 *
 *
 * Created:  2018-02-03
 * 
 * Description:  This is the configuration file for the third_party CodeIgniter_dossiers project
 *
 *
 * Requirements: PHP5 or above
 *
 * @package    CodeIgniter_dossiers
 * @author     Pedro Ruiz hidalgo
 * @link       http://github.com/PedroRuiz/CodeIgniter-Contacts
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| List dateformat.
| -------------------------------------------------------------------------
| Formats supported by php's date().
*/
$config['dssr_dateformat'] = 'd-m-Y';

/*
| -------------------------------------------------------------------------
| Tables Name
| -------------------------------------------------------------------------
| 
*/
$config['dssr_table']       =   'dossiers';
$config['dssr_contacts']    =   'dossier_contacts';
$config['dssr_files']       =   'dossier_files';
$config['dssr_accounting']  =   'dossier_accounting';
$config['dssr_users']       =   'dossier_users';    
$config['dssr_content']     =   'dossier_content';
$config['dssr_texts']       =   'dossier_text';
$config['dssr_ext_contacts']=   'contacts';         // this contacts are third_party/contacts
$config['dssr_ext_users']   =   'users';            // this users are third_party/Ion_auth

/*
| -------------------------------------------------------------------------
| Images folder name
| -------------------------------------------------------------------------
| 
*/
$config['dssr_images'] = 'assets/img/dossiers/';

/*
| -------------------------------------------------------------------------
| external contacts image folder name
| -------------------------------------------------------------------------
| 
*/
$config['dssr_contacts_images'] = 'assets/img/contacts/';

/*
| -------------------------------------------------------------------------
| external contacts image folder name
| -------------------------------------------------------------------------
| 
*/
$config['dssr_dossier_files'] = 'assets/dossiers/files/';

/*
| -------------------------------------------------------------------------
| Allowed upload mime types
| -------------------------------------------------------------------------
| 
*/
$config['dssr_file_types'] = 'gif|png|jpg|jpeg|xls|odt|doc|txt|ods|pdf';


