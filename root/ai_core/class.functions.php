<?php
/*
	File = class.function.php
	Date = 22-2-2018
*/

class AI_Core
{
	// define variable
	public $def_set = array();
	public $def_lang = array();

	public function __construct()
	{
	}

	public function aiGetValue($tbl, $fld, $whr, $val)
	{
		if ($tbl == '' && $fld == '' && $whr == '' && $val == '')
			return false;

		global $ai_db;

		$qry = "SELECT $fld FROM $tbl WHERE $whr='" . $val . "'";
		$row = $ai_db->aiGetQuery($qry);

		return $row[0][$fld];
	}
	public function aiGetCount($tbl = '', $fld = '', $whr = '1=1')
	{
		if ($tbl == '' && $fld == '')
			return '0';

		global $ai_db;

		$qry = "SELECT COUNT(" . $fld . ") AS cnt_fld FROM " . $tbl . " WHERE " . $whr;
		$row = $ai_db->aiGetQuery($qry);

		return $row[0]['cnt_fld'];
	}
	public function aiIncrementCounter($tbl, $fld, $whr, $val, $counter = 1)
	{
		if ($tbl == '' && $fld == '' && $whr == '' && $val == '')
			return false;

		global $ai_db;

		$qry = "UPDATE $tbl SET $fld=$fld+$counter WHERE $whr='" . $val . "'";
		$row = $ai_db->aiQuery($qry);

		return $row;
	}
	public function aiGet404()
	{
	}
	public function aiGetString($val = '')
	{
		if ($val == '')
			return '';

		$val = stripslashes($val);
		return $val;
	}

	public function aiGetError($msg = '')
	{
		echo '<pre class="error_msg">' . $msg . '</pre>';
		exit;
	}

	public function aiGoPage($url = '')
	{
		echo '<script>window.location="' . $url . '";</script>';
		exit;
	}

	public function aiGetDate($dt = '', $fmt = 'm/d/Y')
	{
		if ($dt == '')
			return '';

		return date($fmt, strtotime($dt));
	}

	public function aiGetDefault($tbl = '')
	{
		if ($tbl == '')
			return false;

		global $ai_db;

		$def_arr = $ai_db->aiGetTable($tbl);
		foreach ($def_arr as $def_data) {
			$this->def_set[$def_data['slug']] = $def_data['value'];
		}
	}
	public function aiUpload($img_path, $fld = '', $ftype = 'image', $old_img = '', $convertToWebp = true, $quality = 70)
	{
		if ($img_path['error'] != 0) {
			return $old_img;
		}

		// Create folder if not exist
		if (!is_dir($fld)) {
			mkdir($fld, 0777, true);
		}

		// Extract file info
		$ext = strtolower(pathinfo($img_path['name'], PATHINFO_EXTENSION));
		$file_nm = time() . '_' . preg_replace('/\s+/', '_', $img_path['name']);
		$fnl_file_nm = str_replace(" ", "_", $file_nm);

		// Prevent duplicate
		while (file_exists($fld . $fnl_file_nm)) {
			$fnl_file_nm = time() . '_' . rand(1000, 9999) . '_' . preg_replace('/\s+/', '_', $img_path['name']);
		}

		// Allowed image types for conversion
		$convertible = ['jpg', 'jpeg', 'png', 'gif'];

		// If file is SVG or already WebP → just move it, don’t convert
		if (in_array($ext, ['svg', 'webp'])) {
			move_uploaded_file($img_path['tmp_name'], $fld . $fnl_file_nm);
			if ($old_img != '' && file_exists($fld . $old_img)) {
				unlink($fld . $old_img);
			}
			return $fnl_file_nm;
		}

		// Try converting to WebP if applicable
		if ($convertToWebp && $ftype == 'image' && in_array($ext, $convertible)) {
			$converted = self::convertToWebp($fld, $img_path, $quality, true);
			if ($converted) {
				if ($old_img != '' && file_exists($fld . $old_img)) {
					unlink($fld . $old_img);
				}
				return $converted;
			}
		}

		// Fallback: move original file
		move_uploaded_file($img_path['tmp_name'], $fld . $fnl_file_nm);

		if ($old_img != '' && file_exists($fld . $old_img)) {
			unlink($fld . $old_img);
		}

		return $fnl_file_nm;
	}

