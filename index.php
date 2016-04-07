<?
	include "config.php";
	if( isset($_GET["id"]) ) {
		$id = $_GET["id"];
	} else {
		die( "#ERROR: Missing 'id' argument" );
	}

	if( $steam_key != "Get this from http://steamcommunity.com/dev/apikey") {
		$playerarray = json_decode(file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=' . $steam_key . '&steamids=' . $id . '&format=json'), true);
		if( !$playerarray ) {
			error_reporting(0);
			$username = "{poot name here cuz steam is down :(}";
		} else {
			$username = htmlspecialchars($playerarray['response']['players'][0]['personaname']); // Username
		}
		
	} else {
		Header( "Location: http://steamcommunity.com/dev/apikey" );
	}
?>
<html>
	<head>
		<meta charset="UTF-8" />
		<link href='<? if ($_SERVER['HTTPS']) { 
			print("http://fonts.googleapis.com/css?family=Open+Sans:600,400");
		} else {
			print("https://fonts.googleapis.com/css?family=Open+Sans:600,400");
		}?>' rel='stylesheet' type='text/css'>
		<style>
			@font-face {
				font-family: VCR;
				src: url(../2014-mas/fonts/vcr.woff);
			}
			@font-face {
				font-family: PCFont;
				src: url(../2014-mas/fonts/pcsenior.ttf);
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
				text-align: center;
			}
			.footer {
				position: fixed;
				bottom: 7px;
				width: 100%;
				z-index: 2;		
				padding-top: 20px;
				padding-bottom: 10px;
				background-color: rgba(0, 0, 0, 0);
			}
			.post_footer { /* $(this).toggleClass('post_footer'); */
				background-color: green;
			}
			.title {
				background: url(img/header.png);
				padding-bottom: 5px;
				padding-top: 20px;
				z-index: 3;	
			}
			#overlay {
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
			
			.container {
				position: fixed;
				background: url(img/overlays/1.png) repeat;
				left: 0px;
				top: 0px;
				width: 100%;
				height: 100%;
				z-index: 1;
				opacity: .15;
			}
			.container2 {
				position: fixed;
				background: url(img/overlays/1.png) repeat;
				left: 0px;
				top: 0px;
				width: 100%;
				height: 100%;
				z-index: 2;
				opacity: 0.15;
			}
			
			.footer_alt { /* $(this).toggleClass('clicked'); */
				-webkit-animation: rainbow 10s infinite;
				-ms-animation: rainbow 10s infinite;
				-o-animation: rainbow 10s infinite;
				animation: rainbow 10s infinite;
				background-color: rgba(0, 0, 0, 0);
				font-family: PCFont, 'Open Sans', sans-serif;
				z-index: 5;
				margin-top: 6px;
				font-size: 10pt;
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
			$(document).ready(function() {
				$("#footer").slideDown(0, function() {
					$(this).delay(5000).slideUp('slow').delay(10000).animate({ bottom: '0%', opacity: 'toggle', }, 1000);
				});
				$("#title").slideUp(0, function() {
					$(this).delay(5000).slideDown('slow').delay(10000).animate({ height: 'toggle', opacity: 'toggle' }, 'slow');
				});  
			});
			
			function SetStatusChanged( status ) {
				if ( status == "Workshop Complete" ) {
					$(".footer_alt").html( "Looks like you finished downloading our workshop content, On to on-board content!" )
				} else if ( status == "Sending client info..." ) {
					document.getElementById("player").volume=0.05; 
					$(".footer_alt").html( "You're done downloading all our content<br /><br />Now it's finally time to actually play on our gameserver!" )
					$(".footer_name").remove()
					$(".static").fadeIn( 7000 ) // Fade to static
					var footer = $("#footer");
					var footer_alt = $(".footer_alt");
					footer_alt.css("animation", "initial");
					footer_alt.css("font-size", "14pt");
					footer_alt.css("color", "yellow");
					footer.css("position","absolute");
					footer.css("top", Math.max(0, (($(window).height() - footer.outerHeight()) / 2) + $(window).scrollTop()) + "px");
					footer.css("left", Math.max(0, (($(window).width() - footer.outerWidth()) / 2) + $(window).scrollLeft()) + "px");
				}
			}
		</script>
	</head>
	
	<body>
		<!--<audio hidden autoplay name="media">
			<source src="welcome.mp3" type="audio/mpeg">
		</audio>-->
		<div class="container2"></div>
		<div id="overlay">
			<h1 id="title" class="title"><? echo($banner_top); ?></h1>
			<h1 id="footer" class="footer">
				<div class="footer_name" style="background: none; height: auto;">Hey <?php echo($username); ?></div>
				<div class="footer_alt">You are now loading in, This might take a while!</div><
			/h1>
		</div>
		<div id="static" class="static">
		</div>
		<div id="video">
			<iframe id="player" width="100%" height="100%" src="https://www.youtube.com/embed/<? print( GetRandomVideo() ); ?>?iv_load_policy=3&rel=0&autoplay=1&loop=1&showinfo=0&controls=0&playlist=<? print( GeneratePlaylist() ); ?>" frameborder="0" allowfullscreen></iframe>
		</div>
		<script>
			document.getElementById("player").volume=0.2; // Volume control
		</script>
	</body>
	<?
		if( static_list( $id ) != false ){
			print("<script>document.getElementById(\"video\").innerHTML = \"<iframe width='100%' height='100%' src='//www.youtube.com/embed/" . static_list( $id ) . "?iv_load_policy=3&rel=0&autoplay=1&showinfo=0&controls=0' frameborder='0' allowfullscreen></iframe>\"</script>\"");
		}
	?>
	<!-- test 03012016 -->
</html>