<?php 
	//print_r($includePageData);
	$mddiv = '<div class="row">';
	$headdiv = '';
?>

<?php
foreach ($includePageData['data']['0'] as $key => $value) {

	$explode=explode("___",$key);
	$orignalKey=$explode[0];
	$tag=$explode[1];

	$size=$explode[2];

	if(isset($explode[3])){
		if($explode[3] == 'convertdate')
			$value = ConvertDate($value);
	}
	if($tag == "div"){
		$mddiv .= "<div class='col-md-".$size."'>".$orignalKey." : ".$value."</div>";
	}
	else {
		$headdiv .= "<h5>Head</h5>";
	}
}
$mddiv .= "</div>";
echo $headdiv;
echo $mddiv;
?>
