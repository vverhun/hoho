<?php echo $header; ?>


<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    
  </div>
  <div class="content">
  
  <table style="width:100%; float:left;">
  	 <?php 
  	 	$i = 1;
  	 	
  	 	$cnt = count($errors);
  	 	$errorscnt = 0;
  	 	foreach($errors as $error): ?>
 
   
  		<?php 
  		
   			if(isset($error['default_name']) ) $errorscnt++;
  				//echo $error['default_name']."; ";
  				
  			if(isset($error['default_meta_keywords']) )$errorscnt++;
  				//echo $error['default_meta_keywords']."; "; 
  				
  			if(isset($error['default_meta_keywords']) )$errorscnt++;
  				//echo $error['default_meta_keywords']."; ";
  				
  			if(isset($error['default_description']) )$errorscnt++;
  				//echo $error['default_description']."; "; 
  				
  			if(isset($error['default_model']) )$errorscnt++;
  				//echo $error['default_model']."; ";
  				
  			if(isset($error['default_location']) )$errorscnt++;
  				//echo $error['default_location']."; "; 
  				
  			if(isset($error['default_sku']) )$errorscnt++;
  				//echo $error['default_sku']."; ";
  				
  			if(isset($error['default_weight']) )$errorscnt++;
  				//echo $error['default_weight']."; ";
  				
  			if(isset($error['default_width_height']) )$errorscnt++;
  				//echo $error['default_width_height']."; ";								 
  		
  		?>	
  		
  		
  		
  		
  		
  	 
  	
  	<?php $i++; endforeach; ?>
  	
  	<tr >  	
  		<td><br><br>
  		 <b><span style='color:green;'><? echo $cnt; ?></span>  pictures – Upload: success</b><br><br>
         <b><span style='color:red;'><? echo $errorscnt; ?></span> &nbsp;&nbsp;pictures   – Upload: please check</b>
    <br><br>
  		   <a href='/index.php?route=common/importimages/protocol'>Protocol
  		   </a>
  		</td>	
  	</tr>
  	
  	
  </table>
 
  
  
  
  
  
  
  
  </div>































<!--[if IE]>
<script type="text/javascript" src="view/javascript/jquery/flot/excanvas.js"></script>
<![endif]-->
<script type="text/javascript" src="view/javascript/jquery/flot/jquery.flot.js"></script>
<script type="text/javascript"><!--
function getSalesChart(range) {
	$.ajax({
		type: 'GET',
		url: 'index.php?route=common/home/chart&token=<?php echo $token; ?>&range=' + range,
		dataType: 'json',
		async: false,
		success: function(json) {
			var option = {	
				shadowSize: 0,
				lines: { 
					show: true,
					fill: true,
					lineWidth: 1
				},
				grid: {
					backgroundColor: '#FFFFFF'
				},	
				xaxis: {
            		ticks: json.xaxis
				}
			}

			$.plot($('#report'), [json.order, json.customer], option);
		}
	});
}

getSalesChart($('#range').val());
//--></script>
<?php echo $footer; ?>