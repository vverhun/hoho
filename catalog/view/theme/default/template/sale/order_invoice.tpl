<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $language; ?>" xml:lang="<?php echo $language; ?>">
<head>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
	<style>
	
	hr{
	  width:100%;
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
		 
		 td.totalsec{
		    text-align:left;
		     width:90px; 
 		 }
		 
		  td.totalmiddle{
		  
		   text-align:left;
		   width:90px; 
  		 }
		  td.totalempty{
		  
width:280px; 		 }
		 		 
		 .div1{
		    margin-top:130px;
		 }
	</style>
</head>
<body>
<?php foreach ($orders as $order) { ?>
<div style="page-break-after: always;">
 
  <table class="intro" width="100%" align=right style="float:right;">
 <tr><td align=right><b>Gerhard Richter</b></td></tr>
 <tr><td class="intro" align=right><div>Osterriethweg 22 D-50996 K&ouml;ln  tel: 0 22 36. 96 56 10   fax: 0 22 36.96 56 12 mail: gerhard.richter@netcologne.de</div>
 </td></tr></table>
 <br><br><br><br>
   <div class="div1">
       <?php echo $order['firstname']; ?>  <?php echo $order['lastname']; ?> <br>
        <?php echo $order['bill_address_1']; ?> <br>
  		<?php echo $order['bill_city']; ?>, <?php echo $order['bill_land']; ?> <?php echo $order['bill_postcode']; ?>   <br>  	                            
		 <?php echo $order['country']; ?>    <br>                        
			       
  </div>
  
  <br><br>
  <TABLE WIDTH=100% >
  <tr><td width=10% align=left><b>INVOICE No.</b></td><td width=80%></td><td width=10% class="first"> <b>DATE OF INVOICE</b></td></tr>
  <tr><td width=10% align=left>96/2011</td><td width=80%></td><td align=left width=10% class="sec"> 20.06.2011</td></tr></TABLE>
  
  <hr>
  
  <br><br>
 
 For granting you permission to show the following work(s) of Gerhard Richter
 
  
 <ul>
 <?php foreach ($order['product'] as $product) { ?>
    <li><?php echo $product['sku']; ?></li>
  <?php } ?>
 </ul>
 
 <br><br>
 we invoice:
<br><br><br><br><br><br><br>
<TABLE WIDTH=100% >
   <tr><td align=left class="totalfirst" width=20%><b>Payment term:</b></td><td class="totalempty" width=50%> </td><td class="totalmiddle" width=15%>net.</td><td class="totalsec" width=15%><hr>&nbsp;&nbsp;&nbsp;  100,00 €</td></tr>
   <tr><td align=left class="totalfirst" width=20%><b> </b></td><td class="totalempty"  width=50%>&nbsp;</td><td class="totalmiddle" width=15%>0 %TAX</td><td class="totalsec" width=15%>&nbsp;&nbsp;&nbsp;  100,00 €<hr></td></tr>
   <tr><td align=left class="totalfirst" width=20%><b> </b></td><td class="totalempty"  width=50%></td><td class="totalmiddle" width=15%><b>grand total</b></td><td class="totalsec" width=15%>&nbsp;&nbsp;&nbsp;   100,00 €<hr></td></tr>
   <tr><td align=left class="totalfirst" width=20%><b>Time of performance<br>20.06.2011</b></td><td class="totalempty"  width=50%></td><td class="totalmiddle" width=15%> </td><td class="totalsec" width=15%><img src="/image/paypal.jpg" /></td></tr>
    
</TABLE>  
 
<hr>
<br><br>

deutsche Bank AG K&ouml;ln 
 Account Number 230 20 32 00   
Routing Code 370 700 60
IBAN: DE81 3707 0060 0230 2032 00 
BIC (Swift-Code): DEUTDEDK
VAT-No.: DE 122 724 266 (USt.-id-Nr.)
Without VAT according to Art. 24, 25, 43, 44 of the Council Directive 2006/112/EC
Persons to whom  the services are supplied are liable to tax (Reverse Charge) according to Art. 
196 of the Council Directive 2006/112/EC
Tax #219/5226/0804

    
</div>
<?php } ?>
</body>
</html>