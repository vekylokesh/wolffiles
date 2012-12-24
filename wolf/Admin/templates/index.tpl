{extends file="base.tpl"}
{block name=title}Wolframhart Associates - Admin Control Panel{/block}
{block name=head}
{/block}
{block name=content}

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_box">
								
                                  <tr>
                                    <td align="center" class="body_title">Admin login</td>
                                  </tr>
                                  <tr>
                                    <td class="body_content">
                     
                                   <form name="frmLogin" id="frmLogin" method="post" action="">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="20%" class="form_row1">&nbsp;</td>
                                          <td width="3%" align="left" class="form_row1">&nbsp;</td>
                                          <td width="77%" align="right" class="form_row1"> &nbsp;</td>
                                        </tr>
                                        
                                        <tr>
                                          <td class="form_row1"><b class="red">*</b> User Name</td>
                                          <td align="left" class="form_row1">:</td>
                                          <td align="left" class="form_row1">
                             <input name="userName" id="userName" title="User Name" class="validate[required] text-input text_box1" type="text" /> 
                                          </td>
                                        </tr>
                                        
                                        <tr>
                                          <td class="form_row1"><b class="red">*</b>Password</td>
                                          <td align="left" class="form_row1">:</td>
                                          <td align="left" class="form_row1">
                  <input name="userPassword" id="userPassword" title="Password" class="validate[required] text-input text_box1" type="password" />
                  							</td>
                                        </tr>
                                        
                                        <tr>
                                          <td class="form_row1">&nbsp;</td>
                                          <td align="left" class="form_row1">&nbsp;</td>
                                          <td align="left" class="form_row1"><input name="login" id="login" value="Login" class="bttn_submit" type="submit" />
                                            &nbsp;
                                           </td>
                                        </tr>
                                        
                                        <tr>
                                          <td class="form_row1">&nbsp;</td>
                                          <td align="left" class="form_row1">&nbsp;</td>
                                          <td align="left" class="form_row1">&nbsp;</td>
                                        </tr>
                                        
                                    </table>
                                    </form>
                                    </td>
                                  </tr>
                                </table>

{/block}