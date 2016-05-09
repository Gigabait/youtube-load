<?php
	include "config.php";
	include "lib/steamuser.class.php";
	if( isset($_GET["id"]) ) {
		$id = $_GET["id"];
	} else {
		die( "#ERROR: Missing 'id' argument" );
	}

	$json = new UserJson();
	//$json->master = $json->Read();

	if( $steam_key != "Get this from http://steamcommunity.com/dev/apikey") {
		$playerarray = json_decode(file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=' . $steam_key . '&steamids=' . $id . '&format=json'), true);
		if( !$playerarray ) {
			error_reporting(0);
			$json->properties['name'] = "Player";
			$json->properties['avatar'] = "https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/7c/7cfdd5970fa46b9784f16369a9464b3b0d409008_full.jpg";
			$json->properties['group'] = "user";
		} else {
			if (is_null($playerarray['response']['players'][0]['personaname'])) {
				$json->properties['name'] = "Pirate";
				$json->properties['avatar'] = "https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/7c/7cfdd5970fa46b9784f16369a9464b3b0d409008_full.jpg";
				$json->properties['group'] = "user";
			} else {
				$json->properties['name'] = htmlspecialchars($playerarray['response']['players'][0]['personaname']); // Username
				$json->properties['avatar'] = htmlspecialchars($playerarray['response']['players'][0]['avatarfull']); // Username
				//if (isset($json->master[$json->SteamWorksDecode64($id)]['group'])) {
				//	$json->properties['group'] = $json->master[$json->SteamWorksDecode64($id)]['group'];
				//} else {
				//	$json->properties['group'] = "user";
				//}
				
			}           
		}
	} else {
		Header( "Location: http://steamcommunity.com/dev/apikey" );
	}

	//if (isset($json->properties['group'])) {
	//	if (isset($json->phrases[$json->properties['group']])) {
	//		$json->properties['welcometext'] = $json->phrases[$json->properties['group']];
	//	} else {
	//		$json->properties['welcometext'] = $json->phrases["~DEFAULT"];
	//	}
	//} else {
	//	$json->properties['welcometext'] = $json->phrases["~DEFAULT"];
	//}
	$json->properties['welcometext'] = "It's gonna take a while to load in :|";

?>
<!DOCTYPE html>
<html>
	<head>
		<title>YouTube Load (Potato Version)</title>
		<meta charset="UTF-8" />
		<style>
			@font-face {
				font-family: VCR;
				src: url(../2014-mas/fonts/vcr.woff);
			}
			@font-face {
				font-family: coolvetica;
				src: url(../2014-mas/fonts/coolvetica.ttf);
			}
			* {
				pointer-events: none;
				width: 100%;
				height: 100%;
				margin: 0px;
				padding: 0px;
				overflow: hidden;
				background-color: black;
				font-family: VCR;
			}
			
			h1 {
				width: 100%;
				font-size: 36pt;
				height: 7%;
				font-weight: 100;
				color: white;
			}

			#video {
				background: none;
			}

			#avatar {
				width: 128px;
			    height: 128px;
			    border-radius: 100%;
			    background: none;
			}
			.footer {
				height: auto;
				left: 2%;
				position: fixed;
				bottom: 2%;
				width: 100%;
				z-index: 2;     
				padding-top: 20px;
				padding-bottom: 20px;
				background: none;
			}
			.post_footer { /* $(this).toggleClass('post_footer'); */
				background-color: green;
			}
			.title {
				text-align: center;
				display: none;
				background: url(img/header.png);
				padding-bottom: 5px;
				padding-top: 20px;
				z-index: 3; 
			}
			#container2 {
				position: fixed;
				left: 0px;
				top: 0px;
				width: 100%;
				height: 100%;
				z-index: 3;
				background: none;
			}

			#static {
				display: none;
				opacity: .6;
				position: fixed;
				left: 0px;
				top: 0px;
				width: 100%;
				height: 100%;
				z-index: 2;
				background-image: url(img/overlays/static.gif);
			}
			
			.overlay {
				position: fixed;
				background: url(img/overlays/2.png) repeat;
				left: 0px;
				top: 0px;
				width: 100%;
				height: 100%;
				z-index: 2;
				opacity: 0.5;
			}
			
			@-webkit-keyframes rainbow {
				0% {color: #ff0000;}
				10% {color: #ff8000;}
				20% {color: #ffff00;}
				30% {color: #80ff00;}
				40% {color: #00ff00;}
				50% {color: #00ff80;}
				60% {color: #00ffff;}
				70% {color: #0080ff;}
				80% {color: #0000ff;}
				90% {color: #8000ff;}
				100% {color: #ff0080;}
			}
			@-ms-keyframes rainbow {
				0% {color: #ff0000;}
				10% {color: #ff8000;}
				20% {color: #ffff00;}
				30% {color: #80ff00;}
				40% {color: #00ff00;}
				50% {color: #00ff80;}
				60% {color: #00ffff;}
				70% {color: #0080ff;}
				80% {color: #0000ff;}
				90% {color: #8000ff;}
				100% {color: #ff0080;}
			}
			@-o-keyframes rainbow {
				0% {color: #ff0000;}
				10% {color: #ff8000;}
				20% {color: #ffff00;}
				30% {color: #80ff00;}
				40% {color: #00ff00;}
				50% {color: #00ff80;}
				60% {color: #00ffff;}
				70% {color: #0080ff;}
				80% {color: #0000ff;}
				90% {color: #8000ff;}
				100% {color: #ff0080;}
			}
			@keyframes rainbow {
				0% {color: #ff0000;}
				10% {color: #ff8000;}
				20% {color: #ffff00;}
				30% {color: #80ff00;}
				40% {color: #00ff00;}
				50% {color: #00ff80;}
				60% {color: #00ffff;}
				70% {color: #0080ff;}
				80% {color: #0000ff;}
				90% {color: #8000ff;}
				100% {color: #ff0080;}
			}
		</style>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script>
			function SetStatusChanged( status ) {
				if ( status == "Workshop Complete" ) {
					// um
				} else if ( status == "Sending client info..." ) {
					$(".static").fadeIn( 7000 ) // Fade to static
				}
			}
			setTimeout(function() {
				$("#footer").animate({ left: '5%', opacity: 'toggle', }, 500).delay(10000).animate({ left: '2%', opacity: 'toggle', }, 1000);
				$("#video").animate({ '-webkit-filter': 'blur(10px)', filter: 'blur(10px)' }, 500).delay(10000).animate({ '-webkit-filter': 'blur(0px)', filter: 'blur(0px)', }, 1000);
				$("#title").slideDown('slow').delay(10000).animate({ height: 'toggle', opacity: 'toggle' }, 'slow');
			}, 5000);
		</script>
	</head>
	
	<body>
		<!--<audio hidden autoplay name="media">
			<source src="welcome.mp3" type="audio/mpeg">
		</audio>-->
		<div class="overlay"></div>
		<div id="container2">
			<h1 id="title" class="title"><?php echo($banner_top); ?></h1>
			<h1 id="footer" class="footer">
				<img id="avatar" src="<?php echo($json->properties['avatar']); ?>"/>
				<span style="font-family: 'coolvetica', arial; background: none;height: auto;position: absolute;padding: 10px 14px;"><?php echo($json->properties['name']); ?></span>
				<span style="font-family: 'coolvetica', arial; font-size: 18pt;background: none;height: auto;position: absolute;padding: 60px 14px;"><?php echo($json->properties['welcometext']); ?></span>
			</h1>
		</div>
		<div id="static" class="static">
		</div>
		<div id="video">
			<iframe id="player" width="100%" height="100%" src="https://www.youtube.com/embed/<?php print( GetRandomVideo() ); ?>?iv_load_policy=3&rel=0&autoplay=1&loop=1&showinfo=0&controls=0&playlist=<?php print( GeneratePlaylist() ); ?>" frameborder="0" allowfullscreen></iframe>
		</div>
		<script>
			document.getElementById("player").volume=0.2; // Volume control
		</script>
	</body>
	<?php
		if( static_list( $id ) != false ){
			print("<script>document.getElementById(\"video\").innerHTML = \"<iframe width='100%' height='100%' src='//www.youtube.com/embed/" . static_list( $id ) . "?iv_load_policy=3&rel=0&autoplay=1&showinfo=0&controls=0' frameborder='0' allowfullscreen></iframe>\"</script>\"");
		}
	?>
	<!-- test 03012016 -->
</html>
