<?php echo $header; ?>

<style>
    td {
        background-color: #EEEEEE;
        padding: 3px 0px 3px 0px;
    }


    table.tabledetail td, table.tabledetail{
        background-color: #EEE !important;	
        padding: 1px 0px 1px 0px;
    }


    label{
        width: 131px;
    }
</style>

<script>
    function trim(string)
    {
        return string.replace(/(^\s+)|(\s+$)/g, "");
    }




    $(document).ready(function () {




        $('.showdetail').click(function () {
            var id = $(this).attr('rel');
            $('#' + id).slideToggle('fast');
            $('.proddetailtoshow').css('display', 'none');


            $('.showdetail').each(function (index) {
                if (id != $(this).attr('rel')) {
                    $(this).html($(this).attr('name'));
                }
            });


            if (trim($(this).html()) == 'bearbeiten' || trim($(this).html()) == 'Ansicht') {
                $(this).html('schliessen');
            }
            else
                $(this).html($(this).attr('name'));


            return false;
        });




    });
</script>  

<div class="box">

    <h1>Kundenverwaltung</h1>
    <div class="content">
        <br>
        <div style="margin-left:15px; line-height:17px;">

            <a href="/index.php?route=sale/customer/offene">Offene Anmeldungen:</a><span style="color:red"> <? echo $customer_total; ?></span><br>
            <b>Kunden:</b> <span style="color:green; margin-left:74px;"> <? echo $customer_total2; ?> </span><br><br>

        </div>	


        <br> 
        <!-- approved objects -->
        <h2 style="float:left;   margin-top: -9px;">
            <? if (is_null($letter)){?>Alle<?}else{?><a href="/index.php?route=sale/customer/kunden">Alle</a><?}?> 
            <span style="padding-left:15px;"><? if ($letter == 1){?>A-E<?}else{?><a href="/index.php?route=sale/customer/kunden&letter=1">A-E</a><?}?> </span>
            <span style="padding-left:15px;"><? if ($letter == 2){?>F-J<?}else{?><a href="/index.php?route=sale/customer/kunden&letter=2">F-J</a><?}?> </span>
            <span style="padding-left:15px;"><? if ($letter == 3){?>K-O<?}else{?><a href="/index.php?route=sale/customer/kunden&letter=3">K-O</a><?}?> </span>
            <span style="padding-left:15px;"><? if ($letter == 4){?>P-T<?}else{?><a href="/index.php?route=sale/customer/kunden&letter=4">P-T</a><?}?> </span>
            <span style="padding-left:15px;"><? if ($letter == 5){?>U-Z<?}else{?><a href="/index.php?route=sale/customer/kunden&letter=5">U-Z</a><?}?> </span>
            <span style="padding-left:15px;"><? if (!is_null($privat)){?>Privatpersonen<?}else{?><a href="/index.php?route=sale/customer/kunden&privat=1">Privatpersonen</a><?}?> </span>



        </h2>	

        <table class="sortable" id="sortable_example"  style="" width="99%" cellpadding=0 cellspacing=0>
            <thead>
                <tr>
                    <th class="" valign=center style="background-color: #DDDDDC;height: 27px;"  align=center width="58px">

                        <?php if ($sort == 'c.customer_id') { ?>
                        <a href="<?php echo $sort_customer_id; ?>" class="<?php echo strtolower($order); ?>">  <b>Nr.</b>  </a>
                        <?php } else { ?>
                        <a href="<?php echo $sort_customer_id; ?>">   <b>Nr.</b>  </a>
                        <?php } ?>

                    </th>
                    <th class="left sort-alpha" style="background-color: #DDDDDC;height: 27px;overflow:hidden; white-space: nowrap;" width="150px">

                        <?php if ($sort == 'c.firstname') { ?>
                        <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><b>Kunde</b>  </a>
                        <?php } else { ?>
                        <a href="<?php echo $sort_name; ?>"> <b>Kunde</b>  </a>
                        <?php } ?>


                    </th>
                    <th class="left " style="background-color: #DDDDDC;height: 27px;overflow:hidden; white-space: nowrap;" width="150px">

                        <?php if ($sort == 'ansprechpartner') { ?>
                        <a href="<?php echo $sort_ansprechpartner; ?>" class="<?php echo strtolower($order); ?>"><b>Ansprechpartner</b>  </a>
                        <?php } else { ?>
                        <a href="<?php echo $sort_ansprechpartner; ?>"> <b>Ansprechpartner</b> </a>
                        <?php } ?>

                    </th>              
                    <th class="left " style="background-color: #DDDDDC;height: 27px;overflow:hidden; white-space: nowrap;" width="190px">


                        <?php if ($sort == 'c.email') { ?>
                        <a href="<?php echo $sort_email; ?>" class="<?php echo strtolower($order); ?>">  <b>E-Mail</b></a>
                        <?php } else { ?>
                        <a href="<?php echo $sort_email; ?>">   <b>E-Mail</b> </a>
                        <?php } ?> 


                    </th>
                    <th class="left unsortable" style="background-color: #DDDDDC;height: 27px;" width="130px">

                        <?php if ($sort == 'c.date_added') { ?>
                        <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>">  <b>Eingang</b></a>
                        <?php } else { ?>
                        <a href="<?php echo $sort_date_added; ?>">   <b>Eingang</b> </a>
                        <?php } ?> 	



                    </th>              
                    <th class="left unsortable" style="background-color: #DDDDDC;" width="95px">
                        <?php if ($sort == 'c.status') { ?>
                        <a href="<?php echo $status_customer; ?>" class="<?php echo strtolower($order); ?>">  <b>Status</b></a>
                        <?php } else { ?>
                        <a href="<?php echo $status_customer; ?>">   <b>Status</b> </a>
                        <?php } ?> 

                    </th>
                    <th class="right unsortable" style="background-color: #DDDDDC;" width="95px"></th>
                </tr>
            </thead>

            <tbody>

                <?php if ($customers2) {      $index = 0;     	
                ?>
                <?php foreach ($customers2 as $customer) { $index++;  $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
                <tr>        
                    <td class="left"  align=center><?php echo  sprintf('%04d' , $index); ?></td>
                    <td class="left"><div style='width:138px;overflow: hidden;'><?php echo $customer['firstname']; ?></div></td>
                    <td class="left"><div style='width:138px;overflow: hidden;'><?php echo $customer['ansprechpartner']; ?></div></td>
                    <td class="left"><div style='width:138px;overflow: hidden;'><?php echo $customer['email']; ?></div></td>
                    <td class="left"><?php echo $customer['date_added']; ?></td>
                    <td class="left"><?php echo $customer['approved']; ?></td>
                    <td class="right" > <a href='#' name="Ansicht" class='showdetail' rel='customerdetail<?php echo $customer["customer_id"];?>'>Ansicht</a> </td>
                </tr>

                <tr><td colspan=7 style=' padding:0px !important;'>

                        <div class="proddetailtoshow" style='float:left; display:none; width: 100%; background-color: #EEE !important;  ' id='customerdetail<?php echo $customer["customer_id"];?>'> 


                            <div class="reg_block edit_customer" style='display:none;'>
                                <form class="jNice"  id="edit_customer_form<?php echo $customer["customer_id"];?>" enctype="multipart/form-data" method="post" action="/index.php?route=account/edit">
                                        <input type='hidden' name='customer_id' value='<?php echo $customer["customer_id"];?>' />
                                    
                                    <input type='hidden' name='back' value='<?echo $actual_link; ?>' />
                                    <h3><? echo $heading_title2;?></h3>
                                    <p class="checks" id="personchecks" style="margin-bottom:20px;" >

                                        <input name="type_person" id="firma" class = "type_person1 radio" value="firma"  type  = "radio"    <?php if($customer['firma'] == 'on' ) echo 'checked'; ?>       />  <label for="firma"> <? echo  $typ1;?> </label>
                                        <br><br><input name="type_person" id="museum" class = "type_person2 radio" type="radio" value = "museum"  <?php if($customer['museum'] == 'on' ) echo 'checked'; ?>      /> <label for="museum"><? echo  $typ2;?>  </label>
                                        <br><br><input name="type_person" id="privatperson" class = "type_person3 radio" value="privatperson" type  = "radio"    <?php if($customer['privatperson'] == 'on' ) echo 'checked'; ?> /> <label for="privatperson"><? echo  $typ3;?> </label>


                                    </p>
                                    <div class="inps">
                                        <p><label for="ein"><? echo $entry_name; ?></label>	<input id="ein" type="text" name="firstname" value="<?php echo $customer['firstname']; ?>"/></p>
                                        <p class="separatorp">			        <input id="inp2" type="text" name="lastname" value="<?php echo $customer['lastname']; ?>"/></p>
                                        <p style="margin-bottom:10px;"> <? echo $entry_person; ?> 
                                        </p>

                                        <p><label for="inp3"><? echo $entry_firstname; ?></label>
                                            <input   type="text" name="ansprechpartner" value="<?php echo $customer['ansprechpartner']; ?>"/>
                                        </p>

                                        <p><label for="inp3"><? echo $entry_lastname; ?></label>
                                            <input  type="text" name="ansprechpartner2" value="<?php echo $customer['ansprechpartner2']; ?>"/>
                                        </p>
                                        <p class="separatorp"><label for="inp4"><? echo $entry_position; ?></label> <input id="inp4" type="text" name="position" value="<?php echo $customer['position']; ?>"/></p>

                                        <div style="    background-color: white !important;
                                             float: left;
                                             padding-top: 10px;
                                             padding-bottom: 10px; margin-top:3px; margin-bottom:10px;">
                                            <p><label for="inp5"><? echo $street; ?></label>		<input id="inp5" type="text" name="address_1" value="<?php echo $customer['address_1']; ?>"/></p>
                                            <p><label for="inp6"><? echo $entry_postcode; ?></label>			<input id="inp6" type="text" name="postcode" value="<?php echo $customer['postcode']; ?>"/></p>
                                            <p><label for="inp7"><? echo $entry_city; ?></label>		<input id="inp7" type="text" name="city" value="<?php echo $customer['city']; ?>"/></p>
                                            <p style="    padding-top: 10px;"><label for="inp8"><? echo $entry_country; ?></label>	

                                                <span style="   display: block; margin-left: 132px; width: 190px; ">	
                                                    <select name="land" id="land" style="width:134px;">


                                                        <?php foreach ($countries as $country) { ?>
                                                        <?php if ($country['name'] == $customer['country']) { ?>
                                                        <option value="<?php echo $country['name']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                                                        <?php } else { ?>
                                                        <option value="<?php echo $country['name']; ?>"><?php echo $country['name']; ?></option>
                                                        <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                </span>



                                            </p>

                                            <p style="    padding-top: 10px;"><label style="width:133px; margin-top:5px;"><? echo $communication; ?>:&nbsp;&nbsp;&nbsp;</label>	

                                                <span style="   display: block; margin-left: 132px; width: 190px;">	
                                                    <select name="communic" id="communic" style="width:134px; margin-top:5px;">
                                                        <option value="-"> -- </option>
                                                        <option value="de-DE" <?php if ($customer['lang'] == 'de-DE' ) echo "selected='selected'";?>>German</option>
                                                        <option value="en" <?php if ($customer['lang'] == 'en' ) echo "selected='selected'";?>>English</option>
                                                    </select>
                                                </span>
                                            </p>
                                        </div> 

                                        <p id="taxidnumber"><label for="inp9"><? echo $entry_tax; ?></label>	<input id="inp9" type="text" name="taxid_number" value="<?php echo $customer['taxid_number']; ?>"/></p>

                                        <div style="    background-color: white !important;
                                             float: left;
                                             padding-top: 10px;
                                             padding-bottom: 10px; margin-top:3px; ">
                                            <p><label for="inp10"><? echo $entry_telephone; ?></label>	<input id="inp10" type="text" name="telephone" value="<?php echo $customer['telephone']; ?>" /></p>
                                            <p><label for="inp11"><? echo $mobil; ?></label>	<input id="inp11" type="text" name="mobile" value="<?php echo $customer['mobile']; ?>" /></p>
                                            <p><label for="inp12"><? echo $entry_fax; ?></label>		<input id="inp12" type="text" name="fax" value="<?php echo $customer['fax']; ?>" /></p>
                                            <p><label for="inp13"><? echo $entry_email; ?></label>	<input id="inp13" type="text" name="email" value="<?php echo $customer['email']; ?>" /></p>
                                        </div>  </div>

                                    <h3><? echo $heading_title3;?></h3> 
                                    <p class="checks" ><input id="bill" class="radio" onchange="checboxBill();" name="bill_address" type="checkbox" <?php if($customer['bill_address'] == 'on' ) echo 'checked'; ?> /> <label for="bill"><? echo $heading_title4;?></label>
                                    <div id="billForm" style="<?php if($customer['bill_address'] == 'on' ) echo 'display:none;'; ?>">
                                        <div class="inps" style="background-color:white;">
                                            <input type="hidden" name="bill_access" value="<?php if($customer['bill_address'] == 'on' ){ echo 'off';}else{echo 'on';} ?>" id="bill_accessId"/>
                                            <p><label for="inp5"><? echo $street; ?></label>		<input id="inp5" type="text" name="bill_address_1" value="<?php echo $customer['bill_address_1']; ?>"/></p>
                                            <p><label for="inp6"><? echo $entry_postcode; ?></label>			<input id="inp6" type="text" name="bill_postcode" value="<?php echo $customer['bill_postcode']; ?>"/></p>
                                            <p><label for="inp7"><? echo $entry_city; ?></label>		<input id="inp7" type="text" name="bill_city" value="<?php echo $customer['bill_city']; ?>"/></p>
                                            <p><label for="inp8"><? echo $entry_country; ?></label>			<input id="inp8" type="text" name="bill_land" value="<?php echo $customer['bill_land']; ?>"/></p>
                                        </div>

                                    </div>
                                    </p>
                                    <h3><? echo $passinfo;?></h3>
                                    <div class="inps" style="background-color:white;margin: -6px 0px -10px 0px;
                                         padding: 10px 0px 10px 0px;">
                                        <p style="margin-bottom:10px;"><label for="inp14"><? echo $entry_username; ?></label>
                                            <input id="inp14" type="text" name="username" value="<?php echo $customer['username']; ?>"  /></p>
 
                                    </div>
                            </div>  
                            </form>


                            <div class="reg_block view_customer">
                                <h3>Hauptadresse / Ansprechpartner</h3>
                                <p class="checks" id="personchecks" style="margin-bottom:20px;" >
                                    <input name="type_person" disabled class = "type_person1 radio" value="firma"  type  = "radio"    <?php if($customer['firma'] == 'on' ) echo 'checked'; ?>       />  <label >Firma/Verein/Stiftung</label>
                                    <br><br><input name="type_person" disabled   class = "type_person2 radio" type="radio" value = "museum"  <?php if($customer['museum'] == 'on' ) echo 'checked'; ?>      /> <label  >Museum/Galerie</label>
                                    <br><br><input name="type_person" disabled class = "type_person3 radio" value="privatperson" type  = "radio"    <?php if($customer['privatperson'] == 'on' ) echo 'checked'; ?> /> <label >Privatperson</label>
                                </p>
                                <div class="inps">
                                    <p><label for="ein">Einrichtung:</label>	<?php echo $customer['firstname']; ?></p>
                                    <p class="separatorp"><label for="eiffn">&nbsp;</label><?php echo $customer['lastname']; ?></p>
                                    <p style="margin-bottom:10px;"> Ansprechpartner:
                                    </p>

                                    <p><label for="inp3">Vorname:</label>
                                        <?php echo $customer['ansprechpartner']; ?>
                                    </p>

                                    <p><label for="inp3">Nachname:</label>
                                        <?php echo $customer['ansprechpartner2']; ?>
                                    </p>
                                    <p class="separatorp"><label for="inp4">Position:</label><?php echo $customer['position']; ?></p>

                                    <div style="background-color: white !important;
                                         float: left;
                                         padding-top: 10px;
                                         padding-bottom: 10px; margin-top:3px; margin-bottom:10px;">
                                        <p><label for="inp5">Strasse Haus-Nr.:</label><?php echo $customer['address_1']; ?></p>
                                        <p><label for="inp6">PLZ:</label><?php echo $customer['postcode']; ?></p>
                                        <p><label for="inp7">Stadt:</label><?php echo $customer['city']; ?></p>
                                        <p style="    padding-top: 10px;"><label for="inp8">Land:</label>	
                                            <?php echo $customer['country']; ?>
                                        </p>

                                        <p style="    padding-top: 10px;"><label style="margin-top:5px;">Kommunikations-sprache:&nbsp;&nbsp;&nbsp;</label>	
                                            <?php if ($customer['lang'] == 'de-DE' ) echo "German"; ?>
                                            <?php if ($customer['lang'] == 'en' ) echo "English"; ?>
                                        </p>
                                    </div> 

                                    <p id="taxidnumber"><label for="inp9">TaxID Number:</label><?php echo $customer['taxid_number']; ?></p>

                                    <div style="background-color: white !important;
                                         float: left;
                                         padding-top: 10px;
                                         padding-bottom: 10px; margin-top:3px; ">
                                        <p><label for="inp10">Telefon:</label><?php echo $customer['telephone']; ?></p>
                                        <p><label for="inp11">Mobile:</label><?php echo $customer['mobile']; ?></p>
                                        <p><label for="inp12">Fax:</label><?php echo $customer['fax']; ?></p>
                                        <p><label for="inp13">E-Mail:</label><?php echo $customer['email']; ?></p>
                                    </div>  </div>

                                <h3>Rechnungsadresse</h3> 
                                <p class="checks" ><input class="radio" disabled  name="bill_address" type="checkbox" <?php if($customer['bill_address'] == 'on' ) echo 'checked'; ?> /> <label >Rechnungsadresse entspricht der Hauptadresse</label>
                                <div  style="<?php if($customer['bill_address'] == 'on' ) echo 'display:none;'; ?>">
                                    <div class="inps" style="background-color:white;">
                                        <input type="hidden" name="bill_access" value="<?php if($bill_address == 'on' ){ echo 'off';}else{echo 'on';} ?>" id="bill_accessId"/>
                                        <p><label for="inp5">Strasse Haus-Nr.:</label><?php echo $customer['bill_address_1']; ?></p>
                                        <p><label for="inp6">PLZ:</label><?php echo $customer['bill_postcode']; ?></p>
                                        <p><label for="inp7">Stadt:</label><?php echo $customer['bill_city']; ?></p>
                                        <p><label for="inp8">Land:</label><?php echo $customer['bill_land']; ?></p>
                                    </div>

                                </div>
                                </p>
                                <h3>Zugangsdaten</h3>
                                <div class="inps" style="width:100%;  background-color:white;margin: -6px 0px -10px 0px;
                                     padding: 10px 0px 10px 0px;">
                                    <p style="margin-bottom:10px;"><label for="inp14">Benutzername:</label>
                                        <?php echo $customer['username']; ?> </p>

                                </div>
                            </div>

                            <div style="margin-left: -6px; width:42%;text-align:left; float:left;   margin-bottom: -8px; padding:7px; background-color: #DDDDDC;" >

                                <input type="button" value="Bearbeiten" class="sbmt_button" onClick ="$(this).toggle();$('.view_customer').toggle(); $('.edit_customer').toggle();$('.speichern').toggle();" />
                                       <input type="button" style="display:none;" alt="Möchten Sie <br> die Änderungen <br> speichern?" value="Speichern" class="speichern confirmdialogopener_angebot sbmt_button" rel='#edit_customer_form<?php echo $customer["customer_id"];?>' >

                            </div>
                            <div style="margin-left: -6px; width:317px;text-align:left; float:left;   margin-bottom: -8px; padding:7px; background-color: #DDDDDC;" >

                                <input style='width:154px;' type="button"  value="neues Passwort senden" class="sbmt_button" onclick="window.location.href = '/index.php?route=sale/customer/newpasswort&customer_id=<?php echo $customer["customer_id"];?>'" >

                            </div>

                            <div style="margin-left: -2px; width:17.2%;text-align:left; float:left;   margin-bottom: -8px; padding:7px; background-color: #DDDDDC;" >

                                <input type="button" alt='Möchten Sie die Anfrage<br>aus dem System löschen?' value="Löschen" class="confirmdialogopener sbmt_button" rel='/index.php?route=sale/customer/ablehnen&customer_id=<?php echo $customer["custome&customer_idr_id"];?>' >

                            </div>


                        </div>
                        <div style="width:846px;text-align:right; float:left; height:5px; background-color:#DDDDDC;">&nbsp;</div>

                    </td></tr>

                <?php } ?>
                <?php } else { ?>
                <tr>
                    <td class="center" colspan="7">Keine Ergebnisse</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript"><!--
function filter() {
            url = 'index.php?route=sale/customer&token=<?php echo $token; ?>';
                    var filter_name = $('input[name=\'filter_name\']').attr('value');
                    if (filter_name) {
            url += '&filter_name=' + encodeURIComponent(filter_name);
            }

            var filter_email = $('input[name=\'filter_email\']').attr('value');
                    if (filter_email) {
            url += '&filter_email=' + encodeURIComponent(filter_email);
            }

            var filter_customer_group_id = $('select[name=\'filter_customer_group_id\']').attr('value');
                    if (filter_customer_group_id != '*') {
            url += '&filter_customer_group_id=' + encodeURIComponent(filter_customer_group_id);
            }

            var filter_status = $('select[name=\'filter_status\']').attr('value');
                    if (filter_status != '*') {
            url += '&filter_status=' + encodeURIComponent(filter_status);
            }

            var filter_approved = $('select[name=\'filter_approved\']').attr('value');
                    if (filter_approved != '*') {
            url += '&filter_approved=' + encodeURIComponent(filter_approved);
            }

            var filter_date_added = $('input[name=\'filter_date_added\']').attr('value');
                    if (filter_date_added) {
            url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
            }

            location = url;
            }
            
            
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