<?php
Class MemberDetailModel extends CI_Model {
  public function MemberReport($data=array()){
  }

  public function AjaxMemberReport($data=array()){
    $columns = array(
      // datatable column index  => database column name
      0 =>'A.fullname',
    );
 
    $this->db->select('A.fullname');//s.photo_no,s.photo_name'
    $this->db->from('mlm_userdetail AS A');;
    $result = $this->db->get();
    $totalData = $result->num_rows();
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

    $sql = "SELECT * FROM mlm_userdetail as A where 1=1 ";
    // getting records as per search parameters
    $isFilterApply=0;
    if( !empty($requestData['search']['value']) ) {   //name
      $sql.=" AND ( s.CUST_NAME LIKE '".$requestData['search']['value']."%' ";

      $sql.=" OR s.CUST_CITY LIKE '".$requestData['search']['value']."%') ";
      $isFilterApply=1;
    }

    $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  // adding length
    $result1 = $this->db->query($sql);
    
    if($isFilterApply==1) {
      $totalFiltered =  $result1->num_rows(); 
    }

     // when there is a search parameter then we have to modify total number filtered rows as per search result.
    $row=$result1->result_array();
    for ($i=0; $i < count($row); $i++) {
      $row[$i]['action']='<a class="btn btn-outline btn-primary" href="#">Edit</a>&nbsp;&nbsp;&nbsp;<a class="btn btn-outline btn-danger"   >Delete</a>';
    }
    
    $json_data = array(
      "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
      "recordsTotal"    => intval( $totalData ),  // total number of records
      "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "data"            =>   $row  // total data array

    );
    return $json_data;
 
  }
  function ActivationList($data=array()){
  
    $MainTable="mlm_useractivation as A";
    $JoinTable=array();
    $JoinTable[0]="mlm_userlogin as B";
    $JoinTable[1]="mlm_userdetail as C";
    $JoinTable[2]="mlm_userlogin as D";
    $JoinTable[3]="mlm_userdetail as E";
    $JoinTable[4]="mlm_packagesetting as F";

    $JoinOn=array();
    $JoinOn[0]="A.userid=B.id";
    $JoinOn[1]="B.id=C.userid";
    $JoinOn[2]="A.fromid=D.id";
    $JoinOn[3]="D.id=E.userid";
    $JoinOn[4]="A.packagecode=F.id";

    $Condition="A.status='0'";

    if(isset($data['dateFrom'])){
        $dateFrom=$data['dateFrom'];
        $Condition=$Condition." and date(A.entrydate) >= '$dateFrom'";
     }
     if(isset($data['dateTo'])){
        $dateTo=$data['dateTo'];
        $Condition=$Condition." and date(A.entrydate) <= '$dateTo'";
     }
      $link="";
    $SelectColumn=$link."A.activedate as Active Date___convertdate, B.username AS 'Member Id', C.fullname AS 'Member Name',CONCAT(D.username, '<br>',E.fullname) AS 'From Id' ,A.activeamount as 'Amount ($)'";
    
    $JoinType=array();
    $JoinType[2]="left";
    $JoinType[3]="left";
    $JoinType[4]="left";
    $activationList=CreateJoinQuery($MainTable,$JoinTable,$JoinOn,$Condition,$SelectColumn,$JoinType,'A.entrydate desc'); 
    $activationList=json_decode($activationList,true);  
    return  $activationList;

  }
  
  public function LoginMember($username) {
      $condition = "username =" . "'" . $username . "'";
      $this->db->select('*');
      $this->db->from('mlm_userlogin');
      $this->db->where($condition);
      $this->db->limit(1);
      $query = $this->db->get();
      if ($query->num_rows() == 1) {
        return $query->result();
      } else {
        return false;
      }
  }
}
?>