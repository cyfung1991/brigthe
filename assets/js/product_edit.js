$(document).ready(function(){
  $("body").on("click",".form_submit",function(e){
    $(this).parents("form").ajaxForm(options);
  });

 var options = {
   complete: function(response)
   {
     var res = JSON.parse(response.responseText);
     var msg = (res.msg).replace(/<(?:.|\n)*?>/gm, '');
     if( res.isError === false ){
        alert('Product edited');
        window.location.assign(link_product_list);
     }else{
        alert(msg);
     }
   }
 };

 // Bind product details in form
 if( typeof product_info == "object" ){
   $.each(product_info[0], function(index, value) {
     $("[name="+index+"]").val(value);
  });
 }
});
