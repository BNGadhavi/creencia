<?php

Class Dashboard_model extends CI_Model {

  public function login($data) {

    $condition = "username = " . "'" . $data['username'] . "' AND " . "password =" . "'" . $data['password'] . "'";

    $this->db->select('*');

    $this->db->from('mlm_userlogin');

    $this->db->where($condition);

    $this->db->limit(1);

    $query = $this->db->get();



    if ($query->num_rows() == 1) {

      return true;

    } else {

      return false;

    }

  }

  public function uselogindata($username) {

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

  public function dashboardTopWidget($userId) {

    $topwidgetquery = "SELECT 

              (SELECT COALESCE(round(SUM(netamount),2),0) FROM mlm_transaction WHERE userid = '$userId' and wallettype='Income Wallet') AS 'Income Wallet Balance@@@#@@@fa fa-dollar@@@scooter@@@ReportList/AccountStatement@@@info',

              (SELECT COALESCE(round(SUM(amount),2),0) FROM mlm_binaryincome WHERE userid = '$userId') AS 'Binary Income@@@#@@@fa fa-dollar@@@bloody@@@ReportList/@@@danger',
              
              (SELECT COALESCE(round(SUM(netamount),2),0) FROM mlm_sponsorincome WHERE userid = '$userId') AS 'Sponsor Income@@@#@@@fa fa-dollar@@@blooker@@@ReportList/SponsorIncomeReport@@@warning',

              (SELECT COALESCE(round(SUM(netamount),2),0) FROM mlm_roiincome where clubid='0' and userid='$userId') AS 'Total ROI Income@@@#@@@fa fa-dollar@@@quepal@@@ReportList/RoiIncomeReport/0@@@success',

               (SELECT COALESCE(round(SUM(netamount),2),0) FROM mlm_transaction WHERE userid = '$userId' and wallettype='Capital Wallet') AS 'Capital Wallet Balance@@@#@@@fa fa-dollar@@@scooter@@@ReportList/AccountStatement@@@info',

               (SELECT COUNT(*) FROM mlm_walletorder WHERE userid = '$userId' and status='0') AS 'Pending Wallet Request@@@#@@@fa fa-dollar@@@bloody@@@WalletRequest/WalletRequestReport@@@danger',

               (SELECT if(A.rewardid='0','Not Eligible',B.rank) FROM `mlm_userlogin` as A left JOIN mlm_rewardmaster as B on A.rewardid=B.id where A.id='$userId') AS 'Designation@@@#@@@fa fa-trophy@@@blooker@@@ReportList/RewardIncome@@@warning',

              (SELECT COALESCE(round(SUM(dollar),2),0) FROM mlm_withdrawalreq where status='1' and userid='$userId') AS 'Total Withdrawal@@@#@@@fa fa-dollar@@@quepal@@@Withdrawal/@@@success'
              ";

               
      $topwidgetraw = DirectQuery($topwidgetquery);

      $topwidgetresult = $topwidgetraw->result();

      return $topwidgetresult;

  }



  public function dashboardSideWidget($userId) {

    $da=CurrentDate();

    $topwidgetquery = "SELECT 

              (SELECT count(*) FROM mlm_userdownline WHERE sponsor = '$userId') AS 'Total Direct Member@@@#@@@icon-user@@@royal@@@TeamList/',

              (SELECT  COUNT(*)  FROM `mlm_userdownline` as A , mlm_userlogin as B WHERE A.`sponsor` = '$userId' and A.userid=B.id and B.activestatus='1') AS 'Direct Active Member@@@#@@@icon-user@@@royal@@@TeamList',

              (SELECT COUNT(*) FROM mlm_userstructure WHERE uplineid = '$userId') AS 'Total Downline Member@@@#@@@icon-user@@@influenza@@@TeamList/DownlineSummary',

              (SELECT ifnull(sum(pv),0) FROM mlm_useractivation WHERE `userid` IN (SELECT userid FROM mlm_userstructure WHERE uplineid = '$userId')) AS 'Total Downline Business@@@#@@@icon-user@@@influenza',

              (SELECT ifnull(sum(pv),0) FROM mlm_useractivation WHERE `userid` IN (SELECT userid FROM mlm_userstructure WHERE uplineid = '$userId'and side='0') and date(activedate)=date('$da')) AS 'Today Left Business@@@#@@@icon-user@@@scooter',

              (SELECT ifnull(sum(pv),0) FROM mlm_useractivation WHERE `userid` IN (SELECT userid FROM mlm_userstructure WHERE uplineid = '$userId'and side='2') and date(activedate)=date('$da')) AS 'Today Right Business@@@#@@@icon-user@@@scooter',

              (SELECT COUNT(*) FROM mlm_userstructure WHERE uplineid = '$userId' AND side = '0') AS 'Total Left Member@@@#@@@icon-user@@@royal',

              (SELECT COUNT(*) FROM mlm_userstructure WHERE uplineid = '$userId' AND side = '2') AS 'Total Right Member@@@#@@@icon-user@@@royal',

              (SELECT COUNT(*) FROM mlm_userlogin WHERE `id` IN (SELECT userid FROM mlm_userstructure WHERE uplineid = '$userId' AND side = '0') and  activestatus='1') AS 'Total Active Left Member@@@#@@@icon-user@@@influenza',

              (SELECT COUNT(*) FROM mlm_userlogin WHERE `id` IN (SELECT userid FROM mlm_userstructure WHERE uplineid = '$userId' AND side = '2') and  activestatus='1') AS 'Total Active Right Member@@@#@@@icon-user@@@influenza',

              (SELECT ifnull(sum(pv),0) FROM mlm_useractivation WHERE `userid` IN (SELECT userid FROM mlm_userstructure WHERE uplineid = '$userId'and side='0')) AS 'Total Left Business@@@#@@@icon-user@@@scooter',

              (SELECT ifnull(sum(pv),0) FROM mlm_useractivation WHERE `userid` IN (SELECT userid FROM mlm_userstructure WHERE uplineid = '$userId'and side='2')) AS 'Total Right Business@@@#@@@icon-user@@@scooter'
                ";
      $topwidgetraw = DirectQuery($topwidgetquery);
      $topwidgetresult = $topwidgetraw->result();
      return $topwidgetresult;
  }
  public function profileDetail($userId) {
    $profilequery = "SELECT UL.username, UD.mobile, PS.packagename, UD.fullname, UL1.username AS 'spon', UL.entrydate,UL.activedate, IF(UL.packagecode = 0, 'Inactive', PS.packagename) AS 'Package',UL.activestatus,UL.purchasestatus,UL.lastdate
            FROM mlm_userlogin AS UL 
            INNER JOIN mlm_userdetail AS UD ON UD.userid = UL.id 
            LEFT JOIN mlm_userdownline AS UDO ON UDO.userid = UL.id 
            LEFT JOIN mlm_userlogin AS UL1 ON UL1.id = UDO.sponsor 
            LEFT JOIN mlm_packagesetting AS PS ON PS.id = UL.packagecode
            WHERE UL.id = '$userId'";
      $profileraw = DirectQuery($profilequery);
      $profileresult = $profileraw->result();
      return $profileresult;  
  }

  public function ProfileSubmit($data) {
    $imagename = $data['image'];
    $userId = $data['userId'];
    $profilequery = "UPDATE mlm_userdetail SET profile = '$imagename' WHERE id = '$userId'";
    $profileraw = DirectQuery($profilequery);
  }
}

?>