{extends file="layout.tpl"}
{block name=title}Wolframhart Associates - Admin Control Panel{/block}
{block name=head}
{/block}
{block name=content}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
                           
                            <tr>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_box">
                                  <tr>
                                    <td align="left" class="body_title">Latest Jobs</td>
                                  </tr>
                                  <tr>
                                    <td class="body_content"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="5%" align="left" class="list_title">S.No</td>
                                          <td width="23%" align="left" class="list_title">Job Title</td>
                                          <td width="34%" align="left" class="list_title">Description</td>
                                          <td width="22%" align="left" class="list_title"> Date &amp; Time of Post</td>
                                          <td width="16%" align="center" class="list_title">Actions</td>
                                        </tr>
                                        
                                        {foreach from=$latestjobs key=k item=i}
                                        <tr class="list_row1">
                                          <td align="left">{$i.jb_id}</td>
                                          <td align="left">{$i.jb_title}</td>
                                          <td align="left">{$i.jb_description}</td>
                                          <td align="left">{$i.createdOn}</td>
                                          <td align="center"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image82','','{$smarty.const.ROOT_HTTP_PATH}/images/admin_images/bttn_suspend_hov.png',1)" title="Suspend"><img src="{$smarty.const.ROOT_HTTP_PATH}/images/admin_images/bttn_suspend.png" alt="Suspend" name="Image82" width="20" height="20" border="0" id="Image82" /></a> &nbsp; <a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image92','','{$smarty.const.ROOT_HTTP_PATH}/images/admin_images/bttn_edit_hov.png',1)" title="Edit"><img src="{$smarty.const.ROOT_HTTP_PATH}/images/admin_images/bttn_edit.png" alt="Edit" name="Image92" width="20" height="20" border="0" id="Image92" /></a> &nbsp; <a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('delete61','','{$smarty.const.ROOT_HTTP_PATH}/images/admin_images/bttn_delete_hov.png',1)" title="Delete"><img src="{$smarty.const.ROOT_HTTP_PATH}/images/admin_images/bttn_delete.png" alt="Delete" name="delete61" width="20" height="20" border="0" id="delete61" /></a></td>
                                        </tr>
                                        {/foreach}
                                                           
                                        
                                        
                                        <tr>
                                          <td colspan="5" align="left" class="pagination"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td width="37%" align="left">Record(s) 1 - 5 of 20</td>
                                                <td width="63%" align="right"><a href="#">View More</a></td>
                                              </tr>
                                            </table></td>
                                        </tr>
                                      </table></td>
                                  </tr>
                                </table></td>
                            </tr>
                            
                            
                          </table>
{/block}