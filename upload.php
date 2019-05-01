<?php
   $user = isset($_COOKIE['user']) ? json_decode($_COOKIE['user']) : false;
   if(!$user || $user->permission == 0 ) die(json_encode(array("error" => true, "message" => "Bạn không đủ quyền để thực hiện")));
   if(isset($_POST['base64_image'])){
      $data = explode(',',$_POST['base64_image'])[1];
      $filename = md5($data).".png";
      $path = "template/upload/images/".$filename;
      if(file_exists($path)) die(json_encode(array("error" => true, "message" => "Ảnh đã tồn tại\nVui lòng upload ảnh khác")));
      $file = @fopen($path, "w+");      
      $content = base64_decode($data);
      fwrite($file, $content);
      fclose($file);
      die(json_encode(array("error" => false, "message" => "Upload ảnh thành công", "filename" => $filename)));
   }
?>