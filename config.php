<?
	error_reporting(0);

	$steam_key = "Get this from http://steamcommunity.com/dev/apikey"; // YOU NEED THIS
	
	$banner_top = "Welcome to Pococraft"; // What it will say on the top
	
	$PlaylistGenerationSize = 20; // How many videos we should generate and queue
	//////////////////////////////////////////////////////
	// Name: Static List		                        //
	// Desc: Ignores randomizer and plays only 1 video  //
	//////////////////////////////////////////////////////
	function static_list( $id ) {
		$list = array(
		
		//	ID 					|  VideoID
			
		);
		
		if ( !in_array( $id, $list ) ) { return false; }
		return $list[$id];
	}
	
	//////////////////////////////////////////////////////
	// Name: YouTube Playlist                           //
	// Desc: Randomizes videos based on embedded ID     //
	//////////////////////////////////////////////////////
	
	function GetRandomVideo() {
		$videolist = array(
			"0O2aH4XLbto",
			"BfSX7EN0yXs",
			"L7fQoXzIgeg",
			"17svtURunUk",
			"hyj4JFSErrw",
			"YlEb3L1PIco",
			"lhjk5x54bsE",
			"IU5vKbyc3c8",
			"XYmLhn3qJ6Y",
			"2vjPBrBU-TM",
			"VtQxK5TQ22g",
			"_04s7ONnJRs",
			"9UpunuBr4QI",
			"C2cr7SBBT6A",
			"_4kuQ_T95VY",
			"IcrbM1l_BoI",
			"-fm8VahT1hs",
			"qYodWEKCuGg",
			"QYVwqJCIdR0",
			"GNpNfhpqDk4",
			"y6oXW_YiV6g",
			"y6oXW_YiV6g",
			"2Z4m4lnjxkY",
			"ZZ5LpwO-An4",
			"gy1B3agGNxw",
			"6md5RSnVUuo",
			"elsh3J5lJ6g",
			"eE9tV1WGTgE",
			"LWGJA9i18Co",
			"UJKythlXAIY",
			"3xUfCUFPL-8",
			"c-5nR_xMpj4",
			"TAK5uw7x-Aw",
			"AI_RDJ7ifZQ",
			"Kybyy1EkoOE",
			"vmOArLdg9d4",
			"CNlFkP6nvLE",
			"GnrwM7vFn_U",
			"IvUU8joBb1Q",
			"gHCDN7Gr3KU",
			"Vn1pf0Xi3nU",
			"r_oaVD4NzYo",
			"JvQY6tLMdL0",
			"11t75Vsgjc0",
			"bwsrbC51jxc",
			"QbZfY28ptv4",
			"7PdV2UtsNes",
			"ZGpXlL5Ltdc",
			"RX6YeYT3ed8",
		);
		
		return $videolist[mt_rand( 0, count( $videolist ) )]; // Don't touch this!!
	}
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