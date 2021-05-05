<?php
	function sendDiscord() {
	$webhookurl = "DISCORD-API-KEY";
    $timestamp = date("c", strtotime("now"));
    
    $matchType = $GLOBALS['matchType'];
    $matchID = $GLOBALS['matchID'];
    $mapCon = $GLOBALS['mapCon'];
    $matchInfo = $GLOBALS['matchInfo'];
    $teamA = $matchInfo['TeamOne'];
    $teamB  = $matchInfo['TeamTwo'];
    $defaultMap = $GLOBALS['defaultMap'];
    
    $getMapName  = $mapCon->query(
		"SELECT BanThree, BanFour
		FROM `Matches` 
		WHERE MatchID = '$matchID'"
	);
    
    if($matchType=="BO1") {
        $pickedByA = "undefined";
        $pickedByB = "undefined";
    } else {
        $pickedByA = mysqli_fetch_assoc($getMapName)['BanThree'];
        $pickedByB = mysqli_fetch_assoc($getMapName)['BanFour'];
	}

    $json_data = json_encode([
        "username" => "kcml-webhook-api",

    // Text-to-speech
        "tts" => false,
        "embeds" => [
        [
            // Embed Title
            "title" => "KCML - Map Veto",

            // Embed Type
            "type" => "rich",

            // Embed Description
            "description" => "Map Vote completed, committing all info to database." ,

            // URL of title link
            "url" => "https://kcml.my.id/kcmlcup/mapveto/?id=".$matchID,

            // Timestamp of embed must be formatted as ISO8601
            "timestamp" => $timestamp,

            // Embed left border color in HEX
            "color" => hexdec( "121518" ),

            // Footer
            "footer" => [
                "text" => "Copyright vanillamilkk 2021",
                "icon_url" => "https://kcml.my.id/img/vanillamilkk.png"
            ],

            // Image to send
            //"image" => [
            //    "url" => ""
           // ],

            // Thumbnail
            //"thumbnail" => [
            //    "url" => "https://ru.gravatar.com/userimage/28503754/1168e2bddca84fec2a63addb348c571d.jpg?size=400"
            //],

            // Author
            "author" => [
                "name" => "Kami Cinta Mam Lilia",
                "url" => "https://kcml.my.id/kcmlcup/mapveto/"
            ],

            // Additional Fields array
            "fields" => [
                // Field 1
                [
                    "name" => "Match Type",
                    "value" => $matchType,
                    "inline" => true
                ],
                [
                    "name" => "Team A",
                    "value" => "$teamA",
                    "inline" => true
                ],
                [
                    "name" => "Team B",
                    "value" => "$teamB",
                    "inline" => true
                ],
                [
                    "name" => "Picked by A",
                    "value" => "$pickedByA",
                    "inline" => true
                ],
                [
                    "name" => "Picked by B",
                    "value" => "$pickedByB",
                    "inline" => true
                ],
                [
                    "name" => "Decider",
                    "value" => "$defaultMap",
                    "inline" => true
                ]
                // Etc..
                ]
            ]
        ]

    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );


    $ch = curl_init( $webhookurl );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt( $ch, CURLOPT_POST, 1);
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt( $ch, CURLOPT_HEADER, 0);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec( $ch );
    // If you need to debug, or find out why you can't send message uncomment line below, and execute script.
    // echo $response;
    curl_close( $ch );
	}
?>
