<?php /* Smarty version Smarty-3.1.12, created on 2012-12-24 01:48:55
         compiled from "D:\xampp\htdocs\wolframhart\Admin\templates\addJobs.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2204150d763d476f5f5-59863976%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e1c6455bee0894996e7a950fa2c7879def5f1042' => 
    array (
      0 => 'D:\\xampp\\htdocs\\wolframhart\\Admin\\templates\\addJobs.tpl',
      1 => 1356310084,
      2 => 'file',
    ),
    '924c5a176e2087c5425b0a767ef0dc110f20bce2' => 
    array (
      0 => 'D:\\xampp\\htdocs\\wolframhart\\Admin\\templates\\layout.tpl',
      1 => 1356309259,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2204150d763d476f5f5-59863976',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_50d763d491da68_14673048',
  'variables' => 
  array (
    'loginSuccess' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50d763d491da68_14673048')) {function content_50d763d491da68_14673048($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Wolframhart Associates - Admin Control Panel</title>
<link href="<?php echo @ROOT_HTTP_PATH;?>
/css/style_admin.css" rel="stylesheet" type="text/css" />
<link href="<?php echo @ROOT_HTTP_PATH;?>
/css/js_effect.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo @ROOT_HTTP_PATH;?>
/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo @ROOT_HTTP_PATH;?>
/js/core.js"></script>
<script type="text/javascript" src="<?php echo @ROOT_HTTP_PATH;?>
/js/jquery.easing-sooper.js"></script>
<script type="text/javascript" src="<?php echo @ROOT_HTTP_PATH;?>
/js/jquery.sooperfish.js"></script>
<link rel="stylesheet" href="<?php echo @ROOT_HTTP_PATH;?>
/css/validationEngine.jquery.css" type="text/css"/>
<script src="<?php echo @ROOT_HTTP_PATH;?>
/js/languages/jquery.validationEngine-en.js" type="text/javascript"></script>
<script src="<?php echo @ROOT_HTTP_PATH;?>
/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript" src="<?php echo @ROOT_HTTP_PATH;?>
/js/tiny_mce/tiny_mce.js"></script>
 

<script type="text/javascript">
	// O2k7 skin
	tinyMCE.init({
		// General options
		mode : "exact",
		elements : "jobDescription",
		theme : "advanced",
		skin : "o2k7",
		plugins : "lists,pagebreak,style,layer,save,advhr,advimage,advlink,iespell,insertdatetime,preview,media,searchreplace,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	

	});
</script>

<script type="text/javascript">
    $(document).ready(function() {
							   
	$("#frmLogin").validationEngine();
	//$("#frmAddNewJob").validationEngine();
		
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
 



</head>
<body onload="MM_preloadImages('<?php echo @ROOT_HTTP_PATH;?>
/images/admin_images/bttn_logout_hov.gif','<?php echo @ROOT_HTTP_PATH;?>
/images/admin_images/bttn_edit_hov.png','<?php echo @ROOT_HTTP_PATH;?>
/images/admin_images/bttn_delete_hov.png','<?php echo @ROOT_HTTP_PATH;?>
/images/admin_images/bttn_suspend_hov.png','<?php echo @ROOT_HTTP_PATH;?>
/images/admin_images/bttn_view.png')">
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
                              <td width="19%" align="left"><a href="index.html"><img src="<?php echo @ROOT_HTTP_PATH;?>
/images/admin_images/logo.png" alt="" width="167" height="72" border="0" /></a></td>
                              <td width="81%" align="right" class="admin_title">&nbsp;</td>
                            </tr>
                          </table></td>
                      </tr>
                      <tr>
                        <td class="admin_bdr"><table width="1000" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="10" align="left" valign="top"><img src="<?php echo @ROOT_HTTP_PATH;?>
/images/admin_images/topnav_left.gif" alt="" width="10" height="39" /></td>
                              <td width="980" class="topnav_bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="91%"><ul class="sf-menu" id="nav">
                                        <li class="first"> <a href="index.html"><span>Dashboard</span></a></li>
                                        <li> <a href="search_option.html"><span>Search Management</span></a>
                                          <ul>
                                            <li> <a href="search_option.html">Main Search Options</a></li>
                                            <li> <a href="addJobs.php">Add New Job</a></li>
                                            <li> <a href="view_job_list.html">View Jobs List</a></li>
                                          </ul>
                                        </li>
                                        <li> <a href="add_content_page.html"><span>Content Management</span></a>
                                          <ul>
                                            <li> <a href="add_content_page.html">Add Content Page</a></li>
                                            <li> <a href="view_content_page.html">View Content Pages</a></li>
                                            <li> <a href="view_latest_job.html">Manage Latest Jobs</a></li>
                                          </ul>
                                        </li>
                                        <li><a href="news_events.html"><span>Other Management</span></a>
                                          <ul>
                                            <li> <a href="news_events.html">News &amp; Events</a></li>
                                          </ul>
                                        </li>
                                        <li class="last"> <a href="#"><span>Settings</span></a>
                                          <ul>
                                            <li> <a href="ch_password.html">Change Password</a></li>
                                          </ul>
                                        </li>
                                      </ul></td>
                                    <td width="9%" align="right">
                                    <?php if (!$_smarty_tpl->tpl_vars['loginSuccess']->value){?><a href="<?php echo @ROOT_HTTP_PATH;?>
/admin/logout.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('logout','','<?php echo @ROOT_HTTP_PATH;?>
/images/admin_images/bttn_logout_hov.gif',1)"><img src="<?php echo @ROOT_HTTP_PATH;?>
/images/admin_images/bttn_logout.gif" alt="Log Out" name="logout" width="77" height="22" border="0" id="logout" /></a>
                                    <?php }?></td>
                                  </tr>
                                </table></td>
                              <td width="10" align="right" valign="top"><img src="<?php echo @ROOT_HTTP_PATH;?>
/images/admin_images/topnav_right.gif" alt="" width="10" height="39" /></td>
                            </tr> 
                          </table></td>
                      </tr>
                    </table></td>
                </tr> 
                <tr>
                  <td class="admin_bdr"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="admin_body">
                            
                            

 <form name="frmAddNewJob" id="frmAddNewJob" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_box">
                                  <tr>
                                    <td align="left" class="body_title">Add New Job</td>
                                  </tr>
                                  <tr>
                                    <td class="body_content">
                                                         <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="20%" class="form_row1">&nbsp;</td>
                                          <td width="3%" align="left" class="form_row1">&nbsp;</td>
                                          <td width="77%" align="right" class="form_row1"><b class="red">*</b> = mandatory fields</td>
                                        </tr>
                                        
                                        <tr>
                                          <td class="form_row1"><b class="red">*</b> Job Title</td>
                                          <td align="left" class="form_row1">&nbsp;</td>
                                          <td align="left" class="form_row1">
             <input name="jobTitle" type="text" class="validate[required] text-input text_box1" id="jobTitle" title="Job Title" /></td>
                                        </tr>
                                        
                                        <tr>
                                          <td class="form_row1"><b class="red">*</b> Job Description</td>
                                          <td align="left" class="form_row1">:</td>
                                          <td align="left" class="form_row1">
                                          <textarea id="jobDescription" name="jobDescription" rows="10" cols="60" style="width: 90%" title="Job Description" class="validate[required] text-input  form_txtarea2">
         </textarea> </td>
                                        </tr>
                                        
                                        <tr>
                                          <td class="form_row1"><b class="red">*</b> Specialization</td>
                                          <td align="left" class="form_row1">:</td>
                                          <td align="left" class="form_row1">
              <input name="specialization" type="text" class="validate[required] text-input text_box1" id="specialization" title="Specialization" /></td>
                                        </tr>
                                        <tr>
                                          <td class="form_row1"><b class="red">*</b> Sub Speacialization</td>
                                          <td align="left" class="form_row1">:</td>
                                          <td align="left" class="form_row1">
          <input name="subSpecialization" type="text" class="validate[required] text-input text_box1" id="subSpecialization" title="Sub Speacialization" />
          </td>
                                        </tr>
                                        <tr>
                                          <td class="form_row1"><b class="red">*</b> Location</td>
                                          <td align="left" class="form_row1">:</td>
                                          <td align="left" class="form_row1">
           <input name="location" type="text" class="validate[required] text-input text_box1" id="location" title="Locations" /></td>
                                        </tr>
                                        <tr>
                                          <td class="form_row1"><b class="red">*</b> Salary</td>
                                          <td align="left" class="form_row1">:</td>
                                          <td align="left" class="form_row1">
         <input name="salary" title="Salary" type="text" class="validate[required] text-input text_box1" id="salary" /></td>
                                        </tr>
                                        
                                        
                                        <tr>
                                          <td class="form_row1">&nbsp;</td>
                                          <td align="left" class="form_row1">&nbsp;</td>
                                          <td align="left" class="form_row1"><input type="submit" name="submit" id="submit" value="Submit" class="bttn_submit" />
                                            &nbsp;
                                            <input type="reset" name="button2" id="button2" value="Cancel" class="bttn_submit" /></td>
                                        </tr>
                                    </table>

                                    </td>
                                  </tr>
                                </table>
                     </form>

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
<?php }} ?>