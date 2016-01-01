<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>

<style>
    div.history h2 {
        padding: 5px 0 5px 16px !important;
    }

    .history {
        float: left;
        margin-bottom: 10px;
    }

    a.tab_edit_account {
        font-weight: normal !important;
        text-decoration: none !important;
    }

    div#wrapper div.minor_page h2 {
        width: 830px !important;
    }

    td {
        background-color: #EEEEEE;
        padding: 3px 0px 3px 0px;
    }

    td.stat {
        background-color: transparent;
        padding: 0px;
    }

    table.tabledetail td,table.tabledetail {
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




            if (trim($(this).html()) == '<?php echo $my_edit;?>' || trim($(this).html()) == '<?php echo $my_show;?>') {
                $(this).html('<?php echo $my_close;?>');
            }
            else
                $(this).html($(this).attr('name'));
            return false;
        });
    });
</script>


<h1><?php echo $my_prgect;?></h1>
<br>

<table style="float: left; margin: 5px 0px 5px 12px;" width=250px
       class="stat">
    <tr>
        <td class="stat"><b><?php echo $my_angared;?></b></td>
        <td class="stat" align=left><span style="color: red;"><? echo $orders_total1; ?></span>
        </td>
    </tr>
    <tr>
        <td class="stat"><a href="/index.php?route=account/history/angebote"><?php echo $my_offersStudio;?></a></td>
        <td class="stat" align=left><span style="color: blue;"><? echo $orders_total2; ?></span>
        </td>
    </tr>
    <tr>
        <td class="stat"><a href="/index.php?route=account/history/abgeschlossene"><?php echo $my_complatedProgect;?></a></td>
        <td class="stat" align=left><span style="color: green;"><? echo $orders_total3; ?></span>
        </td>
    </tr>
</table>


<br>

<h2 style="margin-bottom: 0 !important;"><?php echo $my_openProgect;?></h2>
<div class="history">
    <table width="846px" border=0 cellpadding=0 cellspacing=0>
        <tr>
            <td valign=center style="background-color: #DDDDDC;" width=80px
                align=left><b style='padding-left: 15px; float: left;'><?php echo $my_NO;?></b></td>
            <td valign=center width=170px style="background-color: #DDDDDC;"><b><?php echo $my_sentReqvest;?></b></td>
            <td valign=center style="background-color: #DDDDDC; width: 80px;"><b><?php echo $my_image;?></b></td>
            <td valign=center style="background-color: #DDDDDC;" width=170px><b><?php echo $my_getOffer;?></b></td>
            <td valign=center width=150px style="background-color: #DDDDDC;"><b><?php echo $my_Preis;?></b></td>
            <td valign=center style="background-color: #DDDDDC;"><b><?php echo $my_Status;?></b></td>
            <td style="background-color: #DDDDDC;"></td>
        </tr>
        <?php $index=0; foreach ($orders1 as $order) { $index++;?>

        <tr>
            <td><span style='padding-left: 15px; float: left;'>

                    <?php echo sprintf('%04d' , $index); ?>
                </span></td>
            <td><?php echo $order['date_added']; ?></td>
            <td width=80px><?php echo $order['products']; ?></td>
            <td><? if ( $order['order_status_id'] == '3'){ echo $order['date_modified']; }else { echo '...'; } ?></td>
            <td><? if ( $order['order_status_id'] == '3') { echo sprintf('%.2f',round($order['total'],2)); ?>
                &euro; <? } else{ echo '...'; }?></td>
            <td><?php echo $order['status']; ?></td>
            <td align=right><a style="margin-right: 10px;" href='#'
                               name='<? if ( $order['order_status_id'] == '3') { echo $my_edit; } else { echo $my_show; }  ?>'
                               class='showdetail' rel='proddetail<?php echo $order['order_id'];?>'>
                               <? if ( $order['order_status_id'] == '3') { echo $my_edit; } else { echo $my_show; }  ?>
            </a></td>
    </tr>
    <tr>
        <td colspan=8 style="padding: 0px;">
            <div style='display: none;' class="proddetailtoshow"
                 id='proddetail<?php echo $order['order_id'];?>'>

                 <?php foreach ($order['products_orders'] as $product) { ?>

                 <h2 style='background-color: white !important;'>CR: <?php echo $product['sku'];?>,
                    <?php echo $product['name'];?> <span
                        style="float: right; margin-right: 10px;"><? if ($product['status_id'] == 0 && $order['order_status_id'] == '3' ) echo $approved_text; ?></span>
                </h2>

                <table border=0 width=100%  style="float:left;margin-top:-7px;"><tr>
                        <td valign=top ><div style="line-height:22px;margin-left:30px;">
                                <br>
                                <b><?php if ( $product['titelseite'] == '1') echo $my_front_page; ?> <?php if ( $product['innenseite'] == '1') echo $my_inside; ?> </b>
                                <br><br>

                                <table border=0  cellpadding=0 cellspacing=0 width="100%"><tr><td valign=top style="width: 16%;padding: 0px;" >
                                            <b><?php echo $my_title;?></b></td><td  style="padding: 0px;text-align:left;"><?php echo $product['titel']; ?></td></tr>

                                    <tr><td  style="padding: 0px;"><b><?php echo $my_type;?></b></td><td  style="padding: 0px;"><?php echo $product['art']; ?></td></tr>
                                    <?php if ( $product['art_id'] != 11){ ?>
                                    <tr><td  style="padding: 0px;"><b><?php echo $my_rep;?></b></td><td  style="padding: 0px;"><?php echo $product['auflage']; ?></td></tr>
                                    <tr><td  style="padding: 0px;"><b><?php echo $my_size;?></b></td><td  style="padding: 0px;"><?php echo $product['grosse']; ?></td></tr>
                                    <?php } ?>
                                </table>
                                <?php if ($product['komentar'] != '') { ?>
                                <br><br>
                                <b><?php echo $my_comment;?></b> <br> <?php echo $product['komentar']; ?>  

                                <?php }?>

                            </div>                                                              
                        </td>
                        <td valign=top align=right   style="width:30%;padding-right:15px;background-color:white;">
                            <br>    <img style="margin-right: 62px;" src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" />  
                            <br><br><br><br><br>
                            <br><br><br>


                        </td>

                    </tr></table> 

                <?php } ?>    

                <div style="width:816px; text-align:right; background-color:#DDDDDC;float:left; padding:7px 30px 7px 0px;" >

                    <? echo $my_subtotal;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:red" id="subtotal<?php echo $order['order_id'];?>">

                    </span><br><br>
                    0% <? echo $my_tax;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="color:red" id="tax<?php echo $order['order_id'];?>">

                    </span>

                </div>
                <div style="width:816px; text-align:right; background-color:#bebebe;float:left; padding:7px 30px 7px 0px;" ><b style="margin-right: 27px;"><?php echo $my_totalAm;?></b> <span style="color:red" id="gemamtsumme<?php echo $order['order_id'];?>"></span></div>

            </div>

        </td>
    </tr>


    <?php } ?>

</table>
</div>
<br>
<br>

<?php echo $footer; ?>