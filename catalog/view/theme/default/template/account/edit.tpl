<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<script>
	
 
	$(document).ready(function(){
		
         $('#personchecks a.jNiceRadio').click(function(e){
             
			 var id = $(this).next().attr('value');
			 if ( id == 'firma' ) $('#taxidnumber').css('display','block');
			 else $('#taxidnumber').css('display','none');
         });
		 <?php if($firma == 'on' ){ ?>
		    $('#taxidnumber').css('display','block');
		 
		 <?}else{?>
		    $('#taxidnumber').css('display','none');
		 <?}?> 
		
		if ( $( '.type_person1' ).attr('checked') ){ $('#taxidnumber').css('display','block'); }
		if ( $( '.type_person2' ).attr('checked') ){ $('#taxidnumber').css('display','none');  }
		if ( $( '.type_person3' ).attr('checked') ){ $('#taxidnumber').css('display','none');  }
	
		  
		$('#reg_info').CreateBubblePopup({
				innerHtml: "<div class='popup4ik'><p><?php echo $spesial_text2; ?></p></div>",

				innerHtmlStyle: {
									'text-align':'left'
								},
				
				themeName: 	'grey',
				position: 'left',
				align: 'center',
 				themeMaggin: {total: '55px', difference: '30px'},
				selectable: true,
				closingSpeed: 10,
				openingSpeed: 10,
				themePath: 	'catalog/view/theme/default/images/jquerybubblepopup-theme'								 
		   });
		   
		   
			$('#reg_info').ShowBubblePopup();
 			$('#reg_info').HideBubblePopup();
 
		})
	</script>	
		 

 
			<h1><?php echo $my_datem;?></h1>
			  <?php if ($error_warning) { ?>
    				<div class="warning"><?php echo $error_warning; ?></div>
    		  <?php } ?>
    
              <form class="jNice"  id="create" enctype="multipart/form-data" method="post" action="/index.php?route=account/edit">
					<div class="reg_block">
					<h3><? echo $heading_title2;?></h3>
					<p class="checks" id="personchecks">
				 
					<input name="type_person"  class = "type_person1" value="firma"        type  = "radio"    <?php if($firma == 'on' ) echo 'checked'; ?>       /> <? echo  $typ1;?> 
					<input name="type_person"  class = "type_person2" type="radio"         value = "museum"  <?php if($museum == 'on' ) echo 'checked'; ?>      /> <? echo  $typ2;?> 
					<input name="type_person"  class = "type_person3" value="privatperson" type  = "radio"    <?php if($privatperson == 'on' ) echo 'checked'; ?> /> <? echo  $typ3;?>
					
					
					<span class="pflichtfelder"><? echo $mandatory;?></span></p>
					<div class="inps">
						<p><label for="ein"><? echo $entry_name; ?></label>	<input id="ein" type="text" name="firstname" value="<?php echo $firstname; ?>"/></p>
						<p class="separatorp">						<input id="inp2" type="text" name="lastname" value="<?php echo $lastname; ?>"/></p>
						<p><label for="inp3"><? echo $entry_person; ?></label><input id="inp3" type="text" name="ansprechpartner" value="<?php echo $ansprechpartner; ?>"/></p>
						<p class="separatorp"><label for="inp4"><? echo $entry_position; ?></label> <input id="inp4" type="text" name="position" value="<?php echo $position; ?>"/></p>
						<p><label for="inp5"><? echo $street; ?></label>		<input id="inp5" type="text" name="address_1" value="<?php echo $address_1; ?>"/></p>
						<p><label for="inp6"><? echo $entry_postcode; ?></label>			<input id="inp6" type="text" name="postcode" value="<?php echo $postcode; ?>"/></p>
						<p><label for="inp7"><? echo $entry_city; ?></label>		<input id="inp7" type="text" name="city" value="<?php echo $city; ?>"/></p>
						<p style="margin-top:10px;"><label for="inp8"><? echo $entry_country; ?></label>	
						 
						<span style="   display: block; margin-left: 132px; width: 190px;">	
	 						<select name="land" id="land" style="width:134px;">
	        
			
				                <?php foreach ($countries as $country) { ?>
				                <?php if ($country['name'] == $country_id) { ?>
				                <option value="<?php echo $country['name']; ?>" selected="selected"><?php echo $country['name']; ?></option>
				                <?php } else { ?>
				                <option value="<?php echo $country['name']; ?>"><?php echo $country['name']; ?></option>
				                <?php } ?>
				                <?php } ?>
				              </select>
						  </span>
 
						</p>
						
						<p><label style="width:133px; margin-top:5px;"><? echo $communication; ?>:&nbsp;&nbsp;&nbsp;</label>	
						
						<span style="   display: block; margin-left: 132px; width: 190px;margin-top:8px;">	
	 						<select name="communic" id="communic" style="width:134px;">
  				                <option value="de-DE" <?php if ($communic == 'de-DE' ) echo "selected='selected'";?>>German</option>
 				                <option value="en" <?php if ($communic == 'en' ) echo "selected='selected'";?>>English</option>
 				              </select>
						  </span>
						  </p>
						  
						<p id="taxidnumber"><label for="inp9"><? echo $entry_tax; ?></label>	<input id="inp9" type="text" name="taxid_number" value="<?php echo $taxid_number; ?>"/></p>
					</div>
					<div class="inps inps2">
						<p><label for="inp10"><? echo $entry_telephone; ?></label>	<input id="inp10" type="text" name="telephone" value="<?php echo $telephone; ?>" /></p>
						<p><label for="inp11"><? echo $mobil; ?></label>	<input id="inp11" type="text" name="mobile" value="<?php echo $mobile; ?>" /></p>
						<p><label for="inp12"><? echo $entry_fax; ?></label>		<input id="inp12" type="text" name="fax" value="<?php echo $fax; ?>" /></p>
						<p><label for="inp13"><? echo $entry_email; ?></label>	<input id="inp13" type="text" name="email" value="<?php echo $email; ?>" /></p>
					</div>
					<div class="upload_block">
						<div> </div>
						<p style="width:225px;" > </p>
						 
					 <br><br><br><br><br><br><br>
	
						 <div class="fileinputs">
							 
						</div>					
					</div>
					<h3><? echo $heading_title3;?></h3> 
					<p class="checks" id="bill"><input onchange="checboxBill();" name="bill_address" type="checkbox" <?php if($bill_address == 'on' ) echo 'checked'; ?> /> <? echo $heading_title4;?>
                                        <div id="billForm" style="<?php if($bill_address == 'on' ){ echo 'display:none;';} else {echo 'display:block;';} ?>">
                                            <div class="inps">
                                                <input type="hidden" name="bill_access" value="<?php if($bill_address == 'on' ){ echo 'off';}else{echo 'on';} ?>" id="bill_accessId"/>
						<p><label for="inp5"><? echo $street; ?></label>		<input id="inp5" type="text" name="bill_address_1" value="<?php echo $bill_address_1; ?>"/></p>
						<p><label for="inp6"><? echo $entry_postcode; ?></label>			<input id="inp6" type="text" name="bill_postcode" value="<?php echo $bill_postcode; ?>"/></p>
						<p><label for="inp7"><? echo $entry_city; ?></label>		<input id="inp7" type="text" name="bill_city" value="<?php echo $bill_city; ?>"/></p>
						<p><label for="inp8"><? echo $entry_country; ?></label>			<input id="inp8" type="text" name="bill_land" value="<?php echo $bill_land; ?>"/></p>
                                             </div>
                                            
                                        </div>
                                        </p>
					<h3><? echo $passinfo;?></h3>
					<div class="inps">
						<p><label for="inp14"><? echo $entry_username; ?></label>	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $username; ?> </p>
						<input name='username' value='<?php echo $username; ?>' type='hidden' />
					</div>
					<div class="inps inps2">
						<p><label for="inp15"><? echo $entry_password; ?></label>				<input id="inp15" type="password" name="password" value=""/></p>
						<p><label class="lsl" for="inp16"><? echo $entry_confirm; ?></label>	<input id="inp16" type="password" name="confirm" value=""/></p>
					</div>
				</div>
 				<input type="submit" value="<? echo $senden; ?>" class="reg_button_2" />
			</form>
 		
		


  <script type="text/javascript">
      $(document).ready(function(){
          var s = '0';
          $('#bill a.jNiceCheckbox').click(function(e){
              if(s == '0'){
                  <?php if($bill_address == 'on' ){ echo 'checboxBill_open();';}else{echo 'checboxBill_close();';} ?>
                  s++
              }else{
                  <?php if($bill_address == 'on' ){ echo 'checboxBill_close();';}else{echo 'checboxBill_open();';} ?>
                  s--;
              }
          });
      });
      function checboxBill_open(){
          //alert('clickOpen');
          $('#bill_accessId').val('on');
          $('div#billForm').show();
      }
      function checboxBill_close(){
          $('#bill_accessId').val('off');
          $('div#billForm').hide();
          //alert('clickClose');
      }
      <!--
$('select[name=\'zone_id\']').load('index.php?route=account/create/zone&country_id=<?php echo $country_id; ?>&zone_id=<?php echo $zone_id; ?>');
$('#postcode').load('index.php?route=account/create/postcode&country_id=<?php echo $country_id; ?>');
//--></script>
<?php echo $footer; ?> 