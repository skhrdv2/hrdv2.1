function msg_warnig(msg){
    var obj = JSON.parse(msg);
    if(obj.m=="success_insert"){
        swal({
            position: 'center',
            type: 'success',
            title: 'บันทึกสำเร็จ',
            showConfirmButton: false,
            timer: 1500
          });
    }else if(obj.m=="success_update"){
        swal({
            position: 'center',
            type: 'success',
            title: 'แก้ไขสำเร็จ',
            showConfirmButton: false,
            timer: 1500
          });
    }else if(obj.m=="success_delete"){
        swal({
            position: 'center',
            type: 'success',
            title: 'ลบสำเร็จ',
            showConfirmButton: false,
            timer: 1500
          });
    }else{
        swal({
            type: 'error',
            title: 'Oops...',
            text: 'ผิดพลาด!',
            footer: '<a href>Why do I have this issue?</a>'
          });
    }
}