<?php
	class UserJson
	{
		public $master;

		public $group;

		public $properties = array();

		public $phrases = array(
			"manager_dev" => "Developer",
			"manager" => "Manager",
			"administrator" => "Staff Member",
			"Respected Member" => "Honary Member",
			"Senior Member" => "Persistant Member",
			"Certified Member" => "Member",
			"admin" => "The Staff",
			"donator" => "Honary Donator",
            "PocoCraft Donator" => "Honary Donator",
			"~DEFAULT" => "Player",
		);


		public function Read() {
			if (filesize("/var/www/hidden/users.json") != 0) {
				return json_decode(openssl_decrypt(fread($this->fHandle, filesize("/var/www/hidden/users.json")), "aes-256-cbc", "██████████████████████████████████████████████████████████████"), true);
			}
		}
		
		public function SteamIDFlip($id) {
		    if (strlen($id) === 17)
		    {
		        $converted = substr($id, 3) - 61197960265728;
		    }
		    else
		    {
		        $converted = '765'.($id + 61197960265728);
		    }
		    return (string) $converted;
		}

		public function SteamWorksDecode64($id) {

			$steamY;

			if(preg_match('/(\d+)/', $id, $array)) {
			    $steamY = $array[1];
			} else {
			    $steamY = 0;
			}
			$steamY = $steamY - 76561197960265728;
			$steamX = 0;

			if ($steamY%2 == 1){
				$steamX = 1;
			} else {
				$steamX = 0;
			}

			$steamY = (($steamY - $steamX) / 2);
			return "STEAM_0:" . (string)$steamX . ":" . (string)$steamY;
		}

		public function __construct() {
			$this->fHandle = fopen("/var/www/hidden/users.json", "a+");
			if (!$this->fHandle) {
				die("failed to load users.json!");
			}
		}

	};
?>