{extends file="layout.tpl"}
{block name=title}Wolframhart Associates - Admin Control Panel{/block}
{literal} 
<script type="application/javascript">
$(document).ready(function(){
	$('#frmAddNewJob').submit(function(e){
						   
			e.preventDefault();
			$.ajax({
			type: 'post',
			url: 'addJobs.php',
			data: {jobTitle: $('#jobTitle').val(), jobDescription: $('#jobDescription').val(), specialization: $('#specialization').val(),
			subSpecialization: $('#subSpecialization').val(), location: $('#location').val(), salary: $('#salary').val()},
			dataType: 'json',
			success: function(response){
				checkResponseRedirect(response);
				if(response.success){
					jQuery.facebox(response.message, 'popupMessage');
				} else {
					showPopup(response.message);
				}
			}
		})
		return false;
	})
})
</script>
{literal} 
{block name=head}

{/block}
{block name=content}

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
{/block}