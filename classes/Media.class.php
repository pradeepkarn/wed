<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php
/**
 * 
 */
class Media
{
    public $dir; // set image folder
    public $ord; // set image folder

    public function read_files($ord = "DESC",$from="0",$to="100")
    {
      $to = $to + 2;
            $this->ord = $ord;
            //Sort in ascending order - this is default
            if ($this->ord == "DESC") {
                return array_slice(scandir($this->dir,1),$from,$to);
            }
            else if ($this->ord == "ASC") {
                return array_slice(scandir($this->dir),$from,$to);
            }
            else {
                return array_slice(scandir($this->dir,1),$from,$to);
            }
    }

    public function filter_by_name($flname="")
    {
            $fls = $this->read_files($this->ord);
            for ($i=0; $i < count($fls); $i++) { 
                if($flname == $fls[$i]){
                    $fl = $fls[$i];
                }
            }
            return $fl;
    }
    public function filter_by_strparts($strpart="")
    {
            $cats = false;
            $fls = $this->read_files($this->ord);
            for ($i=0; $i < count($fls); $i++) { 
                if (isset(explode($strpart,$fls[$i])[1])) {
                  $cats[] = $fls[$i];
              }
            }
            return $cats;
    }

    public function dltMedia($media_src)
    {
      $target_dir = $media_src;
      if (file_exists($target_dir)) {
          unlink($target_dir);
          return true;
      }
      else {
        return false;
      }
    }
    //upload files
public function upload_media($file,$media_folder,$imgname="",$file_type="image/jpeg"){
    $target_dir = RPATH ."/media/".$media_folder."/";
    $file_ext = explode(".",$file["name"]);
    $ext = end($file_ext);
    $target_file = $target_dir ."{$imgname}.".$ext;
    // $target_file = $target_dir ."{$imgname}".basename($file["name"]);
    $uploadOk = 1;
    $imageFileType = $file['type'];
      
      // Check if file already exists
      if (file_exists($target_file)) {
        $uploadmsg = "Sorry, file already exists.";
        $uploadOk = 0;
      }
      
      // Allow certain file formats
      if($imageFileType != $file_type) {
        $uploadmsg = "Sorry, only {$file_type} files are allowed.";
        $uploadOk = 0;
      }
      
      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
        return $uploadmsg;
      // if everything is ok, try to upload file
      } else {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
          $uploadmsg = "The file ". htmlspecialchars( basename( $file["name"])). " has been uploaded.";
          return true;
        } else {
          $uploadmsg = "Sorry, there was an error uploading your file.";
          return $uploadmsg;
        }
      }
    }

}