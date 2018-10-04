$(document).ready(function(){
  // Sort function
  $("body").on("click", ".sort", function(){
    var this_sort = $(this).data('sort');
    var this_order = "ASC";
    if( this_sort == sort_by ){
      this_order = (order === "ASC") ? "DESC" : "ASC";
    }else{
      this_order = "ASC";
    }
    var goto = current_page+"1/"+this_sort+"/"+this_order;
    // console.log(goto);
    window.location.assign(goto);
  });
  // Delete function
  $("body").on("click", ".delete", function(){
      var product_id = $(this).data('pid');
      var name = $(this).data('name');
      var cfm_del = confirm("Do you want to delete product:"+name);
      if( cfm_del == false){
        return;
      }
      $.ajax({
        type: 'post',
        cache: false,
        url: delete_link,
        data: {
          'product_id': product_id,
          'status': 0
        },
        dataType: 'json',
        success: function(response){
          if(response.isError == 0){
            // Success
            alert(response.msg);
            window.location.reload();
          }else{
            alert(response.msg);
          }
        }
      });
    });
});
