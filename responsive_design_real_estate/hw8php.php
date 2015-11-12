<?php
header("Access-Control-Allow-Origin: *");
$street = $city =$state = "";
//if ($_SERVER["REQUEST_METHOD"] == "GET")
{
// echo "hi2";
if(isset($_GET["streetInput"]))
$street=test_input($_GET["streetInput"]);
if(isset($_GET["cityInput"]))
$city=test_input($_GET["cityInput"]);
if(isset($_GET["stateInput"]))
$state=test_input($_GET["stateInput"]);
//$id = "X1-ZWz1b2m8jewd8r_5ywzw";
$id="X1-ZWz1b2e4iu88wb_1r7kw";
$street=str_ireplace(" ","+",$street);
$city=str_ireplace(" ", "+", $city);
// echo $street;
//echo $city;
// echo $state;

//http://www.zillow.com/webservice/GetDeepSearchResults.htm?zws-id=X1-ZWz1b2e4iu88wb_1r7kw&address=2636+Menlo+Avenue&citystatezip=los+angeles%2C+CA&rentzesimate=true
$url = 'http://www.zillow.com/webservice/GetDeepSearchResults.htm?zws-id=X1-ZWz1b2m8jewd8r_5ywzw&address='.$street.'&citystatezip='.$city.'%2C+'.$state.'&rentzestimate=true';
$xml=simplexml_load_file($url);
//print_r($xml);
$searchresults=$xml->getName();
$streetAddress=$cityAddress=$stateAddress=$zipcode=$homeDetails="";
$useCode=$yearBuilt=$lotSizeSqFt=$finishedSqFt=$bathrooms=$bedrooms="";
$taxAssessmentYear=$taxAssessment=$lastSoldPrice=$lastSoldDate="";
$zestimate=""; $zpid="";
$zestimateDate="";$overallChangeThirtyDays="";
$allTimePropLow=$allTimePropHigh="";
$rentAmount="";
$rentDate="";$rentChangeThirtyDays="";
$allTimeRentLow=$allTimeRentHigh="";
$errFlag=0; $errorCode=0;
foreach($xml->children() as $c)
	{
	$searchresults=$c; 
	//echo $searchresults->getName()."0 ";
	if(strcmp($searchresults->getName(),"response")==0)
		{ 
		$errFlag=1; $errorCode=0;
		}
	else
	{
		if(strcmp($searchresults->getName(),"message")==0)
		{
			foreach($searchresults->children() as $c1)
			{
			if(strcmp($c1->getName(),"code")==0)
				$errorCode=	$c1;
			}
		}
	}
	}
/*
if($errFlag==0)
{
//$array= array("error"=>$errorCode." ");
//echo json_encode($array);
}
else
{*/
foreach($xml->children() as $c)
	{
	$searchresults=$c; 
	//echo $searchresults->getName()."0 ";
	if(strcmp($searchresults->getName(),"response")==0)
		{ 
		// echo "2 "; echo "<br>";
		foreach($searchresults->children() as $child)
			{  
			$childd=$child;  
			//	echo $childd->getName()."3 ";
			if(strcmp("results", $childd->getName())==0)
				{
				//	echo "4 ";echo "<br>";
				foreach($childd->children() as $child1)
					{
					$childd1=$child1;
					//	echo $childd1->getName()."5 ";
					if(strcmp($childd1->getName(),"result")==0)
						{
						//echo "666666 ".$child1->getName();echo "<br>";
						foreach($childd1->children() as $childd2)//zpid, links,address, taxAssessmentYear...
							{
							$child2=$childd2;
							//echo $child2->getName()."777777777 <br>";
							if(strcmp("rentzestimate",$child2->getName())==0)
								{
								foreach($child2->children() as $rentZes) // rent zestimates children
								{
								$rentz=$rentZes;
								if(strcmp($rentz->getName(),"amount")==0)
									{
									$rentAmount=$rentz;
									}
								if(strcmp("last-updated",$rentz->getName())==0)
									{
									$rentDate=$rentz;
									}
								if(strcmp("valueChange",$rentz->getName())==0)
									{
									$rentChangeThirtyDays=$rentz;
									}
								if(strcmp("valuationRange",$rentz->getName())==0)
									{
									foreach($rentz->children() as $rangezz) //value range low high
										{
										$rangez=$rangezz;
										if(strcmp($rangez->getName(),"low")==0)
											{
											$allTimeRentLow=$rangez;
											//echo "RANGE LOW: ".$allTimePropLow;
											}
										if(strcmp($rangez->getName(),"high")==0)
											{
											$allTimeRentHigh=$rangez;
											}
										}
									}
								}
							}
						if(strcmp("zestimate",$child2->getName())==0)
							{
							foreach($child2->children() as $z)
								{
								$zchild=$z;
								if(strcmp("amount",$zchild->getName())==0)
									{
									$zestimate=$zchild;
									}
								if(strcmp("last-updated",$zchild->getName())==0)
									{
									$zestimateDate=$zchild;
									//echo "ZESTIMATEDATE: ".$zestimateDate;
									}
								if(strcmp("valueChange",$zchild->getName())==0)
									{
									$overallChangeThirtyDays=$zchild;
									}
								if(strcmp("valuationRange",$zchild->getName())==0)
									{
									//echo "VALUERANGE---".$zchild->getName();
									foreach($zchild->children() as $rangeChh) //value range low high
										{
										$rangeCh=$rangeChh;
										if(strcmp($rangeCh->getName(),"low")==0)
											{
											$allTimePropLow=$rangeCh;
											//echo "RANGE LOW: ".$allTimePropLow;
											}
										if(strcmp($rangeCh->getName(),"high")==0)
											{
											$allTimePropHigh=$rangeCh;
											}
										}
									}
								}
							}
						if(strcmp("useCode",$child2->getName())==0)
							{
							$useCode=$child2;
							//echo "USECODE: ".$useCode;
							}
						if(strcmp("zpid",$child2->getName())==0)
							{
							$zpid=$child2;
							//echo "USECODE: ".$useCode;
							}
						if(strcmp("yearBuilt",$child2->getName())==0)
							{
							$yearBuilt=$child2;
							//echo "YEAR BUILT:".$yearBuilt;
							}
						if(strcmp("lotSizeSqFt",$child2->getName())==0)
							{
							$lotSizeSqFt=$child2;
							//echo "LOT SIZE: ".$lotSizeSqFt;
							}
						if(strcmp("finishedSqFt",$child2->getName())==0)
							{
							$finishedSqFt=$child2;
							//echo "FINISHED: ".$finishedSqFt;
							}
						if(strcmp("bathrooms",$child2->getName())==0)
							{
							$bathrooms=$child2;
		 					//echo "BATH: ".$bathrooms;
							}
						if(strcmp("bedrooms",$child2->getName())==0)
		 					{
		  					$bedrooms=$child2;
		 					 //echo "BED :".$bedrooms;
		  					}
					    if(strcmp("lastSoldDate",$child2->getName())==0)
						    {
						    $lastSoldDate=$child2;
						    //echo "SOLD DATE: ".$lastSoldDate;
						    }
						if(strcmp("lastSoldPrice",$child2->getName())==0)
		 					{
		  					$lastSoldPrice=$child2;
		  					//echo "LAST PRICE: ".$lastSoldPrice;
		  					}
		  				if(strcmp("taxAssessmentYear",$child2->getName())==0)
						    {
							$taxAssessmentYear=$child2;
		 					//echo "LAST PRICE: ".$lastSoldPrice;
		  					}
					    if(strcmp("taxAssessment",$child2->getName())==0)
						    {
							$taxAssessment=$child2;
		  					//echo "LAST PRICE: ".$lastSoldPrice;
		  					}
		  				if(strcmp("links",$child2->getName())==0) 
		  					{ 
		  					//	echo " 10 <br>";
		 					foreach($child2->children() as $linkCh)
		  						{
		  						$linkChild=$linkCh;
		  						//	echo $linkChild->getName()."11 <br>";
		  						if(strcmp("homedetails",$linkChild->getName())==0)
		  							{
		  							$homeDetails=$linkChild; 
		  							//	echo "HYPERLINK:".$homedetails;
		 							}
		 						 }
		 					 }
		 				if(strcmp("address",$child2->getName())==0) //if 11
		  					{
		  					//	echo "8 "; echo "<br>";
		  					foreach($child2->children() as $childd3)// foreach 11
		  						{
		  						$child3=$childd3;
		  						//echo $child3->getName()."9 <br>";
		  						if(strcmp("street",$child3->getName())==0)
		  							{
		 							$streetAddress=$child3;  
		  							//echo " street: ".$streetAddress;
		  							}
		  						if(strcmp("zipcode",$child3->getName())==0)
		  							{
		  							$zipcode=$child3;
		  							//echo " zip: ".$zipcode;
		  							}
		  						if(strcmp("city",$child3->getName())==0)
		  							{
		  							$cityAddress=$child3;
		 							//echo " city: ".$cityAddress;
		  							}
		  						if(strcmp("state",$child3->getName())==0)
		  							{
		  							$stateAddress=$child3;
		  							//echo " state: ".$stateAddress;
		 							}
		  						}// for each 11
		  					}//if 11
						}
					}
				}
			}
		} 
	}
} 
//}

		  $charturl1='http://www.zillow.com/webservice/GetChart.htm?zws-id=X1-ZWz1b2m8jewd8r_5ywzw&unit-type=percent&zpid='.$zpid.'&width=600&height=300&chartDuration=1year';
		  $charturl2='http://www.zillow.com/webservice/GetChart.htm?zws-id=X1-ZWz1b2m8jewd8r_5ywzw&unit-type=percent&zpid='.$zpid.'&width=600&height=300&chartDuration=5years';
		  $charturl3='http://www.zillow.com/webservice/GetChart.htm?zws-id=X1-ZWz1b2m8jewd8r_5ywzw&unit-type=percent&zpid='.$zpid.'&width=600&height=300&chartDuration=10years';
		  $xml1=simplexml_load_file($charturl1);
		  $xml2=simplexml_load_file($charturl2);
		  $xml3=simplexml_load_file($charturl3);
		  
		  
		  //print_r($xml);
		  $searchresults1=$xml1->getName();
		  $imgurl1=$imgurl2=$imgurl3="";
		  $errFlag1=$errFlag2=$errFlag3=0;
		  //----------------------------------------------------------------------  
		  //IMAGE1 
		  foreach($xml1->children() as $c)
		  {
		  $searchresults1=$c; 
		  //echo $searchresults->getName()."0 ";
		  if(strcmp($searchresults1->getName(),"response")==0)
		  { 
		  $errFlag1=1;
		  }
		  }
		  
		  if($errFlag1==0);
		  //  echo "<h3 align='center'>No exact match found!</h3>";
		  else
		  {
		  foreach($xml1->children() as $c)
		  {
		  $searchresults1=$c; 
		  //echo $searchresults->getName()."0 ";
		  if(strcmp($searchresults1->getName(),"response")==0)
		  { 
		  // echo "2 "; echo "<br>";
		  foreach($searchresults1->children() as $child)
		  {  
		  $childd=$child;  
		  //	echo $childd->getName()."3 ";
		  if(strcmp("url", $childd->getName())==0)
		  {
		  $imgurl1=$childd;
		  }
		  }
		  }
		  }
		  }
		  
		  //----------------------------------------------------------------------  
		  //IMAGE2
		  
		  foreach($xml2->children() as $c)
		  {
		  $searchresults2=$c; 
		  //echo $searchresults->getName()."0 ";
		  if(strcmp($searchresults2->getName(),"response")==0)
		  { 
		  $errFlag2=1;
		  }
		  }
		  
		  if($errFlag2==0);
		  //  echo "<h3 align='center'>No exact match found!</h3>";
		  else
		  {
		  foreach($xml2->children() as $c)
		  {
		  $searchresults2=$c; 
		  //echo $searchresults->getName()."0 ";
		  if(strcmp($searchresults2->getName(),"response")==0)
		  { 
		  // echo "2 "; echo "<br>";
		  foreach($searchresults2->children() as $child)
		  {  
		  $childd=$child;  
		  //	echo $childd->getName()."3 ";
		  if(strcmp("url", $childd->getName())==0)
		  {
		  $imgurl2=$childd;
		  }
		  }
		  }
		  }
		  }
//----------------------------------------------------------------------  
//IMAGE3

foreach($xml3->children() as $c)
{
$searchresults3=$c; 
//echo $searchresults->getName()."0 ";
if(strcmp($searchresults3->getName(),"response")==0)
{ 
$errFlag3=1;
}
}

if($errFlag3==0);
//  echo "<h3 align='center'>No exact match found!</h3>";
else
{
foreach($xml3->children() as $c)
{
$searchresults3=$c; 
//echo $searchresults->getName()."0 ";
if(strcmp($searchresults3->getName(),"response")==0)
{ 
// echo "2 "; echo "<br>";
foreach($searchresults3->children() as $child)
{  
$childd=$child;  
//	echo $childd->getName()."3 ";
if(strcmp("url", $childd->getName())==0)
{
$imgurl3=$childd;
}
}
}
}
}

// echo $homeDetails;
// $array=array("homedetails"=>$homeDetails." ");
$array1= array('homedetails'=>$homeDetails." ", 
"propertyType"=> $useCode." ",
"yearBuilt"=>$yearBuilt." ",
"lotSizeSqFt"=>$lotSizeSqFt." ", 
"finishedSqFt"=>$finishedSqFt." ", 
"bathrooms"=>$bathrooms." ",
"bedrooms"=>$bedrooms." ",
"taxAssessmentYear"=>$taxAssessmentYear." ",
"taxAssessment"=>$taxAssessment." ",
"lastSoldPrice"=>$lastSoldPrice." ", 
"lastSoldDate"=>$lastSoldDate." ",
"zestimate"=>$zestimate." ",
"zestimateDate"=>$zestimateDate." ", 
"overallChangeThirtyDays"=>$overallChangeThirtyDays." ",
"allTimePropHigh"=>$allTimePropHigh." ",
"allTimePropLow"=>$allTimePropLow." ",
"rentZestimateAmount"=>$rentAmount." ", 
"rentZestimateDate"=>$rentDate." ",
"rentChangeThirtyDays"=>$rentChangeThirtyDays." ",
"allTimeRentLow"=>$allTimeRentLow." ", 
"allTimeRentHigh"=>$allTimeRentHigh." ",
"street"=>$streetAddress." ", 
"city"=>$cityAddress." ",
"state"=>$stateAddress." ", 
"zipcode"=>$zipcode." ", "imgurl1"=>$imgurl1." ", "imgurl2"=>$imgurl2." ", "imgurl3"=>$imgurl3." ", "error"=>$errorCode." ");
/* 
"error"=>$errorCode." ");*/
// echo $array("homedetails");
//print_r($array);
echo json_encode($array1);
}

function test_input($data)
{
$data=trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
return $data;
}

?>