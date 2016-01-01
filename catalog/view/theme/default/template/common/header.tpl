<?php if (isset($_SERVER['HTTP_USER_AGENT']) && !strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6')) echo '<?xml version="1.0" encoding="UTF-8"?>'."\n";?>  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" xml:lang="<?php echo $lang; ?>">
    <head>
        <title><?php echo $title; ?></title>
        <?php if ($keywords) { ?>
        <meta name="keywords" content="<?php echo $keywords; ?>" />
        <?php } ?>
        <?php if ($description) { ?>
        <meta name="description" content="<?php echo $description; ?>" />
        <?php } ?>
        <base href="<?php echo $base; ?>" /><?php if ($icon) { ?>
        <link href="<?php echo $icon; ?>" rel="icon" />
        <?php } ?>
        <?php foreach ($links as $link) { ?>
        <link href="<?php echo str_replace('&', '&amp;', $link['href']); ?>" rel="<?php echo $link['rel']; ?>" />
        <?php } ?>
        <link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $template; ?>/stylesheet/style.css" media="screen" />

        <link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $template; ?>/stylesheet/style_slider.css" />
        <link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $template; ?>/stylesheet/jquery.bubblepopup.v2.3.1.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $template; ?>/stylesheet/jqModal.css" media="screen" />


        <?php foreach ($styles as $style) { ?>
        <link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
        <?php } ?>



        <link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $template; ?>/stylesheet/jquery.bubblepopup.v2.3.1.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $template; ?>/stylesheet/base/jquery-ui.css" media="screen" />

        <script type="text/javascript" src="catalog/view/javascript/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="catalog/view/javascript/jquery-ui-1.8.24.min.js"></script>

    
        <script type="text/javascript" src="catalog/view/javascript/jquery.bubblepopup.v2.3.1.min.js"></script>
        <script type="text/javascript" src="catalog/view/javascript/jquery.selectboxes.js"></script>
        <? /* ?>
        <script type="text/javascript" src="catalog/view/javascript/sortable.js"></script>
        <? */ ?>

        <script type="text/javascript" src="catalog/view/javascript/jquery-easing-1.3.pack.js"></script>
        <script type="text/javascript" src="catalog/view/javascript/jquery-easing-compatibility.1.2.pack.js"></script>
        <script type="text/javascript" src="catalog/view/javascript/coda-slider.1.1.1.pack.js"></script>

        <script type="text/javascript" src="catalog/view/javascript/jqModal.js"></script>

        <?php foreach ($scripts as $script) { ?>
        <script type="text/javascript" src="<?php echo $script; ?>">
        </script>
        <?php } ?>

        <script type="text/javascript">
            function getWidth() {
                var myWidth = 0;
                myWidth = document.getElementById("wrapper").clientWidth;
                return myWidth;
            }
            ;
            function getWindowWidth() {
                var winW = 0;
                if (parseInt(navigator.appVersion) > 3) {
                    if (navigator.appName == "Netscape") {
                        winW = window.innerWidth;
                    }
                    if (navigator.appName.indexOf("Microsoft") != -1) {
                        winW = document.body.offsetWidth;
                    }
                }
                return winW;

            }
            function scrollToCenter() {
                var width = getWidth();
                var windowWidth = getWindowWidth();
// alert(width);
// alert(windowWidth);
                window.scroll((width - windowWidth) / 2, 0);
            }


            function add_to_cart_all(id, mdl) {
                var dataString = 'product_id=' + id + '&quantity=1';
                var url = $('#url_' + id).val()
                if ($('#options_' + id).val() > 0) {
                    $(location).attr('href', url);
                    return;
                }
                $.ajax({
                    type: 'post',
                    url: 'index.php?route=module/cart/callback',
                    data: dataString,
                    success: function (html) {

                        if (html != '') {
                            $('#quantity_1').html(html);
                            alert('<? echo $text_added; ?>');
                        } else {
                            alert('<? echo $text_already; ?>');

                        }
                        return false;
                    },
                    complete: function () {

                    }
                });
            }

            $(document).ready(function () {


                $('.confirmdialogopener').click(function (e) {
                    e.preventDefault();
                    var url = $(this).attr('rel');
                    var $myDialog = $('#confirmdialog').dialog({
                        autoOpen: false,
                        modal: true,
                        resizable: false,
                        dialogClass: 'noTitleStuff',
                        buttons: {
                            "nein": function () {
                                $(this).dialog("close");
                                
                            },
                            "ja": function () {
                                window.location.href = url;
                                $(this).dialog("close");
                                 
                            }
                        }
                    });
                    var buttontext = $(this).attr('alt');
                    $('#confirmtext').html(buttontext);
                    $myDialog.dialog('open'); //replace the div id with the id of the button/form
                });
                
                $('.confirmdialogopener_angebot').click(function (e) {
                    e.preventDefault();
                    var id = $(this).attr('rel');
                    var $myDialog = $('#confirmdialog').dialog({
                        autoOpen: false,
                        modal: true,
                        resizable: false,
                        dialogClass: 'noTitleStuff',
                        buttons: {
                            "nein": function () {
                                $(this).dialog("close");
                                
                            },
                            "ja": function () {
                                $(id).submit();
                                $(this).dialog("close");
                                 
                            }
                        }
                    });
                    var buttontext = $(this).attr('alt');
                    $('#confirmtext').html(buttontext);
                    $myDialog.dialog('open'); //replace the div id with the id of the button/form
                });
            });

        </script>


    </head>
    <body >
        
        <div id="wrapper">
            <div id="header">
                <!-- div class="div1">
                <div class="div2">
                <?php if ($logo) { ?>
                <a href="<?php echo str_replace('&', '&amp;', $home); ?>"><img src="<?php echo $logo; ?>" title="<?php echo $store; ?>" alt="<?php echo $store; ?>" /></a>
                <?php } ?>
                </div>
                <div class="div3">
                <a href="<?php echo str_replace('&', '&amp;', $special); ?>" style="background-image: url('catalog/view/theme/default/image/special.png');"><?php echo $text_special; ?></a>
                <a onclick="bookmark(document.location, '<?php echo addslashes($title); ?>');" style="background-image: url('catalog/view/theme/default/image/bookmark.png');"><?php echo $text_bookmark; ?></a>
                <a href="<?php echo str_replace('&', '&amp;', $contact); ?>" style="background-image: url('catalog/view/theme/default/image/contact.png');"><?php echo $text_contact; ?></a>
                <a href="<?php echo str_replace('&', '&amp;', $sitemap); ?>" style="background-image: url('catalog/view/theme/default/image/sitemap.png');"><?php echo $text_sitemap; ?></a>
                </div>
                <div class="div4">
                <a href="<?php echo str_replace('&', '&amp;', $home); ?>" id="tab_home"><?php echo $text_home; ?></a>
                <?php if (!$logged) { ?>
                <a href="<?php echo str_replace('&', '&amp;', $login); ?>" id="tab_login"><?php echo $text_login; ?></a>
                <?php } else { ?>
                <a href="<?php echo str_replace('&', '&amp;', $logout); ?>" id="tab_logout"><?php echo $text_logout; ?></a>
                <?php } ?>
                <a href="<?php echo str_replace('&', '&amp;', $account); ?>" id="tab_account"><?php echo $text_account; ?></a>
                <a href="<?php echo str_replace('&', '&amp;', $cart); ?>" id="tab_cart"><?php echo $text_cart; ?></a>
                <a href="<?php echo str_replace('&', '&amp;', $checkout); ?>" id="tab_checkout"><?php echo $text_checkout; ?></a>
                </div>
                <div class="div5">
                <div class="left">
                </div>
                <div class="right">
                </div>
                <div class="center">
                <div id="search">
                <div class="div8">
                <?php echo $entry_search; ?>&nbsp;
                </div>
                <div class="div9">
                <?php if ($keyword) { ?>
                <input type="text" value="<?php echo $keyword; ?>" id="filter_keyword" /><?php } else { ?>
                <input type="text" value="<?php echo $text_keyword; ?>" id="filter_keyword" onclick="this.value = '';" onkeydown="this.style.color = '#000000'" style="color: #999;"/><?php } ?>
                <select id="filter_category_id">
                <option value="0"><?php echo $text_category; ?></option>
                <?php foreach ($categories as $category) { ?>
                <?php if ($category['category_id'] == $category_id) { ?>
                <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                <?php } ?>
                <?php } ?>
                </select>
                </div>
                <div class="div10">
                &nbsp;&nbsp;<a onclick="moduleSearch();" class="button"><span><?php echo $button_go; ?></span></a>
                <a href="<?php echo str_replace('&', '&amp;', $advanced); ?>"><?php echo $text_advanced; ?></a>
                </div>
                </div>
                </div>
                </div>
                </div>
                <div class="div6">
                <div class="left">
                </div>
                <div class="right">
                </div>
                <div class="center">
                <?php if (isset($common_error)) { ?>
                <div class="warning">
                <?php echo $common_error; ?>
                </div>
                <?php } ?>
                <div id="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <?php echo $breadcrumb['separator']; ?><a href="<?php echo str_replace('&', '&amp;', $breadcrumb['href']); ?>"><?php echo $breadcrumb['text']; ?></a>
                <?php } ?>
                </div>
                <div class="div7">
                <?php if ($currencies) { ?>
                <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="currency_form">
                <div class="switcher">
                <?php foreach ($currencies as $currency) { ?>
                <?php if ($currency['code'] == $currency_code) { ?>
                <div class="selected">
                <a><?php echo $currency['title']; ?></a>
                </div>
                <?php } ?>
                <?php } ?>
                <div class="option">
                <?php foreach ($currencies as $currency) { ?>
                <a onclick="$('input[name=\'currency_code\']').attr('value', '<?php echo $currency['code']; ?>'); $('#currency_form').submit();"><?php echo $currency['title']; ?></a>
                <?php } ?>
                </div>
                </div>
                <div style="display: inline;">
                <input type="hidden" name="currency_code" value="" /><input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                </div>
                </form>
                <?php } ?>
                <?php if ($languages) { ?>
                <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="language_form">
                <div class="switcher">
                <?php foreach ($languages as $language) { ?>
                <?php if ($language['code'] == $language_code) { ?>
                <div class="selected">
                <a><img src="image/flags/<?php echo $language['image']; ?>" alt="<?php echo $language['name']; ?>" />&nbsp;&nbsp;<?php echo $language['name']; ?></a>
                </div>
                <?php } ?>
                <?php } ?>
                <div class="option">
                <?php foreach ($languages as $language) { ?>
                <a onclick="$('input[name=\'language_code\']').attr('value', '<?php echo $language['code']; ?>'); $('#language_form').submit();"><img src="image/flags/<?php echo $language['image']; ?>" alt="<?php echo $language['name']; ?>" />&nbsp;&nbsp;<?php echo $language['name']; ?></a>
                <?php } ?>
                </div>
                </div>
                <div>
                <input type="hidden" name="language_code" value="" /><input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                </div>
                </form>
                <?php } ?>
                </div>
                </div>
                </div -->

                <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="language_form">
                    <input type="hidden" name="language_code" value="" /><input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                </form>


                <a class="lang"  style="cursor:pointer;" onclick="$('input[name=\'language_code\']').attr('value', 'en');
                        $('#language_form').submit();">English</a>
                <span>&nbsp;|&nbsp;</span>
                <a class="lang"  style="cursor:pointer;" onclick="$('input[name=\'language_code\']').attr('value', 'de-DE');
                        $('#language_form').submit();">Deutsch</a>


                <div class="hr_block">
                    <p>
                        <a href="/index.php?route=information/information&information_id=8"><? echo $impressum;?></a>
                    </p>

                    <div>
                        &copy; <?php echo $copyright;?> <? echo date('Y');?> - <?php echo $copyright2;?>
                    </div>


                    <?php if (!$logged) { ?>
                    <form id="login" action="/index.php?route=account/login" method="post" enctype="multipart/form-data">
                        <p>
                            <label for="inp1">
                                <? echo $user;?>
                            </label>
                            <input type="text" id="inp1" name="email"/>
                        </p><br><br>
                                <p>
                                    <label for="inp2">
                                        <? echo $password;?>
                                    </label>
                                    <input type="password" id="inp2" name="password" />
                                </p>
                                <p class="subm">
                                    <input value="" type="submit" />
                                </p>
                                </form>


                                <?}?>

                                </div><img class="logopic" src="catalog/view/theme/default/img/logo.jpg" /><a href="/" class="logo_fake"><img src="catalog/view/theme/<?php echo $template; ?>/img/logo_fake.png" /></a>
                                <?php if ( $logged && !$admin ) { ?>
                                <div class="user_block">
                                    <p>| <? echo $firstname; ?> | <? echo $ansprechpartner; ?> |</p>
                                    <p>| <a href="/index.php?route=checkout/cart" id="tab_checkout"><?php echo $text_Shopp;?></a> | 
                                        <a href="/index.php?route=account/history&preview=preview" class="tab_edit_account" ><?php echo $text_Konto;?></a> |
                                        <a href="/index.php?route=account/logout"><?php echo $text_logout;?></a> |</p>

                                    <a href="/index.php?route=checkout/cart" >
                                        <span id="quantity">						
                                            <span id="quantity_1" style="float: left; text-align: center; width: 20px;"><?php echo $countproducts; ?></span>
                                        </span>
                                    </a>

                                    <br><br>
                                            <img src="catalog/view/theme/default/img/paypal_pic.jpg" /> 

                                            </div>

                                            <?}?>
                                            <?php if ( $admin ) { ?>
                                            <div class="user_block">
                                                <p>| Atelier Gerhard Richter | Frau Konstanze Ell  |</p>
                                                <p>| <a href="/index.php?route=account/password" id="tab_admin_konto"><?php echo $text_Konto;?></a> | 
                                                    <a href="/index.php?route=account/logout"><?php echo $text_logout;?></a> |</p>

                                            </div>
                                            <?}?>

                                            </div>

                                            <table width=100% border=0 cellpadding=0 cellspacing=0 ><tr><td align=center valign=top style="background-color: #DDDDDC"><div id="content" class="minor_page"><?php if (!$logged && strpos($redirect, 'common/home') == false ) { ?>
                                                            <ul class="minor_menu">
                                                                <li>|  <a href="/index.php?route=information/information&information_id=6" class='tab_6'><?php echo $text_Anleitung;?></a></li>
                                                                <li> | <a href="/index.php?route=information/information&information_id=7" class='tab_7'><?php echo $text_Lize; ?></a></li>
                                                                <li> | <a href="/index.php?route=account/create" id='tab_register'><?php echo $text_Regis; ?></a></li>
                                                                <li> | <a href="/index.php?route=account/login" id='tab_login'><?php echo $text_login;?></a></li>
                                                                <li> | <a href="/index.php?route=information/contact" class="tab_contact"><?php echo $text_Contakt;?></a> | </li>
                                                            </ul>		
                                                            <?}?>
                                                            <?php if (!$admin && $logged && (strpos($redirect, 'account') == true || strpos($redirect, 'checkout') == true)) { ?>
                                                            <ul class="minor_menu">
                                                                  <li> | <a href="/index.php?route=account/history" id="tab_history"><?php echo $text_Pr_verwaltung;?></a></li>
                                                                <li> | <a href="/index.php?route=account/edit&preview=preview" class="tab_edit_account"><?php echo $text_editMyAccount;?></a></li>
                                  
                                                                <li> | <a href="/" class="tab_shop"><?php echo $text_Shop;?></a></li>
                                                                <li> | <a href="/index.php?route=information/contact" class="tab_contact"><?php echo $text_Contakt;?></a> | </li>
                                                            </ul>	
                                                            <?}elseif (!$admin && $logged && strpos($redirect, 'account') == false ) { ?>
                                                            <ul class="minor_menu">
                                                                <li> | <a href="/" class="tab_shop"><?php echo $text_Shop;?></a></li>
                                                                <li> | <a href="/index.php?route=information/information&information_id=6" class="tab_6"><?php echo $text_Anleitung;?></a></li>
                                                                <li> | <a href="/index.php?route=information/information&information_id=7" class="tab_7"><?php echo $text_Lize; ?></a></li>
                                                                <li> | <a href="/index.php?route=information/contact"  class="tab_contact"><?php echo $text_Contakt;?></a> | </li>
                                                            </ul>	
                                                            <?}elseif ( $admin ) {  ?>
                                                            <ul class="minor_menu"> 
                                                                <li> | <a href="/index.php?route=sale/customer" id="tab_customer"><?php echo $text_waltung;?></a></li>
                                                                <li> | <a href="/index.php?route=sale/order/anfragen" id="tab_anfragen"><?php echo $text_Anfragen;?></a></li>
                                                                <li> | <a href="/index.php?route=sale/order/projektarchiv" id="tab_projektarchiv"><?php echo $text_Pr_archiv;?></a></li>
                                                                <li> | <a href="/index.php?route=setting/setting" id="tab_setting"><?php echo $text_Abwesenheit;?></a> </li>
                                                                <?if ( $admin == 2) {?>	<li> | <a href="/index.php?route=common/importimages/upload" id="tab_import">Bilder aktualisieren</a> | </li> <?}?>

                                                            </ul>	
                                                            <?}?>		


                                                            <script type="text/javascript">
                                                                <!--
                                                                function getURLVar(urlVarName) {
                                                                    var urlHalves = String(document.location).toLowerCase().split('?');
                                                                    var urlVarValue = '';
                                                                    var urlVarPair = urlHalves[1].split('=');

                                                                    if (urlVarPair[2] == undefined)
                                                                        return urlVarPair[1];
                                                                    else
                                                                        return urlVarPair[1] + '=' + urlVarPair[2];

                                                                    if (urlHalves[1]) {
                                                                        var urlVars = urlHalves[1].split('&');

                                                                        for (var i = 0; i <= (urlVars.length); i++) {
                                                                            if (urlVars[i]) {
                                                                                var urlVarPair = urlVars[i].split('=');

                                                                                if (urlVarPair[0] && urlVarPair[0] == urlVarName.toLowerCase()) {
                                                                                    urlVarValue = urlVarPair[1];
                                                                                }
                                                                            }
                                                                        }
                                                                    }

                                                                    return urlVarValue;
                                                                }

                                                                $(document).ready(function () {
                                                                    route = getURLVar('route');
                                                                    if (!route) {
                                                                        $('#tab_home').addClass('active_item');
                                                                    }
                                                                    else {
                                                                        part = route.split('/');

                                                                        if (route == 'information/contact') {
                                                                            $('.tab_contact').addClass('active_item');
                                                                        }
                                                                        else
                                                                        if (route == 'account/login') {
                                                                            $('#tab_login').addClass('active_item');
                                                                        }
                                                                        else
                                                                        if (route == 'account/create') {
                                                                            $('#tab_register').addClass('active_item');
                                                                        }
                                                                        else
                                                                        if (route == 'information/information&information_id=7') {
                                                                            $('.tab_7').addClass('active_item');
                                                                        }
                                                                        else
                                                                        if (route == 'information/information&information_id=6') {
                                                                            $('.tab_6').addClass('active_item');
                                                                        }
                                                                        else
                                                                        if (route.search('product/search') != -1) {
                                                                            $('.tab_shop').addClass('active_item');
                                                                        }
                                                                        if (route.search('checkout/cart') != -1) {
                                                                            $('#tab_checkout').addClass('active_item');

                                                                        }
                                                                        else
                                                                        if (route.search('account/history') != -1) {
                                                                            $('#tab_history').addClass('active_item');
                                                                        }
                                                                        else
                                                                        if (route.search('account/edit') != -1) {
                                                                            $('.tab_edit_account').addClass('active_item');

                                                                        }
                                                                        else
                                                                        if (route == 'account/edit&preview=preview') {
                                                                            $('.tab_edit_account').addClass('active_item');

                                                                        }

                                                                        else
                                                                        if (route.search('sale/customer') != -1) {
                                                                            $('#tab_customer').addClass('active_item');
                                                                        }
                                                                        else
                                                                        if (route.search('sale/order/anfragen') != -1) {
                                                                            $('#tab_anfragen').addClass('active_item');
                                                                        } else
                                                                        if (route.search('sale/order/projektarchiv') != -1) {
                                                                            $('#tab_projektarchiv').addClass('active_item');
                                                                        } else
                                                                        if (route.search('setting/setting') != -1) {
                                                                            $('#tab_setting').addClass('active_item');
                                                                        } else
                                                                        if (route.search('account/password') != -1) {
                                                                            $('#tab_admin_konto').addClass('active_item');
                                                                        } else
                                                                        if (route.search('common/importimages/upload') != -1) {
                                                                            $('#tab_import').addClass('active_item');
                                                                        }


                                                                    }
                                                                });
                                                                //-->
                                                            </script>
                                                            <script type="text/javascript">
                                                                <!--
                                                                $('#search input').keydown(function (e) {
                                                                    if (e.keyCode == 13) {
                                                                        moduleSearch();
                                                                    }
                                                                });

                                                                function moduleSearch() {
                                                                    pathArray = location.pathname.split('/');

                                                                    url = location.protocol + "//" + location.host + "/" + pathArray[1] + '/';

                                                                    url += 'index.php?route=product/search';

                                                                    var filter_keyword = $('#filter_keyword').attr('value')

                                                                    if (filter_keyword) {
                                                                        url += '&keyword=' + encodeURIComponent(filter_keyword);
                                                                    }

                                                                    var filter_category_id = $('#filter_category_id').attr('value');

                                                                    if (filter_category_id) {
                                                                        url += '&category_id=' + filter_category_id;
                                                                    }

                                                                    location = url;
                                                                }

                                                                //-->
                                                            </script>
                                                            <script type="text/javascript">
                                                                <!--
                                                                $('.switcher').bind('click', function () {
                                                                    $(this).find('.option').slideToggle('fast');
                                                                });
                                                                $('.switcher').bind('mouseleave', function () {
                                                                    $(this).find('.option').slideUp('fast');
                                                                });
                                                                //-->
                                                            </script>
<div id="confirmdialog"><div id="confirmtext"></div></div>