jQuery(function($){
  $('.swp_CTT.style-onelove').each(function(){
    var url = $(this).href;
    $(this).closest('.nc_socialpanel a').attr('href',url);
  });  
});
