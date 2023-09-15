<!----------------------------------------------------------------------------------------------------------------------------------------->
<?php $this->load->view('backend/header');?>
<body class="site-menubar-unfold site-menubar-keep">
		<!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
	<?php $this->load->view('backend/navbar');?>
	<?php $this->load->view('backend/sidebar');?> 
  <!-- Page -->
  <div class="page animsition">
    <div class="page-header">
			<ol class="breadcrumb">
        <li><a href="<?=base_url();?>backend">Dasbor</a></li>
        <li class="active">Level & Hak Akses</li>
      </ol>
      <h1 class="page-title">Level & Hak Akses</h1>
			 <div class="page-header-actions">
        <button class="btn btn-sm btn-icon btn-inverse" data-toggle="tooltip" <?=$RoleUserRoleUpdate;?>
        data-original-title="Atur Default" onclick="RoleSetDefault();">
          <i class="icon wb-replay" aria-hidden="true"></i>
        </button>
        <button type="button" class="btn btn-sm btn-icon btn-inverse" data-toggle="tooltip"
        data-original-title="Refresh" id="Refresh">
          <i class="icon wb-refresh" aria-hidden="true"></i>
        </button>        
      </div>
    </div>
    <div class="page-content">
			<div class="panel">			
				<div class="panel-body">	
					<?php if($role['RoleUserRoleView'] == 'yes'){ ;?>				
				
					<table id="MyTableNoAjax" class="table table-condensed table-striped table-hover">
						<thead>						
							<tr>
										<th>Hak Akses</th>
								<?php
									foreach($leveluser as $row){
										?>
											<th class="text-center"><?=$row->LevelUser;?></th>
										<?php
									}
								?>								
							</tr>
							<tr>	
										<th class="text-center">Pilih Semua</th>
									<?php
									foreach($leveluser as $row){
										?>
											<th class="text-center"><input type="checkbox" autocomplete="off"  id="<?=$row->LevelUser;?>" class="selectall tooltip-right uniformcheckbox" title="<?=$row->LevelUser;?>" name="<?=$row->LevelUser;?>" value="<?=$row->LevelUser;?>" <?=$this->role_model->CheckAttr($row->LevelUser);?> <?=$RoleUserRoleUpdate;?> /></th>
										<?php
									}
									?>								
								</tr>
						</thead>
						<tbody>
							<tr>
								<td><span class="label label-danger"> Berita </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="NewsView" name="NewsView" value="<?=$row->LevelUser;?>" title="<?=$row->NewsView;?>" <?=$this->role_model->GetChecked($row->NewsView);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<tr>
								<td><span class="label label-info left20"> Buat Berita </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="NewsCreate" name="NewsCreate" value="<?=$row->LevelUser;?>" title="<?=$row->NewsCreate;?>" <?=$this->role_model->GetChecked($row->NewsCreate);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<tr>
								<td><span class="label label-info left20"> Update Berita </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="NewsUpdate" name="NewsUpdate" value="<?=$row->LevelUser;?>" title="<?=$row->NewsUpdate;?>" <?=$this->role_model->GetChecked($row->NewsUpdate);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<tr>
								<td><span class="label label-info left20"> Hapus Berita </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="NewsDelete" name="NewsDelete" value="<?=$row->LevelUser;?>" title="<?=$row->NewsDelete;?>" <?=$this->role_model->GetChecked($row->NewsDelete);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<!-------------------------------------------------------------------------------------------------------------->
							<tr>
								<td><span class="label label-danger"> Kategori </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="CategoryView" name="CategoryView" value="<?=$row->LevelUser;?>" title="<?=$row->CategoryView;?>" <?=$this->role_model->GetChecked($row->CategoryView);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<tr>
								<td><span class="label label-info left20"> Buat Kategori </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="CategoryCreate" name="CategoryCreate" value="<?=$row->LevelUser;?>" title="<?=$row->CategoryCreate;?>" <?=$this->role_model->GetChecked($row->CategoryCreate);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<tr>
								<td><span class="label label-info left20"> Update Kategori </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="CategoryUpdate" name="CategoryUpdate" value="<?=$row->LevelUser;?>" title="<?=$row->CategoryUpdate;?>" <?=$this->role_model->GetChecked($row->CategoryUpdate);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<tr>
								<td><span class="label label-info left20"> Hapus Kategori </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="CategoryDelete" name="CategoryDelete" value="<?=$row->LevelUser;?>" title="<?=$row->CategoryDelete;?>" <?=$this->role_model->GetChecked($row->CategoryDelete);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<!-------------------------------------------------------------------------------------------------------------->
							<tr>
								<td><span class="label label-danger"> Komentar </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="CommentView" name="CommentView" value="<?=$row->LevelUser;?>" title="<?=$row->CommentView;?>" <?=$this->role_model->GetChecked($row->CommentView);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<tr>
								<td><span class="label label-info left20"> Buat Komentar </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="CommentCreate" name="CommentCreate" value="<?=$row->LevelUser;?>" title="<?=$row->CommentCreate;?>" <?=$this->role_model->GetChecked($row->CommentCreate);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<tr>
								<td><span class="label label-info left20"> Update Komentar </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="CommentUpdate" name="CommentUpdate" value="<?=$row->LevelUser;?>" title="<?=$row->CommentUpdate;?>" <?=$this->role_model->GetChecked($row->CommentUpdate);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<tr>
								<td><span class="label label-info left20"> Hapus Komentar </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="CommentDelete" name="CommentDelete" value="<?=$row->LevelUser;?>" title="<?=$row->CommentDelete;?>" <?=$this->role_model->GetChecked($row->CommentDelete);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<!-------------------------------------------------------------------------------------------------------------->
							<tr>
								<td><span class="label label-danger"> Captcha </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="CaptchaView" name="CaptchaView" value="<?=$row->LevelUser;?>" title="<?=$row->CaptchaView;?>" <?=$this->role_model->GetChecked($row->CaptchaView);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<tr>
								<td><span class="label label-info left20"> Buat Captcha </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="CaptchaCreate" name="CaptchaCreate" value="<?=$row->LevelUser;?>" title="<?=$row->CaptchaCreate;?>" <?=$this->role_model->GetChecked($row->CaptchaCreate);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<tr>
								<td><span class="label label-info left20"> Update Captcha </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="CaptchaUpdate" name="CaptchaUpdate" value="<?=$row->LevelUser;?>" title="<?=$row->CaptchaUpdate;?>" <?=$this->role_model->GetChecked($row->CaptchaUpdate);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<tr>
								<td><span class="label label-info left20"> Hapus Captcha </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="CaptchaDelete" name="CaptchaDelete" value="<?=$row->LevelUser;?>" title="<?=$row->CaptchaDelete;?>" <?=$this->role_model->GetChecked($row->CaptchaDelete);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<!-------------------------------------------------------------------------------------------------------------->
							<tr>
								<td><span class="label label-danger"> User </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="UserView" name="UserView" value="<?=$row->LevelUser;?>" title="<?=$row->UserView;?>" <?=$this->role_model->GetChecked($row->UserView);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<tr>
								<td><span class="label label-info left20"> Buat User </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="UserCreate" name="UserCreate" value="<?=$row->LevelUser;?>" title="<?=$row->UserCreate;?>" <?=$this->role_model->GetChecked($row->UserCreate);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<tr>
								<td><span class="label label-info left20"> Update User </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="UserUpdate" name="UserUpdate" value="<?=$row->LevelUser;?>" title="<?=$row->UserUpdate;?>" <?=$this->role_model->GetChecked($row->UserUpdate);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<tr>
								<td><span class="label label-info left20"> Hapus User </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="UserDelete" name="UserDelete" value="<?=$row->LevelUser;?>" title="<?=$row->UserDelete;?>" <?=$this->role_model->GetChecked($row->UserDelete);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<!-------------------------------------------------------------------------------------------------------------->
							<tr>
								<td><span class="label label-danger"> File Manager </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="FileView" name="FileView" value="<?=$row->LevelUser;?>" title="<?=$row->FileView;?>" <?=$this->role_model->GetChecked($row->FileView);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<tr>
								<td><span class="label label-info left20"> Buat File </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="FileCreate" name="FileCreate" value="<?=$row->LevelUser;?>" title="<?=$row->FileCreate;?>" <?=$this->role_model->GetChecked($row->FileCreate);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<tr>
								<td><span class="label label-info left20"> Update File </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="FileUpdate" name="FileUpdate" value="<?=$row->LevelUser;?>" title="<?=$row->FileUpdate;?>" <?=$this->role_model->GetChecked($row->FileUpdate);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<tr>
								<td><span class="label label-info left20"> Hapus File </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="FileDelete" name="FileDelete" value="<?=$row->LevelUser;?>" title="<?=$row->FileDelete;?>" <?=$this->role_model->GetChecked($row->FileDelete);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<!-------------------------------------------------------------------------------------------------------------->
							<tr>
								<td><span class="label label-danger"> Level & Hak Akses </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="UserRoleView" name="UserRoleView" value="<?=$row->LevelUser;?>" title="<?=$row->UserRoleView;?>" <?=$this->role_model->GetChecked($row->UserRoleView);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<tr>
								<td><span class="label label-info left20"> Buat Level & Hak Akses </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="UserRoleCreate" name="UserRoleCreate" value="<?=$row->LevelUser;?>" title="<?=$row->UserRoleCreate;?>" <?=$this->role_model->GetChecked($row->UserRoleCreate);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<tr>
								<td><span class="label label-info left20"> Update Level & Hak Akses </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="UserRoleUpdate" name="UserRoleUpdate" value="<?=$row->LevelUser;?>" title="<?=$row->UserRoleUpdate;?>" <?=$this->role_model->GetChecked($row->UserRoleUpdate);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<tr>
								<td><span class="label label-info left20"> Hapus Level & Hak Akses </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="UserRoleDelete" name="UserRoleDelete" value="<?=$row->LevelUser;?>" title="<?=$row->UserRoleDelete;?>" <?=$this->role_model->GetChecked($row->UserRoleDelete);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
								<!-------------------------------------------------------------------------------------------------------------->
							<tr>
								<td><span class="label label-danger"> Backup Database  </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="ToolsBackupDatabase" name="ToolsBackupDatabase" value="<?=$row->LevelUser;?>" title="<?=$row->ToolsBackupDatabase;?>" <?=$this->role_model->GetChecked($row->ToolsBackupDatabase);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<!-------------------------------------------------------------------------------------------------------------->
							<tr>
								<td><span class="label label-danger"> Pengaturan </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="SettingsView" name="SettingsView" value="<?=$row->LevelUser;?>" title="<?=$row->SettingsView;?>" <?=$this->role_model->GetChecked($row->SettingsView);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<tr>
								<td><span class="label label-info left20"> Buat Pengaturan </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="SettingsCreate" name="SettingsCreate" value="<?=$row->LevelUser;?>" title="<?=$row->SettingsCreate;?>" <?=$this->role_model->GetChecked($row->SettingsCreate);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<tr>
								<td><span class="label label-info left20"> Update Pengaturan </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="SettingsUpdate" name="SettingsUpdate" value="<?=$row->LevelUser;?>" title="<?=$row->SettingsUpdate;?>" <?=$this->role_model->GetChecked($row->SettingsUpdate);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<tr>
								<td><span class="label label-info left20"> Hapus Pengaturan </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="SettingsDelete" name="SettingsDelete" value="<?=$row->LevelUser;?>" title="<?=$row->SettingsDelete;?>" <?=$this->role_model->GetChecked($row->SettingsDelete);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<!-------------------------------------------------------------------------------------------------------------->
							<tr>
								<td><span class="label label-danger"> Laporan </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="ReportView" name="ReportView" value="<?=$row->LevelUser;?>" title="<?=$row->ReportView;?>" <?=$this->role_model->GetChecked($row->ReportView);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<tr>
								<td><span class="label label-info left20"> Buat Laporan </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="ReportCreate" name="ReportCreate" value="<?=$row->LevelUser;?>" title="<?=$row->ReportCreate;?>" <?=$this->role_model->GetChecked($row->ReportCreate);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<tr>
								<td><span class="label label-info left20"> Update Laporan </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="ReportUpdate" name="ReportUpdate" value="<?=$row->LevelUser;?>" title="<?=$row->ReportUpdate;?>" <?=$this->role_model->GetChecked($row->ReportUpdate);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<tr>
								<td><span class="label label-info left20"> Hapus Laporan </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="ReportDelete" name="ReportDelete" value="<?=$row->LevelUser;?>" title="<?=$row->ReportDelete;?>" <?=$this->role_model->GetChecked($row->ReportDelete);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<!-------------------------------------------------------------------------------------------------------------->
							<tr>
								<td><span class="label label-danger"> Logs </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="LogsView" name="LogsView" value="<?=$row->LevelUser;?>" title="<?=$row->LogsView;?>" <?=$this->role_model->GetChecked($row->LogsView);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<tr>
								<td><span class="label label-info left20"> Buat Logs </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="LogsCreate" name="LogsCreate" value="<?=$row->LevelUser;?>" title="<?=$row->LogsCreate;?>" <?=$this->role_model->GetChecked($row->LogsCreate);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<tr>
								<td><span class="label label-info left20"> Update Logs </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="LogsUpdate" name="LogsUpdate" value="<?=$row->LevelUser;?>" title="<?=$row->LogsUpdate;?>" <?=$this->role_model->GetChecked($row->LogsUpdate);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
							<tr>
								<td><span class="label label-info left20"> Hapus Logs </span></td>
								<?php						
									foreach($column as $row){									
										?>									
										<td class="text-center">
											<input type="checkbox" autocomplete="off" id="LogsDelete" name="LogsDelete" value="<?=$row->LevelUser;?>" title="<?=$row->LogsDelete;?>" <?=$this->role_model->GetChecked($row->LogsDelete);?> class="role tooltip-right uniformcheckbox" <?=$RoleUserRoleUpdate;?> />
										</td>
										<?php
									}
								?>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<th>Hak Akses</th>
								<?php
									foreach($leveluser as $row){
										?>
											<th class="text-center"><?=$row->LevelUser;?></th>
										<?php
									}
								?>								
							</tr>
						</tfoot>
					</table>	
					<?php }else{
						$this->load->view('backend/no-access');
					}?>	
				</div>
			</div>
			
    </div>
  </div>
  <!-- End Page -->
 <?php $this->load->view('backend/footer');?>
 <script>
	//------------------------------------------------------------------------------------//
	$(function(){
		//------------------------------------------------------------------------------------//
		var MyTable = $("#MyTable").dataTable({
			responsive: true,
			"language": {
				"aria": {
					"sortAscending": ": activate to sort column ascending",
					"sortDescending": ": activate to sort column descending"
				},
				"emptyTable": "Tidak ada data di tabel",
				"info": "Tampilkan _START_ sampai _END_ dari _TOTAL_ data",
				"infoEmpty": "Tidak ada data ditemukan",
				"infoFiltered": "(filtered1 from _MAX_ total entries)",
				"lengthMenu": "Tampilkan _MENU_ data",		
				"zeroRecords": "Tidak ada data yang cocok",
				"search": "Cari: ",			
				"paginate": {
					"previous":"Sebelum",
					"next": "Berikut",
					"last": "Akhir",
					"first": "Awal"
				}
			},
			"bProcessing": true,
			"bServerSide": true,			
			"ajax": {
				"url": "<?=base_url();?>backend/news/NewsList",
				"type": "POST",
				"data":{
					'<?=$this->security->get_csrf_token_name();?>' : '<?=$this->security->get_csrf_hash();?>'			
				},
				"error": function(){
					$.growl.error({title: 'Error', message: 'Ajax request'});
				}
			},
			"bStateSave": true, 	
			"fnDrawCallback": function( oSettings ) {
				//$("input:checkbox").uniform();
			},	
			"columns": [				
				{"data": 'CreatedNews'}, 
				{"data": 'TitleNews'}, 
				{"data": 'CategoryNews'},			
				{"data": 'AuthorNews'},
				{"data": 'FlagPublish'},
				{"data": 'Option'}
			],			
			"lengthMenu": [
				[5, 10, 20, 50, 100],
				[5, 10, 20, 50, 100]
			],					
			"pageLength": 5,  
			
			"columnDefs": [
				 { "orderable": true, "targets": 0 },
				 { "orderable": true, "targets": 1 },
				 { "orderable": true, "targets": 2 },				
				 { "orderable": true, "targets": 3 },
				 { "orderable": true, "targets": 4, 'sClass': 'text-center' },
				 { "orderable": false, "targets": 5, 'sClass': 'text-center' }
						
			],
			"order": [
				[0, "desc"]
			] 
		});				
		/*-------------------------------------------------------------------------------------*/
		$("input.role").click(function(){
			var value = this.value;
			var name = this.name;
			if($(this).prop("checked")){
				var attr = 'yes';
			}else{
				var attr= 'no';
			}
			$.ajax({
				url:'<?=base_url();?>' + 'backend/user_role/ajax',
				type: 'post',				
				data: {
					'do':'RoleSet',
					'LevelUser':value,
					'attr':attr,
					'name':name,
					'<?=$this->security->get_csrf_token_name();?>':'<?=$this->security->get_csrf_hash();?>'
				},
				dataType: 'json',
				beforeSend: function(){
					myLoader.show();
				},
				success: function(respon){
					if(respon.status=='sukses'){
						myLoader.hide();											
						$.growl({title:respon.status,message:respon.message});
						setTimeout(function(){location.reload();},1000);
					}
				},
				timeout: 20000,
				error:function(){
					myLoader.hide();
					$.growl.error({title:'Error',message:'Ajax request'});
				}	
			});			
					
		});
		/*-------------------------------------------------------------------------------------*/
		$("input.selectall").click(function(){
			var value = this.value;
			var name = this.name;
			if($(this).prop("checked")){
				var attr = 'yes';
			}else{
				var attr= 'no';
			}
			$.ajax({
				url:'<?=base_url();?>' + 'backend/user_role/ajax',
				type: 'post',
				data: {
					'do':'RoleSetAll',
					'LevelUser':value,
					'attr':attr,
					'name':name,
					'<?=$this->security->get_csrf_token_name();?>':'<?=$this->security->get_csrf_hash();?>'
				},
				dataType: 'json',
				beforeSend: function(){
					myLoader.show();
				},
				success: function(respon){
					if(respon.status=='sukses'){
						myLoader.hide();											
						$.growl({title:respon.status,message:respon.message});
						setTimeout(function(){location.reload();},1000);
					}	
					
				},
				timeout:20000,
				error:function(){
					myLoader.hide();
					$.growl.error({title:'Error',message:'Ajax request'});
				}	
			});			
					
		});
		
		$("#Refresh").click(function(){MyTable.fnDraw();});
		/*-------------------------------------------------------------------------------------*/

		
	});
	//------------------------------------------------------------------------------------//
	function RoleSetDefault(){
		bootbox.dialog({
			message: "Apakah anda yakin akan men-set default semua hak akses?",
			title: "Konfirmasi",
			buttons: {				
				danger: {
					label: "No",
					className: "btn-default",
					callback: function() {
						
					}
				},
				main: {
				label: "Yes",
				className: "btn-primary",
				callback: function() {						
					$.ajax({
						url: '<?=base_url();?>backend/user_role/ajax',
						type: 'POST',
						data: {
							'do':'RoleSetDefault',
							'<?=$this->security->get_csrf_token_name();?>' : '<?=$this->security->get_csrf_hash();?>'			
						},
						dataType: 'json',					
						beforeSend: function(){
							myLoader.show();
						},
						success: function(respon) {
							myLoader.hide();
							if(respon.status=='sukses'){
									$.growl({title:respon.status,message:respon.message});
								setTimeout(function(){location.reload();},1000);
							}
						},
						timeout: 20000,
						error:function(){
							myLoader.hide();	
							$.growl.error({title:'Error',message:'Ajax request'});
						}	
					});	
				}
				}
			}
		});
	}
 </script>

<!----------------------------------------------------------------------------------------------------------------------------------------->

