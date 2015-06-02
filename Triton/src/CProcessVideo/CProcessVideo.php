<?php 

// CProcessVideo.php
// Tagen från htmlphp-startprojektet. 
// Vad ska jag göra med den här klassen egentligen? Typ kapsulera processeringen av filen bara. Det blir bra. 

class CProcessVideo {
	private $file;
	private $filePath;
	private $originalFileName;
	private $mime;
	private $destinationFolder;
	private $storePath;	
	private $db;
	private $name;
	private $url;
	private $output;
	private $outputClass;
	private $status;
	private $user;	
	private $thumbPath;
	private $pathToFfmpeg;

	public function __construct($db){
		$this->originalFileName = $_POST['filename'];
		$this->db = new CDatabase($db);
		$this->file = $_FILES; // ta filen, som fortfarande existarar i superarray.
		$this->destinationFolder = realpath(TRITON_INSTALL_PATH.'/webroot/video/tmp/');
		$this->name = $this->createFileName();
		$this->url = $this->createUrl();
		$this->storePath = realpath(TRITON_INSTALL_PATH.'/webroot/video/').'/'.$this->name;
		$this->thumbPath = realpath(TRITON_INSTALL_PATH.'/webroot/img/').'/'.$this->name;

		$this->user = $_SESSION['user'];

		$hostname = gethostname();

		switch ($hostname) {
			case 'Mattiass-MacBook-Air.local':
				$this->pathToFfmpeg = '/usr/local/bin/ffmpeg'; // Mattias local
				break;
			case 'ubuntuserv1':
				$this->pathToFfmpeg = '/usr/bin/ffmpeg'; // Mattias server
				break;
			default:
				exit('You cannot upload videos on this server. Sorry!'); // Assuming ffmpeg is not installed elsewhere, i.e BTH student server.
				break;
		}
	}

	public function moveFile(){
		if($this->file['data'] && $this->file['data']['error'] == 0) { 
			$tmpLocation = $this->file['data']['tmp_name'];  
			$this->filePath = realpath($this->destinationFolder).'/'.$this->name; 
			move_uploaded_file($tmpLocation, $this->filePath); 
			$this->output = 'Move finished'; 
			$this->outputClass = 'success';
			$this->status = true; 
			return true;
		} else {
			$this->output = 'Move failed. Upload terminated'; 
			$this->outputClass = 'error';
			$this->status = false;
			return false;
		}
	}
	// custom - get file extension. // Ta en fils bokstäver som är efter den sista punkten. (filextendelsen)
	private function getFileExtension($str) {
		$len = strlen($str);
		$lastDotPos = strpos(strrev($str), '.');
		return substr($str, $len - $lastDotPos, $lastDotPos);
	}

	private function getFileNameWithoutExtension($str) {
		$len = strlen($str) - strpos(strrev($str), '.');
		return substr($str, 0, $len);
	}
	
	// Assuming all files are / can be processed like iphone-videos. 
	public function processFile() {
		if($this->status) {
			$file = $this->getFileNameWithoutExtension($this->storePath);
			exec("{$this->pathToFfmpeg} -i {$this->filePath} -vcodec copy -acodec copy {$file}mp4"); // måste leta fram location på package ffmpeg för att få detta att fungera. 
			exec("rm {$this->filePath}");
		}
	} // exec-grejerna.
	
	// create youtube-like url. 
	private function createUrl() { 
		$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_';
		$len = strlen($chars);
		for($i = 0; $i < 10; $i++) {
			@$str .= substr($chars, rand(0, $len), 1);
		}
		return $str;
	} 
	// create a new randommized filename for the server. with no dots, capitals or spaces. 
	private function createFileName() {
		$extension = $this->getFileExtension($this->originalFileName);
		$number = rand(100000, 500000);
		return 'vid'.$number.'.'.$extension;
	}

	// return stuff. 
	public function getOutput() {
		return $this->output;
	}

	public function getOutputClass() {
		return $this->outputClass;
	}

	public function insertToDb() {
		$params[] = $this->user->getId();
		$params[] = $this->url;
		$params[] = $_POST['title'];
		$params[] = $_POST['description'];
		$params[] = $this->getFileNameWithoutExtension(basename($this->storePath));
		$params[] = date(DATE_RFC822);
		$sql = "INSERT INTO video(user, url, title, description, src, created) VALUES(?, ?, ?, ?, ?, ?)";
		$this->db->ExecuteQuery($sql, $params);
		return $this->url;
	}

	// create thumb and store under video/thumbs. Not sure if relative filepath is good to use here.. 
	public function createThumbnail() {
		$file = $this->getFileNameWithoutExtension($this->storePath); // storepath should be the entire filelength. 
		$target = $this->getFileNameWithoutExtension($this->thumbPath);
		exec("{$this->pathToFfmpeg} -i {$file}mp4 -ss 00:00:00.000 -f image2 -vframes 1 {$target}png 2>&1");
		exec("chmod 777 -R {$target}png 2>&1"); // 2>&1.. 
	}
}
