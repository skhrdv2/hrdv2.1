<?php
  $Db->access("ADMIN");
?>
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Basic Tables</h4>
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
                
					<p><span class="text-bold-600">	<button type='button' class='btn btn-primary ' data-toggle="modal" data-target="#large"><i class='icon-user-plus'></i> เพิ่ม</button></span>
					
					<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="department_search">กลุ่มงาน</label>
											<select id="department_search" name="department_search" class="form-control">
											<option value="">ทั้งหมด</option>
												
											</select>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label for="department_sub_search">ฝ่ายงาน</label>
											<select id="department_sub_search" name="department_sub_search" class="form-control">
												<option value="">ทั้งหมด</option>
											
											</select>
										</div>
									</div>
								</div>

                    <div class="table-responsive">
                        <table id="person_list" class="table table-bordered">
                            <thead class="thead-inverse">
                                <tr>
                                    <th witd="2%">#</th>
									
									<th>ชื่อ-สกุล</th>
									<th >ชื่อเรียก</th>
									<th >ตำแหน่ง</th>
									<th >ประเภทวิชาชีพ</th>
									<th>หน่วยงาน</th>
									<th>กลุ่มงาน</th>
									<th>วันที่เริ่มทำงาน</th>
									<th>สถานะ</th>
									<th with="10%" ></th>
									<th with="10%" ></th>
									
                                </tr>
                            </thead>
                          
                        </table>
                    </div>
                </div>
              
               
            </div>
        </div>
    </div>
</div>
              
<script type="text/javascript">
	
    $(document).ready(function () {
		load_data();
		//เลื้อกแผนกฝ่าย
	

function load_data(is_department,is_department_sub)
 {
        var t = $('#person_list').DataTable({
			"processing": true,
            "ajax":{ 
                   "url": "data/person_list_data.php",
                    "type":"post",
                    "data":{
                        req:'req',is_department:is_department,is_department_sub:is_department_sub}
				},
				
				"aoColumns": [
    {null:null},
   
    { "data": function (data, type, dataToSet) {
        return data.prename_name + data.fname + " " + data.lname;
    }, "width": "100%" },
	{"data":"nickname", "width": "12%" },
	{"data":"position_name", "width": "20%"},
	{"data":"position_groups_name" },
	{"data":"department_sub_name" },
	{"data":"department_name" },
	{"data":"startwork_date" },
	{"data":"person_status_name"}

],
"columnDefs": [
				{
                    "targets":9,
                    "data": null,
                    "defaultContent":"	<button type='button' class='btn  btn-info '><i class='icon-eye6'></i> รูปภาพ</button>",								
                    'bSortable': false
					
                },

              {
                    "targets":10,
                    "data": null,
                    "defaultContent":"	<button type='button' class='btn btn-success '><i class='icon-edit'></i> แก้ไข</button>",																
                    'bSortable': false
					
                },
				
                {
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }

            ],
		
           
       
            "order": [[1, 'asc']]
        });
        t.on('order.dt search.dt', function () {
            t.column(0).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;

            });
        }).draw(); //เรียกใช้งาน datatable
	}	
   

$.ajax({    //แสดงชื่อแผนกทั้งหมด
		
		url:"data/department_data.php",
        type:"POST",
		dataType: "json",
		data:{show_department:'show_department'}, 
		success:function(data){
		//	console.log(data);
			$.each(data, function( index, value ) {
				  $("#department_search").append("<option value='"+ value.id +"'> " + value.name + "</option>");
			});
			
		}
	});
	
	 $("#department_search").change(function(){	
        $(".department_sub_show").remove();
        var department_id = $(this).val();
        var department_sub_id = $("#department_sub_search").val();
      $("#person_list").DataTable().destroy();
        if(department_id !=''){
         //   alert(department_id);
            load_data(department_id);
            $.ajax({
				   url:"data/department_data.php",
                   type:"POST",
				   dataType: "json",
				   data:{department_swow_sub:'show_department_sub',department_id:department_id}, 
				   success:function(data){
				
					   $.each(data, function( index, value ) {
							 $("#department_sub_search").append("<option class='department_sub_show' value='"+ value.id +"'> " + value.name + "</option>");
					   });
					  
				   }
			   });
        }else {
            $(".department_sub_show").remove();
            load_data();
        }
			
		});
	
    $("#department_sub_search").change(function(){	
   
   var department_id = $("#department_search").val();
   var department_sub_id=$(this).val();
 $("#person_list").DataTable().destroy();
   if(department_sub_id !=''){
    //   alert(department_id);
       load_data(department_id,department_sub_id);
   }else {
      
       load_data();
   }
       
   });
     });
          </script>	
          
          <div class="col-lg-4 col-md-6 col-sm-12">
								<div class="form-group">
									
									<!-- Button trigger modal -->
								

									<!-- Modal -->
									<div class="modal fade text-xs-left" id="large" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
									  <div class="modal-dialog modal-lg" role="document">
										<div class="modal-content">
										  <div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											  <span aria-hidden="true">&times;</span>
											</button>
											<h4 class="modal-title" id="myModalLabel17">Basic Modal</h4>
										  </div>
                                          <div class="modal-body"><!-- เริ่ม modalbody-->
                                          <div class="content-body"><!-- Basic form layout section start -->
