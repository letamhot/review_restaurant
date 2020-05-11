$("#productForm #name").keydown(function() {
    var str = $("#name").val();
     if(str != '' && $.trim(str).length >= 2){
       $('#btn-save').prop("disabled", false);
       }
     else{
         $('#btn-save').prop("disabled", true);
       }
 });

 