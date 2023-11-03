<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function array_to_xml($data, &$xml) {
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            if (!is_numeric($key)) {
                $subnode = $xml->addChild("$key");
                array_to_xml($value, $subnode);
            } else {
                array_to_xml($value, $xml);
            }
        } else {
            $xml->addChild("$key", htmlspecialchars("$value"));
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if 'item' key exists and is an array in $_POST
    if (isset($_POST['item']) && is_array($_POST['item'])) {
        // Process the $_POST data and convert it to the desired XML structure
        function processPostData($postData) {
            // Create a SimpleXML object for the root element
            $xml = new SimpleXMLElement('<YealinkIPPhoneDirectory></YealinkIPPhoneDirectory>');

            // Access the 'item' key in $_POST
            $items = $postData['item'];

            foreach ($items as $item) {
                // Create a <DirectoryEntry> element for each item
                $directoryEntry = $xml->addChild('DirectoryEntry');

                // Add Name and Telephone elements
                $directoryEntry->addChild('Name', $item['name']);

                // Handle multiple 'phone' values if present
                if (isset($item['phone'])) {
                    if (is_array($item['phone'])) {
                        foreach ($item['phone'] as $phone) {
                            $directoryEntry->addChild('Telephone', $phone);
                        }
                    } else {
                        $directoryEntry->addChild('Telephone', $item['phone']);
                    }
                }
            }

            // Return the XML as a string
            return $xml->asXML();
        }
		#DANI!!!!
		function processPostDataSnom($postData) {
			// Create a SimpleXML object for the root element
            $xml = new SimpleXMLElement('<tbook></tbook>');

            // Access the 'item' key in $_POST
            $items = $postData['item'];

            foreach ($items as $item) {
                // Create a <DirectoryEntry> element for each item
                $directoryEntry = $xml->addChild('item');

                // Add Name and Telephone elements
                $directoryEntry->addChild('name', $item['name']);

                // Handle multiple 'phone' values if present
                if (isset($item['phone'])) {
                    if (is_array($item['phone'])) {
                        foreach ($item['phone'] as $phone) {
                            $directoryEntry->addChild('number', $phone);
                        }
                    } else {
                        $directoryEntry->addChild('number', $item['phone']);
                    }
                }
            }

            // Return the XML as a string
            return $xml->asXML();
			
		}

        // Assuming you have received $_POST data
        $xmlString = processPostData($_POST);
		$xmlStringSnom = processPostDataSnom($_POST);

        // Specify the file path where you want to save the XML
        $filePath = 'phonebook-yealink.xml';
	$filePathSNOM = 'phonebook-snom.xml';
		
        // Save the XML to a file
        file_put_contents($filePath, $xmlString);
		file_put_contents($filePathSNOM, $xmlStringSnom);
	    
	echo "Agenda actualitzada correctament!";
        echo "Agenda YEALINK: http://127.0.0.1/$filePath";
	echo "Agenda SNOM: http://127.0.0.1/$filePathSNOM"    
        exit;
    } else {
        echo "Error 404 - Contactar amb sat1@parlem.com";
    }
}
?>
