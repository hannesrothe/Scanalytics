<?php
	include("config.php");
?>
<html>
<head>
	<title>Science Quantified</title>
	<link rel="stylesheet" type="text/css" href="design/main.css">
</head>
<body>
	<?php
		if(!empty($_GET['fname']) && !empty($_GET['lname'])){
			$author_data = new author_analytics();
			$author_data->set_author_data($_GET);
			$author_name = $author_data->get_author_data()["fname"] . " " . $author_data->get_author_data()["lname"];
			
			if($author_data->get_data_rm() !== false) //Is there any data from Readermeter?
			
			$data_rm["hr_index"] = $author_data->get_data_rm()->author_metrics->hr_index;
			$data_rm["gr_index"] = $author_data->get_data_rm()->author_metrics->gr_index;
			$data_rm["single_most_read"] = $author_data->get_data_rm()->author_metrics->single_most_read;
			$data_rm["publication_count"] = $author_data->get_data_rm()->author_metrics->publication_count;
			$data_rm["bookmark_count"] = $author_data->get_data_rm()->author_metrics->bookmark_count;
			$data_rm["data_source"] = $author_data->get_data_rm()->author_metrics->data_source;
				
		}
	?>
	<div id="main">
		<form id="author_data" action="index.php" method="get">
			First name: <input name="fname" form="author_data" value='<?php if(!empty($_GET['fname']) && !empty($_GET['lname'])) echo $author_data->get_author_data()["fname"]; ?>'/>
			Last name: <input name="lname" form="author_data" value='<?php if(!empty($_GET['fname']) && !empty($_GET['lname'])) echo $author_data->get_author_data()["lname"]; ?>'/>
			<button>Send</button>
		</form>
		<div class="data_box">
			Name: <?php echo @$author_name ?><br />
			<?php 
				foreach($data_rm as $metrics=>$value){
					echo $metrics . ": ". $value. "<br />";
				}
			 ?>
		</div>
		<div class="data_box">

		</div>
		<ul id="debug">Debug
		<?php
			if(isset($author_data->debug)){
				foreach($author_data->debug as $e) 
					echo "<li>Wo? ".$e[0]."<br />Was? ".$e[1]."</li>";
			}else{
				echo "<li>Empty</li>";
			}
		?>
		</ul>
	</div>
</body>
</html>