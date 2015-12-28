<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
 
 <h2 style="margin-top:30px;margin-bottom:10px;">Abwesenheits-Assistent</h2>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="jNice">
     
         <table border=0 width=60%  >
            <td valign=top> <?php if (!$config_maintenance) { ?>
              <input type="radio" name="config_maintenance" value="0" checked="checked" /> aktivieren <br>
              <input type="radio" name="config_maintenance" value="1" /> deaktivieren
              <?php } else { ?>
              <input type="radio" name="config_maintenance" value="0" /> aktivieren <br>
              <input type="radio" name="config_maintenance" value="1" checked="checked" /> deaktivieren
              <?php } ?>
			 </td>
			 <td>
			  <table border=0 width=80% style="margin-top:0px;">
			  <tr>	
			 <td valign=top><label style="  display: block; padding-top: 5px;"> Tag: </label>  </td> <td valign=center><input type='tag' name='tag' style="width:30px;" value="<? echo $tag; ?>"> &nbsp;&nbsp;&nbsp;&nbsp;</td>
			 <td valign=top><label style="display: block; padding-top: 5px;"> Monat:</label> </td> <td valign=center> <input type='Monat' name='monat' style="width:30px;" value="<? echo $monat; ?>"> &nbsp;&nbsp;&nbsp;&nbsp;</td>
			 <td valign=top><label style="display: block; padding-top: 5px;"> Jahr: </label> </td> <td valign=center><input type='Jahr' name='jahr' style="width:50px;" value="<? echo $jahr; ?>"> &nbsp;&nbsp;&nbsp;&nbsp;</td>
			 </tr>	
			 
			 </table>
			 
			 </td>
          </tr>
 
		  </table>
		  <hr>
		  <input type="button" onclick="$('#form').submit();" class="sbmt_button" value="speichern" style="float:right;">
		  
 		   
    </form>
  </div>
</div>
 
<?php echo $footer; ?>