<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Content-type: text/javascript");
    error_reporting(0);
    $streetInput=$_GET["streetInput"];
    $cityInput=$_GET["cityInput"];
    $stateInput=$_GET["stateInput"];
    $urlstreet = preg_split("/[\s,]+/", $streetInput);
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
		$urlcity = preg_split("/[\s,]+/", $cityInput);
		foreach($urlcity as $key => $value)
		{
			$url.=$value;
			if(end($urlcity) !== $value)
			{
				$url.="+";
			}
		}
		$url.="%2C+".$stateInput;
		$url.="&rentzestimate=true";
            $xml=simplexml_load_file($url);
            if($xml->message[0]->code == 0):
            $val1 = number_format((double)$xml->response->results->result->rentzestimate->valuationRange->low, 2);
            $val2=number_format((double)$xml->response->results->result->rentzestimate->valuationRange->high, 2);
            $homeDetails = (string) $xml->response->results->result->links->homedetails;
            $street=(string)$xml->response->results->result->address->street;
            $city=(string)$xml->response->results->result->address->city;
            $state=(string)$xml->response->results->result->address->state;
            $zipcode=(string)$xml->response->results->result->address->zipcode;
            $latitude=(string)$xml->response->results->result->address->latitude;
            $longitude=(string)$xml->response->results->result->address->longitude;
            date_default_timezone_set('America/Los_Angeles');
			if( $xml->response->results->result->useCode!="")
			$useCode=(string) $xml->response->results->result->useCode; 
			else 
			$useCode="N/A";
			if (isset($xml->response->results->result->lastSoldPrice))
			     $lastSoldPrice=(string) "$".number_format(doubleval($xml->response->results->result->lastSoldPrice), 2);
            else
                $lastSoldPrice= "N/A";
        
            if(isset($xml->response->results->result->yearBuilt))
			 $yearBuilt=(string) $xml->response->results->result->yearBuilt; 
			else 
			 $yearBuilt="N/A";
             date_default_timezone_set('America/Los_Angeles') ;
			if(isset($xml->response->results->result->lastSoldDate))
			$lastSoldDate=(string) date('d-M-Y',strtotime($xml->response->results->result->lastSoldDate)); 
			else 
			$lastSoldDate="N/A";
       
            if (isset($xml->response->results->result->lotSizeSqFt))
			$lotSizeSqFt=(string) number_format(doubleval($xml->response->results->result->lotSizeSqFt)) . " sq.ft";
            else
            $lotSizeSqFt= "N/A";	
        
            if($xml->response->results->result->zestimate->{'last-updated'}!="")
			$estimateLastUpdate=(string) date('d-M-Y',strtotime($xml->response->results->result->zestimate->{'last-updated'})).":";
            else 
                $estimateLastUpdate="N/A";	
            if ($xml->response->results->result->zestimate->amount!=""){
			$estimateAmount=(string)"$".number_format(doubleval($xml->response->results->result->zestimate->amount), 2); 
            }
			else
			$estimateAmount= "N/A";
            $imgn = "http://cs-server.usc.edu:45678/hw/hw6/down_r.gif";
            $imgp = "http://cs-server.usc.edu:45678/hw/hw6/up_g.gif";
            $f=0;
			if ($xml->response->results->result->zestimate->valueChange!="")
			{
			$f=1;
				if($xml->response->results->result->zestimate->valueChange < 0)
				{
					 $estimateValueChangeSign = '-';
				}
				else 
				{
				    $estimateValueChangeSign = '+';
				}
			}
			if($f)
			$estimateValueChange = (string) "$".number_format(doubleval(abs($xml->response->results->result->zestimate->valueChange)), 2);
            else{
				$estimateValueChange ="N/A";}
            if(isset($xml->response->results->result->finishedSqFt))
			$finishedSqFt=(string) number_format(doubleval($xml->response->results->result->finishedSqFt)) . " sq.ft";
            else
            $finishedSqFt="N/A";	
        
            if($xml->response->results->result->bathrooms!="")
			$bathrooms=(string) $xml->response->results->result->bathrooms; 
			else 
			$bathrooms="N/A";
            
            if($xml->response->results->result->zestimate->valuationRange->low!="")
                $estimateValuationRangeLow = (string) "$".number_format(doubleval($xml->response->results->result->zestimate->valuationRange->low), 2);
			else 
                $estimateValuationRangeLow ="N/A";
                
             if($xml->response->results->result->zestimate->valuationRange->high!="")
			     $estimateValueationRangeHigh = (string)" $". number_format(doubleval($xml->response->results->result->zestimate->valuationRange->high),2);
			else 
                $estimateValueationRangeHigh ="N/A";
                
                
            if ($xml->response->results->result->bedrooms!="")
			 $bedrooms = (string) $xml->response->results->result->bedrooms;
            else 
                $bedrooms = "N/A";
                
            if($xml->response->results->result->rentzestimate->{'last-updated'}!="")
			$restimateLastUpdate = (string) date('d-M-Y',strtotime($xml->response->results->result->rentzestimate->{'last-updated'})).":";
else $restimateLastUpdate = (string) "N/A";
                
                if ($xml->response->results->result->rentzestimate->amount!="")
			 $restimateAmount = (string)"$".number_format(doubleval($xml->response->results->result->rentzestimate->amount),2);
