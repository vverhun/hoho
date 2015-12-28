<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
 <script type="text/javascript">
    function getWidth() {
          var myWidth = 0;
          myWidth = document.getElementById("wrapper").clientWidth;
          return myWidth;
    };
    function getWindowWidth(){
        var winW=0;
         if (parseInt(navigator.appVersion)>3) {
         if (navigator.appName=="Netscape") {
          winW = window.innerWidth;
         }
         if (navigator.appName.indexOf("Microsoft")!=-1) {
          winW = document.body.offsetWidth;
         }
        }
        return winW;

    }
     function scrollToCenter(){
        var width = getWidth();
        var windowWidth = getWindowWidth();
    // alert(width);
    // alert(windowWidth);
        window.scroll((width-windowWidth)/2,0);
    }
	$(document).ready(function(){
		$('#ser_info_1').CreateBubblePopup({
				innerHtml: '<div class="popup4ik"><p><?php echo $text_info_1;?></p></div>',

				innerHtmlStyle: {
									'text-align':'left'
								},
				
				themeName: 	'grey',
				position: 'left',
				selectable: true,
				closingSpeed: 10,
				openingSpeed: 10,
				themePath: 	'catalog/view/theme/default/images/jquerybubblepopup-theme'								 
		   });
		   
		   
		   $('#ser_info_1').ShowBubblePopup();
		   $('#ser_info_1').HideBubblePopup();
		   
		$('#ser_info_2').CreateBubblePopup({
				innerHtml: '<div class="popup4ik"><p><?php echo $text_info_2;?></p></div>',

				innerHtmlStyle: {
									'text-align':'left'
								},
				
				themeName: 	'grey',
				position: 'left',
				selectable: true,
				closingSpeed: 10,
				openingSpeed: 10,
				themePath: 	'catalog/view/theme/default/images/jquerybubblepopup-theme'								 
		   });
		     $('#ser_info_2').ShowBubblePopup();
			  $('#ser_info_2').HideBubblePopup();
			  
		$('.ser_info_3').CreateBubblePopup({
				innerHtml: '<div class="popup4ik"><p><?php echo $text_info_3;?></p></div>',

				innerHtmlStyle: {
									'text-align':'left'
								},
				
				themeName: 	'grey',
				position: 'left',
				selectable: true,
				closingSpeed: 10,
				openingSpeed: 10,
				themePath: 	'catalog/view/theme/default/images/jquerybubblepopup-theme'								 
		});

		$('.ser_info_4').CreateBubblePopup({
			innerHtml: '<div class="popup4ik"><p><?php echo $text_info_4;?></p></div>',

			innerHtmlStyle: {
								'text-align':'left'
							},
			
			themeName: 	'grey',
			position: 'left',
			selectable: true,
			closingSpeed: 10,
			openingSpeed: 10,
			themePath: 	'catalog/view/theme/default/images/jquerybubblepopup-theme'								 
		});

		
		$('.ser_info_3').ShowBubblePopup();
        $('.ser_info_3').HideBubblePopup();
			
		$('.ser_info_4').ShowBubblePopup();
        $('.ser_info_4').HideBubblePopup();
        			
		var theInt = null;
		var $crosslink, $navthumb;
		var curclicked = 0;
		
		$('.showProduct0').click(function(){
			   $('.panel1').css('display','block');
			   $('.panel2').css('display','none');
			
			   $(function(){
					$("#main-photo-slider").codaSlider();
			    });
	   	       return false;		
		 });
		 
		$('.showProduct').click(function(){
			   $('.panel1').css('display','none');
			   $('.panel2').css('display','block');
				
	
				$(function(){
					$("#main-photo-slider").codaSlider();
			    });
	   	       return false;		
		 });
		 
		$('.showProduct2').click(function(){

			    $('.panel1').css('display','block');
			    $('.panel2').css('display','none');
				$(function(){
					$("#main-photo-slider").codaSlider();
			    });
	   	       return false;		
		 });	 
		 
		 
		 $('.cross-link1').click(function(){
			 $('.panel1').css('display','block');
			 $('.panel2').css('display','none');
	   	     return false;		
		 })
		 
		 $('.cross-link2').click(function(){
			 $('.panel1').css('display','none');
			 $('.panel2').css('display','block');
			 
	   	       return false;		
		 })		 
		
		})
