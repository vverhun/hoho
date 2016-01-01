<style>
    label{
        width: 171px;
    }
</style>

<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>

<h1>  <?php echo $my_datem; ?> </h1> 

<?php if ($error_warning) { ?>
<p style="font-size: 14px;font-weight: bold;color: red;"><?php echo $error_warning; ?></p>
<?php } ?>

<div class="reg_block">
    <h3><? echo $heading_title2;?></h3>
    <p class="checks" id="personchecks" style="margin-bottom:20px;" >
        <input name="type_person" id="firma" disabled class = "type_person1 radio" value="firma"  type  = "radio"    <?php if($firma == 'on' ) echo 'checked'; ?>       />  <label for="firma"> <? echo  $typ1;?> </label>
        <br><br><input name="type_person" disabled id="museum" class = "type_person2 radio" type="radio" value = "museum"  <?php if($museum == 'on' ) echo 'checked'; ?>      /> <label for="museum"><? echo  $typ2;?>  </label>
        <br><br><input name="type_person" disabled id="privatperson" class = "type_person3 radio" value="privatperson" type  = "radio"    <?php if($privatperson == 'on' ) echo 'checked'; ?> /> <label for="privatperson"><? echo  $typ3;?> </label>
    </p>
    <div class="inps">
        <p><label for="ein"><? echo $entry_name; ?></label>	<?php echo $firstname; ?></p>
        <p class="separatorp"><label for="eiffn">&nbsp;</label><?php echo $lastname; ?></p>
        <p style="margin-bottom:10px;"> <? echo $entry_person; ?> 
        </p>

        <p><label for="inp3"><? echo $entry_firstname; ?></label>
            <?php echo $ansprechpartner; ?>
        </p>

        <p><label for="inp3"><? echo $entry_lastname; ?></label>
            <?php echo $ansprechpartner2; ?>
        </p>
        <p class="separatorp"><label for="inp4"><? echo $entry_position; ?></label><?php echo $position; ?></p>

        <div style="background-color: white !important;
             float: left;
             padding-top: 10px;
             padding-bottom: 10px; margin-top:3px; margin-bottom:10px;">
            <p><label for="inp5"><? echo $street; ?></label><?php echo $address_1; ?></p>
            <p><label for="inp6"><? echo $entry_postcode; ?></label><?php echo $postcode; ?></p>
            <p><label for="inp7"><? echo $entry_city; ?></label><?php echo $city; ?></p>
            <p style="    padding-top: 10px;"><label for="inp8"><? echo $entry_country; ?></label>	
                <?echo $country_id; ?>
            </p>

            <p style="    padding-top: 10px;"><label style="margin-top:5px;"><? echo $communication; ?>:&nbsp;&nbsp;&nbsp;</label>	
                <?php if ($communic == 'de-DE' ) echo "German"; ?>
                <?php if ($communic == 'en' ) echo "English"; ?>
            </p>
        </div> 

        <p id="taxidnumber"><label for="inp9"><? echo $entry_tax; ?></label><?php echo $taxid_number; ?></p>

        <div style="background-color: white !important;
             float: left;
             padding-top: 10px;
             padding-bottom: 10px; margin-top:3px; ">
            <p><label for="inp10"><? echo $entry_telephone; ?></label><?php echo $telephone; ?></p>
            <p><label for="inp11"><? echo $mobil; ?></label><?php echo $mobile; ?></p>
            <p><label for="inp12"><? echo $entry_fax; ?></label><?php echo $fax; ?></p>
            <p><label for="inp13"><? echo $entry_email; ?></label><?php echo $email; ?></p>
        </div>  </div>

    <h3><? echo $heading_title3;?></h3> 
    <p class="checks" ><input id="bill" class="radio" disabled onchange="checboxBill();" name="bill_address" type="checkbox" <?php if($bill_address == 'on' ) echo 'checked'; ?> /> <label for="bill"><? echo $heading_title4;?></label>
    <div id="billForm" style="<?php if($bill_address == 'on' ) echo 'display:none;'; ?>">
        <div class="inps" style="background-color:white;">
            <input type="hidden" name="bill_access" value="<?php if($bill_address == 'on' ){ echo 'off';}else{echo 'on';} ?>" id="bill_accessId"/>
            <p><label for="inp5"><? echo $street; ?></label><?php echo $bill_address_1; ?></p>
            <p><label for="inp6"><? echo $entry_postcode; ?></label><?php echo $bill_postcode; ?></p>
            <p><label for="inp7"><? echo $entry_city; ?></label><?php echo $bill_city; ?></p>
            <p><label for="inp8"><? echo $entry_country; ?></label><?php echo $bill_land; ?></p>
        </div>

    </div>
</p>
<h3><? echo $passinfo;?></h3>
<div class="inps" style="width:100%;  background-color:white;margin: -6px 0px -10px 0px;
     padding: 10px 0px 10px 0px;">
    <p style="margin-bottom:10px;"><label for="inp14"><? echo $entry_username; ?></label>
        <?php echo $username; ?> </p>

</div>
</div>                



<input type="button" style="margin:13px 3px 13px 0px !important;" value="<? echo $bearbeiten;?>" class="reg_button_2" onclick="window.location.href = '/index.php?route=account/edit'"/>

















<script type="text/javascript">
            $(document).ready(function(){
    var s = '0';
            $('#bill a.jNiceCheckbox').click(function(e){
    //alert("click");
    if (s == '0'){
    <?php if ($bill_address == 'on'){ echo 'checboxBill_open();'; }else{echo 'checboxBill_close();';} ? >
            //checboxBill_open();
            s++
    } else{
    <?php if ($bill_address == 'on'){ echo 'checboxBill_close();'; }else{echo 'checboxBill_open();';} ? >
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