<html>
   <head>
      <title><?php echo $page_title;?></title>
   </head>
   <body>
     <?php if( count($product_info) > 0 ){
       echo "<img src=".$this->config->item('upload_http').$product_info['pic_path'].">";
       echo $product_info['name']."<br>";
       echo $product_info['price']."<br>";
       echo $product_info['desc']."<br>";
     }?>
   </body>
</html>
