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
 <div class="datefilter">
    
     <?for ($i = 2012; $i < 2050; $i++){ ?>
     
     <?if ($i <= date('Y')){?>
       <?if ($year == $i){ echo "<b>".$i."</b>"; }else {?><a href="/index.php?route=sale/order/projektarchiv&type=<?echo $type;?>&year=<? echo $i;?>"><? echo $i;?></a> <?}?>
    <?}?>
 <?}?>
     
 
 </div>
<div class="box" style="float:left;">
    
        
     <h1 style="background-image: url('view/image/order.png');margin-top:14px !important;">Projektarchiv</h1>
    <!-- <div class="buttons"><a onclick="$('#form').attr('action', '<?php echo $invoice; ?>'); $('#form').attr('target', '_blank'); $('#form').submit();" class="button"><span><?php echo $button_invoices; ?></span></a><a onclick="$('#form').attr('action', '<?php echo $delete; ?>'); $('#form').attr('target', '_self'); $('#form').submit();" class="button"><span><?php echo $button_delete; ?></span></a></div>
    -->
		 <div style="margin-left:15px; line-height:22px;">

      <?if ($type == 5){ echo "<b>Abgeschlossene Projekte:</b>"; }else {?>                
   <a href="/index.php?route=sale/order/projektarchiv&type=5">Abgeschlossene Projekte:</a>
   <?}?><span style="color:green;margin-left:4px;"><? echo $offen; ?></span><br>
     <?if ($type == 7){ echo "<b style='margin-right:18px;'>Abgelehnte Projekte:</b>"; }else {?>   
   <a href="/index.php?route=sale/order/projektarchiv&type=7" style='margin-right:48px;'>Abgelehnte Projekte:</a>
<?}?><span style="color:#404042;"><? echo $angebot; ?></span><br>	
                 
                 </div>
	<br>
	<h2>
    
    <?if (is_null($quater)){ echo "<b>Alle</b>"; } else {?><a href="/index.php?route=sale/order/projektarchiv&type=<?echo $type;?>&year=<?echo $year;?>">Alle</a> <?}?>
     
    &nbsp;&nbsp;&nbsp;&nbsp;<?if ($quater == 1){ echo "<b>Q1</b>"; }else {?><a href="/index.php?route=sale/order/projektarchiv&type=<?echo $type;?>&year=<?echo $year;?>&quater=1">Q1</a> <?}?>
    &nbsp;&nbsp;&nbsp;&nbsp;<?if ($quater == 2){ echo "<b>Q2</b>"; }else {?><a href="/index.php?route=sale/order/projektarchiv&type=<?echo $type;?>&year=<?echo $year;?>&quater=2">Q2</a> <?}?>
    &nbsp;&nbsp;&nbsp;&nbsp;<?if ($quater == 3){ echo "<b>Q3</b>"; }else {?><a href="/index.php?route=sale/order/projektarchiv&type=<?echo $type;?>&year=<?echo $year;?>&quater=3">Q3</a> <?}?>
    &nbsp;&nbsp;&nbsp;&nbsp;<?if ($quater == 4){ echo "<b>Q4</b>"; }else {?><a href="/index.php?route=sale/order/projektarchiv&type=<?echo $type;?>&year=<?echo $year;?>&quater=4">Q4</a> <?}?>

            </h2>
 
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
 				
 				</h2><table border=0 width=100%  style="float:left;margin-top:-7px;"><tr>

                                    <td valign=top ><div style="line-height:22px;margin-left:30px;">
                                            <br>
                                            <b>    <?php if ( $product['titelseite'] == '1') echo 'Titelseite'; ?> <?php if ( $product['innenseite'] == '1') echo 'Innenseite'; ?> </b>
                                            <br><br>

                                            <table border=0  cellpadding=0 cellspacing=0 width="100%"><tr><td valign=top style="width: 16%;padding: 0px;" >
                                                        <b> Titel: </b></td><td  style="padding: 0px;text-align:left;"><?php echo $product['titel']; ?></td></tr>

                                                <tr><td  style="padding: 0px;"><b>Art:</b></td><td  style="padding: 0px;"><?php echo $product['art']; ?></td></tr>
                                                <?php if ( $product['art_id'] != 11){ ?>
                                                <tr><td  style="padding: 0px;"><b>Auflage:</b></td><td  style="padding: 0px;"><?php echo $product['auflage']; ?></td></tr>
                                                <tr><td  style="padding: 0px;"><b>Größe:</b></td><td  style="padding: 0px;"><?php echo $product['grosse']; ?></td></tr>
                                                <?php } ?>
                                            </table>
                                            <?php if ($product['komentar'] != '') { ?>
                                            <br><br>
                                            <b>Kommentar:</b> <br> <?php echo $product['komentar']; ?>  

                                            <?php }?>

                                        </div>                                                              
                                    </td>
                                    <td valign=top align=right   style="width:30%;padding-right:15px;background-color:white;">
                                        <br>    <img style="margin-right: 62px;" src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" />  
                                        <br><br><br><br><br>

                                        <input type="hidden"  id="realprice1<?php echo $product['product_id'].$order['order_id']; ?>" value="<?php echo  sprintf('%.2f',$product['price']);  ?>">
                                        <input type="hidden"  id="realprice<?php echo $product['product_id']; ?>" value='<? echo $product['total'];?>' />

                                               <table border=0 cellpadding=0 cellspacing=0  class='price'>

                                            <tr><td align=right>
                                                    Reproduktionskosten:&nbsp;&nbsp;<span style="color:red;" id="summe1<?php echo $product['product_id'].$order['order_id']; ?>"><?php echo  sprintf('%.2f',$product['price']);  ?>  &euro;</span> 

                                                    <br>(+/- %):&nbsp;&nbsp;      
                                                </td></tr>

                                            <tr><td align=right>
                                                    Datenversand:&nbsp;&nbsp;  <span style="color:red" id="summe2<?php echo $product['product_id'].$order['order_id']; ?>"><?php echo  sprintf('%.2f',round($product['tax'],2));  ?>  &euro;</span> 

                                                    <br>(+/- %):&nbsp;&nbsp;       

                                            </td></tr><tr><td align=right>SUMME: <span class="totalproduct<?php echo $order['order_id'];?>" style="color:red" id="summe<?php echo $product['product_id'].$order['order_id']; ?>"><?php echo  sprintf('%.2f',$product['total']);  ?>  &euro;</span><div class="separator">&nbsp;</div></td></tr>
                                        </table>
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
                
             
                
               
                <div style="width:95.7%;text-align:right; background-color:#bebebe;float:left; padding:7px 30px 7px 7px;" >
                   <?if ($type == 5){?>
                
                     <a TARGET="_blank" style="color:red !important;float:left;" href="/index.php?route=sale/order/printorder&order_id=<?php echo $order["order_id"];?>" >
                           Rechnung erstellen
                      </a>
                <?}?>
                
                <b>GESAMSUMME:</b> <span style="color:red"><?php echo sprintf('%.2f',round($order['total'],2));  ?> &euro;</span>
                </div>
                 <?if ($type == 7){?>
		  <div style="width: 98.3%; 
    float: right;
    margin-bottom: -8px;
    padding: 7px;
    background-color: #DDDDDC;" >

                                <input  style="float:right;" type="button" alt='Möchten Sie die Anfrage<br>aus dem System löschen?' value="Löschen" class="confirmdialogopener sbmt_button" rel='/index.php?route=sale/order/delete&order_id=<?php echo $order["order_id"];?>' >

                            </div>
<?}?>	 
             
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