else  $restimateAmount = "N/A";
            if(isset($xml->response->results->result->taxAssessmentYear))
			 $taxAssessmentYear = (string) date('Y',strtotime($xml->response->results->result->taxAssessmentYear)); 
			else 
			 $taxAssessmentYear ="N/A";
                
            $f=0;
			if ($xml->response->results->result->rentzestimate->valueChange!="")
			{
			$f=1;
			if($xml->response->results->result->rentzestimate->valueChange < 0)
			{
				$restimateValueChangeSign = '-';
			}
			else 
			{
				$restimateValueChangeSign = '+';
			}
			}
			if($f)
			$restimateValueChange = (string) "$".number_format(doubleval(abs($xml->response->results->result->rentzestimate->valueChange)), 2);
			else $restimateValueChange = (string) "N/A";
              
            if (isset($xml->response->results->result->taxAssessment))
			     $taxAssessment = (string)"$".number_format(doubleval($xml->response->results->result->taxAssessment), 2);
            else
                 $taxAssessment ="N/A";	    
            if ($val1!=0)
			$restimateValuationRangeLow = (string) "$".$val1;
                else 
                    $restimateValuationRangeLow = (string) "N/A";
             if ($val2!=0)
			 $restimateValuationRangeHigh = (string) "$ ".$val2;
                    else 
                    $restimateValuationRangeHigh= (string) "N/A";
        
    $arr = array(   'homeDetails' => $homeDetails,
                                'street' => $street,
                                'city' => $city,
                                'state' => $state,
                                'zipcode' => $zipcode,
                                'latitude' => $latitude,
                                'longitude' => $longitude,
                                'useCode' => $useCode,
                                'lastSoldPrice' => $lastSoldPrice,
                                'yearBuilt' => $yearBuilt,
                                'lastSoldDate' => $lastSoldDate,
                                'lotSizeSqFt' => $lotSizeSqFt,
                                'estimateLastUpdate' => $estimateLastUpdate,
                                'estimateAmount' => $estimateAmount,
                                'finishedSqFt' => $finishedSqFt,
                                'estimateValueChangeSign' => $estimateValueChangeSign,
                                'imgn' => $imgn,
                                'imgp' => $imgp,
                                'estimateValueChange' => $estimateValueChange,
                                'bathrooms' => $bathrooms,
                                'estimateValuationRangeLow' => $estimateValuationRangeLow,
                                'estimateValueationRangeHigh' => $estimateValueationRangeHigh,
                                'bedrooms' => $bedrooms,
                                'restimateLastUpdate' => $restimateLastUpdate ,
                                'restimateAmount' => $restimateAmount,
                                'taxAssessmentYear' => $taxAssessmentYear,
                                'restimateValueChangeSign' => $restimateValueChangeSign,
                                'restimateValueChange' => $restimateValueChange,
                                'taxAssessment' => $taxAssessment,
                                'restimateValuationRangeLow' => $restimateValuationRangeLow,
                                'restimateValuationRangeHigh' => $restimateValuationRangeHigh
                                );
                
                $zpid = (string)$xml->response->results->result->zpid;
                        $zwsid = "X1-ZWz1b2mw7s90y3_5i268";
                        $duration='1year';
                        $fields = array('zws-id' => $zwsid,
                                        'unit-type' => 'percent',
                                        'zpid' => $zpid,
                                        'width' => '600',
                                        'height' => '300',
                                        'chartDuration' => $duration
                                       );
                        $url = "http://www.zillow.com/webservice/GetChart.htm?" . http_build_query($fields,'',"&");
                        $xmlFile = simplexml_load_file($url);
                        //print_r($xmlFile);
                        $urlimage1 = (string)$xmlFile->response[0]->url;
                        $arr1 = array('url' => $urlimage1);
                        $duration='5years';
                        $fields = array('zws-id' => $zwsid,
                                        'unit-type' => 'percent',
                                        'zpid' => $zpid,
                                        'width' => '600',
                                        'height' => '300',
                                        'chartDuration' => $duration
                                       );
                        $url = "http://www.zillow.com/webservice/GetChart.htm?" . http_build_query($fields,'',"&");
                        $xmlFile = simplexml_load_file($url);
                        $urlimage2 =(string)$xmlFile->response[0]->url;
                        $arr2 = array('url' => $urlimage2);
                        $duration='10years';
                        $fields = array('zws-id' => $zwsid,
                                        'unit-type' => 'percent',
                                        'zpid' => $zpid,
                                        'width' => '600',
                                        'height' => '300',
                                        'chartDuration' => $duration
                                       );
                        $url = "http://www.zillow.com/webservice/GetChart.htm?" . http_build_query($fields,'',"&");
                        $xmlFile = simplexml_load_file($url);
                        $urlimage3 = (string)$xmlFile->response[0]->url;
                        $arr3 = array('url' => $urlimage3);
                        $imageArr = array(
                                        'oneyear' => $arr1,
                                        'fiveyears' => $arr2,
                                        'tenyears' => $arr3);
                        $finalArray = array('result' => $arr,
                                        'chart' => $imageArr,'messageCode' => '0');
                        $json = json_encode($finalArray);
                        echo $json;
                else:
                    $arr= array('messageCode'=>'1');
                    $json = json_encode($arr);
                    echo $json;
                endif;