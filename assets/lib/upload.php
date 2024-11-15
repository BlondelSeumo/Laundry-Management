<?php  

include_once(dirname(dirname(dirname(__FILE__))).'/header.php');
if($_FILES['image']["type"]){
		if(isset($_POST['check_for_logo_img']) && filter_var($_POST['check_for_logo_img']) == 'ld-upload-imagectsi'){
			$iWidth = filter_var($_POST['w']);
			$iHeight = filter_var($_POST['h']);
		}else{
			$iWidth = $iHeight = 200;
		}
		
		$iJpgQuality = 90;	
		 $hh=filter_var($_POST['h']);
		 $ww=filter_var($_POST['w']);
		 $xx1=filter_var($_POST['x1']);
		 $yy1=filter_var($_POST['y1']);	
		
		$newfilename=filter_var($_POST['newname']);	
		$newfolderpath="";
		 if($_FILES){
		 
		$hh=filter_var($_POST['h']);
		$ww=filter_var($_POST['w']);
		$xx1=filter_var($_POST['x1']);
		$yy1=filter_var($_POST['y1']);
		
		$newfilename=filter_var($_POST['newname']).rand(0,100000);
		
           
            if (! $_FILES['image']['error'] && $_FILES['image']['size'] < 1300 * 1300) {
           
                  
					$filename = explode('.',$_FILES['image']['name']);
					
						$newfolderpath=realpath(dirname(dirname(__FILE__)).'/images/services/')."/";
						
						if(!file_exists($newfolderpath)){
						mkdir($newfolderpath,0755);						
						}
						$sTempFileName=$newfolderpath.$newfilename;
							
                    move_uploaded_file($_FILES['image']['tmp_name'], $sTempFileName);
                    
                     
                        $aSize = getimagesize($sTempFileName); 
                      if (!$aSize) {
                            @unlink($sTempFileName);
                            return;
                        }
                       
                        switch($aSize[2]) {
                            case IMAGETYPE_JPEG:
                                $sExt = '.jpg';
                                
                                $vImg = @imagecreatefromjpeg($sTempFileName);
                                break;
                            case IMAGETYPE_PNG:
                                $sExt = '.png';
                              
                                $vImg = @imagecreatefrompng($sTempFileName);
                                break;
							case IMAGETYPE_GIF:
								$sExt = '.gif';
								
								$vImg = @imagecreatefromgif($sTempFileName);
								break;
                            default:
                                unlink($sTempFileName);
                                return;
                        }
                       
                        $vDstImg = @imagecreatetruecolor( $iWidth, $iHeight );
                        /** DO NOT DELETE BELOW COMMENTED CODE  */
						
						imagesavealpha($vDstImg, true);
						$color = imagecolorallocatealpha($vDstImg, 0, 0, 0, 127);
						imagefill($vDstImg, 0, 0, $color);
						imagecopyresampled($vDstImg, $vImg, 0,0, (int)$xx1, (int)$yy1, (int)$iWidth, (int)$iHeight, (int)$ww, (int)$hh);
						$sResultFileName = $sTempFileName . $sExt;
						
						if($aSize['mime'] == 'image/png') {
                            imagepng($vDstImg, $sResultFileName);
						}else{
							imagejpeg($vDstImg, $sResultFileName, $iJpgQuality);
                        }
						@unlink($sTempFileName);
						
						echo filter_var($newfilename.$sExt);
					
					}
			}
		}	
	 
?>