	public function convertToWebp($dirPath, $uploading_image, $quality = 70, $freeSpace = true)
	{
		if (!is_dir($dirPath)) {
			mkdir($dirPath, 0777, true);
		}

		$ext = strtolower(pathinfo($uploading_image['name'], PATHINFO_EXTENSION));
		$file_nm = time() . '_' . basename($uploading_image['name']);
		$fnl_file_nm = str_replace(" ", "_", $file_nm);

		while (file_exists($dirPath . $fnl_file_nm)) {
			$fnl_file_nm = time() . '_' . rand(1000, 9999) . '_' . basename($uploading_image['name']);
		}

		$tempPath = $dirPath . $fnl_file_nm;
		move_uploaded_file($uploading_image['tmp_name'], $tempPath);

		$file_nm_no_ext = pathinfo($fnl_file_nm, PATHINFO_FILENAME);
		$destination = $dirPath . $file_nm_no_ext . '.webp';

		$mime = mime_content_type($tempPath);

		switch ($mime) {
			case 'image/jpeg':
				$image = @imagecreatefromjpeg($tempPath);
				break;
			case 'image/png':
				$image = @imagecreatefrompng($tempPath);
				if ($image !== false) {
					imagepalettetotruecolor($image);
					imagealphablending($image, true);
					imagesavealpha($image, true);
				}
				break;
			case 'image/gif':
				$image = @imagecreatefromgif($tempPath);
				break;
			default:
				// Unsupported (like SVG, WebP) — just keep original
				return basename($tempPath);
		}

		if ($image === false) {
			if ($freeSpace && file_exists($tempPath))
				unlink($tempPath);
			return null;
		}

		imagewebp($image, $destination, $quality);
		imagedestroy($image);

		// Reduce file size loop
		$filesize = filesize($destination) / 1024; // KB
		while ($filesize > 100 && $quality > 10) {
			$quality -= 10;
			switch ($mime) {
				case 'image/jpeg':
					$image = @imagecreatefromjpeg($tempPath);
					break;
				case 'image/png':
					$image = @imagecreatefrompng($tempPath);
					if ($image !== false) {
						imagepalettetotruecolor($image);
						imagealphablending($image, true);
						imagesavealpha($image, true);
					}
					break;
				case 'image/gif':
					$image = @imagecreatefromgif($tempPath);
					break;
			}
			if ($image !== false) {
				imagewebp($image, $destination, $quality);
				imagedestroy($image);
				$filesize = filesize($destination) / 1024;
			} else {
				break;
			}
		}

		if ($freeSpace && file_exists($tempPath)) {
			unlink($tempPath);
		}

		return $file_nm_no_ext . '.webp';
	}






	public function aiDelete($old_img = '')
	{
		if ($old_img != '')
			unlink($old_img);
	}

	public function aiGetAgo($tp_date = '')
	{
		if ($tp_date == '')
			return '';

		$curr_time = strtotime(date('d-m-Y H:i:s'));
		$tp_time = strtotime($tp_date);
		$time_diff = $curr_time - $tp_time;

		if ($time_diff < 0)
			return '';

		$tp_time_date = $this->aiTimeToDate($time_diff);

		if ($tp_time_date['day'] > 0)
			$tp_msg = $tp_time_date['day'] . ' days ago';
		elseif ($tp_time_date['hour'] > 0)
			$tp_msg = $tp_time_date['hour'] . ' hours ago';
		elseif ($tp_time_date['minute'] > 0)
			$tp_msg = $tp_time_date['minute'] . ' minutes ago';
		else
			$tp_msg = $tp_time_date['second'] . ' seconds ago';

		return $tp_msg;
	}

