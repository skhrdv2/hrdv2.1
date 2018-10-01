
	<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">ตั้งค่ากลุ่มงาน</h4>
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
							
											<button class="btn btn-primary form-group" id="btnfrm"><i class="icon-plus2 bigger-110"></i> เพิ่ม</button>
											<div class="tableTools-container"></div>
										
											<div class="table-responsive">
											<table id="setting_department" class=" table table-striped table-bordered table-hover">
												<thead>
													<tr>
													<th></th>
													<th width="6%"></th>
													<th width="30%">ชื่อหน่วยงาน</th>
													<th width="16%">หัวหน้าหน่วยงาน</th>
													<th width="10%">โทรศัพท์</th>
													<th width="20%">Line_Token</th>
													<th width="8%">สถานะ</th>
                                                    <th width="10%">Lastupdate</th>
														
													</tr>
												</thead>

												<tbody>
													
												</tbody>
											</table>
									</div>          
									
            </div>
        </div>
        </div>
    </div>
</div>
         <script type="text/javascript">
	
    $(document).ready(function () {
		var url="data/setting_department_data.php";
		$.fn.dataTable.ext.errMode = 'throw';
        var t = $('#setting_department').DataTable({
            "ajax":{ 
                   "url":url,
                    "type":"post",
                    "data":{
                        req:'req'}
				},
				"aoColumns": [
    {},
	{},
	{"data":"department_name"},
	{"data":"head_department"},
	{"data":"department_tel","sClass": "center"},
	{"data":"department_line_token"},
	{"data":"department_status","sClass": "center"},
	{"data":"last_update","sClass": "center"},
	
],
"columnDefs": [
				{
                    "targets":1,
                    "data": null,
                    "defaultContent":"<button id='edit' class='btn btn-warning btn-sm'><i class='icon-pen3'></i></button>  <button id='delete' class='btn btn-danger btn-sm'><i class='icon-trash3'></i></button>",
														
                    'bSortable': false
                },
],


            "order": []
        });
		new $.fn.dataTable.Buttons( t, {
			buttons: [
						
					  
					  {
						"extend": "excel",
						"text": "<i class='icon-file-excel bigger-110 '></i> <span>Excel</span>",
						"className": "btn  btn-primary"
					  },
					  {
						"extend": "pdf",
						"text": "<i class='icon-file-pdf bigger-110 '></i> <span class=''>PDF</span>",
						"className": "btn btn-primary"
					  },
					  {
						"extend": "print",
						"text": "<i class='icon-printer3 '></i> <span class=''>Print</span>",
						"className": "btn btn-white btn-primary ",
					
						autoPrint: false,
						message: 'คุณสามารถปริ้นได้เลย'
					  }		  
					]
} );
      t.buttons().container()
          .appendTo($('.tableTools-container'));
		
        t.on('order.dt search.dt', function () {
            t.column(0).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;

            });
        }).draw(); //เรียกใช้งาน datatable
	
			
		$("#btnfrm").click(function(){
				
				$("#acc").val("save");
				$("#department_forms").modal();
		});


		$('#setting_department tbody').on('click', '#edit', function () { //ดึง id มาแก้ไขจาก datatable
            var data = t.row($(this).parents('tr')).data();
			//alert(data['department_id']);

			$("#department_forms").modal();
		$.post(url,{acc:"query_edit",sql:data['department_id']})
                    .done(function (data) {

                        var ard = JSON.parse(data);
                        $("#department_name").val(ard['department_name']);
						$("#department_head_cid").val(ard['department_head_cid']).change()
						$("#department_status").val(ard['department_status'])
						$("#BtnAcc").attr("class", "btn btn-warning edit");
						$("#acc").val("edit");
						$("#department_id").val(ard['department_id']);
						$("#department_tel").val(ard['department_tel']);
					
                    });      
                  
        });

	  $('#setting_department tbody').on('click', '#delete', function () {//ดึง id มาลบ datatable
            var data = t.row($(this).parents('tr')).data();
            if (confirm("ต้องการลบข้อมูลนี้หรือไม่"))
            {
                $.post(url, {
                    sql:data['department_id'],
                    acc: 'delete'
                }).done(function (data) {
					//console.log(data);
							msg_warnig(data);
                            t.ajax.reload();
                        });
            }

        });
		$("#departfrm").validate({
            rules: {
                department_name:
                        { required: true,
                            minlength: 3,
                         //   maxlength: 10,
                         /*   remote: {
                                url: "modules/usermanager/chk_user.php",
                                type: "post"
                            }*/
                        },
				department_tel:{
							number: true
				},
            },
            messages: {
                department_name: {
                    required: "ห้ามมีค่าว่าง ",
                    minlength: "อย่างน้อย 3 ตัวอักษร",
                },
				department_tel:{
						number:"กรอกเฉพาะตัวเลข",
				}
			},
				submitHandler: function (form) {
					$.ajax({
		 url:url,
		 type:"POST",
		 datatype:"json",
		 data:{acc:$("#acc").val(),department_name:$("#department_name").val(),
			department_status:$("#department_status").val(),
			department_head_cid:$("#department_head_cid").val(),
			person_id_search:$("#person_id_search").val(),
			department_id:$("#department_id").val(),
			department_tel:$('#department_tel').val()},
			 success:function(data){
				 console.log(data);
				$('#department_forms').modal('hide');
				$("#department_name").val("");
				$("#person_id_search").val('');
				$("#department_head_cid").val('').trigger('change');
				$("#acc").val('');
				$("#department_id").val('');
				$("#department_tel").val('');
			   	msg_warnig(data);
			 	t.ajax.reload();
		  },
		 
	 });
             },	

    });
	$('.select22').select2();

	$('#department_head_cid').change(function(){
//	alert($(this).val());
		$.post("data/search_person_id.php", {cid:$(this).val()}
		).done(function (data) {
//console.log(data);
                        var ard2 = JSON.parse(data);
                        $("#person_id_search").val(ard2['person_id']);			
         });                
        });	
	
});

          </script>	
		  <form action="" id="departfrm" name="departfrm" method="POST">
		  
		  <div class="modal fade" id="department_forms"  >
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
						<div class="modal-header">
							<h2 class="modal-title" id="exampleModalLabel">เพิ่มกลุ่มงาน</h2>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						
							</button>
						</div>
						<div class="modal-body">
						<!--ส่วนแสดงฟอร์ม-->	
						<div class="form-group col-12">
						<label for="department_name">กลุ่มงาน</label>
						<input type="text" class="form-control" name="department_name" id="department_name">
						</div>
													<div class="form-group col-12">
													<label for="department_head_cid">หัวหน้ากลุ่มงาน</label>
													<select name="department_head_cid" id="department_head_cid" class="select22 form-control" style="width:100%">
   														<option value="">ระบุ</option>
  														 <?php $result=$Db->query("SELECT ps.*,CONCAT(pn.prename_name,ps.fname,'   ',ps.lname) AS fullname FROM hrd_person ps
   						    										left outer join hrd_prename pn ON pn.prename_id=ps.prename_id ");
														foreach($result AS $row){?>
   														<option value="<?=$row['cid'];?>"><?=$row['fullname'];?></option>
														<?php  }?>
  													</select>
													</div>
													<div class="form-group col-12">
						<label for="department_tel">เบอร์โทร</label>
						<input name="department_tel" id="department_tel" class="form-control">							
						</div>
						<div class="form-group col-12">
						<label for="department_status">สถานะ</label>
						<select name="department_status" id="department_status" class="form-control">
						<option value="Y">เปิดใช้งาน</option>
						<option value="N">ปิดใช้งาน</option>
						</select>							
						</div>
					
								<input type="text"  id="person_id_search">
								<input type="text"  id="acc">
								<input type="text"  id="department_id">

						</div><!--จบส่วนแสดงฟอร์ม-->
						<div class="modal-footer">
							<button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" id="SaveBtn" class="btn btn-success">บันทึกข้อมูล</button>
						
						</div>
					</div>
				</div>
			</div>
		  </form>	
		
							
							
										
								
	
				