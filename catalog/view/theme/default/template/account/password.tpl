 




<?php echo $header; ?> 
      <style>
      .inps{
          width:262px !important;
          margin-right:90px;
      }
      </style>
      <h1><?php echo $heading_title; ?></h1>
   
     <?php if ($error_password) { ?>
    <div class="warning"><?php echo $error_password; ?></div>
    <?php } ?>

     <?php if ($error_confirm) { ?>
    <div class="warning"><?php echo $error_confirm; ?></div>
    <?php } ?>
    
    	
     <?php if ($success_password) { ?>
    <div class=" " style='color:green;'><?php echo $success_password; ?></div>
    <?php } ?>
    
    	
    <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="forgotten" class="jNice">
    <div class="reg_block">
	
       <h3> </h3>
       <div class="inps"> <p>
        <label><?php echo $entry_password; ?></label> <input type="password" name="password" value="<?php echo $password; ?>" />
       
      </p></div>
      
        <div class="inps" style="width: 335px !important;"> <p>
        <label> <?php echo $entry_confirm; ?></label> <input type="password" name="confirm" value="<?php echo $confirm; ?>" />
       
      </p></div>
      
      
	 </div>
	 
	      <div class="buttons">
        <table align=right width=14% cellpadding=0 cellspacing=0>
          <tr>
             <td align="right">
			    <input type="button" onclick="$('#forgotten').submit();" class="reg_button_3" name="search" value="<?php echo $button_continue; ?>">	
			 </td>
          </tr>
        </table>
      </div>
	  
	  
    </form>
  
 <?php echo $footer; ?> 