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
<script type="text/javascript">
$(document).ready(function() {

	$('.jNiceCheckbox').click(function() {
		var prodid = $(this).next().attr('value');
		var orderid = $(this).next().attr('orderid');
		prodid = String(prodid) + String(orderid);

		
		var realprice = $('#realprice1' + prodid).val();
		
		if($(this).hasClass("jNiceChecked")) {
			$('#summe1' + prodid).html('0.00 &euro;');
			$('#summe2' + prodid).html('0.00 &euro;');
		}
		else {
		
			$('#summe1' + prodid).html(realprice  + ' &euro;');
			$('#summe2' + prodid).html('50.00 &euro;');
		}
		
		calcTotalSumme(prodid, orderid);
	});
});	 

$(document).ready(function() {
	
	$('.showdetail').click(function() {
		 var id = $(this).attr('rel');
         $('#' + id).slideToggle('fast');
		 
		 $('.proddetailtoshow').css('display','none');
	    
		 $('.showdetail').each(function(index) {
   		     if (id != $(this).attr('rel')){  $(this).html('bearbeiten'); }
		 });
		 
         if ($(this).html() == 'bearbeiten') { 
         	$(this).html('schliessen');
         }
         else { 
         	$(this).html('bearbeiten'); 
         }
		 return false;
    });
	
	
	
	$(".firstinput").change(function() {
	    var summ = $(this).val();
		var orderid = $(this).attr('orderid');
		var prodid = $(this).attr('rel');
		prodid = String(prodid) + String(orderid);
		
		//console.log($('#genehmigung_'+prodid+':checked').val() );
		//if($('#genehmigung_'+prodid+':checked').val() == 'undefined' ) { 
		if(!$('#genehmigung_'+prodid).is(':checked') ) { 
		if ( summ != '' ){
			 
			var realprice = parseFloat($('#realprice1' + prodid).val());
	        summ = parseFloat(summ);
		
	 		changedsum = 0;
			 
	 		changedsum  = realprice + parseFloat((realprice*summ)/100);
		 
	 
			$('#summe1' + prodid).html(sprintf('%01.2f',changedsum)  + ' &euro;');
			
		}else{
		    //var prodid = $(this).attr('rel'); 
			var realprice = $('#realprice1' + prodid).val();
			$('#summe1' + prodid).html(realprice  + ' &euro;');		
		}
	    calcTotalSumme(prodid, orderid);
	    }
	});
	

	$(".secondinput").change(function() {
	    var summ = $(this).val();
		var orderid = $(this).attr('orderid');
		var prodid = $(this).attr('rel');
		prodid = String(prodid) + String(orderid);
		
		if(!$('#genehmigung_'+prodid).is(':checked') ) { 
		
		if ( summ != '' ){			 
			var realprice = parseFloat(50);
	        summ = parseFloat(summ);
		
	 		changedsum = 0;			 
	 		changedsum  = realprice + parseFloat((realprice*summ)/100);		 
	 
			$('#summe2' + prodid).html(sprintf('%01.2f',changedsum)  + ' &euro;');
			calcTotalSumme();
		}else{
			$('#summe2' + prodid).html('50.00 &euro;');
		}
		calcTotalSumme(prodid, orderid);
		
		}
	});
	
});

