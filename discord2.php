<?php
	function sendDiscord() {
	$webhookurl = "DISCORD-API-KEY";
    $timestamp = date("c", strtotime("now"));
    
    $adminName = $GLOBALS['adminName'];
    $teamA = $GLOBALS['teamOne'];
    $teamB = $GLOBALS['teamTwo'];
    $teamOneLink = $GLOBALS['teamOneLink'];
    $teamTwoLink = $GLOBALS['teamTwoLink'];
    $linkbase = $GLOBALS['linkbase'];
    $matchID = $GLOBALS['matchID'];

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
            "description" => "Map Vote initialized, creating new row on database." ,

            // URL of title link
            "url" => "https://kcml.my.id/kcmlcup/mapveto/viewveto.php?id=".$matchID,

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
                    "name" => "Admin Name",
                    "value" => "$adminName",
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
                    "name" => "Link untuk " . "$teamA",
                    "value" => "$teamOneLink",
                    "inline" => false
                ],
                [
                    "name" => "Link untuk " . "$teamB",
                    "value" => "$teamTwoLink",
                    "inline" => false
                ],
                [
                    "name" => "Link Spectator",
                    "value" => "$linkbase",
                    "inline" => false
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
