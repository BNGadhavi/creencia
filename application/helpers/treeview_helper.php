<?php 
if (! defined('BASEPATH')) exit('No direct script access allowed');
function treeUserData($uid) {

}

function treeviewattr($mid)
{
  $str='';
  if($mid=='-')
  {
    $str='title="No Id Found"';
  }
  else
  {
    $str='data-toggle="popover" data-trigger="hover" data-container="body" data-placement="right" data-html="true" id="'.$mid.'"';
  }
  return $str;
}

function treeviewpopupdiv($mid) {
  if($mid=='-') {
    $rtndiv='';
  }
  else {
  	$profilequery = "SELECT UL1.username, UD.fullname, PS.packagename FROM mlm_userlogin AS UL LEFT JOIN mlm_packagesetting AS PS ON PS.id = UL.packagecode LEFT JOIN mlm_userdownline AS UDO ON UDO.userid = UL.id LEFT JOIN mlm_userlogin AS UL1 ON UL1.id = UDO.sponsor LEFT JOIN mlm_userdetail AS UD ON UL1.id = UD.userid WHERE UL.id = '$mid'";
  	$profileraw = DirectQuery($profilequery);
  	$profiledata = $profileraw->result();
  	$profiledata = $profiledata[0];

	$downquery = "SELECT 
					(SELECT count(*) FROM mlm_userstructure WHERE uplineid = '$mid' AND side = '0') AS 'leftcnt',
					(SELECT count(*) FROM mlm_userstructure WHERE uplineid = '$mid' AND side = '2') AS 'rightcnt',
					(SELECT count(*) FROM mlm_userstructure as A , mlm_userlogin as B WHERE A.uplineid = '$mid' AND A.side = '0' and A.userid=B.id and B.activestatus='1') AS 'leftactcnt',
					(SELECT count(*) FROM mlm_userstructure as A , mlm_userlogin as B WHERE A.uplineid = '$mid' AND A.side = '2' and A.userid=B.id and B.activestatus='1') AS 'rightactcnt',
					(SELECT COALESCE(SUM(pv), 0) FROM mlm_useractivation WHERE userid IN (SELECT userid FROM mlm_userstructure WHERE uplineid = '$mid' AND side = '2') ) AS 'rightpv',
					(SELECT COALESCE(SUM(pv), 0) FROM mlm_useractivation WHERE userid IN (SELECT userid FROM mlm_userstructure WHERE uplineid = '$mid' AND side = '0') ) AS 'leftpv'
					";
  	$downraw = DirectQuery($downquery);
  	$downdata = $downraw->result();
  	$downdata = $downdata[0];

    $rtndiv = '<div id="popover-content-'.$mid.'" class="hide">
                 <div id="div1" class="border">
                    <table style="width:100%; border: 0px double #008cff; border-collapse: collapse; ">
                    	<tr>
                    		<th>SponsorId : </th>
                      		<td colspan="2">'.$profiledata->username.'</td>	
                    	</tr>
                    	<tr>
                    		<th>Sponsor Name : </th>
                      		<td colspan="2">'.$profiledata->fullname.'</td>	
                    	</tr>
                        <tr>
                        <th>PackageName : </th>
                          <td colspan="2">'.$profiledata->packagename.'</td> 
                        </tr>
                    	<tr>
                    		<th></th>
                    		<th>Left</th>
                    		<th>Right</th>
                    	</tr>
                    	<tr>
                    		<th>Total Member</th>
                    		<td><b>'.$downdata->leftcnt.'</b></td>
                    		<td><b>'.$downdata->rightcnt.'</b></td>
                      </tr>
                      <tr>
                    		<th>Active Member</th>
                    		<td><b>'.$downdata->leftactcnt.'</b></td>
                    		<td><b>'.$downdata->rightactcnt.'</b></td>
                      </tr>
                      <tr>
                    		<th>Total Business</th>
                    		<td><b>'.$downdata->leftpv.'</b></td>
                    		<td><b>'.$downdata->rightpv.'</b></td>
                      </tr>
                    </table>
                </div>
              </div>';
  }
  return $rtndiv;
}

function treeviewmemberid($treedata, $upline, $side, $rtntype) {
	if($rtntype == 'userid') {
		if(isset($treedata[$upline][$side]) && $upline != '-') {
			return $treedata[$upline][$side]['userid'];
		}
		else {
			return '-';
		}
	}
	else if($rtntype == 'image') {
		if( (!isset($treedata[$upline][$side])) || $upline == '-') {
			return 'blank.png';
		}
		else if($treedata[$upline][$side]['activestatus'] == '1') {
			return 'active.png';
		}
   /* else if($treedata[$upline][$side]['purchasestatus'] == '1') {
      return 'repactive.png';
    }*/
		else {
			return 'inactive.png';
		}
	}
	else if($rtntype == 'username') {
		if( (!isset($treedata[$upline][$side])) || $upline == '-') {
			return '-';
		}
		else {
			return $treedata[$upline][$side]['username'];
		}
	}
	else if($rtntype == 'name') {
		if( (!isset($treedata[$upline][$side])) || $upline == '-') {
			return '-';
		}
		else {
			return $treedata[$upline][$side]['name'];
		}
	}
}

function checkdownid($user, $userid) {
	$response['status'] = false;
	if($userid == $user) {
		$response['status'] = true;
	}
	else {
		$linkQuery = "SELECT userid FROM mlm_userstructure WHERE userid = '$user' AND uplineid = '$userid'";
		$linkinfo = DirectQuery($linkQuery);
		$linkSave = $linkinfo->result();
		if(count($linkSave) > 0) {
			$response['status'] = true;
		}
	}
	return $response;
}
?>