function sprintf( ) {	// Return a formatted string
	// 
	// +   original by: Ash Searle (http://hexmen.com/blog/)
	// + namespaced by: Michael White (http://crestidg.com)

	var regex = /%%|%(\d+\$)?([-+#0 ]*)(\*\d+\$|\*|\d+)?(\.(\*\d+\$|\*|\d+))?([scboxXuidfegEG])/g;
	var a = arguments, i = 0, format = a[i++];

	// pad()
	var pad = function(str, len, chr, leftJustify) {
		var padding = (str.length >= len) ? '' : Array(1 + len - str.length >>> 0).join(chr);
		return leftJustify ? str + padding : padding + str;
	};

	// justify()
	var justify = function(value, prefix, leftJustify, minWidth, zeroPad) {
		var diff = minWidth - value.length;
		if (diff > 0) {
			if (leftJustify || !zeroPad) {
			value = pad(value, minWidth, ' ', leftJustify);
			} else {
			value = value.slice(0, prefix.length) + pad('', diff, '0', true) + value.slice(prefix.length);
			}
		}
		return value;
	};

	// formatBaseX()
	var formatBaseX = function(value, base, prefix, leftJustify, minWidth, precision, zeroPad) {
		// Note: casts negative numbers to positive ones
		var number = value >>> 0;
		prefix = prefix && number && {'2': '0b', '8': '0', '16': '0x'}[base] || '';
		value = prefix + pad(number.toString(base), precision || 0, '0', false);
		return justify(value, prefix, leftJustify, minWidth, zeroPad);
	};

	// formatString()
	var formatString = function(value, leftJustify, minWidth, precision, zeroPad) {
		if (precision != null) {
			value = value.slice(0, precision);
		}
		return justify(value, '', leftJustify, minWidth, zeroPad);
	};

	// finalFormat()
	var doFormat = function(substring, valueIndex, flags, minWidth, _, precision, type) {
		if (substring == '%%') return '%';

		// parse flags
		var leftJustify = false, positivePrefix = '', zeroPad = false, prefixBaseX = false;
		for (var j = 0; flags && j < flags.length; j++) switch (flags.charAt(j)) {
			case ' ': positivePrefix = ' '; break;
			case '+': positivePrefix = '+'; break;
			case '-': leftJustify = true; break;
			case '0': zeroPad = true; break;
			case '#': prefixBaseX = true; break;
		}

		// parameters may be null, undefined, empty-string or real valued
		// we want to ignore null, undefined and empty-string values
		if (!minWidth) {
			minWidth = 0;
		} else if (minWidth == '*') {
			minWidth = +a[i++];
		} else if (minWidth.charAt(0) == '*') {
			minWidth = +a[minWidth.slice(1, -1)];
		} else {
			minWidth = +minWidth;
		}

		// Note: undocumented perl feature:
		if (minWidth < 0) {
			minWidth = -minWidth;
			leftJustify = true;
		}

		if (!isFinite(minWidth)) {
			throw new Error('sprintf: (minimum-)width must be finite');
		}

		if (!precision) {
			precision = 'fFeE'.indexOf(type) > -1 ? 6 : (type == 'd') ? 0 : void(0);
		} else if (precision == '*') {
			precision = +a[i++];
		} else if (precision.charAt(0) == '*') {
			precision = +a[precision.slice(1, -1)];
		} else {
			precision = +precision;
		}

		// grab value using valueIndex if required?
		var value = valueIndex ? a[valueIndex.slice(0, -1)] : a[i++];

		switch (type) {
			case 's': return formatString(String(value), leftJustify, minWidth, precision, zeroPad);
			case 'c': return formatString(String.fromCharCode(+value), leftJustify, minWidth, precision, zeroPad);
			case 'b': return formatBaseX(value, 2, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
			case 'o': return formatBaseX(value, 8, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
			case 'x': return formatBaseX(value, 16, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
			case 'X': return formatBaseX(value, 16, prefixBaseX, leftJustify, minWidth, precision, zeroPad).toUpperCase();
			case 'u': return formatBaseX(value, 10, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
			case 'i':
			case 'd': {
						var number = parseInt(+value);
						var prefix = number < 0 ? '-' : positivePrefix;
						value = prefix + pad(String(Math.abs(number)), precision, '0', false);
						return justify(value, prefix, leftJustify, minWidth, zeroPad);
					}
			case 'e':
			case 'E':
			case 'f':
			case 'F':
			case 'g':
			case 'G':
						{
						var number = +value;
						var prefix = number < 0 ? '-' : positivePrefix;
						var method = ['toExponential', 'toFixed', 'toPrecision']['efg'.indexOf(type.toLowerCase())];
						var textTransform = ['toString', 'toUpperCase']['eEfFgG'.indexOf(type) % 2];
						value = prefix + Math.abs(number)[method](precision);
						return justify(value, prefix, leftJustify, minWidth, zeroPad)[textTransform]();
					}
			default: return substring;
		}
	};

	return format.replace(regex, doFormat);
}



function calcTotalSumme(prodid, orderid){
      var summe1 = $('#summe1' + prodid).html();
	  var summe2 = $('#summe2' + prodid).html();
	  
	  $('#summe' + prodid).html( sprintf('%01.2f', parseFloat(summe1) + parseFloat(summe2)) + ' &euro;');
	  
	  var totalsum = 0;
	  
	  $('.totalproduct' + orderid).each(function(index) {
         var summe = parseFloat($(this).html());
		 totalsum = totalsum + summe; 
      });

	  var tax =  parseInt($('#taxorig' + orderid).html());
 
	  
      if ( tax != 0 ){
          tax = parseFloat(totalsum*0.07);
      }else{
          tax = 0;
          
      }
	  
	  $('#subtotal' + orderid).html(sprintf('%01.2f',totalsum) + ' &euro;');
	  $('#tax' + orderid).html(sprintf('%01.2f',tax) + ' &euro;');
	  $('#gemamtsumme' + orderid).html(sprintf('%01.2f',tax + totalsum) + ' &euro;');

	  
	  
}




 </script>  
 
<div class="box">
 
     <h1 style="background-image: url('view/image/order.png');">Anfragenverwaltung</h1>
    <!-- <div class="buttons"><a onclick="$('#form').attr('action', '<?php echo $invoice; ?>'); $('#form').attr('target', '_blank'); $('#form').submit();" class="button"><span><?php echo $button_invoices; ?></span></a><a onclick="$('#form').attr('action', '<?php echo $delete; ?>'); $('#form').attr('target', '_self'); $('#form').submit();" class="button"><span><?php echo $button_delete; ?></span></a></div>
    -->
	 <div style="margin-left:15px; line-height:22px;">
    <b>Offen Anfragen:</b> <span style="color:red; padding-left:41px;"><? echo $offen; ?></span><br>
    <a href="/index.php?route=sale/order/bearbeitete">Bearbeitete Anfragen:</a><span style="color:blue; padding-left:21px;"><? echo $angebot; ?></span><br>
	</div>
	<br>
	<h2>Offene Anfragen</h2>
 
      <table class="list" style="float:left;width:96%;"  cellpadding=0 cellspacing=0 border=0>
        <thead>
          <tr>
             <td align=center style="background-color: #DDDDDC;" width=60px>
 
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
               <a href="<?php echo $date_order; ?>" class="<?php echo strtolower($order); ?>"><b>Eingang</b>  </a>
             <?php } else { ?>
               <a href="<?php echo $date_order; ?>"><b>Eingang</b>   </a>
             <?php } ?>
			</td>
		    <td class="left" style="background-color: #DDDDDC;">
			 <?php if ($sort == 'o.date_modified') { ?>
               <a href="<?php echo $edit_order; ?>" class="<?php echo strtolower($order); ?>"><b>bearbeitet</b> </a>
             <?php } else { ?>
               <a href="<?php echo $edit_order; ?>"><b>bearbeitet</b>  </a>
             <?php } ?>
			  </td>

            <td class="right" style="background-color: #DDDDDC;">
			 <?php if ($sort == 'o.status_id') { ?>
               <a href="<?php echo $status_order; ?>" class="<?php echo strtolower($order); ?>"><b>Status</b> </a>
             <?php } else { ?>
               <a href="<?php echo $status_order; ?>"><b>Status</b>  </a>
             <?php } ?>
			  </td>
			 </td>
	        <td class="right" style="background-color: #DDDDDC;">  </td>
          </tr>
        </thead>
        <tbody>
     
          <?php if ($orders) { $index = 0; ?>
          
          <?php foreach ($orders as $order) { $index++; ?>
  
		  <tr>
            <td style="text-align: center;"> 
            	<?php echo sprintf('%04d' , $index); ?>
            </td>
            <td class="right" width=170pxd><div style='width:150px; overflow:hidden;'><?php echo $order['name']; ?></div></td>
            <td class="left"><div style='width:130px; overflow:hidden;'><?php echo $order['ansprechpartner']; ?></div></td>
            <td class="left"><?php echo $order['totalproducts']; ?></td>
            <td class="left"><?php echo $order['date_added']; ?></td>
			 <td>  <? if ( $order['status_id'] == '3'){ echo $order['date_modified']; }else { echo '...'; } ?></td>
			 
            <td class="right"><?php echo $order['status']; ?></td>
			
            <td class="right"> <a href='#' class='showdetail' rel='proddetail<?php echo $order['order_id'];?>'>bearbeiten</a> </td>
          </tr>
		   <tr><td colspan=8  style="padding:0px !important;">
		    <form action="/index.php" method='get' id="formmanuelle<?php echo $order['order_id']; ?>" class="jNice" >
			  <input type=hidden name="route" value="account/notify/manuelle" />
			  <input type=hidden name="order_id" value="<?php echo $order['order_id'];?>" />
			</form>
		   
		    <form action="/index.php" method='get' id="form<?php echo $order['order_id']; ?>" class="jNice" >
			<input type=hidden name="route" value="sale/order/angebot" />
			<input type=hidden name="order_id" value="<?php echo $order['order_id'];?>" />
			
		    <div  style='display:none;' class="proddetailtoshow" id='proddetail<?php echo $order['order_id'];?>'> 
             
              <?php foreach ($order['products_orders'] as $product) { ?>
                <h2 style='background-color:white !important;'>CR: <?php echo $product['sku'];?>, <?php echo $product['name'];?>
				   <? if ( $order['status_id'] == '1'){?>	
					<span style="float:right; padding-right:24px">Genehmigung nicht erteilt&nbsp;
						<input type="checkbox" name='del[]' id="genehmigung_<?php echo $product['product_id']; ?>" orderid='<?php echo $order['order_id'];?>' value='<?php echo $product['product_id']; ?>' />
					</span>
				   <?} else if ($product['status_id'] == 0) { ?>
				  		 <span style="float:right; padding-right:24px">Genehmigung nicht erteilt&nbsp;</span>
				   <?php } ?>
				</h2>
                <table border=0 width=100%  style="float:left;margin-top:-7px;"><tr>
  
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
 
				        <br>(+/- %):&nbsp;&nbsp; <input orderid='<?php echo $order['order_id'];?>' type="text" rel="<?php echo $product['product_id']; ?>" size=5 class="firstinput" name="first<?php echo $product['product_id']; ?>" value='' />
                                </td></tr>
					 
				<tr><td align=right>
                                        Datenversand:&nbsp;&nbsp;  <span style="color:red" id="summe2<?php echo $product['product_id'].$order['order_id']; ?>"><?php echo  sprintf('%.2f',round($product['tax'],2));  ?>  &euro;</span> 
					 
				        <br>(+/- %):&nbsp;&nbsp;<input orderid='<?php echo $order['order_id'];?>' type="text" rel="<?php echo $product['product_id']; ?>" size=5 class="secondinput" name="second<?php echo $product['product_id']; ?>" value='' /></td></tr>
					
				<tr><td align=right>SUMME: <span class="totalproduct<?php echo $order['order_id'];?>" style="color:red" id="summe<?php echo $product['product_id'].$order['order_id']; ?>"><?php echo  sprintf('%.2f',$product['total']);  ?>  &euro;</span><div class="separator">&nbsp;</div></td></tr>
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
               
               
                <div style="width:816px; text-align:right; background-color:#bebebe;float:left; padding:7px 30px 7px 0px;" ><b>GESAMTSUMME:</b> <span style="color:red" id="gemamtsumme<?php echo $order['order_id'];?>"><?php echo  sprintf('%.2f',round($order['total'],2));  ?>  &euro;</span></div>
                
			    <div style="margin-left: -6px; width:38%;text-align:left; float:left;   margin-bottom: -8px; padding:7px; background-color: #DDDDDC;" >
			      
			      <input type="button" alt="Möchten Sie die <br> Anfrage ablehnen?" value="Ablehnen" class="confirmdialogopener sbmt_button" rel='/index.php?route=sale/order/cancel&order_id=<?php echo $order["order_id"];?>' >
			     
			   </div>
                        
                           <div style="margin-left: -6px; width:24%;text-align:left; float:left;   margin-bottom: -8px; padding:7px; background-color: #DDDDDC;" >
			      
                               <input type="button" alt='Möchten Sie die Anfrage<br>aus dem System löschen?' value="Löschen" class="confirmdialogopener sbmt_button" rel='/index.php?route=sale/order/delete&order_id=<?php echo $order["order_id"];?>&back=anfragen' >
			     
			   </div>
                        
                        
			    <div style="margin-left: -5px; width:35%;text-align:right; float:left;   margin-bottom: -11px; padding:7px; background-color: #DDDDDC;" >
			      
			      <?if ( $order['status_id'] == '1'){?>
			      	<input type="button" style="float:right;" alt="Möchten Sie das <br> Angebot senden?" value="Angebot senden" class="confirmdialogopener_angebot sbmt_button" rel='#form<?php echo $order["order_id"];?>' >
			      	
			      <?}else{?>			      
			      	<input type="button" style="float:right;" value="manuelle Freigabe" class="confirmdialogopener sbmt_button" onclick="$('#formmanuelle<?php echo $order["order_id"];?>').submit();" >
			      <?}?>			      
			      
			   </div>
                
                
                           
             
             
             </div>
		   	   </form>
			   <div style="width:846px;text-align:right; float:left; height:5px; background-color:#DDDDDC;">&nbsp;</div>
		   </td></tr>
	
		   
		   
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="7"><div style="padding-left:21px">Keine Ergebnisse gefunden</div></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
  
 
 
   </div>
</div>
<script type="text/javascript">
<!--
$(function() {
	
	
});

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