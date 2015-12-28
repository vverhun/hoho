<?php echo $header; ?> 

<style>
.jNiceSelectWrapper {
  height:26px !important;
}

.jNiceCheckbox, .jNiceRadio  {
	margin: 0 10px 0 5px;
}


</style>
<script>
$(document).ready(function(){

		$('.process_button').click(function(){
 			 var errort = 0;
			$(".artdropdown").each(function(){
              if ( $(this).find("option:selected").val() == '0' ) {
			     alert('<? echo $required;?>');
				 errort = 1;
				 return false;
			  }
            });

 			$(".titelrequired").each(function(){
              if ( $(this).attr('value') == '' ) {
			     if ( errort == 0 )alert('<? echo $required;?>');
				 errort = 1;
				 return false;
			  }
            });

 			$(".komentarrequired").each(function(){
 	              if ( $(this).attr('value') == '' ) {
 				     if ( errort == 0 )alert('<? echo $required;?>');
 					 errort = 1;
 					 return false;
 				  }
 	            });
 			
						
			if ( errort == 0 ) {
			   $('#cart').submit();		
			}    
		})
})

function changeart(drop, pid){

	$("#auflage" + pid).css('display', 'block');
	$("#grosse" + pid).css('display', 'block');

	$("lastcomment").css('display','none');
	
	$( ".komentar" + pid ).removeClass('komentarrequired');

	$( ".komentar" + pid ).css('height', '30px');
	
    var parent_id = $(drop).find("option:selected").val();
	$( ".lastcomment" + pid ).css( 'display', 'none' );


	var html = $("#kommentartext" + pid).html();
	html = html.replace('*:', ':');
	$("#kommentartext" + pid).html(html);

	
    //fill in the auflage dropdown
    var myOptions1 = {
            "3 000" : "3 000",
            "5 000" : "5 000",
            "7 500" : "7 500",
            "10 000" : "10 000",
            "15 000" : "15 000",
            "20 000" : "20 000",
            "30 000" : "30 000",
            "50 000" : "50 000",
            "80 000" : "80 000",
            "<?echo $weitere;?> 10.000" : "<?echo $weitere;?> 10.000"
        }
    var myOptions2 = {
            "1 000" : "1 000",
            "2 000" : "2 000",
            "3 500" : "3 500",
            "5 000" : "5 000",
            "7 500" : "7 500",
            "10 000" : "10 000",
            "25 000" : "25 000",
            "50 000" : "50 000",
            "<?echo $weitere;?> 10.000" : "<?echo $weitere;?> 10.000"
        }
 
    var myOptions3 = {
            "2 000" : "2 000",
            "10 000" : "10 000",
            "20 000" : "20 000",
            "30 000" : "30 000",
            "50 000" : "50 000",
            "100 000" : "100 000",
            "175 000" : "175 000",
            "250 000" : "250 000",
            "500 000" : "500 000",
            "750 000" : "750 000",
            "1 000 000" : "1 000 000",
            "1 500 000" : "1 500 000",
            "2 000 000" : "2 000 000",
            "<?echo $weitere;?> 500.000" : "<?echo $weitere;?> 500.000"
        }
    
    var myOptions4 = {
            "2 000" : "2 000",
            "3 000" : "3 000",
            "5 000" : "5 000",
            "10 000" : "10 000",
            "30 000" : "30 000",
            "50 000" : "50 000",
            "100 000" : "100 000",
            "175 000" : "175 000",
            "250 000" : "250 000",
            "500 000" : "500 000",
            "750 000" : "750 000",
            "1 000 000" : "1 000 000",
            "<? echo $daruber; ?>" : "<? echo $daruber; ?>"
        }
       
 
    $('#auflage'+pid+' option').remove();
    if ( parent_id == '1' || parent_id == '2' || parent_id == '10' || parent_id == '11' || parent_id == '9' || parent_id == '3' || parent_id == '8') { 
	
	   // $("#auflage"+pid).addOption(myOptions1, false);
		      $.each(myOptions1, function(val, text) {
            $("#auflage"+pid).append( new Option(text,val) );
          });
    } 
    if ( parent_id == '4' || parent_id == '7'  ){  
	   //$("#auflage"+pid).addOption(myOptions2, false); 
		      $.each(myOptions2, function(val, text) {
            $("#auflage"+pid).append( new Option(text,val) );
          });
	
	}
    if ( parent_id == '5'  ){  
	   //$("#auflage"+pid).addOption(myOptions3, false); 
	   $.each(myOptions3, function(val, text) {
            $("#auflage"+pid).append( new Option(text,val) );
          });
		  
	}
    if ( parent_id == '6'  ){  
	   //$("#auflage"+pid).addOption(myOptions4, false); 
	     $.each(myOptions4, function(val, text) {
            $("#auflage"+pid).append( new Option(text,val) );
          });
		  
	   }

    if ( parent_id == '11' ){

    	$("#auflage" + pid).css('display', 'none');
    	$("#grosse" + pid).css('display', 'none');
    	var html = $("#kommentartext" + pid).html();
    	html = html.replace(':', '*:');
    	$("#kommentartext" + pid).html(html);

    	 

    	$( ".komentar" + pid ).addClass('komentarrequired');
    	
    	$( ".lastcomment" + pid ).css( 'display', 'block' );
    	$( ".komentar" + pid ).css('height', '152px');
    	
    }
    
    var element = $("#auflage"+pid);
    /*$.jNice.SelectUpdate($("#auflage"+pid));*/
    
    //fill in the grosse dropdown
    var myGrosse1 = {
            "1/8 <? echo $seite; ?>" : "1/8 <? echo $seite; ?>",
            "1/4 <? echo $seite; ?>" : "1/4 <? echo $seite; ?>",
            "1/2 <? echo $seite; ?>" : "1/2 <? echo $seite; ?>",            
            "1/1 <? echo $seite; ?>" : "1/1 <? echo $seite; ?>",  
            "2/1 <? echo $seite; ?>" : "2/1 <? echo $seite; ?>"
        }
    var myGrosse2 = {
            "<? echo $din; ?> A5" : "<? echo $din; ?> A5",
            "<? echo $din; ?> A4" : "<? echo $din; ?> A4",
            "<? echo $din; ?> A3" : "<? echo $din; ?> A3",
            "<? echo $gdin; ?> A3" : "<? echo $gdin; ?> A3"
        }
    
    var myGrosse3 = {
            "1/8 <? echo $seite; ?>" : "1/8 <? echo $seite; ?>",
            "1/4 <? echo $seite; ?>" : "1/4 <? echo $seite; ?>",
            "1/2 <? echo $seite; ?>" : "1/2 <? echo $seite; ?>",            
            "1/1 <? echo $seite; ?>" : "1/1 <? echo $seite; ?>"
        }

    $('#grosse'+pid+' option').remove();
    if ( parent_id == '1' || parent_id == '10' ||  parent_id == '11' || parent_id == '2' || parent_id == '9' || parent_id == '3' || parent_id == '5' ) { 
	     // $("#grosse"+pid).addOption(myGrosse1, false);
		  $.each(myGrosse1, function(val, text) {
            $("#grosse"+pid).append( new Option(text,val) );
          });


    } 
    if ( parent_id == '4' || parent_id == '7' || parent_id == '8' ){  

     	//$("#grosse"+pid).addOption(myGrosse2, false); 
         $.each(myGrosse2, function(val, text) {
            $("#grosse"+pid).append( new Option(text,val) );
          });
		  
	}
    if ( parent_id == '6'  ){  
	
       //$("#grosse"+pid).addOption(myGrosse3, false); 
	
	      $.each(myGrosse3, function(val, text) {
            $("#grosse"+pid).append( new Option(text,val) );
          });
		  
	}
 
    var element = $("#grosse"+pid);
   /* $.jNice.SelectUpdate($("#grosse"+pid));*/
    


    
    return false;
}
</script>

 
            <h1><?php echo $my_shopcart;?></h1>
 &nbsp;
  
 
    <form class="jNice" action="<?php echo str_replace('&amp;', '&', $checkout); ?>" method="post" enctype="multipart/form-data" id="cart">
      
     
        <?php $class = 'odd'; ?>
        <?php foreach ($products as $product) { ?>
       
        <h2>CR: <?php if ($product['sku'] != '-1')echo $product['sku'];  ?>, <?php echo $product['name'];?></h2>
        <table class="cart" style="float:left;margin-bottom: 7px;" width=100%>
        <tr>
          <td align="left" valign=center>
 
			  <a style="text-decoration:none;" href="/index.php?route=checkout/cart/removefromcart&remove=<?php echo $product['key']; ?>">
			    &nbsp;&nbsp;  <img src="catalog/view/theme/default/img/del.gif" />
			  </a>
			  
			  
          </td>
          <td align="center" valign="center" width="145px"> 
          	  <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /> 
          </td>
          <td align="left" valign="top"> 
             <div style='font-size:12px;'><input type="radio" name="radio<?php echo $product['product_id']; ?>" value="titel"/><?php echo $my_front_page;?>
             <input type="radio" name="radio<?php echo $product['product_id']; ?>" value="inner" checked=checked/><?php echo $my_inside;?> 
			 </div>
			 <br>
             <div style="width:243px">
	             <select class="artdropdown" title="<?php echo $my_publication;?>" id="art<?php echo $product['product_id']; ?>" name="art<?php echo $product['product_id']; ?>" OnChange="return changeart(this,'<?php echo $product['product_id']; ?>');" style="width:204px;z-index:14; margin-bottom:10px;">
	              	  <option value="0"><?php echo $my_publication;?></option>
		              <option value="1"><?php echo $my_book;?></option>
		              <option value="2"><?php echo $my_artCatalog;?></option>
		              <option value="9"><?php echo $auction_Catalog;?></option>
		              
		              <option value="3"><?php echo $my_broshur;?></option>
		              <option value="4"><?php echo $my_promotion;?></option>
		              <option value="5"><?php echo $my_jornal;?></option>
		              <option value="6"><?php echo $my_newspaper;?></option>
		              <option value="7"><?php echo $my_calendarr;?></option>
  		              <option value="10"><?php echo $my_advert;?></option>
  		              <option value="11"><?php echo $my_others;?></option>
  		              
		         </select> 
	             <div id="wrap_auflage">
	             <select title="<?php echo $my_1;?>" id="auflage<?php echo $product['product_id']; ?>" name="auflage<?php echo $product['product_id']; ?>"  style="width:204px;z-index:13; margin-bottom:10px;">
		              <option value="0"><?php echo $my_1;?></option>
		         </select> 
		         </div> 
		         <div id="wrap_grosse">
		         <select title="<?php echo $my_2;?>" id="grosse<?php echo $product['product_id']; ?>" name="grosse<?php echo $product['product_id']; ?>"  style="width:204px;z-index:12; margin-bottom:10px;">
		              <option value="0"><?php echo $my_2;?></option>
		         </select>
		         </div>
		         
		         <div class="lastcomment<?php echo $product['product_id']; ?>" style="  background-color: #EEEEEE;
    display: none;
    font-size: 11px;
    line-height: 15px;
    padding: 8px 0 8px 8px;
    position: relative;
    text-align: left;
    width: 195px;">
		             <?php echo $lastcomment; ?>
		         </div>
	         </div>	                 
          </td>
          <td valign="top" >
          <?php echo $my_title_poblication;?> <br>
          <input type=text class="titelrequired" name='titel<?php echo $product['product_id']; ?>' value='' style="width: 323px;"/><br>
          <span id='kommentartext<?php echo $product['product_id']; ?>'><?php echo $my_comment;?></span><br>
          <textarea class="komentar<?php echo $product['product_id']; ?>" name='komentar<?php echo $product['product_id']; ?>' rows=1  style="width: 333px;"></textarea>
          </td>
                  
        </tr>      </table>
        <?php } ?>

	 
      <div class="buttons" style="margin-top:4px;float:left;width:100%; border-top:1px solid #6d6d6d;">
        <table width=100%>
          <tr>
            <td align="center"><input type="button" class="continue_button" value="<?echo $my_einkauf;?>" onclick="location = '<?php echo str_replace('&amp;', '&', $continue); ?>'" ></td>
            <td align="right"><input type="button"  class="process_button"  value="<?echo $my_anfragen;?>" ><span> </span></a></td>
          </tr>
        </table>
      </div>
    </form>
   
  
 
<?php echo $footer; ?> 