<?php

/*******************************************************************************

Copyright 2012 Mikro Værkstedet A/S, www.mikrov.dk

This library is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either 
version 2.1 of the License, or (at your option) any later version.

This library is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public 
License along with this library.  If not, see <http://www.gnu.org/licenses/>.

 ******************************************************************************/

/******************************************************************************
 
 	JSONWSP PHP Client library example
 	
 	This example demonstrates the simple nature of the jsonwsp client.
 	In the example a client object is created with a valid jsonwsp service
 	description url. The setViaProxy is used to force the client to use the
 	description url host to call service methods. Then a method call is
 	made and the result is checked and parsed.
 
 ******************************************************************************/


// Include the client classes
include "../jsonwspclient.php";

// Create a new client object
$client = new JsonWspClient("http://ladonize.org/python-demos/AlbumService/jsonwsp/description",false,array("CookieName" => "CookieValue"));

// Use a proxy instead of the native service url (from the description)
$client->setViaProxy(true);

// Call a service method by name and with an associative array as arguments
$response = $client->CallMethod("listBands",array("search_frase" => "Swan"));

// Check responsetype and callresult for a valid response
if($response->getJsonWspType() == JsonWspType::Response && $response->getCallResult() == JsonWspCallResult::Success)
{
	// Get the result data
	$responseJson = $response->getJsonResponse();
	$result = $responseJson["result"];
	
	// Output succes and the contents of the result
	echo "Valid response:<br><pre>".print_r($result,true)."</pre>";

} 

// Check the response type is a fault
else if($response->getJsonWspType() == JsonWspType::Fault)
{
	// Handle service fault here
	echo "Service fault: ".$response->getServiceFault()->getString();
}

// Other reasons that it is not a valid method response
else 
{
	// Other error, check callresult and jsonwsp type
	echo "Other service error.";
}
