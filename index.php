<?
	include "config.php";
	$id = $_GET["id"];
	if( $steam_key != "Get this from http://steamcommunity.com/dev/apikey") {
		$playerarray = json_decode(file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=' . $steam_key . '&steamids=' . $id . '&format=json'), true);
		$username = htmlspecialchars($playerarray['response']['players'][0]['personaname']); // Username
	} else {
		Header( "Location: http://steamcommunity.com/dev/apikey" );
	}
?>
<html>
	<head>
		<meta charset="UTF-8" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,600,400&subset=cyrillic,cyrillic-ext,latin,greek-ext,greek,latin-ext,vietnamese' rel='stylesheet' type='text/css'>
		<style>
			* {
				pointer-events: none;
				width: 100%;
				height: 100%;
				margin: 0px;
				padding: 0px;
				overflow: hidden;
				background-color: black;
			}
			
			h1 {
				width: 100%;
				font-size: 36pt;
				height: 7%;
				font-weight: 100;		
				padding: 12px 0px;
				color: white;
				font-family: 'Open Sans', sans-serif;
				text-align: center;
			}
			.footer {
				position: fixed;
				bottom: 7px;
				width: 100%;
				z-index: 2;		
				padding-top: 20px;
				background-color: brown;
			}
			
			.title {
				background: url(img/background.png) repeat;
				padding-bottom: 20px;
				z-index: 2;	
			}
			.overlay {
				position: fixed;
				background: url(img/overlays/1.png);
				left: 0px;
				top: 0px;
				width: 100%;
				height: 100%;
				z-index: 1;
				background-repeat: repeat;
			}
		</style>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script>
			$(document).ready(function() {
				$("#footer").slideDown(0, function() {
					$(this).delay(5000).slideUp('slow').delay(10000).animate({ height: 'toggle', opacity: 'toggle' }, 'slow');
				});
				$("#title").slideUp(0, function() {
					$(this).delay(5000).slideDown('slow').delay(10000).animate({ height: 'toggle', opacity: 'toggle' }, 'slow');
				});  
			});
		</script>
	</head>
	
	<body>
		<div class="overlay"></div>
		<h1 id="title" class="title"><? echo($banner_top); ?></h1>
		<h1 id="footer" class="footer">Howdy, <?php echo($username); ?></h1>
		
		<div id="video">
			<iframe id="player" width="100%" height="100%" src="//www.youtube.com/embed/<? print( GetRandomVideo() ); ?>?iv_load_policy=3&rel=0&autoplay=1&loop=1&showinfo=0&controls=0&playlist=<? print( GeneratePlaylist() ); ?>" frameborder="0" allowfullscreen></iframe>
		</div>
	</body>
	<?
		if( static_list( $id, $playerVideos ) != false ){
			print("<script>document.getElementById(\"video\").innerHTML = \"<iframe width='100%' height='100%' src='//www.youtube.com/embed/" . static_list( $id, $playerVideos ) . "?iv_load_policy=3&rel=0&autoplay=1&showinfo=0&controls=0' frameborder='0' allowfullscreen></iframe>\"</script>\"");
		}
	?>
	<script>
		document.getElementById("player").volume=0.2; // Controls volume
	</script>
</html>
