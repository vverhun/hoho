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
        width: 171px;
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

            <b>Offene Anmeldungen:</b><span style="color:red"> <? echo $customer_total; ?></span><br>
            <a href="/index.php?route=sale/customer/kunden">Kunden:</a> <span style="color:green; margin-left:97px;"> <? echo $customer_total2; ?> </span><br><br>

        </div>	
        <h2>Offene Anmeldungen</h2>	

        <table class="sortable" id="sortable_example"  width="99%" cellpadding=0 cellspacing=0>
            <thead>
                <tr>
                    <?php /* ?>
                    <th class="" valign=center style="background-color: #DDDDDC;height: 27px;"  align=center width="58px">
                        <b>Nr.</b>
                    </th>
                    <?php */ ?>


                    <th class="" valign=center style="background-color: #DDDDDC;height: 27px;"  align=center width="58px">
                        <?php if ($sort == 'c.customer_id') { ?>
                        <a href="<?php echo $sort_customer_id; ?>" class="<?php echo strtolower($order); ?>">  <b>Nr.</b>  </a>
                        <?php } else { ?>
                        <a href="<?php echo $sort_customer_id; ?>">   <b>Nr.</b>  </a>
                        <?php } ?>
                    </th>

                    <th class="left sort-alpha" style="background-color: #DDDDDC;overflow:hidden;height: 27px; white-space: nowrap;" width="150px">

                        <?php if ($sort == 'name') { ?>
                        <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><b>Kunde</b>  </a>
                        <?php } else { ?>
                        <a href="<?php echo $sort_name; ?>"> <b>Kunde</b>  </a>
                        <?php } ?>


                    </th>
                    <th class="left " style="background-color: #DDDDDC;overflow:hidden;height: 27px; white-space: nowrap;" width="150px">

                        <?php if ($sort == 'c.ansprechpartner') { ?>
                        <a href="<?php echo $sort_ansprechpartner; ?>" class="<?php echo strtolower($order); ?>"><b>Ansprechpartner</b>  </a>
                        <?php } else { ?>
                        <a href="<?php echo $sort_ansprechpartner; ?>"> <b>Ansprechpartner</b> </a>
                        <?php } ?>

                    </th>              
                    <th class="left " style="background-color: #DDDDDC;overflow:hidden; height: 27px;white-space: nowrap;" width="190px">


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

                <?php if ($customers) { ?>
                <?php foreach ($customers as $customer) { ?>
                <tr>      
                    <td class="left"  align=center>...</td>
                    <td class="left "><div style='width:138px;overflow: hidden;'><?php echo $customer['firstname']; ?></div></td>
                    <td class="left"><div style='width:138px;overflow: hidden;'><?php echo $customer['ansprechpartner']; ?></div></td>
                    <td class="left"><div style='width:138px;overflow: hidden;'><?php echo $customer['email']; ?></div></td>
                    <td class="left"><?php echo $customer['date_added']; ?></td>
                    <td class="left"><span style="color:red;">offen</span></td>
                    <td class="right"> <a href='#' name="bearbeiten" class='showdetail' rel='customerdetail<?php echo $customer["customer_id"];?>'>bearbeiten</a> </td>


                </tr>

                <!-- start additioal hided-->

                <tr><td colspan=7 style="min-height: 1px; padding:0px !important;">

                        <div  class="proddetailtoshow" style='float:left; background-color: #EEE !important;	 display:none; width: 100%; ' id='customerdetail<?php echo $customer["customer_id"];?>'> 


                            <div class="reg_block">
                                <h3>Hauptadresse / Ansprechpartner</h3>
                                <p class="checks" id="personchecks" style="margin-bottom:20px;" >
                                    <input name="type_person" id="firma" disabled class = "type_person1 radio" value="firma"  type  = "radio"    <?php if($customer['firma'] == 'on' ) echo 'checked'; ?>       />  <label for="firma">Firma/Verein/Stiftung</label>
                                    <br><br><input name="type_person" disabled id="museum" class = "type_person2 radio" type="radio" value = "museum"  <?php if($customer['museum'] == 'on' ) echo 'checked'; ?>      /> <label for="museum">Museum/Galerie</label>
                                    <br><br><input name="type_person" disabled id="privatperson" class = "type_person3 radio" value="privatperson" type  = "radio"    <?php if($customer['privatperson'] == 'on' ) echo 'checked'; ?> /> <label for="privatperson">Privatperson</label>
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
                                            <?php if ($customer['communic'] == 'de-DE' ) echo "German"; ?>
                                            <?php if ($customer['communic'] == 'en' ) echo "English"; ?>
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
                                <p class="checks" ><input id="bill" class="radio" disabled onchange="checboxBill();" name="bill_address" type="checkbox" <?php if($customer['bill_address'] == 'on' ) echo 'checked'; ?> /> <label for="bill">Rechnungsadresse entspricht der Hauptadresse</label>
                                <div id="billForm" style="<?php if($customer['bill_address'] == 'on' ) echo 'display:none;'; ?>">
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
   

                            <div style="/* margin-left: -10px; */width: 33%;text-align:left; float:left;   margin-bottom: -8px;/* padding:7px; */ background-color: #DDDDDC;">
                                <input class="confirmdialogopener sbmt_button" type="button" onclick="" value="Ablehnen">
                            </div>
                            <div style="padding-left: -56px;width: 34%;/* text-align:left; */padding-left: -22px;float: left;margin-bottom: -11px;/* padding:7px 0 7px 14px; */ background-color: #DDDDDC;margin-left: -75px;">
                                <input class="confirmdialogopener sbmt_button" style="float: right;" type="button" onclick=" window.location = '/index.php?route=sale/customer/loschen&amp;customer_id=666'" value="Löschen">
                            </div>
                            <div style="padding-left: 75px;width: 33%;/* text-align:left; */float: left;margin-bottom: -11px;/* padding:7px 0 7px 14px; */ background-color: #DDDDDC;">
                                <input class="confirmdialogopener sbmt_button" style="float: right;" type="button" onclick=" window.location = '/index.php?route=sale/customer/akzept&amp;customer_id=666'" value="Akzeptieren">
                            </div>

                        </div>
                        <div style="width:846px;text-align:right; float:left; height:5px; background-color:#DDDDDC;">&nbsp;</div>

                    </td></tr>

                <?php } ?>
                <?php } else { ?>
                <!-- no customers waiting approve-->
                <tr>
                    <td class="center" colspan="7">Keine Ergebnisse</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <br> 

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
//--></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/ui.datepicker.js"></script>
<script type="text/javascript"><!--
$(document).ready(function () {
        /*$('#date').datepicker({dateFormat: 'yy-mm-dd'});*/
    });
//--></script>
<?php echo $footer; ?>