<?php
	function binary_search ($fname, $key) {
		$fp = fopen ($fname, "rb") or die ("Cannot open the file " . $fname);
		$left = 0;
		$right = filesize($fname);
		
		while(true) {
			$mid = $left + ceil(($right-$left)/2);
			while ($mid) {
				fseek($fp, $mid);
				if (fgetc($fp) == "\x0A") {
					break;
				}
				$mid--;
			}
			if ($mid > 0) {
				$mid++;
			}
			$search_key = '';
			while (!feof($fp)) {
				fseek($fp, $mid);
				$char = fgetc($fp);
				if ($char == "\t") {
					break;
				}
				$search_key .= $char;
				$mid++;
			}
			$order = strcmp($key, $search_key);
			if ($order < 0) {
				$right = $mid - strlen($search_key) - 1;
			} else if ($order > 0) {
				$left = $mid + strlen($search_key) + 1;
			} else {
				$mid++;
				$result = '';
				while (!feof($fp)) {
					fseek($fp, $mid);
					$char = fgetc($fp);
					if ($char == "\x0A") {
						break;
					}
					$result .= $char;
					$mid++;
				}
				echo $result;
				return $result;
			}
			if ($left > $right) {
				echo "undef";
				return "undef";
			}
    }
	}
?>