</script>


 
            <h1><?php echo $my_shotyon;?></h1>
			<form class="jNice">
			<div style="width:240px; float: left;">
			 	<select id="category_id" title="<?php echo $my_Auswahl;?>" OnChange="return changeCategory(this);" style=" margin-left: 18px; width:184px;z-index:1000;">
	              <option value="0"><?php echo $my_Auswahl;?></option>
	              <?php foreach ($categories as $category) { ?>
	              <?php if ($category['category_id'] == $category_id) { ?>
	              		<option value="<?php echo $category['category_id']; ?>" selected="selected" rel="<?php echo $category['parent_id']; ?>"><?php echo $category['name']; ?></option>
	              <?php } else { ?>
	              		<option value="<?php echo $category['category_id']; ?>"  rel="<?php echo $category['parent_id']; ?>"><?php echo $category['name']; ?></option>
	              <?php } ?>
	              <?php } ?>
	            </select>
	         </div>
	         	<p style="width:845px !important; border-bottom: 1px solid #6d6d6d;  margin-bottom:0px !important; margin-left: 0 !important; padding-bottom: 14px;"><?php echo $my_text_desc;?><img id="ser_info_1" src="catalog/view/theme/default/img/info_pic_1.jpg" /></p>
				
				<div class="ser_inps" <?php if ( $parent == '36') {?> style="display:block;" <?php } else{ ?> style="display:none;" <?php } ?>  id="c36">
					<div class="sitem">
						<label for="inp20"><?php echo $my_titel;?></label>
						<input type="text" name="keyword" class="keyword" id="inp20" value="<? echo $titel; ?>" />
					</div>
					<div class="sitem">
						<label for="inp21">							
							<table border=0 cellpadding=0 cellspacing=0>
								<tr><td>WV (CR)-Nr.:</td>
									<td><img id="ser_info_2" src="catalog/view/theme/default/img/info_pic_1.jpg" /></td>
								</tr>                             
							</table> 						
						</label>
						<input type="text" name="wv_cr-nr" id="inp21" value="<? echo $wv_cr_nr; ?>" />
					</div>
					<div class="sitem">
						<label for="inp22"><?php echo $my_year;?></label>
						<input type="text" name="jahr" id="inp22" value="<? echo $jahr_t; ?>" />
					</div>
					<img class="ser_info_3" src="catalog/view/theme/default/img/info_pic_1.jpg" />
					<input type="button" value="<? echo $button_search; ?>" name="search" class='searchbutton' onclick="contentSearch();" />
				</div>

				<div class="ser_inps" <?php if ( $parent == '37') {?> style="display:block;" <?php } else{ ?> style="display:none;" <?php } ?> id="c37">
 	                <div class="sitem" style="margin-top: 0px;">
						  	<label for="inp20"><?php echo $my_titel;?></label>	<input type="text" class="keyword" id="inp200" name="keyword" value="<? echo $titel2; ?>" />
					</div>
					
					
					<div class="sitem2" style="margin-top: 31px; margin-left:10px;">
						 	<select id="tag" title="<?php echo $my_day;?>"  style="width:83px;">	              			
	                         <option value="0"><?php echo $my_day;?></option>
	                         <?php 
	                             for ( $i = 1; $i <= 31; $i++ ){
	                             	?>
	                             	  <?php if ($i == $tag) { ?>
						              <option value="<?php echo $i; ?>" selected="selected" ><?php echo $i; ?></option>
						              <?php } else { ?>
						              <option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
						              <?php } 	
	                             }
	                         ?>
	            			</select>
					</div>
					
					
					<div class="sitem2" style="margin-top: 31px;">
						 <select id="monat" title="<?php echo $my_Monat;?>" style="width:83px;">
	              			 <option value="0"><?php echo $my_Monat;?></option>
	                         <?php 
	                             for ( $i = 1; $i <= 12; $i++ ){
	                             	?>
	                             	  <?php if ($i == $monat) { ?>
						              <option value="<?php echo $i; ?>" selected="selected" ><?php echo $i; ?></option>
						              <?php } else { ?>
						              <option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
						              <?php } 	
	                             }
	                         ?>
	            			</select>
					</div>
					<div class="sitem2" style="margin-top: 31px;">
							<select id="jahr" title="<?php echo $my_year;?>" style="width:83px;">
	              			<option value="0"><?php echo $my_year;?></option>
	                         <?php 
	                             for ( $i = $end_year; $i <= $start_year; $i++ ){
	                             	?>
	                             	  <?php if ($i == $jahr) { ?>
						              <option value="<?php echo $i; ?>" selected="selected" ><?php echo $i; ?></option>
						              <?php } else { ?>
						              <option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
						              <?php } 	
	                             }
	                         ?>
	            			</select> 
					</div>			
					<img class="ser_info_4" src="catalog/view/theme/default/img/info_pic_1.jpg" />
					<input type="button" value="<? echo $button_search; ?>" name="search" class="searchbutton" onclick="contentSearch();" />
				</div>
				<input type='hidden' name='perpage' id='perpage' value='8'  />				
			</form>
  <?php if (isset($products)) {  ?>
	 <div class="search_results">
	 
				<div class="paginator_block">
					<form class="jNice">
					<div  style='margin-top:7px;'>
						<select name="show_res" title="Show all style" "width:120px;z-index:100;" OnChange="changePerPage(this);" id="selectperpage">
							<option value='4' <? if ($perpage == '4') echo 'selected=selected'; ?> > <? echo $show_4; ?></option>
							<option value='8' <? if ($perpage == '8') echo 'selected=selected'; ?> ><? echo $show_8; ?></option>
							<option value='12' <? if ($perpage == '12') echo 'selected=selected'; ?> ><? echo $show_12; ?></option>
							<option value='16' <? if ($perpage == '16') echo 'selected=selected'; ?> ><? echo $show_16; ?></option>
							<option value='32' <? if ($perpage == '32') echo 'selected=selected'; ?> ><? echo $show_32; ?></option>	
														<option value='1000000' <? if ($perpage == '1000000') echo 'selected=selected'; ?> ><? echo $show_all; ?></option>
													
 						</select></div>
					</form>
					<!-- div class="paginator">
						<a href="#" class="back"></a>
						<a href="#" class="active_page">1</a>
						<a href="#">2</a>
						<a href="#">3</a>
						<a href="#">4</a>
						<a href="#" class="next"></a>
					</div  -->
					 <div class="paginator" style="float:right;">
						<?php echo $pagination; ?>
				    </div>
				</div>
			
				<div class="results"><?
			      if (sizeof($products) == 0 ){ echo  "<br><br><b>".$text_empty."</b>" ; }?>
				<?php for ($i = 0; $i < sizeof($products); $i++ ) { ?>
				<script>
				$(document).ready(function(){
				   	$('#p<?php echo $products[$i]["product_id"]; ?>').jqm({modal: true, trigger: 'a.showProduct<?php echo $products[$i]["product_id"]; ?>'});
					$('#p<?php echo $products[$i]["product_id"]; ?>').jqmAddClose('.hideProduct');
				})
				</script>
					<div class="sear_res_item">
						<a class="showProduct0 showProduct<?php echo $products[$i]["product_id"]; ?>" style="cursor:pointer;">
							<b style="height:15px;"> <? if (  $products[$i]['sku'] != '' && $products[$i]['sku'] != '-1'){?> CR: <?php 
							 
								$text = $products[$i]['sku'];
								if(mb_strlen($text, 'UTF-8') > 18  ) {
									$text = mb_substr( $text, 0, 18, 'UTF-8')."...";
								}
								echo $text;  
								
							    }?></b>
							<div class="img_wrap" style="height:120px;">
								<table height="100%" width="100%">
									<tr>	
										<td align="center" valign="middle">
											<img src="<?php echo $products[$i]['thumb']; ?>" />
										</td>
									</tr>
								</table>
								
							</div>
							<b><?php 
								$text = $products[$i]['name'];
								if(mb_strlen($text, 'UTF-8') > 18  ) {
									$text = mb_substr( $text, 0, 18, 'UTF-8')."...";
								}
								echo $text; ?>
							</b>
						</a>
						<div class="bot_buts">
							<a style="cursor:pointer;" class="showProduct showProduct<?php echo $products[$i]["product_id"]; ?>"><img src="catalog/view/theme/default/img/info_icon.jpg"></a>
							<a style="cursor:pointer;" class="showProduct2 showProduct<?php echo $products[$i]["product_id"]; ?>"><img src="catalog/view/theme/default/img/add_icon.jpg"></a>
							<a style="cursor:pointer;" onclick="add_to_cart_all(<? echo $products[$i]['product_id']; ?>,'lst')"  class="button_add_small basket_button" ><img src="catalog/view/theme/default/img/basket_icon.jpg"></a>
						</div>
					</div>
					<div class="prod_popup jqmWindow" id="p<?php echo $products[$i]['product_id']; ?>" style="z-index:3001000 !important;">
						<a href="#" class="hideProduct">
							<img src="catalog/view/theme/default/img/close_button.gif" />
						</a>
						<div class="slider-wrap">
							<div id="main-photo-slider" class="csw">
								<div class="panelContainer">
									<div class="panel1" title="Panel 1">
									  <table border=0 width=660px height=450px><tr><td valign=center align=center>
 										 <img src="/image/<?php echo $products[$i]['image']; ?>" alt="temp" height="300px;"  style="max-width:680px;"/>
 										</td></tr></table>
 									</div>
									<div class="panel2" title="Panel 2" style="display:none;">
									  <table border=0 width=660px height=450px><tr><td valign=center align=center>
      									<div  class="table_panel2">
 											 <table border=0 width=65%  cellpadding=0 cellspacing=0 style="   font-family: verdana;
    														font-size: 12px;
														    font-weight: normal;
														    padding: 24px;">	 
											 
												 <tr><td style="background-color:#ececec;"><span style="color:#9b9b9b;"><?php echo $my_titel;?></span></td><td style="background-color:#ececec;"><span style="color:#414141;"><?php echo $products[$i]['name']; ?></span></td></tr>
												 <tr><td ><span style="color:#9b9b9b;"><?php echo $my_year;?></span></td><td><span style="color:#414141;"><?php echo $products[$i]['location']; ?></span></td></tr>
												 <tr><td style="background-color:#ececec;"><span style="color:#9b9b9b;">Material:</span></td><td style="background-color:#ececec;"><span style="color:#414141;"><?php echo $products[$i]['meta_description']; ?></span></td></tr>
												 <tr><td><span style="color:#9b9b9b;"><?php echo $my_size;?></span></td><td><span style="color:#414141;"><?php echo $products[$i]['meta_keywords']; ?></span></td></tr>
												 <tr><td style="background-color:#ececec;"><span style="color:#9b9b9b;">Catalog Raisonne:</span></td><td style="background-color:#ececec;"> <span style="color:#414141;"><?php if ($products[$i]['sku'] != '-1') echo $products[$i]['sku']; ?></span></td></tr>
											     <tr><td></td><td>&nbsp;&nbsp;</td></tr>
												 <tr><td style="background-color:#ececec;"><span style="color:#9b9b9b;"><?php echo $my_file_size;?></span></td><td style="background-color:#ececec;"><span style="color:#414141;"><?php echo $products[$i]['weight']; ?> MB</span></td></tr>
												 <tr><td><span style="color:#9b9b9b;"><?php echo $my_width;?></span></td><td><span style="color:#414141;"><?php echo $products[$i]['width']; ?> cm </span></td></tr>
												 <tr><td style="background-color:#ececec;"><span style="color:#9b9b9b;"><?php echo $my_height;?></span></td><td style="background-color:#ececec;"><span style="color:#414141;"><?php echo $products[$i]['height']; ?> cm</span></td></tr>
												 <tr><td><span style="color:#9b9b9b;"><?php echo $my_resolution;?></span></td><td><span style="color:#414141;"><?php echo $products[$i]['model']; ?></span></td></tr>
												 <tr><td style="background-color:#ececec;"><span style="color:#9b9b9b;"><?php echo $my_color;?></span></td><td style="background-color:#ececec;"><span style="color:#414141;"><?php echo strip_tags(html_entity_decode($products[$i]['description'])); ?></span></td></tr>
											 
											 </table>
											 </div>	
											 </td></tr></table>
										 
 									</div>		
								</div>
							</div>
							<p class="smallDescription"><?php echo $products[$i]['name']; ?></p>
							<div id="movers-row">
								<div><a href="#1" class="cross-link1"><img src="<?php echo $products[$i]['thumb']; ?>" style="height:50px;" class="nav-thumb" alt="temp-thumb" /></a></div>
								<div><a href="#2" class="cross-link2"><img src="catalog/view/theme/default/img/t_1.jpg" class="nav-thumb" alt="temp-thumb" /></a></div>
							</div>
						</div>
					</div>
	
				 <?php } ?> 	 
				</div>
			</div>
			<?php }  ?> 
  

  <!--  div class="middle"> 
   
  
     <?php if (isset($products)) { ?>
    <div class="sort">
      <div class="div1">
        <select name="sort" onchange="location = this.value">
          <?php foreach ($sorts as $sorts) { ?>
          <?php if (($sort . '-' . $order) == $sorts['value']) { ?>
          <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
          <?php } else { ?>
          <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
          <?php } ?>
          <?php } ?>
        </select>
      </div>
      <div class="div2"><?php echo $text_sort; ?></div>
    </div>
    <table class="list">
      <?php for ($i = 0; $i < sizeof($products); $i = $i + 4) { ?>
      <tr>
        <?php for ($j = $i; $j < ($i + 4); $j++) { ?>
        <td width="25%"><?php if (isset($products[$j])) { ?>
          <a href="<?php echo $products[$j]['href']; ?>"><img src="<?php echo $products[$j]['thumb']; ?>" title="<?php echo $products[$j]['name']; ?>" alt="<?php echo $products[$j]['name']; ?>" /></a><br />
          <a href="<?php echo $products[$j]['href']; ?>"><?php echo $products[$j]['name']; ?></a><br />
          <span style="color: #999; font-size: 11px;"><?php echo $products[$j]['model']; ?></span><br />
          <?php if ($display_price) { ?>
          <?php if (!$products[$j]['special']) { ?>
          <span style="color: #900; font-weight: bold;"><?php echo $products[$j]['price']; ?></span>
          <?php } else { ?>
          <span style="color: #900; font-weight: bold; text-decoration: line-through;"><?php echo $products[$j]['price']; ?></span> <span style="color: #F00;"><?php echo $products[$j]['special']; ?></span>
          <?php } ?>
		  <a class="button_add_small" href="<?php echo $products[$j]['add']; ?>" title="<?php echo $button_add_to_cart; ?>" >&nbsp;</a>
          <?php } ?>
          <br />
          <?php if ($products[$j]['rating']) { ?>
          <img src="catalog/view/theme/default/image/stars_<?php echo $products[$j]['rating'] . '.png'; ?>" alt="<?php echo $products[$j]['stars']; ?>" />
          <?php } ?>
          <?php } ?></td>
        <?php } ?>
      </tr>
      <?php } ?>
    </table>
    <div class="pagination"><?php echo $pagination; ?></div>
    <?php } else { ?>
    <div style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 10px; margin-top: 3px; margin-bottom: 15px;"><?php echo $text_empty; ?></div>
    <?php }?>
  </div>
  <div class="bottom">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
  </div>
