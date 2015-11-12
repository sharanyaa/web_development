<!DOCTYPE html>
<html>
    <head>
	<meta charset='UTF-8'>
    <title>Real Estate Search</title>
        <script >
        function validateForm()
            {
			
			var a = true;
			var msg ="Verify the following fields:\n";
			if(document.form1.street.value=="" || document.form1.street.value.length==0)
			{    a = a && false;
			     msg += "\n Street Address";
			} 
			if(document.form1.city.value=="" || document.form1.city.value.length==0)
			{
			a= a && false;
			msg += "\n City";
			} 
			 var spattern = /^(\d|[a-zA-Z])([a-zA-Z]|\d|\s)+/g;
			var cpattern    =  /^([a-zA-Z])([a-zA-Z]|\s)+/g;
			//console.log("hhh");
			if(spattern.test(document.form1.street.value)==false) 
			{
         a= a && false;      
         msg += "Invalid Street Address!\n";
      }	
       if(!cpattern.test(document.form1.city.value)) {
         a = a && false;      
         msg += "Invalid City Code!\n";
      }	
			if(a==false)
			alert(msg);
			return a;
            }
        </script>
    </head>
	<body align="center"style=" margin-left: auto;
    margin-right: auto; margin-left:15vw;
    width: 70%;" >
	<div align="center" style=" width:40vw; border: 1px solid; margin-left:15vw; "  >
<form name="form1" method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>" onsubmit="return(validateForm())" >
	Street Address* : <input type="text" name="street" > <br/><br/>
			 City* : <input type="text" name="city"  ><br/><br/>
			 State* :
			 <!-- PHP form complete in w3 schools value display after clicking submit-->
			 <select name="state" size="1">
			 <option value="AK">AK</option>
			 <option value="AL">AL</option>
			 <option value="AR">AR</option>
			 <option value="AZ">AZ</option>
  <option value="CA">CA</option>
  <option value="CO">CO</option>
  <option value="CT">CT</option>
  <option value="DC">DC</option>
  <option value="DE">DE</option>
  <option value="GA">GA</option>
  <option value="FL">FL</option>
  <option value="HI">HI</option>
  <option value="IA">IA</option>
  <option value="ID">ID</option>
  <option value="IL">IL</option>
  <option value="IN">IN</option>
  <option value="KS">KS</option>
  <option value="KY">KY</option>
  <option value="LA">LA</option>
  <option value="MA">MA</option>
  <option value="MD">MD</option>
  <option value="ME">ME</option>
  <option value="MI">MI</option>
  <option value="MN">MN</option>
  <option value="MO">MO</option>
  <option value="MS">MS</option>
  <option value="MT">MT</option>
  <option value="NC">NC</option>
  <option value="ND">ND</option>
  <option value="NE">NE</option>
  <option value="NH">NH</option>
  <option value="NJ">NJ</option>
  <option value="NM">NM</option>
  <option value="NV">NV</option>
  <option value="NY">NY</option>
  <option value="OH">OH</option>
  <option value="OK">OK</option>
  <option value="OR">OR</option>
  <option value="PA">PA</option>
  <option value="RI">RI</option>
  <option value="SC">SC</option>
  <option value="SD">SD</option>
  <option value="TN">TN</option>
  <option value="TX">TX</option>
  <option value="UT">UT</option>
  <option value="VA">VA</option>
  <option value="VT">VT</option>
  <option value="WA">WA</option>
  <option value="WI">WI</option>
  <option value="WV">WV</option>
  <option value="WY">WY</option>
</select>
<br/><br/>
        <input type="submit" value="Search" name="searchBtn" style="{left-padding:100px}">
		<br/><br/>
            <img src="http://www.zillow.com/widgets/GetVersionedResource.htm?path=/static/logos/Zillowlogo_150x40_rounded.gif" alt="Real Estate on Zillow" cwidth="150" height="40" alt="Zillow Real Estate Search" />
<br/><br/>
<em>* - Mandatory fields.</em>
	</form>
	</div>
