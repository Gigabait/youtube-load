<?php
	$steam_key = "Get this from http://steamcommunity.com/dev/apikey"; // YOU NEED THIS
	
	$banner_top = "Welcome to YouTube Load"; // What it will say on the top
	
	$bottom_text = "If you're joining for the first time, this might take a while!"; // What it will say on the top
	
	$PlaylistGenerationSize = 10; // How many videos we should generate and queue
    
    //Lists
    $videolist = array(
			"mN6O62qwyGY",
			"PDu_T54K-VI",
			"OFzXaFbxDcM",
			"hgKDu5pp_fU",
			"D1sZ_vwqwcE",
			"48jt_lWA7W0",
			"b6vSf0cA9qY",
			"e-fA-gBCkj0",
			"vKYAbhIEZug",
			"KD5fLb-WgBU",
			"IgGjUjQRAxw",
			"5-6fEj17MK4",
			"E7fzUGR8ZH4",
			"scmQ6iN8hKM",
			"6fdr-Fiv92c",
			"vc3JWo2iiGc",
			"l18A5BOTlzE",
			"gk-aCL6eyGc",
			"n4tK7LYFxI0",
			"oABEGc8Dus0",
			"dGghkjpNCQ8",
			"ojofvfeA3Fg",
			"WomOv0gB7O8",
			"kn6-c223DUU",
			"8PTDv_szmL0",
			"aTBSQKh8teE",
			"_ovdm2yX4MA",
			"Sv6dMFF_yts",
			"ghb6eDopW8I",
			"sf6LD2B_kDQ",
			"dVVZaZ8yO6o",
			"36reZ9-3VK0",
			"IJNR2EpS0jw",
			"PWofgnLXTtk",
			"RlD-Sufzrh4",
			"4u-6B_iF5s0",
			"8rnr2wuAhYc",
			"y6Sxv-sUYtM",
			"Jj-pSzqb-Xk",
			"c71RCAyLS1M",
			"6qwkVGDKVvE",
			"WZJKIFWFSU0",
			"gTLWb9BJbiI",
			"ytc0U2WAz4s",
			"GNpNfhpqDk4",
			"HAIDqt2aUek",
			"qUsm3PCoGIE",
			"5NV6Rdv1a3I",
			"hT_nvWreIhg",
			"qrOeGCJdZe4",
			"ktvTqknDobU",
			"dvgZkm1xWPE",
			"YgFyi74DVjc",
			"jlAgHt92lqE",
			"-RYlAPjyNm8",
		);
        $playerVideos = array(
            //"SteamID64" => "VideoID",
            "76561197972597160" => "i3uVX-RUFVw",
			"76561198060486309" => "_s8OlKt_dRY",
        );
	
	//////////////////////////////////////////////////////
	// Name: Static List		                        //
	// Desc: Ignores randomizer and plays only 1 video  //
	//////////////////////////////////////////////////////
	function static_list( $id, $list ) {
		if ( in_array( $id, $list ) ) { return false; }
		return $list[$id];
	}
	
	//////////////////////////////////////////////////////
	// Name: YouTube Playlist                           //
	// Desc: Randomizes videos based on embedded ID     //
	//////////////////////////////////////////////////////
	
	function GetRandomVideo() {		
		return $GLOBALS['videolist'][mt_rand( 0, sizeof( $GLOBALS['videolist'] ) - 1 )]; // Don't touch this!!
	}

	//////////////////////////////////////////////////////
	// Name: Automatic Playlist Generator               //
	// Desc: I recommend not touching this.             //
	//////////////////////////////////////////////////////

	function GeneratePlaylist() {
		
		$x = $PlaylistQueue = null; // Otherwise undefined
		
		while ($x <= $GLOBALS['PlaylistGenerationSize']) {
			$VideoID = GetRandomVideo();
			if( strpos($PlaylistQueue , $VideoID) != false) {  // If we get a duplicate in the playlist
				// print("<script>console.warn(\"Duplicate found: " . $VideoID . ". REQUESTED RETRY!!\");</script>");
			} else {
				if( $x != $GLOBALS['PlaylistGenerationSize'] ) {
					$PlaylistQueue .= $VideoID . ",";
				} else {
					$PlaylistQueue .= $VideoID;
				}
				$x++;
			}
		}
		return $PlaylistQueue;
	}
?>
