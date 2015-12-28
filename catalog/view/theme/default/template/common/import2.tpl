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
  	 	
    	 	foreach($errors as $error): ?>
  	<tr style=" border:1px solid;">  	
  		<td>
  			<? echo $i.". "?><?php echo $error['file']; ?>
  		</td>	
  	</tr>
  	<tr >  
  		<td>
  		<?php 
                        if ($error['remove']){ echo "<b>".$error['remove']."</b>;"; }
                        
  			echo "<b>Upload ".$error['upload']."</b>; "; 
  			if(isset($error['default_name']) ) 
  				echo $error['default_name']."; ";
  				
  			if(isset($error['default_meta_keywords']) ) 
  				echo $error['default_meta_keywords']."; "; 
  				
  			if(isset($error['default_meta_keywords']) ) 
  				echo $error['default_meta_keywords']."; ";
  				
  			if(isset($error['default_description']) ) 
  				echo $error['default_description']."; "; 
  				
  			if(isset($error['default_model']) ) 
  				echo $error['default_model']."; ";
  				
  			if(isset($error['default_location']) ) 
  				echo $error['default_location']."; "; 
  				
  			if(isset($error['default_sku']) ) 
  				echo $error['default_sku']."; ";
  				
  			if(isset($error['default_weight']) ) 
  				echo $error['default_weight']."; ";
  				
  			if(isset($error['default_width_height']) ) 
  				echo $error['default_width_height']."; ";								 
  		
  		?>	
  		
  		
  		
  		
  		
  		</td>
  		
  	</tr>
  	
  	
  	
  	<?php $i++; endforeach; ?>
  	
  	 
  	
  	
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