<?php
$street = $city =$state = "";
 if ($_SERVER["REQUEST_METHOD"] == "POST")
 {
 // echo "hi2";
 $street=test_input($_POST["street"]);
 $city=test_input($_POST["city"]);
 $state=test_input($_POST["state"]);
 //$id = "X1-ZWz1b2m8jewd8r_5ywzw";
 $id="X1-ZWz1b2e4iu88wb_1r7kw";
 $street=str_ireplace(" ","+",$street);
 $city=str_ireplace(" ", "+", $city);
// echo $street;
 //echo $city;
// echo $state;
  $url = 'http://www.zillow.com/webservice/GetDeepSearchResults.htm?zws-id=X1-ZWz1b2m8jewd8r_5ywzw&address='.$street.'&citystatezip='.$city.'%2C+'.$state.'&rentzestimate=true';
  $xml=simplexml_load_file($url);
  //print_r($xml);
  $searchresults=$xml->getName();
  $streetAddress=$cityAddress=$stateAddress=$zipcode=$hyperLink="";
  $useCode=$yearBuilt=$lotSizeSqFt=$finishedSqFt=$bathrooms=$bedrooms="";
  $taxAssessmentYear=$taxAssessment=$lastSoldPrice=$lastSoldDate="";
  $zestimate="";
  $zestimateDate="";$valueChangeThirtyDays="";
  $allTimePropLow=$allTimePropHigh="";
  $rentAmount="";
  $rentDate="";$rentChangeThirtyDays="";
  $allTimeRentLow=$allTimeRentHigh="";
  $errFlag=0;
  foreach($xml->children() as $c)
  {
  $searchresults=$c; 
  //echo $searchresults->getName()."0 ";
  if(strcmp($searchresults->getName(),"response")==0)
  { 
  $errFlag=1;
  }
  }
  if($errFlag==0)
  echo "<h3 align='center'>No exact match found!</h3>";
  else
  {
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
	$valueChangeThirtyDays=$zchild;
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
	$hyperLink=$linkChild; 
//	echo "HYPERLINK:".$hyperLink;
	}
	}
	}
	if(strcmp("address",$child2->getName())==0)
	{
//	echo "8 "; echo "<br>";
	foreach($child2->children() as $childd3)
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
	}
	}
	}
	}
	}
	}
  } 
  }
  }
 $addr=$streetAddress." ".$cityAddress." ".$stateAddress;
echo "<table>";
echo "<h3 align='center'>Search Results</h3>";
echo "<tr>";
echo "<td style='background-color: #E9CF06'colspan='4'>See more details for <a href=".$hyperLink.">".$addr."</a> on Zillow </td>";
echo "<tr><td colspan='4'> </td></tr>";
echo "</tr>";
echo "<tr>";
echo "<td>Property Type: </td>";
echo "<td>".$useCode."</td>";
echo "<td>Last Sold Price: </td>";
echo "<td>".$lastSoldPrice."</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Year Built: </td>";
echo "<td>".$yearBuilt."</td>";
echo "<td>Last Sold Date: </td>";
echo "<td>".$lastSoldDate."</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Lot Size: </td>";
echo "<td>".$lotSizeSqFt."</td>";
echo "<td>Zestimate&reg Property Estimate as of ".$zestimateDate.": </td>";
echo "<td>".$zestimate."</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Finished Area: </td>";
echo "<td>".$finishedSqFt."</td>";
echo "<td>30 Days Overall Change <img src="."down_r.gif"."> </td>";
echo "<td>".$valueChangeThirtyDays."</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Bathrooms: </td>";
echo "<td>".$bathrooms."</td>";
echo "<td>All Time Property Range: </td>";
echo "<td>$".$allTimePropLow." - ".$allTimePropHigh."</td>";
echo "</tr><tr><td>Bedrooms: </td>";
echo "<td>".$bedrooms."</td>";
echo "<td>Rent Zestimate&reg." ."Valuation as of ".$rentDate."</td>";
echo "<td>".$rentAmount."</td>";
echo "</tr>";
echo "<tr><td>Tax Assessment Year: </td>";
echo "<td>".$taxAssessmentYear."</td>";
echo "<td>30 Days Rent Change <img src='up_g.gif'></td>";
echo "<td>".$rentChangeThirtyDays."</td>";
echo "</tr><tr><td>Tax Assessment: </td>";
echo "<td>".$taxAssessment."</td>";
echo "<td>All Time Rent Change: </td>";
echo "<td>$".$allTimeRentLow." - ".$allTimeRentHigh."</td>";
echo "</tr></table>";
echo "<br/><br/>";
echo "&copy Zillow, Inc., 2006-2014. Use is subject to ";
echo "<a href='http://www.zillow.com/corp/Terms.htm'>Terms of Use</a><br/>";
echo "<a href='http://www.zillow.com/zestimate/'>What's a Zestimate?</a>";
 }
 }
 #DO VALIDATION IN JAVASCRIPT SUCH AS NO COMMA, SLASH SYMBOLS IN INPUT, etc.
 function test_input($data)
 {
 $data=trim($data);
 $data = stripslashes($data);
 $data = htmlspecialchars($data);
 return $data;
 }

?>

	</noscript>
	</body>
</html>