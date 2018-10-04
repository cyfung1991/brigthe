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
        alert('Product created');
        window.location.assign(link_product_list);
     }else{
        alert(msg);
     }
   }
 };
});
