<?php
require_once('basic/custom_curl.php');

$AuthURL = "https://api.linnworks.net//api/Auth/AuthorizeByApplication";

$appId = "35f5cb6e-022a-4243-91b6-5f5344eb67f2";
$appSecret = "65d0acaa-8bd6-48dc-9240-1e8e10ff5e98";
$oldToken = "2e82a94780925690923b0cc95b3bedbb";

$baseURL = "https://eu1.linnworks.net//api/";
$data = array('applicationId' => $appId, 'applicationSecret' => $appSecret, 'token' => $oldToken);




$result = GetAuth($AuthURL, $data);

$token = $result["Token"];


//var_dump(GetCategories());

$parameters["fkTransferId"] = "2031eab7-af2c-4256-b023-61664be3069d";
$parameters["pkStockItemId"] = "b6bc37c3-0bee-45a4-8c85-fba7700448d0";

$parameters["pageNumber"] = 1;
$parameters["entriesPerPage"] = 1;

//var_dump(AddItemToTransfer($parameters));
//var_dump(GetArchivedTransfers($parameters));

//$Dashboards = new Dashboards;
//var_dump($Dashboards->GetInventoryLocationIdList());
$Inventory = new Inventory;
var_dump($Inventory->GetInventoryItems());





function GetAuth($url, $parameters)
{
	var_dump($parameters);
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));

	$data = curl_exec($ch);
	curl_close($ch);

	$result = json_decode(json_decode(json_encode($data)), true);
	return $result;
}

function GetCategories(){
	global $baseURL, $token;


	$url = $baseURL . "Inventory/GetCategories";

	$ch = curl_init($url);
	var_dump($token);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		"Authorization : " . $token
		));
	$data = curl_exec($ch);
	curl_close($ch);

	$result = json_decode(json_decode(json_encode($data)), true);
	return $result;
}


function AddItemToTransfer($parameters){
	global $baseURL, $token;

	$url = $baseURL . "WarehouseTransfer/AddItemToTransfer";

	$ch = curl_init($url);
	var_dump($token);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		"Authorization : " . $token
		));
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));

	$data = curl_exec($ch);
	curl_close($ch);

	var_dump($data);

	$result = json_decode(json_decode(json_encode($data)), true);
	return $result;
}

function GetListTransfers(){
	global $baseURL, $token;
	$url = $baseURL . "WarehouseTransfer/GetListTransfers";

	curl_init_custom_no_parameters($url, $token);
}


function GetArchivedTransfers($parameters){
	global $baseURL, $token;

	$url = $baseURL . "WarehouseTransfer/AddItemToTransfer";

	$ch = curl_init($url);
	var_dump($token);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		"Authorization : " . $token
		));
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));

	$data = curl_exec($ch);
	curl_close($ch);

	var_dump($data);

	$result = json_decode(json_decode(json_encode($data)), true);
	return $result;
}

class Dashboards {
	protected $url, $token;


	public function __construct(){
		global $baseURL, $token;
		$this->url = $baseURL . "Dashboards/";
		$this->token = $token;
	}

	public function GetInventoryLocationData(){
		$url = $this->url . "GetInventoryLocationData";
		$result = curl_init_custom_no_parameters($url, $this->token);
		return $result;
	}

	public function GetInventoryLocationIdList(){
		$LocationData = $this->GetInventoryLocationData();
		$locationIdList = array();
		foreach ($LocationData as $location){
			array_push($locationIdList, $location["StockLocationId"]);
		}
		return $locationIdList;
	}
}

class Inventory {
	protected $url, $token;


	public function __construct(){
		global $baseURL, $token;
		$this->url = $baseURL . "Inventory/";
		$this->token = $token;
	}


	public function GetInventoryItems(){
		$url = $this->url . "GetInventoryItems";

		$view = array(
			  "Id" => "9bd2e841-c46e-4023-9986-ffa7ceb5a743",
			  "Name" => "sample string 2",
			  "Mode": 0,
			  "Source" => "sample string 3",
			  "SubSource" => "sample string 4",
			  "CountryCode" => "sample string 5",
			  "CountryName" => "sample string 6",
			  "Listing": 0,
			  "ShowOnlyChanged": true,
			  "IncludeProducts": 0,
			  "Filters": [
			    {
			      "FilterName": 0,
			      "DisplayName" => "SKU / Title / Barcode",
			      "FilterNameExact": [
			        "sample string 1",
			        "sample string 2"
			      ],
			      "Field": 2,
			      "Condition": 0,
			      "ConditionDisplayName" => "Equals",
			      "FilterLogic": 0,
			      "Value" => "sample string 1"
			    },
			    {
			      "FilterName": 0,
			      "DisplayName" => "SKU / Title / Barcode",
			      "FilterNameExact": [
			        "sample string 1",
			        "sample string 2"
			      ],
			      "Field": 2,
			      "Condition": 0,
			      "ConditionDisplayName" => "Equals",
			      "FilterLogic": 0,
			      "Value" => "sample string 1"
			    }
			  ],
			  "Columns": [
			    {
			      "ColumnName": 0,
			      "DisplayName" => "SKU",
			      "Group": 0,
			      "Field": 2,
			      "SortDirection": 0,
			      "Width": 1.1,
			      "IsEditable": false
			    },
			    {
			      "ColumnName": 0,
			      "DisplayName" => "SKU",
			      "Group": 0,
			      "Field": 2,
			      "SortDirection": 0,
			      "Width": 1.1,
			      "IsEditable": false
			    }
			  ],
			  "Channels": [
			    {
			      "Source" => "sample string 1",
			      "SubSource" => "sample string 2",
			      "Width": 3.1
			    },
			    {
			      "Source" => "sample string 1",
			      "SubSource" => "sample string 2",
			      "Width": 3.1
			    }
			  ]
			);

		$result = curl_init_custom_no_parameters($url, $this->token);
		return $result;
	}

}
?>






