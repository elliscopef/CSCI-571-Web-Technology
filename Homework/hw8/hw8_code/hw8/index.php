
<?php

$category = $_GET['category'];
$chamber = $_GET['chamber'];
$keyword = $_GET['keyword'];
$bioguide = $_GET['bioguide'];
$bill_active = $_GET['bill_active'];

// echo $chamber;
// echo $keyword ;
// echo $category;

if($category=="legistlator"){
	if($bioguide!=null){
		return legislatorBioguideSearch($bioguide,$chamber,$keyword);
	}
	return legislatorSearch($chamber,$keyword);

}else if($category=="bills"){
	if($bioguide!=null){
		return legistlatorBillSearch($bioguide);
	}
	if($bill_active=="true"){
		return ActiveBillsSearch($chamber,$keyword);
	}else if($bill_active=="false"){
		return NewBillsSearch($chamber,$keyword);
	}
	
}else if($category=="committees"){
	if($bioguide!=null){
		return legistlatorCommitteesSearch($bioguide);
	}
	return CommitteesSearch($chamber,$keyword);
}


//"http://104.198.0.197:8080/legislators?apikey=".$apikey."&per_page=all"
function legislatorSearch($chamber,$keyword){
	$apikey = 'ad112f71df2e4109864ee87613db82d8';
	if($chamber==null){
		$url = "http://104.198.0.197:8080/legislators?apikey=".$apikey."&per_page=all";
	}else{
		$url = "http://104.198.0.197:8080/legislators?chamber=".$chamber."&state=".$keyword."&apikey=".$apikey;
	}
	$res = file_get_contents($url);
	echo $res;
	return $res;
}

function legislatorBioguideSearch($bioguide,$chamber,$keyword){
	$apikey = 'ad112f71df2e4109864ee87613db82d8';
	$url = "http://104.198.0.197:8080/legislators?chamber=".$chamber."&state=".$keyword."&bioguide_id=".$bioguide."&apikey=".$apikey;
	$res = file_get_contents($url);
	echo $res;
	return $res;
}



function legistlatorBillSearch($bioguide){
	$apikey = 'ad112f71df2e4109864ee87613db82d8';
	$url = "http://104.198.0.197:8080/bills?per_page=5&apikey=".$apikey."&sponsor.bioguide_id=".$bioguide;
	$res = file_get_contents($url);
	echo $res;
	return $res;
}
function legistlatorCommitteesSearch($bioguide){
	$apikey = 'ad112f71df2e4109864ee87613db82d8';
	$url = "http://104.198.0.197:8080/committees?per_page=5&"."&apikey=".$apikey."&member_ids=".$bioguide;
	$res = file_get_contents($url);
	echo $res;
	return $res;
}




function ActiveBillsSearch($chamber,$keyword){
	$apikey = 'ad112f71df2e4109864ee87613db82d8';
	$url = "http://104.198.0.197:8080/bills?per_page=50&history.active=true&last_version.urls.pdf__exists=true&apikey=".$apikey ;
	$res = file_get_contents($url);
	echo $res;
	return $res;

}

function NewBillsSearch($chamber,$keyword){
	$apikey = 'ad112f71df2e4109864ee87613db82d8';
	$url = "http://104.198.0.197:8080/bills?per_page=50&history.active=false&last_version.urls.pdf__exists=true&apikey=".$apikey ;
	$res = file_get_contents($url);
	echo $res;
	return $res;

}

function CommitteesSearch($chamber,$keyword){
	$apikey = 'ad112f71df2e4109864ee87613db82d8';
	$url = "http://104.198.0.197:8080/committees?committee_id=".rawurlencode($keyword)."&chamber=".rawurlencode($chamber)."&apikey=".$apikey ;
	$res = file_get_contents($url);
	echo $res;
	return $res;
}


?>