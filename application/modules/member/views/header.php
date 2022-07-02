<?php 
	$logged_insess = $this->session->userdata('logged_in');
	$ProfilePictureImage = getProfilePicture($logged_insess['userid']);
	$memberName=getMemberName($logged_insess['userid']);
	$membuserid=$logged_insess['userid'];
	$tabelName="mlm_userlogin";
  $condition = "id ='$membuserid'";
  $getData=CreateSingleQuery($tabelName,$condition);
  $getData=json_decode($getData,true);
  $bcidactivestatus=$getData['data'][0]['activestatus'];

 

  $stas="color: red";
  if($bcidactivestatus=='1')
  {
  	$stas="color: green";
  }
?>
<header class="topbar-nav">
<nav class="navbar navbar-expand fixed-top bg-white">
<ul class="navbar-nav mr-auto align-items-center">
  <li class="nav-item">
    <a class="nav-link toggle-menu" href="javascript:void();">
     <i class="fa fa-bars menu-icon" style="color: white;"></i>
   </a>
  </li>
  
</ul>


<b style="<?php echo $stas; ?>;">Hello ! <?php echo $memberName;?></b>  
<ul class="navbar-nav align-items-center right-nav-link">
  
	<li class="nav-item">
		<a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
		  <span class="user-profile"><img src="<?php echo base_url(); ?>assets/images/Profile/<?php echo $ProfilePictureImage; ?>" class="img-circle" alt="user avatar"></span>
		</a>
		<ul class="dropdown-menu dropdown-menu-right">
		 <li class="dropdown-item user-details">
		  <a href="javaScript:void();">
		     <div class="media">
		       <div class="avatar"><img class="align-self-start mr-3" src="<?php echo base_url(); ?>assets/images/Profile/<?php echo $ProfilePictureImage; ?>" alt="user avatar"></div>
		      <div class="media-body">
		      <h6 class="mt-2 user-title"><?php echo $logged_insess['username']; ?></h6>
		      <p class="user-subtitle"></p>
		      </div>
		     </div>
		    </a>
		  </li>
		  <li class="dropdown-divider"></li>
		  <li class="dropdown-item"><a href="<?php echo $member_url; ?>MemberProfile"><i class="icon-envelope mr-2"></i> Profile</a></li>
		  <li class="dropdown-divider"></li>
		  <li class="dropdown-item"><a href="<?php echo $member_url; ?>Dashboard/logout"><i class="icon-power mr-2"></i> Logout</a></li>
		</ul>
	</li>
</ul>
</nav>
</header>
<div class="clearfix"></div>