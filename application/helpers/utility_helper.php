<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');	
	function ListOfNews($data){
		$MainTable="mlm_news";
		$Condition="1=1";
		$link='id,';
		if(isset($data['adminFlag'])){
			$link="concat('Utility/DeleteNews/',id) as Delete___link,";
		}
		$SelectColumn=$link."news as News";
		$NewsList=CreateSingleQuery($MainTable,$Condition,$SelectColumn,'entrydate desc');
        $NewsList=json_decode($NewsList,true);  
        return  $NewsList;
	}

	function ListOfAchiver($data){
		$MainTable="mlm_achiever";
		$Condition="1=1";
		$link='id,';
		if(isset($data['adminFlag'])){
			$link="concat('Utility/DeleteAchiver/',id) as Delete___link,";
		}
		$SelectColumn=$link."name as Name";
		$AchiverList=CreateSingleQuery($MainTable,$Condition,$SelectColumn,'entrydate desc');
        $AchiverList=json_decode($AchiverList,true);  
        return  $AchiverList;	
	}
	function ListOfContactus($data){
		$MainTable="mlm_contactus";
		$Condition="1=1";
		$link='id,';
		if(isset($data['adminFlag'])){
			$link="concat('Utility/DeleteContact/',id) as Delete___link,";
		}
		$SelectColumn=$link."entrydate as 'Date___convertdate',name as Name , mobile as 'Mobile No' , subject as 'Subject' , msg as 'Message'";
		$AchiverList=CreateSingleQuery($MainTable,$Condition,$SelectColumn,'entrydate desc');
        $AchiverList=json_decode($AchiverList,true);  
        return  $AchiverList;	
	}
?>