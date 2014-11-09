<?php
if (is_ajax()) {
  if (isset($_POST["action"]) && !empty($_POST["action"])) { //Checks if action value exists
    $action = $_POST["action"];
    switch($action) { //Switch case for value of action
      case "test": test_function(); break;
    }
  }
}
 
//Function to check if the request is an AJAX request
function is_ajax() {
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}
 
function test_function(){
  $return = $_POST;
    $urlstreet = preg_split("/[\s,]+/", $return["streetInput"]);
		$url="http://www.zillow.com/webservice/GetDeepSearchResults.htm?zws-id=X1-ZWz1b2mw7s90y3_5i268&address=";
		foreach($urlstreet as $key => $value)
		{
			$url.=$value;
			if(end($urlstreet) !== $value)
			{
				$url.="+";
			}
		}
		$url.="&citystatezip=";
		$urlcity = preg_split("/[\s,]+/", $return["cityInput"]);
		foreach($urlcity as $key => $value)
		{
			$url.=$value;
			if(end($urlcity) !== $value)
			{
				$url.="+";
			}
		}
		$url.="%2C+".$return["stateInput"];
		$url.="&rentzestimate=true";
		$xml=simplexml_load_file($url);
        $homedetails=:"http:\/\/www.zillow.com\/homedetails\/".$xml->response->results->result->address->street." ".$xml->response->results->result->address->city." ".$xml->response->results->result->address->state." ".\/$xml->response->results->result->address->zipcode\/";
            $street=$xml->response->results->result->address->street;
            $city=$xml->response->results->result->address->city;
            $state=$xml->response->results->result->address->state;
            $zipcode=$xml->response->results->result->address->zipcode;
  $return["json"] = json_encode($return);
  echo json_encode($return);
}
?>