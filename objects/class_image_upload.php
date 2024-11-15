<?php  

/*If you got an error of undefined variable then check variable is defined like $this->variable_name or not
Use Not for image_upload_class
*	set value of image_name;=image_name
*	set value of tmp_name;=tmp_name
*	set value of imagetype for extension;=imagetype
*	set value of file_size;=filesize
*	set value of image_id for adding insert id to the image;=image_id
*	set value of folder for 1st class->business_id==1;
*	set value of folder if second and more id..set it equal to business id;
*	set value of insert id while updating record equals to filter_var($_POST['id']);
*	set value of imagenewname and its thumbnail name;=imagenewname and thumbnailnewname
*	set value of dir/path;=dir;
*/
class laundry_image_upload{
		public $image_name;
		public $tmp_name;
		public $dir;
		public $file_size;
		public $maxsize='1000000';
		public $thumb_height=100;
		public $thumb_width=100;
		public $org_height;
		public $org_width;
		public $newfilename;
		public $image_id;
		public $conn;
		public $imagetype;
		public $imagenewname;
		public $thumbnailnewname;
		
		public	function GetImageExtension($imagetype)
		{
			if (empty($imagetype))
				return false;
			switch ($imagetype) {
				case 'image/bmp':
					return '.bmp';
				case 'image/gif':
					return '.gif';
				case 'image/jpeg':
	                return '.jpg';
				case 'image/png':
					return '.png';
				default:
					return false;
			}
		}
		
		public function upload_image(){
			if($this->checksize()){
				echo filter_var("Size of image should not be more than 10 MB");
				exit;
			}
		
			$fileextention = $this->GetImageExtension($this->imagetype);
						
			if(move_uploaded_file($this->tmp_name,$this->dir.$this->imagenewname.$this->image_id.$fileextention)){
				$filename=basename($this->dir.$this->imagenewname.$this->image_id.$fileextention);
				
					if($this->create_thumbnail()){
						return true;
					}
					
					return $filename;
				}
		}
			
		/*1 mb =1000 kb check file size*/
		public function checksize(){
			if(($this->file_size >= $this->maxsize)){
				return true;
			}
		}	
		
		public function create_thumbnail(){
			$fileextention = $this->GetImageExtension($this->imagetype);
			$thumbnail=$this->dir.$this->thumbnailnewname.$this->image_id.$fileextention;
			list($this->org_height,$this->org_width)=getimagesize($this->dir.$this->imagenewname.$this->image_id.$fileextention);
			$thumb_create = imagecreatetruecolor($this->thumb_width,$this->thumb_height);
			switch($fileextention){
					case '.jpg':
						$source=imagecreatefromjpeg($this->dir.$this->imagenewname.$this->image_id.$fileextention);
						break;
					
					case '.jpeg':
						$source=imagecreatefromjpeg($this->dir.$this->imagenewname.$this->image_id.$fileextention);
						break;
					
					case '.png':
						$source=imagecreatefrompng($this->dir.$this->imagenewname.$this->image_id.$fileextention);
						break;
					
					case '.gif':
						$source=imagecreatefromgif($this->dir.$this->imagenewname.$this->image_id.$fileextention);
						break;
					
					default:
					    $source=imagecreatefromjpeg($this->dir.$this->imagenewname.$this->image_id.$fileextention);
	
				}
				
				imagecopyresized($thumb_create,$source,0,0,0,0,$this->thumb_width,$this->thumb_height,$this->org_width,$this->org_height);
			
				switch($fileextention){
					case 'jpg' || 'jpeg':
						imagejpeg($thumb_create,$thumbnail,100);
						break;
					case 'png':
						imagepng($thumb_create,$thumbnail,100);
						break;
					case 'gif':
						imagegif($thumb_create,$thumbnail,100);
						break;
					default:
						imagejpeg($thumb_create,$thumbnail,100);
			
				}
		}
	}
?>