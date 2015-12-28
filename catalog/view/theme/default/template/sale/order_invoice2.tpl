<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $language; ?>" xml:lang="<?php echo $language; ?>">
<head>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
	<style>
	table{
	   float:left;
	}
	hr{
	  width:100%;
	  float:left;
	}
		 table.intro {
		    text-align:right;
		 } 
		    .intro{
		    font-size:8pt;
		 } 
		 td.first{
		    text-align:right;
		 }
		 
		 td.totalfirst{
		    text-align:left;
		  
		 }
		 
		 td.sec{
		    text-align:right;
		 }
		 
		/* ------------ */
	 	 td.topline{
		    border-top:1px solid black;
		 }	 
		 		 
		 div.toplinesecond{
		    border-top:1px solid black;
		    height:5px;
 
 		 }	
		 td.totalsec{
 		     width:90px; 
 		 }
 		 
		 /* ---------- */
		 
		  td.totalmiddle{
		  
		   text-align:left;
		   width:140px; 
  		 }
		  td.totalempty{ 
			width:220px; 		 
		 }
		 		 
		 .div1{
		    margin-top:130px;
			
		 }
	 
		 td.footer{
		     text-align:center;
		 }
		 
 
		 
		 td.centerheight{
		    height:650px;
		 }
		 
	</style>
</head>
<body>
<table class="maintable" height=900px><tr><td class="centerheight" height=700px>


<?php foreach ($orders as $order) { ?>
  
  <table  width="100%" align=right style="float:right;">
 
  <tr><td align=left> 
      <img src="/image/pdflogo.jpg" />
  
 </td></tr></table>
 <br><br><br><br>
   <div class="div1">&nbsp;<?php if (strlen($order['firstname'] > 40)){ echo substr_replace($order['firstname'], "<br>&nbsp;", 40, 0);} else { echo $order['firstname'];}   ?><br>&nbsp;<?php echo $order['lastname']; ?> <br>
              <?php if ( $order['ansprechpartner'] != '' ) { echo $order['ansprechpartner']; ?> <br>  <br><?php } ?>
       
        <?php echo $order['bill_address_1']; ?> <br>
  		 <?php echo $order['bill_postcode']; ?> <?php echo $order['bill_city']; ?> <?php if ($order['bill_land'] != '') echo ', '. $order['bill_land']; ?>     <br>  	                            
 			       
  </div>
  
  <br><br>
  <TABLE WIDTH=100% >
  <tr><td width=10% align=left><b>RECHNUNG Nr.</b></td><td width=80%></td><td width=10% class="first"> <b>DATUM</b></td></tr>
  <tr><td width=10% align=left>C <?php echo $order['order_id']; ?>/<?php echo $order['year']; ?></td><td width=80%></td><td align=left width=10% class="sec"> <?php echo $order['date_added']; ?></td></tr></TABLE>
  
  <hr>
  
  
  <br><br><br>
 <div>
Wir erlauben uns, für die Reproduktion des Werkes (der Werke) von Gerhard Richter<br>
 </div> 
  
 <style>
 
 table.detailtable{
    
 }
 table.detailtable td{
      margin: 10px;
      border: 1px solid #A3A3A3;
 } 
 </style>
<table border=1 class="detailtable" cellpadding="4" cellspacing="0"><tr style="background-color:#EBEBEB; font-weight:bold;">
<td style="width:100px;padding: 10px;">#</td>
<td style="width:220px;padding: 10px;">Titel</td>
<td style="width:50px;padding: 10px;" align=center>Jahr</td>
<td style="width:263px;padding: 10px;">Titel der Publikation</td>

</tr>
 <?php foreach ($order['product'] as $product) { ?>
 <tr>
     <td ><?php echo $product['sku']; ?></td> 
     <td ><?php echo $product['name']; ?></td>
     <td  align=center><?php echo $product['jahr']; ?></td>
     <td ><?php echo $product['titel']; ?></td> 
 </tr>        
  <?php } ?>
 </table> 
 <br><br>
folgendes in Rechnung zu stellen:


 </td></tr>
<tr><td valign=bottom>


<TABLE WIDTH=100% >
   <tr><td align=left class="totalfirst" width=18%><b>Gesamtpreis:</b></td><td class="totalempty" width=50%> </td><td class="totalmiddle" width=15%>Steuerpfl.Betrag</td><td class="totalsec topline" width=17% align="right"><?php echo   sprintf('%.2f',$order['subtotal']); ?> €</td></tr>
   <tr><td align=left class="totalfirst" width=18%><b> </b></td><td class="totalempty"  width=50%>&nbsp;</td><td class="totalmiddle" width=15%>7 % MwSt.</td><td class="totalsec" width=17% align="right"><?php echo   sprintf('%.2f',round($order['tax'],2)); ?> €<hr></td></tr>
   <tr><td align=left class="totalfirst" width=18%><b> </b></td><td class="totalempty"  width=50%></td><td class="totalmiddle" width=15%><b>Rechnungsbetrag</b></td><td class="totalsec"  width=17% align="right"><b><?php echo sprintf('%.2f',$order['total']); ?> €</b>  <div><img src="/image/doubleline.gif" /></div> </td></tr>
   
   
   <tr><td align=left class="totalfirst" width=18%><b>Leistungszeitpunkt<br><?php echo $order['date_modified']; ?></b></td><td class="totalempty"  width=50%></td><td class="totalmiddle" width=17%> </td><td class="totalsec" width=15%><img src="/image/paypalde.jpg" /></td></tr>
    
</TABLE>  
 
<hr>
 
    
 <TABLE WIDTH=100% class="footertable" >
 <tr>
     <td class="footer" align=center> <br> <br><br><br><br>Kontonummer 230 20 32 / Deutsche Bank K&ouml;ln / BLZ 370 700 60</td> 
 </tr>
  <tr>
      <td class="footer" align=center>Umsatzsteuer-Ident-Nr. DE 122 724 266 // Steuer-Nr. 219/5226/0804</td>
 </tr>
 </TABLE>

    
</td></tr></table>  


<?php } ?>
</body>
</html>