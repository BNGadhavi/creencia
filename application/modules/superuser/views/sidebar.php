<?php
$AdminUrl=$this->config->item('GlobalAdminUrl');
if (!isset($this->session->userdata['adminLoggedIn'])) {
	$redirection = base_url('index.php/superuser/login');
	header("location: $redirection");
}
$AdminSesData = $this->session->userdata('adminLoggedIn');
$CommonUrl=$this->config->item('GlobalCommonUrl');
?>
<div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
<div class="brand-logo">
	<a href="<?php echo $AdminUrl; ?>Dashboard">
		<center> <h4><?php //echo GetCompanyName();?></h4><img src="<?php echo base_url(); ?>assets/web/images/logo.png" class="logo-icon" alt="logo icon" style='max-width: 100%'></center>
	</a>
</div>
<ul class="sidebar-menu do-nicescrol">
	<li class="sidebar-header">Menu</li>
	<li>
        <a href="<?php echo $AdminUrl; ?>Dashboard" class="waves-effect">
		<i class="fa fa-home"></i> <span>Dashboard</span>
		<small class="badge float-right badge-info"></small>
		</a>
    </li>

	<?php 
		$AdminMenu = AdminMenuRight($AdminSesData['userid']);
		foreach ($AdminMenu as $key => $value) {

			?>
				<li>
				    <a href="javaScript:void();" class="waves-effect">
				    <i class="<?php echo $value['icon']; ?>"></i> <span><?php echo $value['Parent Menu']; ?></span>
			        <i class="fa fa-angle-left float-right"></i>
			        </a>
			        <?php if(COUNT($value['sub']) > 0) {
			        	echo '<ul class="sidebar-submenu">';
			        	foreach ($value['sub'] as $k => $v) {
			        		?>
			        			<li><a href="<?php echo $AdminUrl.$v['link']; ?>"><i class="<?php echo $v['icon'] ?>"></i><?php echo $v['name']; ?></a></li>
			        		<?php
			        	}
			        	echo '</ul>';
			        } ?>
  				</li>
			<?php
		}
	?>
	<li>
        <a href="<?php echo $AdminUrl; ?>Dashboard/logout" class="waves-effect">
          <i class="fa fa-home"></i> <span>Logout</span>
          <small class="badge float-right badge-info"></small>
        </a>
    </li>
</ul>
</div>