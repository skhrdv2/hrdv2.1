 <div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">ตั้งค่าฝ่าย/งาน</h4>
                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
                        <li><a data-action="reload"><i class="icon-reload"></i></a></li>
                        <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                        <li><a data-action="close"><i class="icon-cross2"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body collapse in">
                <div class="card-block card-dashboard">

										<div>
										<button class="btn btn-primary" id="btnfrm">เพิ่ม</button>
											<table id="setting_department_sub" class="table table-striped table-bordered table-hover">
												<thead>
													<tr>
													<th width="4%">#</th>
													<th width="6%">#</th>
													<th width="22%">ชื่อหน่วยงานย่อย</th>
													<th width="22%">ชื่อหน่วยงานหลัก</th>
													<th width="16%">หัวหน้าหน่วยงาน</th>
													<th width="10%">โทรศัพท์</th>
													<th width="20%">Line_Token</th>
													<th width="8%">สถานะ</th>
													
													</tr>
												</thead>

												<tbody>
													
												</tbody>
											</table>
													</table>
									</div>          
            </div>
        </div>
        </div>
    </div>
</div>
		
         <script type="text/javascript">
	
    $(document).ready(function () {
		var url="data/setting_department_sub_data.php";
		$.fn.dataTable.ext.errMode = 'throw';
        var t = $('#setting_department_sub').DataTable({
            "ajax":{ 
                   "url": "data/setting_department_sub_data.php",
                    "type":"post",
                    "data":{
                        req:'req'}
				},
				"aoColumns": [
    {null:null},
	{null:null},
	{"data":"department_sub_name"},
	{"data":"department_name"},
	{"data":"head_department"},
	{"data":"department_sub_tel","sClass": "center"},
	{"data":"department_sub_line_token"},
	{"data":"department_sub_status","sClass": "center"},

	
],
"columnDefs": [
				{
                    "targets":1,
                    "data": null,
					"defaultContent":"<button id='edit' class='btn btn-warning btn-sm'><i class='icon-pen3'></i></button>  <button id='delete' class='btn btn-danger btn-sm'><i class='icon-trash3'></i></button>",
														
                    'bSortable': false
                },
],
            "order": [[1, 'desc']]
        });
        t.on('order.dt search.dt', function () {
            t.column(0).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;

            });
        }).draw(); //เรียกใช้งาน datatable

		$("#btnfrm").click(function(){
		$("#acc").val("save");
		$("#department_sub_forms").modal();
		});
		$('#setting_department_sub tbody').on('click', '#edit', function () { //ดึง id มาแก้ไขจาก datatable
            var data = t.row($(this).parents('tr')).data();
			//alert(data['department_sub_id']);

		$("#department_sub_forms").modal();
		$.post(url,{acc:"query_edit",sql:data['department_sub_id']})
                    .done(function (data) {

                        var ard = JSON.parse(data);
                        $("#department_sub_name").val(ard['department_sub_name']);
						$("#department_sub_head_cid").val(ard['department_sub_head_cid']).change()
						$("#department_id").val(ard['department_id']).change()
						$("#department_sub_status").val(ard['department_sub_status'])
						$("#acc").val("edit");
						$("#department_sub_id").val(ard['department_sub_id']);
						$("#department_sub_tel").val(ard['department_sub_tel']);
					
                    });      
                  
        });
		$('#setting_department_sub tbody').on('click', '#delete', function () {//ดึง id มาลบ datatable
            var data = t.row($(this).parents('tr')).data();
            if (confirm("ต้องการลบข้อมูลนี้หรือไม่"))
            {
                $.post(url, {
                    sql:data['department_sub_id'],
                    acc: 'delete'
                }).done(function (data) {
					//console.log(data);
							msg_warnig(data);
                            t.ajax.reload();
                        });
            }

        });
		$("#depart_subfrm").validate({
            rules: {
                department_sub_name:
                        { required: true,
                            minlength: 3,
                         //   maxlength: 10,
                         /*   remote: {
                                url: "modules/usermanager/chk_user.php",
                                type: "post"
                            }*/
                        },
				department_id:{
					required:true,
				},
				department_sub_tel:{
					number:true,
				},
            },
            messages: {
                department_sub_name:
				 {
                    required: "กรุณากรอกข้อมูล ",
                    minlength: "อย่างน้อย 3 ตัวอักษร",
                },
				department_id:
				{ 
					required:"กรุณากรอกข้อมูล",
				},
				department_sub_tel:{
					number:"กรอกเฉพาะตัวเลข",
				}
			},
				submitHandler: function (form) {
					$.ajax({
		 url:url,
		 type:"POST",
		 datatype:"json",
		 data:{acc:$("#acc").val(),
		 department_sub_name:$("#department_sub_name").val(),
		 department_id:$("#department_id").val(),
		 department_sub_status:$("#department_sub_status").val(),
		 department_sub_head_cid:$("#department_sub_head_cid").val(),
		 person_id_search:$("#person_id_search").val(),
		 department_sub_id:$("#department_sub_id").val(),
		 department_sub_tel:$('#department_sub_tel').val()
		 },
			 success:function(data){
				// console.log(data);
				$('#department_sub_forms').modal('hide');
				$("#department_sub_name").val(""),
				$("#department_id").val(""),
				$("#department_sub_status").val(" "),
		 		$("#department_sub_id").val(" "),
				$('#department_sub_tel').val(" ")
				$("#department_sub_head_cid").val('').trigger('change');
			  	msg_warnig(data);
			 	t.ajax.reload();
		  },
		 
	 });
             },	

    }); //end validate
	

				$('#department_sub_head_cid').change(function(){
//	alert($(this).val());
		$.post("data/search_person_id.php", {cid:$(this).val()}
		).done(function (data) {
//console.log(data);
                        var ard2 = JSON.parse(data);
                        $("#person_id_search").val(ard2['person_id']);			
         });                
        });	
	
				$('.select22').select2();

    });
		  </script>	
		  
		  <form action="" id="depart_subfrm" name="depart_subfrm" method="POST">
		  
		  <div class="modal fade" id="department_sub_forms"  >
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
						<div class="modal-header">
							<h2 class="modal-title" id="exampleModalLabel">เพิ่มฝ่าย/งาน</h2>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						
							</button>
						</div>
						<div class="modal-body">
						<!--ส่วนแสดงฟอร์ม-->	
						<div class="form-group col-12">
						<label for="department_sub_name">ชื่อฝ่าย/งาน</label>
						<input type="text" class="form-control" name="department_sub_name" id="department_sub_name">
						</div>
						<div class="form-group col-12">
													<label for="department_id">กลุ่มงาน</label>
													<select name="department_id" id="department_id" class="select22 form-control" style="width:100%">
   														<option value="">ระบุ</option>
  														 <?php $result=$Db->query("SELECT * FROM hrd_department ");
														foreach($result AS $row){?>
   														<option value="<?=$row['department_id'];?>"><?=$row['department_name'];?></option>
														<?php  }?>
  													</select>
													</div>
													<div class="form-group col-12">
													<label for="department_sub_head_cid">หัวหน้าฝ่าย/งาน</label>
													<select name="department_sub_head_cid" id="department_sub_head_cid" class="select22 form-control" style="width:100%">
   														<option value="">ระบุ</option>
  														 <?php $result=$Db->query("SELECT ps.*,CONCAT(pn.prename_name,ps.fname,'   ',ps.lname) AS fullname FROM hrd_person ps
   						    										left outer join hrd_prename pn ON pn.prename_id=ps.prename_id ");
														foreach($result AS $row){?>
   														<option value="<?=$row['cid'];?>"><?=$row['fullname'];?></option>
														<?php  }?>
  													</select>
													</div>
													<div class="form-group col-12">
						<label for="department_sub_tel">เบอร์โทร</label>
						<input name="department_sub_tel" id="department_sub_tel" class="form-control">							
						</div>
						<div class="form-group col-12">
						<label for="department_sub_status">สถานะ</label>
						<select name="department_sub_status" id="department_sub_status" class="form-control">
						<option value="Y">เปิดใช้งาน</option>
						<option value="N">ปิดใช้งาน</option>
						</select>							
						</div>
					
								<input type="text"  id="person_id_search">
								<input type="text"  id="acc">
								<input type="text"  id="department_sub_id">

						</div><!--จบส่วนแสดงฟอร์ม-->
						<div class="modal-footer">
							<button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" id="SaveBtn" class="btn btn-success">บันทึกข้อมูล</button>
						
						</div>
					</div>
				</div>
			</div>
		  </form>	
								