</div  -->


<script type="text/javascript"><!--

$(document).ready(function() {
 
 		var search_cat = 1;
		$("#category_id").change(function() {
		    //alert($(this).find("option:selected").attr("rel"));
		});
 });

function changeCategory(drop){

    
    $('.search_results').html('');
    $('.search_results').css('display','none');
    
    $('.paginator').html('');

 
    var options = '';
    options += '<option value="0"><?php echo $my_year;?></option>';

	var category_id = $(drop).find("option:selected").attr('value');

	var start_year = 2020;
	var end_year   = 1950;
	
    if (category_id  == 40){
    	start_year =  '<?php echo $start_year40; ?>';
        end_year   =  '<?php echo $end_year40; ?>';	
    }

    if (category_id  == 41){
    	start_year =  '<?php echo $start_year41; ?>';
        end_year   =  '<?php echo $end_year41; ?>';	
    }
    if (category_id  == 42){
    	start_year =  '<?php echo $start_year42; ?>';
        end_year   =  '<?php echo $end_year42; ?>';	
    }
    if (category_id  == 43){
    	start_year =  '<?php echo $start_year43; ?>';
        end_year   =  '<?php echo $end_year43; ?>';	
    }
    
 
        
    for (var i = end_year; i <= start_year; i++ ) {
        options += '<option value="' + i + '">' + i + '</option>';
    }

      $("select#jahr").html(options);    
   
    
    var parent_id = $(drop).find("option:selected").attr("rel");
    

    if ( parent_id == '36') {$('#c36').css('display','block');$('#c37').css('display','none'); search_cat = 1;}
    if ( parent_id == '37') {$('#c36').css('display','none');$('#c37').css('display','block'); search_cat = 2;}
    
    
   	$('#inp20').attr('value', '');
	$('#inp200').attr('value', '');	
	$('#inp21').attr('value', '');;
	$('#inp22').attr('value', '');
    
   // console.log($("#tag option[value='0']").text());
    $("#tag option[value='0']").attr('selected', 'selected');
    $("#monat option[value='0']").attr('selected', 'selected');
    $("#jahr option[value='0']").attr('selected', 'selected');
    
    //$.jNice.SelectUpdate($("#tag"));
    //$.jNice.SelectUpdate($("#monat"));
    //$.jNice.SelectUpdate($("#jahr"));
    
    return false;
 
}

