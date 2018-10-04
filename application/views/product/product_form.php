<html>
   <head>
      <title><?php echo $page_title;?></title>
      <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
      <script src="http://malsup.github.com/jquery.form.js"></script>
      <?php foreach($js as $item){
    		$this_js_link = base_url('assets/js/').$item.'.js';
    	?>
    	<script type="text/javascript" src="<?php echo $this_js_link?>"></script>
    	<?php }?>
   </head>
   <body>
     <?php echo form_open_multipart($api_link, 'id="pic_upload"');?>
         Name: <input type="text" name="name"/><br>
         Price: <input type="text" name="price"/><br>
         Description: <textarea type="text" name="desc"/></textarea><br>
         Photo: <input id="file" type="file" name="image"/><br>
         <input type="submit" class="form_submit" value="Submit" />
      </form>
   </body>

   <script type="text/javascript">
   var product_info = <?php echo ( count($product_info) > 0) ? json_encode($product_info) : '""';?>;
   var link_product_list = "<?php echo base_url('product');?>";
   </script>
</html>
