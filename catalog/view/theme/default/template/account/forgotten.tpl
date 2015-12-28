<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
      
      <h1><?php echo $heading_title; ?></h1>
   
     <?php if ($error) { ?>
    <div class="warning"><?php echo $error; ?></div>
    <?php } ?>
	
	
    <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="forgotten" class="jNice">
    <div class="reg_block">
	
       <h3><?php echo $text_your_email; ?></h3>
     <div class="inps"> <p>
        <label><?php echo $entry_email; ?></label> <input type="text" name="email" /> 
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