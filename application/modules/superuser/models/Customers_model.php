<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Customers_model extends CI_Model {
 
    var $table = 'mlm_userlogin as UL';
    var $column_order = array("UL.id","UL.username","UL.password","UL.entrydate","UL.activedate","UL1.username","UD.fname","UD.email","UD.mobile","UD.address","UD.pincode","UD1.fname"); //set column field database for datatable orderable
   
    var $column_search = array("UL.id","UL.username","UL.password","UL.entrydate","UL.activedate","UL1.username","UD.fname","UD.email","UD.mobile","UD.address","UD.pincode","UD1.fname");
    var $order = array('UL.id' => 'desc'); // default order 
    
  

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
        
        $this->db->select("UL.id AS 'Id',UL.username,UL.password AS 'Password',UL.securitypassword,UD.fname,UL.entrydate,UL.activedate,CONCAT(UL1.username,'<br>',UD1.fullname) AS 'SponsorInfo',if(DW.side='0','LEFT','RIGHT') AS 'Side',UL.entrydate,UL.activedate,if(UL.activestatus='1',PS.packagename,'Inactive') as 'ActiveDetail',UD.email,UD.mobile as 'MobileNo',UD.address,UD.pincode");

         $this->db->from($this->table);
        $this->db->join('mlm_userdetail as UD','UL.id=UD.userid');
        $this->db->join('mlm_userdownline AS DW','UL.id=DW.userid','left');
        $this->db->join('mlm_userdetail AS UD1','DW.sponsor=UD1.userid','left');
        $this->db->join('mlm_userlogin AS UL1','UL1.id =  DW.sponsor','left');
        $this->db->join('mlm_packagesetting AS PS','PS.id = UL.packagecode','left');
        /*$this->db->join('mlm_cities AS CI','CI.id = UD.city','left');
        $this->db->join('mlm_states AS ST','ST.id = UD.state','left');*/

        
        $i = 0;
        
        $serachValue=rtrim($_POST['search']['value']);
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $serachValue);
                }
                else
                {
                    $this->db->or_like($item, $serachValue);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        //echo $this->db->last_query();
        //return $query->result();
        $result=array();
        //$result=$query->result();
        if($query->result()){
            return $query->result();
        }
        else{
            return $result;
        }
        //return $query->result();

    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();

    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();

    }
 
}