<section id="basic-form-layouts">
	<div class="row match-height">
		<div class="col-md-6">
			<div class="card">
				
				<div class="card-body collapse in">
					<div class="card-block">
						
						<form class="form">
							<div class="form-body">
                                <h4 class="form-section"><i class="icon-head"></i> Personal Info</h4>
                                <div class="row">
                                    
									<div class="col-md-12">
										<div class="form-group">
											<label for="projectinput1">คำนำหน้าชื่อ</label>
                                            <select id="projectinput5" name="interested" class="form-control">
												<option value="">ระบุ</option>
                                                <?php $result= $Db->query('SELECT * FROM hrd_prename');
                                foreach($result AS $row){ ?>
                                                 <option value="<?=$row['prename_id']?>"><?=$row['prename_name'];?></option>  
                             <?php   } ?>
											</select>
										</div>
									</div>
								
								</div>
								
								<div class="row">
                                    
									<div class="col-md-6">
										<div class="form-group">
											<label for="projectinput1">ชื่อ</label>
											<input type="text" id="projectinput1" class="form-control" placeholder="First Name" name="fname">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="projectinput2">นามสกุล</label>
											<input type="text" id="projectinput2" class="form-control" placeholder="Last Name" name="lname">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="projectinput3">E-mail</label>
											<input type="text" id="projectinput3" class="form-control" placeholder="E-mail" name="email">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="projectinput4">Contact Number</label>
											<input type="text" id="projectinput4" class="form-control" placeholder="Phone" name="phone">
										</div>
									</div>
								</div>
                                <h4 class="form-section"><i class="icon-mail6"></i> ข้อมูลการติดต่อ</h4>

<div class="form-group">
    <label for="userinput5">บ้านเลขที่</label>
    <input class="form-control border-primary" type="email" placeholder="email" id="userinput5">
</div>

<div class="form-group">
    <label for="userinput6">หมู่</label>
    <input class="form-control border-primary" type="url" placeholder="http://" id="userinput6">
</div>

<div class="form-group">
    <label>Contact Number</label>
    <input class="form-control border-primary" id="userinput7" type="tel" placeholder="Contact Number">
</div>

<div class="form-group">
    <label for="userinput8">Bio</label>
    <textarea id="userinput8" rows="5" class="form-control border-primary" name="bio" placeholder="Bio"></textarea>
</div>

								<h4 class="form-section"><i class="icon-clipboard4"></i> Requirements</h4>

								<div class="form-group">
									<label for="companyName">Company</label>
									<input type="text" id="companyName" class="form-control" placeholder="Company Name" name="company">
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="projectinput5">Interested in</label>
											<select id="projectinput5" name="interested" class="form-control">
												<option value="none" selected="" disabled="">Interested in</option>
												<option value="design">design</option>
												<option value="development">development</option>
												<option value="illustration">illustration</option>
												<option value="branding">branding</option>
												<option value="video">video</option>
											</select>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label for="projectinput6">Budget</label>
											<select id="projectinput6" name="budget" class="form-control">
												<option value="0" selected="" disabled="">Budget</option>
												<option value="less than 5000$">less than 5000$</option>
												<option value="5000$ - 10000$">5000$ - 10000$</option>
												<option value="10000$ - 20000$">10000$ - 20000$</option>
												<option value="more than 20000$">more than 20000$</option>
											</select>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label>Select File</label>
									<label id="projectinput7" class="file center-block">
										<input type="file" id="file">
										<span class="file-custom"></span>
									</label>
								</div>

								<div class="form-group">
									<label for="projectinput8">About Project</label>
									<textarea id="projectinput8" rows="5" class="form-control" name="comment" placeholder="About Project"></textarea>
								</div>
							</div>

						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="card">
			
				<div class="card-body collapse in">
					<div class="card-block">

						<form class="form">
							<div class="form-body">
								<h4 class="form-section"><i class="icon-eye6"></i> ข้อมูลการทำงาน</h4>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="userinput1">วันเริ่มทำงาน</label>
											<input type="text" id="userinput1" class="form-control border-primary" placeholder="Name" name="name">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="userinput2">Last Name</label>
											<input type="text" id="userinput2" class="form-control border-primary" placeholder="Company" name="company">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="userinput3">กลุ่มงาน</label>
											<input type="text" id="userinput3" class="form-control border-primary" placeholder="Username" name="username">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="userinput4">หน่วยงาน</label>
											<input type="text" id="userinput4" class="form-control border-primary" placeholder="Nick Name" name="nickname">
										</div>
                                    </div>
                                    <div class="col-md-6">
										<div class="form-group">
											<label for="userinput4">ตำแหน่ง</label>
											<input type="text" id="userinput4" class="form-control border-primary" placeholder="Nick Name" name="nickname">
										</div>
									</div>
								</div>

							
							</div>

						</form>

					</div>
				</div>
			</div>
		</div>
	</div>

</section>
<!-- // Basic form layout section end -->
        </div> 

										<!-- จบ modalbody -->
										  </div>
										  <div class="modal-footer">
											<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
											<button type="button" class="btn btn-outline-primary">Save changes</button>
										  </div>
										</div>
									  </div>
									</div>
								</div>
							</div>        
	
  