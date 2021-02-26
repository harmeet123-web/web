<?php

 $countfiles = count($file_name);
          //$fileupload = array();
          //$filedate = array();
          $fileuser = array();
          $uploadfile1 = array();
          $uploadfile = array();
        for($i=0 ; $i < $countfiles; $i++ ) {  
         if($file_name[$i] <> "")
         {  
           $ext = explode(".",$file_name[$i]); 
           if($ext[1] == "doc" || $ext[1] == "pdf" || $ext[1] == "txt" || $ext[1] == "jpg" || $ext[1] == "jpeg" || $ext[1] == "png" || $ext[1] == "gif" || $ext[1] == "docx" || $ext[1] == "PNG" || $ext[1] == "JPG")
           {
            if(!empty($jbb_file)){
                  $Str = str_replace("'", '',stripslashes($_FILES["file_name"]["name"][$i]));
                  $uploadfile = "../job_files/".$Str;
                  $date = date('m/d/Y h:i:s a', time());
                  $fileuser = $_SESSION[user];
              $uploadfile1_file = $Str;
              $uploadfile1 = $jbb_file.','.$uploadfile1_file;
              $final_date = $jbb_file_date.','.$date;
              $final_user = $jbb_file_user.','.$fileuser;
            }else{ 
                  $Str = str_replace("'", '', stripslashes($_FILES["file_name"]["name"][$i])); 
                  //echo $Str;  
                  $uploadfile = "../job_files/".$Str;
                  $date = date('m/d/Y h:i:s a', time());
                  $fileuser = $_SESSION[user];
              //$uploadfile1_file = $_FILES["file_name"]["name"];
              $uploadfile1 = $Str;
              $final_date = $date;
              $final_user = $fileuser;
            }
            move_uploaded_file($_FILES["file_name"]["tmp_name"][$i], $uploadfile);
            $fileupload .= ",$uploadfile1";                           
            $filedate .= ",$final_date";
            $fileuserShow .= ",$final_user";  
           }else{ 
   
           }
           
         }
      }