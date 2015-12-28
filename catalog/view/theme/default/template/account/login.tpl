 
 	      
 <?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
 
			
     <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
    <?php } ?>
    <?php if ($error) { ?>
    <div class="warning"><?php echo $error; ?></div>
    <?php } ?>
				<h1><?php echo $text_login;?></h1>

  <form class="jNice" action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="login2">
				<div class="reg_block">
					<h3><?php echo $text_Zugangsdaten; ?></h3>
					<div class="inps">
						<p><label for="ein"><?php echo $text_Benutzername;?></label>	<input id="ein" type="text" name="email"/></p>
					</div>
					<div class="inps inps2">
						<p><label for="inp10" style="margin-right: 24px;"><?php echo $text_Passwort;?></label>	<input class="log_pass" id="inp10" type="password" name="password"/></p>
						<a style="margin-right:51px;" href="<?php echo str_replace('&', '&amp;', $forgotten); ?>"><?php echo $text_qwestion;?></a>
					</div>
				</div>
				<input type="submit" value="<?echo $button_continue;?>" class="reg_button_3" />
			</form>
			
		 
		  
		  
  

 <script type="text/javascript"><!--
$('#login input').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#login2').submit();
	}
});
//--></script>
<?php echo $footer; ?> 