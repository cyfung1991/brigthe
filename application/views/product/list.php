<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $page_title;?></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<?php foreach($js as $item){
		$this_js_link = base_url('assets/js/').$item.'.js';
	?>
	<script type="text/javascript" src="<?php echo $this_js_link?>"></script>
	<?php }?>
	<?php foreach($css as $item){
		$this_css_link = base_url('assets/css/').$item.'.css';
	?>
	<link rel="stylesheet" type="text/css" href="<?php echo $this_css_link?>">
	<?php }?>

</head>
<body>

<div id="container">
	<h1><?php echo $page_title;?></h1>
	<a href="<?php echo base_url('product/create_product');?>">Create product</a>

	<!-- Pagination -->
	<div id="pagination">
		Page:
		<?php
		// Pagination html string
		$page_str = "";
		for($i = 1; $i <= $total_page; $i++){
			$this_page_link = base_url("product/index/$i/$sort_by/$order");
			if( (int)$i === (int)$current_page ){
				$this_page_html = "<a class='active' href=$this_page_link>".$i."</a>";
			}else{
				$this_page_html = "<a href=$this_page_link>".$i."</a>";
			}
			$page_str .= ( strlen($page_str) <= 0 ) ? $this_page_html : " | ".$this_page_html;
		}
		echo $page_str;
		?>
		<br> <strong><?php echo $records_per_page?></strong> item per page
	</div>
	<div id="list">
		<?php
		if( count($result) > 0 ){
			echo "<table>";
			echo "<tr>";
			echo "<th>#</th>";
			echo "<th class='sort' data-sort='name'>Name</th>";
			echo "<th class='sort' data-sort='price'>Price</th>";
			echo "<th>Image</th>";
			echo "<th>Description</th>";
			echo "<th>Action</th>";
			echo "</tr>";
			foreach( $result AS $key => $result_item ){
				$this_edit_link = base_url("product/edit_product/".$result_item['product_id']);
				$this_edit_html = "<a href=$this_edit_link>EDIT</a>";
				$this_product_view_link = base_url("product/view_product/".$result_item['product_id']);
				echo "<tr>";
				echo "<td>".$result_item['product_id']."</td>";
				echo "<td><a href='".$this_product_view_link."'>".$result_item['name']."</a></td>";
				echo "<td>".$result_item['price']."</td>";
				if( strlen($result_item['pic_path']) > 0 ){
					echo "<td>";
					echo "<a href='".$this_product_view_link."'>";
					echo "<img class='product_img' src='".$this->config->item('upload_http').$result_item['pic_path']."'>";
					echo "</a>";
					echo "</td>";
				}else{
					echo "<td> - N/A -</td>";
				}
				echo "<td>".$result_item['desc']."</td>";
				echo "<td>$this_edit_html | ";
				echo "<a href='#' class='delete' data-name='".$result_item['name']."' data-pid='".$result_item['product_id']."'>DELETE</a></td>";
				echo "</tr>";
			}
			echo "</table>";
		}
		?>
	</div>
	<script>
	var delete_link = "<?php echo base_url('product/api_delete')?>";
	var current_page = "<?php echo base_url('product/index/')?>";
	var sort_by = "<?php echo $sort_by;?>";
	var order = "<?php echo $order;?>";
	</script>
</body>
</html>
