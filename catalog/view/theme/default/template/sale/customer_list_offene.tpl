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

                            <table border=0 width=100%  style="float:left;" class="tabledetail"><tr>

                                    <td valign=top align=left>
                                        <table width='60%'><tr><td  width=198px>
                                                    &nbsp;&nbsp;&nbsp;Einrichtung: </td><td> <b><?php echo $customer['firstname']; ?></b><br>
                                                </td></tr><tr><td  width=198px>
                                                    &nbsp;&nbsp; Ansprechpartner:  </td><td><b><?php echo $customer['ansprechpartner']; ?></b><br>
                                                </td></tr><tr><td  width=198px>
                                                    &nbsp;&nbsp; Position: </td><td><b><?php echo $customer['position']; ?></b><br>
                                                </td></tr>
                                            <tr><tr>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>					
                                            <tr><td  width=198px>
                                                    &nbsp;&nbsp;   Benutzername: </td><td><b><?php echo $customer['username']; ?></b><br>
                                                </td></tr><tr><td  width=198px>				  
                                                    &nbsp;&nbsp;    Straße: </td><td><b><?php echo $customer['address_1']; ?></b><br>
                                                </td></tr><tr><td  width=198px>
                                                    &nbsp;&nbsp;	PLZ: </td><td><b><?php echo $customer['postcode']; ?></b><br>
                                                </td></tr><tr><td  width=198px>
                                                    &nbsp;&nbsp;	Stadt: </td><td><b><?php echo $customer['city']; ?></b><br>
                                                </td></tr><tr><td  width=198px>
                                                    &nbsp;&nbsp;	Land: </td><td><b><?php echo $customer['country']; ?></b><br>
                                                </td></tr><tr><td  width=198px>
                                                    &nbsp;&nbsp;	TaxID Number: </td><td><b><?php echo $customer['taxid_number']; ?></b><br>
                                                </td></tr>

                                            <tr><tr>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>

                                            <tr><td>

                                                    &nbsp;&nbsp;	Telefon: </td><td><b><?php echo $customer['telephone']; ?></b><br>
                                                </td></tr><tr><td>
                                                    &nbsp;&nbsp;	Mobil: </td><td><b><?php echo $customer['mobile']; ?></b><br>
                                                </td></tr><tr><td>
                                                    &nbsp;&nbsp;	Fax: </td><td><b><?php echo $customer['fax']; ?></b><br>
                                                </td></tr><tr><td>
                                                    &nbsp;&nbsp;	E-Mail: </td><td><b><?php echo $customer['email']; ?></b><br><br>
                                                </td></tr></table>

                                        <div style="float: right;   margin-right: -111px; margin-top: -105px;width: 245px;">
                                            <? if ( $customer['downloadedfile'] != '' ) {?>		
								<a href="/download/<?php echo $customer['downloadedfile']; ?>" style="color:black; text-decoration:none;">	 	 
										<img  width="50px" class="medalka" src="catalog/view/theme/default/img/inpspic.gif" />
										<br><div style="text-decoration:underline;text-align:justify;" >Verifizierungs-<br>Document</div>
								</a>
							<?}?>
                                        </div>	 

                                    </td>

                                <tr><td colspan=7><h2 style="background-color: #F7F7F7 !important;padding:5px 0 5px 13px;">Rechnungsadresse</h2></td></tr>		
                                <tr><td colspan=7>
                                        <div style="padding:5px 0 5px 13px;">	
                                            <? echo $bill_address; if ( $customer['bill_address'] == 'on'){?> <b> Rechnungsadresse entspricht der Hauptadresse </b> <?} else{?>
				  
	             <table border=0  style="float:left;"> 
			  
				  <tr><td width=184px> 
			    Straße: </td><td> <b><?php echo $customer['bill_address_1']; ?></b><br>
				    </td></tr><tr><td width=184px>
				 	PLZ: </td><td><b><?php echo $customer['bill_postcode']; ?></b><br>
					</td></tr><tr><td width=184px>
				 	Stadt: </td><td><b><?php echo $customer['bill_city']; ?></b><br>
					</td></tr><tr><td width=184px>
				 	Land: </td><td><b><?php echo $customer['bill_land']; ?></b><br>
					</td></tr> </table>
					
					
				  <?}?>
                                        </div>		
                                    </td></tr>	

                                </tr></table>

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