	public function aiTimeToDate($tp_time = '')
	{
		if ($tp_time == '')
			return '';

		$dt_arr = array();

		$d = floor($tp_time / 86400);
		$dt_arr['day'] = ($d < 10 ? '0' : '') . $d;

		$h = floor(($tp_time - $d * 86400) / 3600);
		$dt_arr['hour'] = ($h < 10 ? '0' : '') . $h;

		$m = floor(($tp_time - ($d * 86400 + $h * 3600)) / 60);
		$dt_arr['minute'] = ($m < 10 ? '0' : '') . $m;

		$s = $tp_time - ($d * 86400 + $h * 3600 + $m * 60);
		$dt_arr['second'] = ($s < 10 ? '0' : '') . $s;

		return $dt_arr;
	}



	public function aiCheckLogin()
	{
		if (!(isset($_SESSION['id']) && $_SESSION['id'] != ''))
			$this->aiGoPage("index.php");
	}

	public function aiCheckPermission($module, $action = 'view')
	{
		// Admin has all permissions
		if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') {
			return true;
		}

		// Check Employee Permissions
		if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'employee') {
			global $ai_db;
			$role = $_SESSION['role'] ?? '';
			if (empty($role))
				return false;

			static $request_permissions = null;

			if ($request_permissions === null) {
				$qry = "SELECT permissions FROM tbl_roles WHERE role_name='$role' AND status='active'";
				$res = $ai_db->aiGetQuery($qry);
				if (count($res) > 0) {
					$request_permissions = json_decode($res[0]['permissions'], true) ?: [];
				} else {
					$request_permissions = [];
				}
			}

			if (isset($request_permissions[$module]) && in_array($action, $request_permissions[$module])) {
				return true;
			}
		}

		return false;
	}




	public function aiUpdateSetting($slug = '', $val = '')
	{
		if ($slug == '')
			return false;

		global $ai_db;

		$qry = "UPDATE " . DB_PREFIX . "setting SET meta_value='" . $val . "' WHERE meta_key='" . $slug . "'";
		$res = $ai_db->aiQuery($qry);

		return true;
	}



	public function aiSlug($name = '')
	{
		if ($name == '')
			return '';

		$spec_char = array(' ', '--', '&', '\\', '\'', '"');

		$name = strtolower($name);
		$name = str_replace($spec_char, '-', $name);

		return $name;
	}

	public function aiGetLang($lang = 'en')
	{
		if ($lang == '')
			return 'en';

		foreach ($this->lang_arr as $key => $val) {
			if ($key == $lang)
				return $lang;
		}

		return 'en';
	}



	public function aiGetPassword()
	{
		$seed = str_split('abcdefghijklmnopqrstuvwxyz'
			. 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
			. '0123456789'); // and any other characters
		shuffle($seed); // probably optional since array_is randomized; this may be redundant
		$rand = '';
		foreach (array_rand($seed, 6) as $k)
			$rand .= $seed[$k];

		return $rand;
	}


	public function aiSendNotification($registatoin_ids, $message)
	{
		// Set POST variables
		$url = 'https://android.googleapis.com/gcm/send';

		$fields = array(
			'registration_ids' => $registatoin_ids,
			'data' => $message,
		);

		$headers = array(
			'Authorization: key=' . GOOGLE_API_KEY,
			'Content-Type: application/json'
		);
		// Open connection
		$ch = curl_init();

		// Set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Disabling SSL Certificate support temporarly
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

		// Execute post
		$result = curl_exec($ch);
		if ($result === FALSE) {
			die('Curl failed: ' . curl_error($ch));
		}

		// Close connection
		curl_close($ch);
		echo $result;
	}

	public function aiSendHtmlEmail($to, $sub, $body)
	{

		if ($_SERVER['HTTP_HOST'] == 'localhost') {
			return '';
		} else {
			require 'includes/PHPMailerAutoload.php';

			$mail = new PHPMailer();
			$mail->From = FROM_EMAIL;
			$mail->FromName = EMAIL_FNAME;
			$mail->Host = HOST_NAME;
			$mail->SMTPDebug = 0;
			$mail->SMTPAuth = true;
			$mail->Port = PORT;
			$mail->AddAddress($to);
			$mail->Subject = $sub;
			$mail->Body = $body;
			$mail->Username = EMAIL_USER;
			$mail->Password = EMAIL_PASS;


			if (!$mail->send()) {
				return "fail";
			} else {
				return "success";
			}
		}
	}



	public function aiTranslate($text, $from_lan = 'en', $to_lan = 'en')
	{
		$from_lan = 'en';
		if (isset($_SESSION['curr_lang']) && $_SESSION['curr_lang'] != '')
			$to_lan = $_SESSION['curr_lang'];
		else
			$to_lan = 'en';

		if ($to_lan == 'en') {
			$translated_text = $text;
		} else {
			$json = json_decode(file_get_contents('https://ajax.googleapis.com/ajax/services/language/translate?v=1.0&q=' . urlencode($text) . '&langpair=' . $from_lan . '|' . $to_lan));
			//print_r($json);
			$translated_text = $json->responseData->translatedText;
		}
		return $translated_text;
	}

	public function getTranslation($txt)
	{
		if ($this->def_lang[$txt] != '') {
			return $this->def_lang[$txt];
		} else {
			return $txt;
		}
	}
	public function aiUpdateGCM($tbl, $field, $val, $whr)
	{
		global $ai_db;

		$qry2 = "UPDATE " . $tbl . " SET " . $field . "='" . $val . "' WHERE " . $whr;
		$res2 = $ai_db->aiQuery($qry2);
	}

	public function aiGeneratePIN($digits = 4)
	{
		$i = 0;
		$pin = "";
		while ($i < $digits) {

			$pin .= mt_rand(0, 9);
			$i++;
		}
		return $pin;
	}


	function sendPushNotification($tokens, $payload, $title)
	{
		//$tokens = $arr;
		//print_r($payload);die;
		$url = 'https://fcm.googleapis.com/fcm/send';
		$priority = "high";
		$notification = array_merge(array('title' => $title, 'body' => $payload['message']), $payload);
		//print_r($notification);die;
		$fields = array(
			'registration_ids' => $tokens,
			'notification' => $notification,
			'data' => $notification,
			'content_available' => true
		);

		$headers = array(
			'Authorization:key=' . PUSH_NOTIFICATION . '',
			'Content-Type: application/json'
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		// echo json_encode($fields);
		$result = curl_exec($ch);
		//print_r($result);die;           
		echo curl_error($ch);
		if ($result === FALSE) {
			die('Curl failed: ' . curl_error($ch));
		}
		curl_close($ch);
		return $result;
	}

	public function checkAPISecurity($SECRET)
	{
	}

	public function aiGetPaging($qry, $paged = 1, $per_page = 10, $url = '')
	{
		global $ai_db;
		$paged = ($paged != '') ? $paged : 1;
		if (strpos($url, '?') === false)
			$url = $url . '?';
		else
			$url = $url . '&';

		$qry3 = $qry . ' LIMIT ' . ($per_page * ($paged - 1)) . ', ' . $per_page;
		$res3 = $ai_db->aiGetQuery($qry3);

		$res2 = $ai_db->aiGetQuery($qry);

		$total_rec = count($res2);
		$total_page = ceil($total_rec / $per_page);

		$data = '<ul class="list-inline">
		<li><a href="' . $url . 'paged=1">&laquo;</a></li>';

		for ($i = 1; $i <= $total_page; $i++) {
			$data .= '<li><a class="';
			$data .= ($paged == $i) ? 'active' : '';
			$data .= '" href="' . $url . 'paged=' . $i . '">' . $i . '</a></li>';
		}

		$data .= '<li><a href="' . $url . 'paged=' . $total_page . '">&raquo;</a></li>';

		return array($res3, $data);
	}

	public function base64fileupload($target_dir, $encoded_string)
	{

		$filedata = explode(',', $encoded_string);
		$decoded_file = base64_decode($filedata[1]);


		$file = uniqid() . '.' . 'jpg'; // rename file as a unique name
		$file_dir = $target_dir . uniqid() . '.' . 'jpg';

		try {
			file_put_contents($file_dir, $decoded_file);
			return $file;
		} catch (Exception $e) {
			return false;
		}
	}

	public function Translate($name = '')
	{
		if ($name == '') {
			return false;
		} else {
			$res = $this->aiGetValue(DB_PREFIX . "language", "name_hnd", "slug", $name);
			if ($res != "") {
				return $res;
			} else {
				return $name;
			}
		}
	}


	public function createSlug($string)
	{
		// Convert to lowercase
		$slug = strtolower($string);

		// Remove special characters
		$slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);

		// Replace multiple spaces or hyphens with a single hyphen
		$slug = preg_replace('/[\s-]+/', '-', $slug);

		// Trim hyphens from start and end
		$slug = trim($slug, '-');

		return $slug;
	}

	public function aiParseImportFile($file_path, $original_filename)
	{
		$ext = strtolower(pathinfo($original_filename, PATHINFO_EXTENSION));

		if ($ext === 'xlsx') {
			if (!class_exists('ZipArchive')) {
				return false;
			}
			$zip = new ZipArchive();
			if ($zip->open($file_path) !== TRUE) {
				return false;
			}

			$shared_strings = [];
			$shared_strings_xml = $zip->getFromName('xl/sharedStrings.xml');
			if ($shared_strings_xml) {
				$xml = @simplexml_load_string($shared_strings_xml);
				if ($xml) {
					foreach ($xml->si as $si) {
						if (isset($si->t)) {
							$shared_strings[] = (string) $si->t;
						} elseif (isset($si->r)) {
							$text = '';
							foreach ($si->r as $r) {
								$text .= (string) $r->t;
							}
							$shared_strings[] = $text;
						} else {
							$shared_strings[] = '';
						}
					}
				}
			}

			$sheet_xml = $zip->getFromName('xl/worksheets/sheet1.xml');
			if (!$sheet_xml) {
				$zip->close();
				return false;
			}

			$xml = @simplexml_load_string($sheet_xml);
			if (!$xml) {
				$zip->close();
				return false;
			}

			$rows = [];
			foreach ($xml->sheetData->row as $row) {
				$row_data = [];
				foreach ($row->c as $cell) {
					$cell_ref = (string) $cell['r'];
					preg_match('/^[A-Z]+/', $cell_ref, $matches);
					$col_letter = $matches[0] ?? '';

					$col_idx = 0;
					$len = strlen($col_letter);
					for ($i = 0; $i < $len; $i++) {
						$col_idx = $col_idx * 26 + (ord($col_letter[$i]) - 64);
					}
					$col_idx = $col_idx - 1;

					$val = '';
					if (isset($cell->v)) {
						$val = (string) $cell->v;
						$t = (string) $cell['t'];
						if ($t === 's') {
							$val = $shared_strings[(int) $val] ?? '';
						}
					} elseif (isset($cell->is->t)) {
						$val = (string) $cell->is->t;
					}
					$row_data[$col_idx] = $val;
				}

				if (!empty($row_data)) {
					$max_idx = max(array_keys($row_data));
					for ($i = 0; $i <= $max_idx; $i++) {
						if (!isset($row_data[$i])) {
							$row_data[$i] = '';
						}
					}
					ksort($row_data);
					$rows[] = $row_data;
				}
			}

			$zip->close();
			return $rows;
		} elseif ($ext === 'xls') {
			$temp_csv = tempnam(sys_get_temp_dir(), 'xls_to_csv');
			$py_script = __DIR__ . '/xls_to_csv.py';
			$cmd = "python " . escapeshellarg($py_script) . " " . escapeshellarg($file_path) . " " . escapeshellarg($temp_csv);
			exec($cmd, $output, $return_var);

			$rows = [];
			if ($return_var === 0 && file_exists($temp_csv)) {
				$handle = fopen($temp_csv, "r");
				if ($handle) {
					while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
						$rows[] = $data;
					}
					fclose($handle);
				}
			}
			if (file_exists($temp_csv)) {
				@unlink($temp_csv);
			}
			return $rows;
		} else {
			// Fallback to CSV parsing
			$rows = [];
			$handle = fopen($file_path, "r");
			if ($handle) {
				while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
					$rows[] = $data;
				}
				fclose($handle);
			}
			return $rows;
		}
	}
}

$ai_core = new AI_Core();
