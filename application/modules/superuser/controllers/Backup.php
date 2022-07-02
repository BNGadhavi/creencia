<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Backup extends MX_Controller {
	public function __construct(){
    	parent::__construct();
    	$this->load->helper('url');
    	$this->load->helper('security');
        $this->load->helper('income');
        $this->load->helper('sms');
    	$this->load->model('Backup_model');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->library('zip');
    	$adminLoggedIn = $this->session->userdata('adminLoggedIn');
        $userid=$adminLoggedIn['userid'];
        $this->sessionAdminUserid=$userid;
    }

	public function index(){
        $BackupList=$this->Backup_model->Report();
        $response=array();
        $response['responseData']=$BackupList;
        $response['pageTitle']='Backup Report';
        $this->load->view('backup',$response);
    }

    public function backupdb() {
        $userid= $this->sessionAdminUserid;
        ini_set('memory_limit', '1024M');
        $this->load->dbutil();
        //$db_format=array('format'=>'zip','filename'=>'my_db_backup.sql');
        $prefs = array(
            'tables'        => array('mlm_transaction', 'mlm_userdetail','mlm_userlogin', 'mlm_userdownline', 'mlm_useractivation','mlm_invoicedetail', 'mlm_invoicemaster', 'mlm_levelincome','mlm_packagesetting','mlm_productmaster','mlm_walletmaster','mlm_walletorder','mlm_gstmaster','mlm_repurchasedesignation','mlm_levelmaster','mlm_pinmaster','mlm_pintransaction','mlm_pinorder','mlm_withdrawalreq','mlm_repurchaseincome'),   // Array of tables to backup.
            'ignore'        => array(),                     // List of tables to omit from the backup
            'format'        => 'zip',                       // gzip, zip, txt
            'filename'      => 'mybackup.sql',              // File name - NEEDED ONLY WITH ZIP FILES
            'add_drop'      => TRUE,                        // Whether to add DROP TABLE statements to backup file
            'add_insert'    => TRUE,                        // Whether to add INSERT data to backup file
            'newline'       => "\n"                         // Newline character used in backup file
        );
        $backup=& $this->dbutil->backup($prefs);
        $dbname='backup'.strtotime(CurrentDate()).'.zip';
        $save='assets/db_backup/'.$dbname;
        
        $data = array();
        $data['filename'] = $save;
        $data['addedby'] = $userid;
        $this->Backup_model->Insert($data);

        write_file($save,$backup);
        force_download($dbname,$backup);
    }
}
?>