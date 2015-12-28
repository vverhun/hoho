<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
  		 
            <h1>Confirmation</h1>
   
 
        <?php foreach ($products as $product) { ?>
       
        <h2>CR: <?php echo $product['sku'];  ?>, <?php echo $product['name'];?></h2>
        <table class="cart" style="float:left;" width=100%>
        <tr>
        
          <td align="left" valign="top"> 
          	  <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /> 
          </td>
          <td align="left" valign="top"> 
             <?php if ( $product['titelseite'] == '1'){ ?>  <b>Titelseite</b> <br><br>  <br> <?php }?>
            <?php if ( $product['innenseite'] == '1'){ ?>   <b>Innenseite</b>  <br><br>  <br> <?php }?>
             <div style="width:288px">
	              Art der publication: <b><?php echo $product['art']; ?> </b><br><br>
	              Auflage publication: <b><?php echo $product['auflage']; ?> </b><br><br>
	             Grosse der Abbildung:  <b><?php echo $product['grosse']; ?>  </b><br><br>
	            
		        
	         </div>	                 
          </td>
          <td valign="top" >
          <b>Titel der Publikationen*: </b> <br>
          <?php echo $product['titel']; ?> <br><br><br>
          <b>Komentar:</b><br>
           <?php echo $product['komentar']; ?> 
          </td>
                  
        </tr>      </table>
        <?php } ?>
        
        
   <table width="100%">
          <tbody><tr>
            <td align="center"> </td>
            <td align="right"><a class="process_button" onclick="" style="cursor:pointer;"><span> </span></a></td>
          </tr>
        </tbody></table>
        
  <script type="text/javascript"><!--
    $('.process_button').click(function() {
		$.ajax({ 
			type: 'GET',
			url: 'index.php?route=payment/cod/confirm',
			success: function() {
				location = '/index.php?route=checkout/success';
			}		
		});
    });
//--></script>
  
 <?php echo $footer; ?>