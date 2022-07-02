<?php
$AdminUrl=$this->config->item('GlobalAdminUrl');
$data=array();
if(isset($responseData['data'])){
	$data=$responseData['data'];	
}
?>
<?php 
	$thead="<table id='example' class='table table-striped table-bordered table-hover table-full-width'><thead><tr><th>SR</th>";
	$tbody="<tbody>";
	$tfoot="<tfoot><tr><th>SR</th>";
	$counter=0;
	$sum=0;
	$sumplus=0;
	$sumkey=array();
	for($i=0;$i<count($data);$i++){
	     $counter++;
		 $tbody=$tbody."<tr><td>".$counter."</td>";
	  	foreach ($data[$i] as  $key => $value) {
			$explode=explode("___",$key);
			$footclass = 'search_txt';
			$tdclass = '';
			if($counter == 1){ //For Creating th
      			if(@$explode[1] == "hide" || @$explode[1] == "imgtext" )
      			{
      			}
	      		else
      			{
      				if(@$explode[1] == "link") {
      					$key=$explode[0];
      					$footclass = '';

      				}
      				else if(@$explode[1] == "linkicon") {
      					$key = "<i class='".$explode[2]."'></i>";
      					$footclass = '';
      				}
      				else if(@$explode[1] == "linkjs") {
      					$key = "<i class='".$explode[2]."'></i>";
      					$footclass = '';
      				}
      				else if(@$explode[1] == "imagedisplay") {
      					$key=$explode[0];
      					$footclass = '';
      				}
      				else if(@$explode[1] == "sum"){
      					$key=$explode[0];
      					$sumkey[$explode[2]] = 0;
      					$footclass = $explode[2].'_sum';	
      				}
      				else if(@$explode[1] == "split"){
						$key=$explode[0];
					}
      				else if(@$explode[1] == "convertdate" || @$explode[1] == "convertdatetime") $key=@$explode[0];

      				$thead=$thead."<th class='search_txt'>". ucwords($key) ."</th>";
      				$tfoot=$tfoot."<th class='".$footclass."'>". ucwords($key) ."</th>";
      			}
      		}

      		if(@$explode[1] == "sum") {
				$tdclass = $explode[2];
				$sumkey[$explode[2]] = $sumkey[$explode[2]] + $value;
			}
			
			if(@$explode[1] == "hide")
      		{      			
      		}
      		else if(@$explode[1] == "imgtext"){ 
      			$getimgtextid=explode("###",$value);
      			$imgTextId=$getimgtextid[0];
      			$imgType=$getimgtextid[1];
      			$imgValue=$getimgtextid[2];

      			?>


      			<input type="hidden" id="imgtxt<?php echo $imgTextId;?>" name="imgtext" value="<?php echo $imgValue;?>" imgType="<?php echo $imgType;?>">

      		<?php }
      		else
      		{
      			
	      		if(@$explode[1] == "convertdate") {
	      			if($value!='')
	      				$value=ConvertDate($value);		      	
	      			else
	      				$value='-----';

	      		}
	      		else if(@$explode[1] == "convertdatetime") {
	      			if($value!='')
	      				$value=ConvertDateTime($value);		      	
	      			else
	      				$value='-----';

	      		}
		      	else if(@$explode[1] == "link"){
		      		$targetblank='';
		      		if(@$explode[2]=="targetblank"){
		      			$targetblank="target='_blank'";
		      		}

		      		$value = "<a ".$targetblank." href='". $AdminUrl.$value. "''>".$explode[0]."</a>";
		      	}
		      	else if(@$explode[1] == "linkicon"){
		      		$targetblank='';
		      		if(@$explode[3]=="targetblank"){
		      			$targetblank="target='_blank'";
		      		}
		      		$value = "<a ".$targetblank." href='". $AdminUrl.$value. "'' class='font20'> <i aria-hidden='true' class='".$explode[2]."'></i></a>";
		      		$tdclass = 'text-center';
		      	}
		      	else if(@$explode[1] == "linkjs"){
		      		$value = '<a href="javascript:void();" class="font20 deleteraw" deleteurl="'.$value.'"><i aria-hidden="true" class="'.$explode[2].'"></i></a>';
		      		$tdclass = 'text-center';
		      	}
		      	else if(@$explode[1] == "sum"){
					//$sum.$sumplus = $sum.$sumplus+$value;
					$sum.$sumplus = $sum + ($sumplus+$value);
		      	}
		      	else if(@$explode[1] == "imagedisplay"){
		      		if($value!=''){
		      			$imagesplit=explode("###",$value);
      					$imgtextdisplayId=0;
      					if(count($imagesplit)>1){
      						$imgtextdisplayId=$imagesplit[1];		
      					}	

		      			$value = "<button id='imageId' type='button' class='btn btn-primary waves-effect waves-light proofmodel' imgid='".$imgtextdisplayId."'  imgsrc='".$imagesplit[0]."' data-toggle='modal' data-target='#primarymodal'><i class='fa fa-eye'></i></button>";	
		      		}
		      		else{
		      			$value = "-----";
		      		}
		      		
		      	}
		      	else if(@$explode[1] == "split"){
					$splitkey = $explode[2];
					$newvalue = explode($splitkey, $value);
					$value = '';
					foreach ($newvalue as $newkey => $newvaalue) {
						$value .= $newvaalue."<br>";
					}
				}
	      	   	$tbody=$tbody."<td class='".$tdclass."'>". $value ."</td>";	
      	    }
	  	}
	  	$tbody=$tbody."</tr>";
	}
	$thead=$thead."</tr></thead>";
	$tbody=$tbody."</tbody>";
	$tfoot=$tfoot."</tfoot></table>";
	echo $thead.$tbody.$tfoot;
?>

<div class="modal fade" id="primarymodal" style="display: none;" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content border-primary">
			<div class="modal-header bg-primary">
			<h5 class="modal-title text-white"><i class="fa fa-star"></i>Image</h5>
			<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">×</span>
			</button>
			</div>
			<div class="modal-body">
				<div id="imgShowText" style="width:100%;"></div>
				<img src="" height="100%" width="100%" id="imagedisplay">
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-inverse-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
			</div>
		</div>
	</div>
</div>