function changePerPage(perpage){
   
	  var perpage1 = $(perpage).find("option:selected").val();
	  $('#perpage').val(perpage1);	  
	  contentSearch();
  
}


$('.ser_inps input').keydown(function(e) {
	if (e.keyCode == 13) {
		contentSearch();
	}
});

function contentSearch() {
	url = 'index.php?route=product/search';
	
	
  var parent_id = $('#category_id').find("option:selected").attr("rel");

  if ( parent_id == '36') {$('#c36').css('display','block');$('#c37').css('display','none'); search_cat = 1;}
  if ( parent_id == '37') {$('#c36').css('display','none');$('#c37').css('display','block'); search_cat = 2;} 
  
  
 
	var category_id = $('#category_id').attr('value');
	var parent_id = $('#category_id').find("option:selected").attr("rel");
	var perpage = $('#perpage').val();
	
	/**--for first categories items-****/
	
	var titel  = $('#inp20').attr('value');
	var titel2  = $('#inp200').attr('value');
	
	var wv_cr_nr = $('#inp21').attr('value');
	var jahr = $('#inp22').attr('value');
	var first_cat = '0';
	
	if (titel != '') {
		url += '&titel=' + encodeURIComponent(titel);
				
	}
	if (titel2 != '') {
		url += '&titel2=' + encodeURIComponent(titel2);
				
	}
		
	if (wv_cr_nr) {
		url += '&wv_cr_nr=' + encodeURIComponent(wv_cr_nr);
		
	}
	
	if (jahr) {
		url += '&jahr_t=' + encodeURIComponent(jahr);
		
	}
	
	/**--for second categories items-****/
	
	var tag  = $('#tag').attr('value');
	var monat = $('#monat').attr('value');
	var jahr = $('#jahr').attr('value');
	
	
	
	if (tag != 0) {
		url += '&tag=' + encodeURIComponent(tag);
		
	}
	
	if (monat != 0) {
		url += '&monat=' + encodeURIComponent(monat);
		
	}
	
	if (jahr != 0) {
		url += '&jahr=' + encodeURIComponent(jahr);
		
	}
	/***-----------------------***********/
	url += '&perpage=' + perpage + '&search_cat=' + encodeURIComponent(search_cat);
	
	if (category_id) {
		url += '&category_id=' + encodeURIComponent(category_id);
	}
	if (parent_id) {
		url += '&parent_id=' + encodeURIComponent(parent_id);
	}
		
	if ($('#description').attr('checked')) {
		url += '&description=1';
	}
	
	if ($('#model').attr('checked')) {
		url += '&model=1';
	}
	
 
	location = url;
	return false;
}
//--></script>
<?php echo $footer; ?> 