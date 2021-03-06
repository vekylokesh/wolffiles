<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{block name=title} Wolframhart Associates - Admin Control Panel{/block}</title>
<link href="{$smarty.const.ROOT_HTTP_PATH}/css/style_admin.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.ROOT_HTTP_PATH}/css/js_effect.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{$smarty.const.ROOT_HTTP_PATH}/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="{$smarty.const.ROOT_HTTP_PATH}/js/core.js"></script>
<script type="text/javascript" src="{$smarty.const.ROOT_HTTP_PATH}/js/jquery.easing-sooper.js"></script>
<script type="text/javascript" src="{$smarty.const.ROOT_HTTP_PATH}/js/jquery.sooperfish.js"></script>
<link rel="stylesheet" href="{$smarty.const.ROOT_HTTP_PATH}/css/validationEngine.jquery.css" type="text/css"/>
<script src="{$smarty.const.ROOT_HTTP_PATH}/js/languages/jquery.validationEngine-en.js" type="text/javascript"></script>
<script src="{$smarty.const.ROOT_HTTP_PATH}/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    $(document).ready(function() {
    });
    </script>
{literal} 
<script type="text/javascript">
    $(document).ready(function() {
							   
	$("#frmLogin").validationEngine();
		
      $('ul.sf-menu').sooperfish({
    dualColumn  : 20, //if a submenu has at least this many items it will be divided in 2 columns
    tripleColumn  : 50, //if a submenu has at least this many items it will be divided in 3 columns
    hoverClass  : 'sfHover',
    delay    : 500, //make sure menus only disappear when intended, 500ms is advised by Jacob Nielsen
    animationShow  :{height:'show',opacity:'show'},
    speedShow    : 350,
    easingShow      : 'easeOutTurbo',
    animationHide  : {height:'hide',opacity:'hide'},
    speedHide    : 300,
    easingHide      : 'easeInTurbo',
    autoArrows  : false
      });
    });
    </script>
<script type="text/javascript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
{/literal} 
{block name=head}{/block}
</head>
<body onload="MM_preloadImages('{$smarty.const.ROOT_HTTP_PATH}/images/admin_images/bttn_logout_hov.gif','{$smarty.const.ROOT_HTTP_PATH}/images/admin_images/bttn_edit_hov.png','{$smarty.const.ROOT_HTTP_PATH}/images/admin_images/bttn_delete_hov.png','{$smarty.const.ROOT_HTTP_PATH}/images/admin_images/bttn_suspend_hov.png','{$smarty.const.ROOT_HTTP_PATH}/images/admin_images/bttn_view.png')">
<center>
  <div class="main_wrapper">
    <div class="in_wrapper">
      <div class="foot_wrapper">
        <table width="1000" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td valign="top" class="logo_pad"><table width="100%" border="0" cellspacing="0" cellpadding="0" >
                            <tr>
                              <td width="19%" align="left"><a href="index.html"><img src="{$smarty.const.ROOT_HTTP_PATH}/images/admin_images/logo.png" alt="" width="167" height="72" border="0" /></a></td>
                              <td width="81%" align="right" class="admin_title">&nbsp;</td>
                            </tr>
                          </table></td>
                      </tr>
                      <tr>
                        <td class="admin_bdr"><table width="1000" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="10" align="left" valign="top">&nbsp;</td>
                              
                            </tr> 
                          </table></td>
                      </tr>
                    </table></td>
                </tr> 
                <tr>
                  <td class="admin_bdr"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="admin_body">
                            
                            {block name=content} {/block}
                          </td>
                      </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="center" class="footer_bg"><table width="1000" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="footer"><span>Copyright &copy; 2012 Wolframhart Associates. All Rights Reserved.</span></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</center>
</body>
</html>
