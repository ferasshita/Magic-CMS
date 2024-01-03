<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Editor extends Controller {

	public function __construct()
	{

		helper(
				['langs', 'IsLogedin','timefunction','Mode','countrynames', 'functions_zone','app_info']);

				$this->comman_model = new \App\Models\Comman_model();
			LoadLang();

	}
	public function edit()
	{
		$data['page'] = filter_var(htmlspecialchars($this->request->getGet('page')),FILTER_SANITIZE_STRING);
		$data['folder_pg'] = filter_var(htmlspecialchars($this->request->getGet('folder')),FILTER_SANITIZE_STRING);
		echo view('editor/editor', $data);
		echo View('includes/endJScodes', $data);
	}
	public function edits(){
		echo view('editor/edits');

	}
	public function save(){
		define('MAX_FILE_LIMIT', 1024 * 1024 * 2);//2 Megabytes max html file size

		function sanitizeFileName($file) {
			//sanitize, remove double dot .. and remove get parameters if any
			//	$file = __DIR__ . '/' . preg_replace('@\?.*$@' , '', preg_replace('@\.{2,}@' , '', preg_replace('@[^\/\\a-zA-Z0-9\-\._]@', '', $file)));
			//allow only .html extension
			//$file = preg_replace('/\..+$/', '', $file) . '.html';
			return $file;
		}
		function showError($error) {
			header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
			die($error);
		}

		$html   = '';
		$file   = '';
		$action = '';

		if (NULL !== ($this->request->getPost('startTemplateUrl')) && !empty($this->request->getPost('startTemplateUrl'))) {
			$startTemplateUrl = sanitizeFileName($this->request->getPost('startTemplateUrl'));
			$html = file_get_contents($startTemplateUrl);
		} else if (NULL !== ($this->request->getPost('html'))){
			$html = substr($this->request->getPost('html'), 0, MAX_FILE_LIMIT);
		}


		if (NULL !== ($this->request->getPost('file'))) {
			$file = sanitizeFileName($this->request->getPost('file'));
		}

		$html_f = $html;

		$html = preg_replace('/<!-- dont_write -->(.*?)<!-- \/dont_write -->/s', '', $html);


		$html = preg_replace('/<script>\/\/ dont_write<\/script>(.*?)<script>\/\/ \/dont_write<\/script>/s', '', $html);
		// Replace the content within the <div> element with class="container" with PHP code
		if (isset($_GET['action'])) {
			$action = $_GET['action'];
		}
		// Replace the content within the <div> element with class="container" with PHP code
		if ($action) {
			//file manager actions, delete and rename
			switch ($action) {
				case 'rename':
					$newfile = sanitizeFileName($this->request->getPost('newfile'));
					if ($file && $newfile) {
						if (rename($file, $newfile)) {
							echo "File '$file' renamed to '$newfile'";
						} else {
							showError("Error renaming file '$file' renamed to '$newfile'");
						}
					}
				break;
				case 'delete':
					if ($file) {
						if (unlink($file)) {
							echo "File '$file' deleted";
						} else {
							showError("Error deleting file '$file'");
						}
					}
				break;
				default:
					showError("Invalid action '$action'!");
			}
		} else {
			//save page
			if ($html) {
				if ($file) {
					$dir = dirname($file);
					if (!is_dir($dir)) {
						echo "$dir folder does not exist\n";
						if (mkdir("src/".$dir, 0777, true)) {
							echo "$dir folder was created\n";
							$file = "src/".$file;
						} else {
							showError("Error creating folder '$dir'\n");
						}
					}
				if (file_put_contents($file, $html)) {
						echo "File saved '$file'";

					} else {
						showError("Error saving file '$file'\nPossible causes are missing write permission or incorrect file path!");
					}
				} else {
					showError('Filename is empty!');
				}
			} else {
				showError('Html content is empty!');
			}
		}

	}
	public function scan(){
		//scan media folder for all files to display in media modal

		if (isset($_POST['mediaPath'])) {
			define('UPLOAD_PATH', $_POST['mediaPath']);
		} else {
			define('UPLOAD_PATH', 'media');
		}

		$scandir = 'Asset/upload/gallery';

		// Run the recursive function
		// This function scans the files folder recursively, and builds a large array

		$scan = function ($dir) use ($scandir, &$scan) {
			$files = [];

			// Is there actually such a folder/file?

			if (file_exists($dir)) {
				foreach (scandir($dir) as $f) {
					if (! $f || $f[0] == '.') {
						continue; // Ignore hidden files
					}

					if (is_dir($dir . '/' . $f)) {
						// The path is a folder

						$files[] = [
							'name'  => $f,
							'type'  => 'folder',
							'path'  => str_replace($scandir, '', $dir) . '/' . $f,
							'items' => $scan($dir . '/' . $f), // Recursively get the contents of the folder
						];
					} else {
						// It is a file

						$files[] = [
							'name' => $f,
							'type' => 'file',
							'path' => str_replace($scandir, '', $dir) . '/' . $f,
							'size' => filesize($dir . '/' . $f), // Gets the size of this file

						];
					}
				}
			}

			return $files;
		};

		$response = $scan($scandir);

		// Output the directory listing as JSON

		header('Content-type: application/json');

		echo json_encode([
			'name'  => '',
			'type'  => 'folder',
			'path'  => '',
			'items' => $response,
		]);

	}
		public function upload(){

			/*
			This script is used by image upload input to save the image on the server and return the image url to be set as image src attribute.
			*/
			$uploadDenyExtensions  = ['php'];
			$uploadAllowExtensions = ['ico','jpg','jpeg','png','gif','webp'];

			function showError($error) {
				header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
				die($error);
			}

			function sanitizeFileName($file)
			{
				//sanitize, remove double dot .. and remove get parameters if any
				$file = preg_replace('@\?.*$@' , '', preg_replace('@\.{2,}@' , '', preg_replace('@[^\/\\a-zA-Z0-9\-\._]@', '', $file)));
				return $file;
			}


			define('UPLOAD_FOLDER', __DIR__ . '/');
			if (isset($_POST['mediaPath'])) {
				define('UPLOAD_PATH', sanitizeFileName($_POST['mediaPath']) .'/');
			} else {
				define('UPLOAD_PATH', '/');
			}

			$fileName  = $_FILES['file']['name'];
			$extension = strtolower(substr($fileName, strrpos($fileName, '.') + 1));

			//check if extension is on deny list
			if (in_array($extension, $uploadDenyExtensions)) {
				showError("File type $extension not allowed!");
			}

			/*
			//comment deny code above and uncomment this code to change to a more restrictive allowed list
			// check if extension is on allow list
			if (!in_array($extension, $uploadAllowExtensions)) {
				showError("File type $extension not allowed!");
			}
			*/

			$destination = 'Asset/upload/gallery/'. $fileName;
			move_uploaded_file($_FILES['file']['tmp_name'], $destination);

			if (isset($_POST['onlyFilename'])) {
				echo '../../'.$destination;
			} else {
				echo '../../'.$destination;

			}
		}
}
