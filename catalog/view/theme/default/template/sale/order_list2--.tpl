<?php echo $header; ?>
 
<style>
	td {
 		  background-color:#EEEEEE;
		  padding: 3px 0px 3px 0px;
	}
		table.tabledetail td, table.tabledetail{
		background-color: #EEE !important;	
	 
	padding: 1px 0px 1px 0px;
	}
	.sbmt_button{
	   margin:1px !important;
	}
</style>
<script> 
$(document).ready(function() {
$('.showdetail').click(function() {
		 var id = $(this).attr('rel');
         $('#' + id).slideToggle('fast');
		 
		 $('.list').css('float','left');
		 $('.proddetailtoshow').css('display','none');

 	 $('.showdetail').each(function(index) {
   		     if (id != $(this).attr('rel')){  $(this).html('Ansicht'); }
		 });

         if ($(this).html() == 'Ansicht') $(this).html('schliessen');
         else  $(this).html('Ansicht');
		 return false;
    });
});
 </script>  
 
<div class="box">
 
     <h1 style="background-image: url('view/image/order.png');">Projektarchiv</h1>
    <!-- <div class="buttons"><a onclick="$('#form').attr('action', '<?php echo $invoice; ?>'); $('#form').attr('target', '_blank'); $('#form').submit();" class="button"><span><?php echo $button_invoices; ?></span></a><a onclick="$('#form').attr('action', '<?php echo $delete; ?>'); $('#form').attr('target', '_self'); $('#form').submit();" class="button"><span><?php echo $button_delete; ?></span></a></div>
    -->
		 <div style="margin-left:15px; line-height:22px;">

    Abgeschlossene Projekte: <span style="color:green;"><? echo $offen; ?></span><br>
    Abgelehnte Projekte:<span style="color:#404042;padding-left:33px;"><? echo $angebot; ?></span><br>
	</div>
	<br>
	<h2>Abgeschlossene Projekte</h2>
 
   <table class="list" style="float:left;width:846px;"  cellpadding=0 cellspacing=0 border=0>
        <thead>
          <tr>
             <td align=center style="background-color: #DDDDDC;" width=100px>
 
			 <?php if ($sort == 'o.invoice') { ?>
               <a href="<?php echo $modified_order; ?>" class="<?php echo strtolower($order); ?>"> <b>Nr.</b> </a>
             <?php } else { ?>
               <a href="<?php echo $modified_order; ?>"> <b>Nr.</b> </a>
             <?php } ?>
			 
		    </td>
            <td class="left" style="background-color: #DDDDDC;">
			
			
			 <?php if ($sort == 'o.firstname') { ?>
               <a href="<?php echo $firstname_order; ?>" class="<?php echo strtolower($order); ?>"><b>Kunde</b>  </a>
             <?php } else { ?>
               <a href="<?php echo $firstname_order; ?>"> <b>Kunde</b>  </a>
             <?php } ?>
			</td>
            <td class="left" style="background-color: #DDDDDC;">
			 <?php if ($sort == 'c.ansprechpartner') { ?>
               <a href="<?php echo $ansprechpartner_order; ?>" class="<?php echo strtolower($order); ?>"><b>Ansprechpartner</b> </a>
             <?php } else { ?>
               <a href="<?php echo $ansprechpartner_order; ?>"> <b>Ansprechpartner</b>  </a>
             <?php } ?>
			 </td>
            <td class="left" style="background-color: #DDDDDC;">
			 <?php if ($sort == 'o.totalproducts') { ?>
               <a href="<?php echo $totalproducts_order; ?>" class="<?php echo strtolower($order); ?>"><b>Bilder</b> </a>
             <?php } else { ?>
               <a href="<?php echo $totalproducts_order; ?>"> <b>Bilder</b>  </a>
             <?php } ?>
			 </td>
            <td class="left" style="background-color: #DDDDDC;">
			 <?php if ($sort == 'o.date_added') { ?>
               <a href="<?php echo $date_order; ?>" class="<?php echo strtolower($order); ?>"><b>abgeschlossen</b>  </a>
             <?php } else { ?>
               <a href="<?php echo $date_order; ?>"><b>abgeschlossen</b>   </a>
             <?php } ?>
			</td>
		    <td class="left" style="background-color: #DDDDDC;">
		    <?php if ($sort == 'o.status_id') { ?>
               <a href="<?php echo $status_order; ?>" class="<?php echo strtolower($order); ?>"><b>Status</b> </a>
             <?php } else { ?>
               <a href="<?php echo $status_order; ?>"><b>Status</b>  </a>
             <?php } ?>
             
			  </td>

            <td class="right" style="background-color: #DDDDDC;">
			 
			 
			  </td>
			 </td>
	        <td class="right" style="background-color: #DDDDDC;">  </td>
          </tr>
        </thead>
        <tbody>
     
          <?php if ($orders) { $index = 0; ?>
          <?php foreach ($orders as $order) { $index++; ?>
          
		  
		 
		  
		  <tr>
            <td style="text-align: center;"> <?php echo $order['pdfid']; ?></td>
            <td class="right" width=170px><div style='width:150px; overflow:hidden;'><?php echo $order['name']; ?></div></td>
            <td class="left"  width=180px><div style='width:150px; overflow:hidden;'><?php echo $order['ansprechpartner']; ?></div></td>
            <td class="left" width=60px><?php echo $order['totalproducts']; ?></td>
            <td class="left" width=120px><?php echo $order['date_added']; ?></td>
            <td class="right" width=140px><?php echo $order['status']; ?></td>
			
            <td class="right"> <a href='#' class='showdetail' rel='proddetail<?php echo $order['order_id'];?>'>Ansicht</a> </td>
          </tr>
		   <tr><td colspan=8  style="padding:0px !important;">
		    <form action="/index.php" method='get' id="form<?php echo $order['order_id']; ?>" class="jNice" >
			<input type=hidden name="route" value="sale/order/angebot" />
			<input type=hidden name="order_id" value="<?php echo $order['order_id'];?>" />
			
		    <div  class="proddetailtoshow" style='display:none;' id='proddetail<?php echo $order['order_id'];?>'> 
             
              <?php foreach ($order['products_orders'] as $product) { ?>
                <h2 style='background-color:white !important;'>CR: <?php echo $product['sku'];?>, <?php echo $product['name'];?>
 				   <?php  if ($product['status_id'] == 0) { ?>
				  		 <span style="float:right; padding-right:24px">Genehmigung nicht erteilt&nbsp;</span>
				   <?php } ?>
 				
 				</h2>
                <table border=0 width=100%  style="float:left;"><tr>
                   
                   <td valign=center align=center width=206px> <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /> </td>
                   <td valign=center >
				   <div style="line-height:19px;">
				   <table border=0 width=90% cellpadding=0 cellspacing=0><tr><td width="100px" style="padding: 0px;">
                      Titel:</td><td  style="padding: 0px;width: 100px;"><b><?php echo $product['titel']; ?></b> </td></tr>
                      <tr><td  style="padding: 0px;">Plazierung:&nbsp;&nbsp;</td><td  style="padding: 0px;"><b><?php if ( $product['titelseite'] == '1') echo 'Titelseite'; ?> <?php if ( $product['innenseite'] == '1') echo 'Innenseite'; ?></b>  </td></tr>                    
                      <tr><td  style="padding: 0px;">Art:</td><td  style="padding: 0px;"><b><?php echo $product['art']; ?></b>   </td></tr>
                      
                    <?php if ( $product['art_id'] != 11){ ?>
                       <tr><td  style="padding: 0px;">Auflage:</td><td  style="padding: 0px;"><b><?php echo $product['auflage']; ?></b>   </td></tr>
                       <tr><td  style="padding: 0px;">Größe:</td><td  style="padding: 0px;"><b><?php echo $product['grosse']; ?></b>  </td></tr>
                       <?php } ?>
					   		  <?php if ($product['komentar'] != '') { ?><tr><td style="padding: 0px;" width=100px valign=top >
                         Kommentar:</td><td  style="padding: 0px;width: 100px;font-size:11px;"> <?php echo $product['komentar']; ?> </td></tr>  <?php }?>  
					  
					  </table>
					  </div>                                                           
                   </td>
                   <td valign=top align=right  style="padding-right:30px">
		 
				   	Reproduktionskosten:&nbsp;<span style="color:red"><?php echo  sprintf('%.2f',$product['price']);  ?> &euro;</span><br><br>
					<?if ( $order['status_id'] == '1'){?>
					   Gewährter Nachlass (+/- %):<input type="text" size=5 name="first<?php echo $product['product_id']; ?>" value='' /><br><br>
					<?}?>
					Datenversand: <span style="color:red"><?php echo  sprintf('%.2f',$product['tax']);  ?> &euro;</span><br><br>
					<?if ( $order['status_id'] == '1'){?>
						Gewährter Nachlass (+/- %):<input type="text" size=5 name="second<?php echo $product['product_id']; ?>" value='' /><br><br>
					<?}?>
					
					SUMME: <span style="color:red"><?php echo  sprintf('%.2f',$product['total']);  ?>  &euro;</span><br>
				   
				   
				   </td>
                                       
                </tr></table>
               <?php } ?>
               
                           <div style="width:816px; text-align:right; background-color:#DDDDDC;float:left; padding:7px 30px 7px 0px;" >
                
                       Steuerpfl. Betrag:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:red" id="subtotal<?php echo $order['order_id'];?>">
                            <?php echo  sprintf('%.2f',$order['subtotal']);  ?>  &euro;
                      </span><br><br>
                       <?php echo $order['numberpercent'];?>% MwSt.:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="color:red" id="tax<?php echo $order['order_id'];?>">
                            <?php echo  sprintf('%.2f',round($order['tax'],2));  ?>  &euro;
                      </span>
                     
                    <span style="display:none;" id="taxorig<?php echo $order['order_id'];?>">
                            <?php echo  sprintf('%.2f',round($order['tax'],2));  ?>  &euro;
                      </span>
                </div>
                
                
                
                <div style="     background-color: #BEBEBE;
     cursor: pointer;
    float: left;
    padding: 7px 0 7px 15px;
    text-align: left;
    text-decoration:underline; font-weight:bold;
    width: 389px; ">
                
                
                	 <a TARGET="_blank" style="color:red !important;" href="/index.php?route=sale/order/printorder&order_id=<?php echo $order["order_id"];?>" >
                           Rechnung erstellen
                     </a>
                </div>
                
                <div style="width:405px;text-align:right; background-color:#bebebe;float:left; padding:7px 30px 7px 7px;" >
                
                
                        <b>GESAMSUMME:</b> <span style="color:red"><?php echo sprintf('%.2f',round($order['total'],2));  ?> &euro;</span>
                
                
                </div>
                
			 
             
             </div>
		   	   </form>
			   
			    <div style="width:846px;text-align:right; float:left; height:5px; background-color:#DDDDDC;">&nbsp;</div>

		   </td></tr>
	
		   
		   
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="7"><div style="padding-left:10px;">Keine Ergebnisse</div></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
  
 <!--       yyyyyyyyyyyyyyyyyyyyyyy    -->
 
 
	<h2 class="list" style="float:left;  margin-top: 40px;">Abgelehnte Projekte</h2>
 
 <table class="list" style="float:left;width:96%;"  cellpadding=0 cellspacing=0 border=0>
        <thead>
          <tr>
             <td align=center style="background-color: #DDDDDC;" width=100px>
 
			 <?php if ($sort == 'o.order_id') { ?>
               <a href="<?php echo $sort_order; ?>" class="<?php echo strtolower($order); ?>"> <b>Nr.</b> </a>
             <?php } else { ?>
               <a href="<?php echo $sort_order; ?>"> <b>Nr.</b> </a>
             <?php } ?>
			 
		    </td>
            <td class="left" style="background-color: #DDDDDC;">
			
			
			 <?php if ($sort == 'o.firstname') { ?>
               <a href="<?php echo $firstname_order; ?>" class="<?php echo strtolower($order); ?>"><b>Kunde</b>  </a>
             <?php } else { ?>
               <a href="<?php echo $firstname_order; ?>"> <b>Kunde</b>  </a>
             <?php } ?>
			</td>
            <td class="left" style="background-color: #DDDDDC;">
			 <?php if ($sort == 'c.ansprechpartner') { ?>
               <a href="<?php echo $ansprechpartner_order; ?>" class="<?php echo strtolower($order); ?>"><b>Ansprechpartner</b> </a>
             <?php } else { ?>
               <a href="<?php echo $ansprechpartner_order; ?>"> <b>Ansprechpartner</b>  </a>
             <?php } ?>
			 </td>
            <td class="left" style="background-color: #DDDDDC;">
			 <?php if ($sort == 'o.totalproducts') { ?>
               <a href="<?php echo $totalproducts_order; ?>" class="<?php echo strtolower($order); ?>"><b>Bilder</b> </a>
             <?php } else { ?>
               <a href="<?php echo $totalproducts_order; ?>"> <b>Bilder</b>  </a>
             <?php } ?>
			 </td>
            <td class="left" style="background-color: #DDDDDC;">
			 <?php if ($sort == 'o.date_added') { ?>
               <a href="<?php echo $date_order; ?>" class="<?php echo strtolower($order); ?>"><b>abgeschlossen</b>  </a>
             <?php } else { ?>
               <a href="<?php echo $date_order; ?>"><b>abgeschlossen</b>   </a>
             <?php } ?>
			</td>
		    <td class="left" style="background-color: #DDDDDC;">
			 <?php if ($sort == 'o.status_id') { ?>
               <a href="<?php echo $status_order; ?>" class="<?php echo strtolower($order); ?>"><b>Status</b> </a>
             <?php } else { ?>
               <a href="<?php echo $status_order; ?>"><b>Status</b>  </a>
             <?php } ?>
			  </td>

            <td class="right" style="background-color: #DDDDDC;">
			 
			  </td>
			 </td>
	        <td class="right" style="background-color: #DDDDDC;">  </td>
          </tr>
        </thead>
        <tbody>
     
          <?php if ($orders2) { $index1=0; ?>
          <?php foreach ($orders2 as $order) {$index1++; ?>
          
		  
		 
		  
		  <tr>
            <td style="text-align: center;"><?php echo sprintf('%04d' , $index1); ?></td>
            <td class="right" width=170px><div style='width:150px; overflow:hidden;'><?php echo $order['name']; ?></div></td>
            <td class="left"  width=180px><div style='width:150px; overflow:hidden;'><?php echo $order['ansprechpartner']; ?></div></td>
            <td class="left" width=60px><?php echo $order['totalproducts']; ?></td>
            <td class="left" width=120px><?php echo $order['date_added']; ?></td>
            <td class="right" width=140px><?php echo $order['status']; ?></td>
			
            <td class="right"> <a href='#' class='showdetail' rel='proddetail<?php echo $order['order_id'];?>'>Ansicht</a> </td>
          </tr>
		   <tr><td colspan=8  style="padding:0px !important;">
		    <form action="/index.php" method='get' id="form<?php echo $order['order_id']; ?>" class="jNice" >
			<input type=hidden name="route" value="sale/order/angebot" />
			<input type=hidden name="order_id" value="<?php echo $order['order_id'];?>" />
			
		    <div class="proddetailtoshow" style='display:none;' id='proddetail<?php echo $order['order_id'];?>'> 
             
              <?php foreach ($order['products_orders'] as $product) { ?>
                <h2 style='background-color:white !important;'>CR: <?php echo $product['sku'];?>, <?php echo $product['name'];?>
 					   <?php  if ($product['status_id'] == 0) { ?>
				  		 <span style="float:right; padding-right:24px">Genehmigung nicht erteilt&nbsp;</span>
				   <?php } ?>
 				</h2>
                <table border=0 width=100%  style="float:left;"><tr>
                   
                   <td valign=center align=center width=200px> <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /> </td>
                   <td valign=center ><div style="line-height:19px;">
				    <table border=0 width=90% cellpadding=0 cellspacing=0><tr><td width="100px" style="padding: 0px;">
                      Titel:</td><td  style="padding: 0px;width: 100px;"><b><?php echo $product['titel']; ?></b> </td></tr>
                      <tr><td  style="padding: 0px;">Plazierung:&nbsp;&nbsp;</td><td  style="padding: 0px;"><b><?php if ( $product['titelseite'] == '1') echo 'Titelseite'; ?> <?php if ( $product['innenseite'] == '1') echo 'Innenseite'; ?></b>  </td></tr>                    
                      <tr><td  style="padding: 0px;">Art:</td><td  style="padding: 0px;"><b><?php echo $product['art']; ?></b>   </td></tr>
                      
                       <?php if ( $product['art_id'] != 11){ ?>
                       <tr><td  style="padding: 0px;">Auflage:</td><td  style="padding: 0px;"><b><?php echo $product['auflage']; ?></b>   </td></tr>
                       <tr><td  style="padding: 0px;">Größe:</td><td  style="padding: 0px;"><b><?php echo $product['grosse']; ?></b>  </td></tr>
                       <?php } ?>
                       		  <?php if ($product['komentar'] != '') { ?><tr><td style="padding: 0px;" width=100px valign=top >
                         Kommentar:</td><td  style="padding: 0px;width: 100px;font-size:11px;"> <?php echo $product['komentar']; ?> </td></tr>  <?php }?>
                         
                         </table>
					  </div>                                                                     
                   </td>
                   <td valign=top align=right  style="padding-right:30px">
		 
				   	Reproduktionskosten:&nbsp;<span style="color:red"><?php echo  sprintf('%.2f',$product['price']);  ?> &euro;</span><br><br>
					<?if ( $order['status_id'] == '1'){?>
					   Gewährter Nachlass (+/- %):<input type="text" size=5 name="first<?php echo $product['product_id']; ?>" value='' /><br><br>
					<?}?>
					Datenversand: <span style="color:red"><?php echo  sprintf('%.2f',$product['tax']);  ?> &euro;</span><br><br>
					<?if ( $order['status_id'] == '1'){?>
						Gewährter Nachlass (+/- %):<input type="text" size=5 name="second<?php echo $product['product_id']; ?>" value='' /><br><br>
					<?}?>
					
					SUMME: <span style="color:red"><?php echo  sprintf('%.2f',$product['total']);  ?>  &euro;</span><br>
				   
				   
				   </td>
                                       
                </tr></table>
               <?php } ?>
               
                           <div style="width:816px; text-align:right; background-color:#DDDDDC;float:left; padding:7px 30px 7px 0px;" >
                
                       Steuerpfl. Betrag:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:red" id="subtotal<?php echo $order['order_id'];?>">
                            <?php echo  sprintf('%.2f',$order['subtotal']);  ?>  &euro;
                      </span><br><br>
                       <?php echo $order['numberpercent'];?>% MwSt.:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="color:red" id="tax<?php echo $order['order_id'];?>">
                            <?php echo  sprintf('%.2f',$order['tax']);  ?>  &euro;
                      </span>
                     
                    <span style="display:none;" id="taxorig<?php echo $order['order_id'];?>">
                            <?php echo  sprintf('%.2f',$order['tax']);  ?>  &euro;
                      </span>
                </div>
                
                <div style="width:809px;text-align:right; background-color:#bebebe;float:left; padding:7px 30px 7px 7px; " ><b>GESAMSUMME:</b> <span style="color:red"><?php echo  sprintf('%.2f',$order['total']);  ?> &euro;</span></div>
                
				
				 
             
             
             </div>
		   	   </form>
			   			   <div style="width:846px;text-align:right; float:left; height:5px; background-color:#DDDDDC;">&nbsp;</div>

		   </td></tr>
	
		   
		   
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="7"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
   </div>
</div>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=sale/order&token=<?php echo $token; ?>';
	
	var filter_order_id = $('input[name=\'filter_order_id\']').attr('value');
	
	if (filter_order_id) {
		url += '&filter_order_id=' + encodeURIComponent(filter_order_id);
	}
	
	var filter_name = $('input[name=\'filter_name\']').attr('value');
	
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	
	var filter_order_status_id = $('select[name=\'filter_order_status_id\']').attr('value');
	
	if (filter_order_status_id != '*') {
		url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
	}	

	var filter_date_added = $('input[name=\'filter_date_added\']').attr('value');
	
	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}

	var filter_total = $('input[name=\'filter_total\']').attr('value');

	if (filter_total) {
		url += '&filter_total=' + encodeURIComponent(filter_total);
	}	
		
	location = url;
}
//--></script>
<script type="text/javascript" src="view/javascript/jquery/ui/ui.datepicker.js"></script>
<script type="text/javascript"><!--
$(document).ready(function() {
	/*$('#date').datepicker({dateFormat: 'yy-mm-dd'});*/
});
//--></script>
<?php echo $footer; ?>