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
				$json->properties['avatar'] = htmlspecialchars($playerarray['response']['players'][0]['avatarfull']); // Avatar
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
	$json->properties['welcometext'] = "Player";

	function createVideo(){
		print("<script>
		  function onYouTubeIframeAPIReady() {
			var player;
			player = new YT.Player('video', {
			  videoId: '" . GetRandomVideo() ."',
			  width: 0, // these shits don't matter
			  height: 0, // fuck you
			  playerVars: {
				autoplay: 1, // Auto-play the video on load
				iv_load_policy: 3,
				rel: 0,
				controls: 0,
				playlist: '" . GeneratePlaylist(). "',		
			  },
			  events: {
				onReady: function(e) {
				  e.target.setVolume(1);
				}
			  }
			});
		  }
		</script>");
	}

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
				/* overflow: hidden;*/
				background-color: black;
				font-family: VCR;
			}
			
			body {
				overflow: hidden;
			}

			h1 {
				width: 100%;
				font-size: 36pt;
				height: 7%;
				font-weight: 100;
				color: white;
			}

			.avatartext {
				background: none;
				color: white;
				font-family: 'coolvetica', arial;
				height: auto;
				font-size: 18pt;
			}

			#avatarcontainer {
				background: none;
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
				background: url(img/header_holiday.png);
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
			
			#footer_snow {
				background: url(img/snow_footer.png) repeat-x;
				position: fixed;
				bottom: -80%;
			}

			#ring {
			    background: none;
			    width: 250px;
			    height: 250px;
			    position: absolute;
			    overflow: visible;
			    top: -39px;
			    left: -62px;
			}

			#container2 {
				background: none;
				background-image: url('http://www.wearewebstars.dk/codepen/img/s1.png'), url('http://www.wearewebstars.dk/codepen/img//s2.png'), url('http://www.wearewebstars.dk/codepen/img//s3.png');
				height: 100%;
				left: 0;
				position: absolute;
				top: 0;
				width: 100%;
				z-index:1;
				-webkit-animation: snow 10s linear infinite;
				-moz-animation: snow 10s linear infinite;
				-ms-animation: snow 10s linear infinite;
				animation: snow 10s linear infinite;
			}
			@keyframes snow {
			  0% {background-position: 0px 0px, 0px 0px, 0px 0px;}
			  50% {background-position: 500px 500px, 100px 200px, -100px 150px;}
			  100% {background-position: 500px 1000px, 200px 400px, -100px 300px;}
			}
			@-moz-keyframes snow {
			  0% {background-position: 0px 0px, 0px 0px, 0px 0px;}
			  50% {background-position: 500px 500px, 100px 200px, -100px 150px;}
			  100% {background-position: 400px 1000px, 200px 400px, 100px 300px;}
			}
			@-webkit-keyframes snow {
			  0% {background-position: 0px 0px, 0px 0px, 0px 0px;}
			  50% {background-position: 500px 500px, 100px 200px, -100px 150px;}
			  100% {background-position: 500px 1000px, 200px 400px, -100px 300px;}
			}
			@-ms-keyframes snow {
			  0% {background-position: 0px 0px, 0px 0px, 0px 0px;}
			  50% {background-position: 500px 500px, 100px 200px, -100px 150px;}
			  100% {background-position: 500px 1000px, 200px 400px, -100px 300px;}
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
			$( document ).ready(function() {
				function rainbowLoop( element ) {
					element.animate({hueRadius: 360}, {
						duration: 1000,
						easing: 'linear',

						step: function() {
							$(this).css({
								"-webkit-filter": "hue-rotate("+this.hueRadius+"deg)",
							});
						},

						complete: rainbowLoop(this)
					});
				}

				setTimeout(function() {

					$("#footer").animate({ left: '5%', opacity: 'toggle', }, 500).delay(10000).animate({ left: '2%', opacity: 'toggle', }, 1000);
					$("#video").animate({blurRadius: 10}, {
						duration: 1000,
						easing: 'linear',

						step: function() {
							$(this).css({
								"-webkit-filter": "blur("+this.blurRadius+"px)",
								"filter": "blur("+this.blurRadius+"px)"
							});
						}
					}).delay(10000).animate({blurRadius: 0}, {
						duration: 1000,
						easing: 'linear',

						step: function() {
							$(this).css({
								"-webkit-filter": "blur("+this.blurRadius+"px)",
								"filter": "blur("+this.blurRadius+"px)"
							});
						},

						//complete: rainbowLoop(this)
					});
					$("#title").slideDown('slow').delay(10000).animate({ height: 'toggle', opacity: 'toggle' }, 'slow');
				}, 5000);
			});
		</script>
	</head>
	
	<body>
		<!--<audio hidden autoplay name="media">
			<source src="welcome.mp3" type="audio/mpeg">
		</audio>-->
		<!--<div class="overlay"></div>-->
		<div id="container2">
			<h1 id="title" class="title"><?php echo($banner_top); ?></h1>
			<h1 id="footer" class="footer">
				<div id="avatarcontainer">
					<img id="avatar" src="<?php echo($json->properties['avatar']); ?>"/>
					<img id="ring" src="img/ring_holiday.png?041216"/>
					<!--<span class="avatartext" style=" -webkit-animation:RGBshift 2s infinite alternate; animation:RGBshift 2s infinite alternate; position: absolute;padding-left: 14px;font-size: 36pt;"><?php echo($json->properties['name']); ?>-->
					<span class="avatartext" style="position: absolute;padding-left: 70px;font-size: 36pt;"><?php echo($json->properties['name']); ?>
						<span class="avatartext" style="position: absolute; margin-left: 12px; width: auto; background: green; border: 2px solid green; border-left: 6px solid green; border-right: 6px solid green;">
							<?php echo($json->properties['welcometext']); ?>
						</span>
					</span>
					<span class="avatartext" style="position: absolute;padding: 60px 70px;">
						<?php
							echo("If it's your first time it's gonna take a while!");
							//echo($json->properties['lastseen']); 
						?>						
					</span>
				</div>
			</h1>
			<!--<img style="background: transparent; width: initial; height: initial;position: absolute;right: 0px;bottom: 8px;" src="img/ppc_logo.png">-->
		</div>

		<div id="static" class="static"></div>
		<div id="video"></div>
		<div id="footer_snow"></div>
	</body>

	<script async src="https://www.youtube.com/iframe_api"></script>
	<?php createVideo() ?>

	<?php
		if( static_list( $id ) != false ){
			print("<script>document.getElementById(\"video\").innerHTML = \"<iframe width='100%' height='100%' src='//www.youtube.com/embed/" . static_list( $id ) . "?iv_load_policy=3&rel=0&autoplay=1&showinfo=0&controls=0' frameborder='0' allowfullscreen></iframe>\"</script>\"");
		}
	?>
	<!-- test 060416 -->
</html>
