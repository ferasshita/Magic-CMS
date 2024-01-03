

    //Basic
function simple_pop(msg){

        swal(msg);
    }

    //A title with a text under
    function title_pop(head,msg){
        swal(head, msg)
    }

    //Success Message
    function success_pop(head,msg){
        swal(head, msg, "success")
    }

    //Warning Message

    function delete_pop(head,question,confirm,deleted_thing){
        swal({
            title: head,
            text: question,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: confirm,
            closeOnConfirm: false
        }, function(){
            swal("Deleted!", deleted_thing, "success");
        });
    }

    //Parameter
    function confirm_pop(head,msg,yes,no,yes_msg,no_msg){
        swal({
            title: head,
            text: msg,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: yes,
            cancelButtonText: no,
            closeOnConfirm: false,
            closeOnCancel: false
        }, function(isConfirm){
            if (isConfirm) {
                swal("Deleted!", yes_msg, "success");
            } else {
                swal("Cancelled", no_msg, "error");
            }
        });
    }

    //Custom Image
  function img_pop(title,msg,img){
        swal({
            title: title,
            text: text,
            imageUrl: img
        });
    }

    //Auto Close Timer
    function timer_pop(title,msg,time){
         swal({
            title: title,
            text: msg,
            timer: time,
            showConfirmButton: false
        });
    }
