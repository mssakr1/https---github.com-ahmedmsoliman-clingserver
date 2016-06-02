<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of imageSave
 *
 * @author TOSHIBA
 */
class imageSave {
//put your code here
    public function SaveImage($_TmpF) {
        $imgPath='';
        if (isset ($_TmpF['file']['name']) && !empty($_TmpF['file']['name']) && strlen($_TmpF['file']['name'])>=3) {
            $filename=$_TmpF['file']['name'];
            $da=getdate(date("U"));
            $_TmpF["file"]["name"]=$da[seconds].$da[minutes].$da[hours].$da[mday].$da[wday].$da[mon].$da[year].$da[yday];

            $uploaddir = 'uploads/';
            $file = $_TmpF["file"]["name"];//basename($filename);
            $uploadfile = $uploaddir . $file;

            if (move_uploaded_file($_TmpF['file']['tmp_name'], $uploadfile)) {
            //sendResponse(200, 'Upload Successful');
                $imgPath=$uploadfile;
                return $imgPath;

            }else {
                return null;
            }

        }
    }
}
?>
