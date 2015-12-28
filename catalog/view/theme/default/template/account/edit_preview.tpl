<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
 
            <h1>  <?php echo $my_datem; ?> </h1> 
   
    
  <h2><?php echo $my_datem;?> <a style="float:right; color: #636362; margin-right: 16px;" href="/index.php?route=account/edit"><? echo $bearbeiten;?></a></h2>
<?php if ($error_warning) { ?>
    				<p style="font-size: 14px;font-weight: bold;color: red;"><?php echo $error_warning; ?></p>
    		  <?php } ?>
    		  
   <b style="margin-bottom: 2px; display: block;"></b>
         <table id="table_personal_data" style="float:left;width:50%;padding: 10px; margin-left: -4px;" cellpadding=7 cellspacing=7>
          <tr>
            <td width="150"><?php echo $my_Einrichtung;?></td>
            <td><span><?php echo $firstname; ?></span></td>
          </tr>
          <tr>
            <td>TaxID Number:</td>
            <td><span><?php echo $taxid_number; ?></span> </td>
          </tr>          <tr>
            <td> </td>
            <td> </td>
          </tr>
          <tr>
            <td><?php echo $my_contact;?></td>
            <td><span><?php echo $ansprechpartner; ?></span></td>
          </tr>
          <tr>
            <td>Position:</td>
            <td><span><?php echo $position; ?></span></td>
          </tr>
          <tr>
            <td><?php echo $my_userName;?></td>
            <td><span><?php echo $username1; ?></span></td>
          </tr>
		       <tr>
            <td> </td>
            <td> </td>
          </tr>
		  <tr>
            <td><?php echo $my_street;?></td>
            <td><span><?php echo $address_1; ?></span></td>
          </tr>
		  <tr>
            <td><?php echo $my_postcode;?></td>
            <td><span><?php echo $postcode; ?></span></td>
          </tr>		
		  <tr>
            <td><?php echo $my_sity;?></td>
            <td><span><?php echo $city; ?></span></td>
          </tr>		
		  <tr>
            <td><?php echo $my_country;?></td>
            <td><span><?php echo $country_id; ?></span></td>
          </tr>			    
        </table>
 
        <table id="table_personal_data2" style="float:left;width:50%;padding: 10px;"  cellpadding=10 cellspacing=10>
          <tr>
            <td width="150"><?php echo $my_phone;?></td>
            <td><span><?php echo $telephone; ?></span></td>
          </tr>
           <tr>
            <td width="150">Mobil:</td>
            <td><span><?php echo $mobile; ?></span></td>
          </tr>
           <tr>
            <td width="150">Fax:</td>
            <td><span><?php echo $fax; ?></span></td>
          </tr>		
		       <tr>
            <td> </td>
            <td> </td>
          </tr>
		  
		  <tr>
            <td width="150">E-Mail*:</td>
            <td><span><?php echo $email; ?></span></td>
          </tr>	         	    
        </table>
		
		<h2><? echo $heading_title3; ?> <a style="float:right; color: #636362; margin-right: 16px;" href="/index.php?route=account/edit"><? echo $bearbeiten;?></a></h2>
		
		<table style="float:left;width:100%;padding: 13px;">
		<tr><td>
		    
			<div id="billForm" style="<?php if($bill_address == 'on' ){ echo 'display:none;';} else {echo 'display:block;';} ?>">
 
                                           
          <table id="table_personal_data" style="float:left;width:50%;padding: 10px; margin-left: -17px;" cellpadding=7 cellspacing=7>
          <tr>
            <td width="150"><? echo $street; ?></td>
            <td><span><?php echo $bill_address_1; ?></span></td>
          </tr>
          <tr>
            <td width="150"><? echo $entry_postcode; ?></td>
            <td><span><?php echo $bill_postcode; ?></span></td>
          </tr>		  

          <tr>
            <td width="150"><? echo $entry_city; ?></td>
            <td><span><?php echo $bill_city; ?></span></td>
          </tr>		

          <tr>
            <td width="150"><? echo $entry_country; ?></td>
            <td><span><?php echo $bill_land; ?></span></td>
          </tr>	
		  
          </table>
										   
            </div>
			<?php if($bill_address == 'on' ){ echo $heading_title4; }?>
			
			
			
		</td>
		</tr>	 
		</table>	
   
  <h2 style="margin-top:7px;"><?php echo $my_access;?> <a style="float:right; color: #636362; margin-right: 16px;" href="/index.php?route=account/edit"><? echo $bearbeiten;?></a></h2>  

  <table style="float:left;width:100%;padding: 13px;">
          <tr>
            <td style="width:52%"><?php echo $my_userName;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $username; ?></td>
            <td><?php echo $my_Passwor;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;**********</td>
          </tr>                 	    
  </table>
		
 
		
         
    		  
    		  
    		  
    		  
    		  
    		  
    		  
    		  
    		  
    		  
    		  
 <script type="text/javascript">
      $(document).ready(function(){
          var s = '0';
          $('#bill a.jNiceCheckbox').click(function(e){
              //alert("click");
              if(s == '0'){
                  <?php if($bill_address == 'on' ){ echo 'checboxBill_open();';}else{echo 'checboxBill_close();';} ?>
                  //checboxBill_open();
                  s++
              }else{
                  <?php if($bill_address == 'on' ){ echo 'checboxBill_close();';}else{echo 'checboxBill_open();';} ?>
                  //checboxBill_close();
                  s--;
              }
          });
      });
      function checboxBill_open(){
          //alert('clickOpen');
          $('#bill_accessId').val('on');
          $('div#billForm1').show();
      }
      function checboxBill_close(){
          $('#bill_accessId').val('off');
          $('div#billForm1').hide();
          //alert('clickClose');
      }
      </script>
 <?php echo $footer; ?>    		  