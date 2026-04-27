<?php
foreach ($form["fields"] as &$field) {
    //see if this is a multi-field, like name or address
    if (is_array($field["inputs"])) {
        // loop through inputs
        foreach ($field["inputs"] as &$input) {
            $label = $input["label"];
            // get value from entry object; change the id to a string
            $value = $entry[strval($input["id"])];

            if (!empty($value)) {
                $output .= $label . '!-@' . $value . '#@';
            }
        }
    } else {
        $label = $field["label"];
        // get value from entry object
        $value = $entry[$field["id"]];

        if (!empty($value)) {
            $output .= $label . '!-@' . $value . '#@';
        }
    }
}

$array = array();
$lines = explode('#@', $output);
foreach ($lines as $line) {
    list($key, $value) = explode("!-@", $line);
    $array[$key] = $value;
}

$api_keyy = get_option('insightly_api_key');
//Get first name and last name
if ($array['First'] != "") {
    $name = $array['First'];
} else if ($array['Name'] != "") {
    $name = $array['Name'];
} else if ($array['Last'] != "") {
    $name = $array['Last'];
}

$name = explode(' ', $name);
$first = "";
$last = "";

for ($i = 0; $i < sizeof($name); $i++) {
    if ($i == 0)
        $first = $name[$i];
    else
        $last = $last . " " . $name[$i];
}

$last = trim($last);
if ($last == "")
    $last = "None";

if ($array['Message'] != "") {
    $Notes = $array['Message'];
} else {
    $Notes = $array['Notes'];
}

$service_url = 'https://api.insight.ly/v2.2/Leads';
$ch = curl_init($service_url);
$http_uri = 'https://' . $_SERVER['HTTP_HOST'];
curl_setopt($ch,
    CURLOPT_HTTPHEADER,
    array('Content-Type: application/json',
        'Authorization: Basic ' . base64_encode($api_keyy)));

curl_close($process);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$title = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$title = str_replace('-', ' ', $title);

if ($array['Locations'] != "") {
    $location = $array['Locations'];
} else {
    $location = "Not Provided";
}

if ($array['Services'] != "") {
    $desired = $array['Services'];
} else {
    $desired = "Not Provided";
}

if ($array['Website Address'] != "") {
    $address = $array['Website Address'];
} else {
    $address = $array['Address'];
}

$data = array(
    'FIRST_NAME' => $first,
    'LAST_NAME' => $last,
    'EMAIL_ADDRESS' => $array['Email'],
    'PHONE_NUMBER' => $array['Phone'],
    'ADDRESS_STREET' => $address,
    'ADDRESS_CITY' => $array['City'],
    'ADDRESS_STATE' => $array['State'],
    'ADDRESS_COUNTRY' => $array['Country'],
    'LEAD_DESCRIPTION' => $Notes,

    'CUSTOMFIELDS' => array(
        [
            "CUSTOM_FIELD_ID" => 'LEAD_FIELD_1',
            "FIELD_VALUE" => $array['IP Address']
        ],
        [
            "CUSTOM_FIELD_ID" => 'LEAD_FIELD_2',
            "FIELD_VALUE" => $array['referal_url']
        ],
        [
            "CUSTOM_FIELD_ID" => 'LEAD_FIELD_3',
            "FIELD_VALUE" => $entry['source_url']
        ],
        [
            "CUSTOM_FIELD_ID" => 'LEAD_FIELD_4',
            "FIELD_VALUE" => $array['User Agent']
        ],
        [
            "CUSTOM_FIELD_ID" => 'LEAD_FIELD_5',
            "FIELD_VALUE" => $http_uri
        ],
        [
            "CUSTOM_FIELD_ID" => 'Campaign_Name__c',
            "FIELD_VALUE" => $array['campaign_name']
        ],
        [
            "CUSTOM_FIELD_ID" => 'Campaign_Source__c',
            "FIELD_VALUE" => $array['campaign_source']
        ],
        [
            "CUSTOM_FIELD_ID" => 'campaign_medium__c',
            "FIELD_VALUE" => $array['campaign_medium']
        ],
        [
            "CUSTOM_FIELD_ID" => 'LEAD_FIELD_7',
            "FIELD_VALUE" => $desired
        ],
        [
            "CUSTOM_FIELD_ID" => 'Service_Company__c',
            "FIELD_VALUE" => 'All Green Recycling'
        ],
        [
            "CUSTOM_FIELD_ID" => 'LEAD_FIELD_8',
            "FIELD_VALUE" => $location
        ]
    )
);

$data = json_encode($data);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$return = curl_exec($ch);
$err = curl_errno($ch);
$msg = curl_error($ch);

error_log($return);

//echo $return;

curl_close($ch);
?>