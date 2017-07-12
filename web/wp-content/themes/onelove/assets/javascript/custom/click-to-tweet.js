jQuery(function($){
  $('a.swp_CTT.style-onelove').each(function(){
    var that = this;
    var anchor_to_mod = $(that).next('.nc_socialPanel').find('a');

    anchor_to_mod.unbind('click').removeAttr('href').click(
      function(event){
      event.preventDefault();
      that.click();
      }
    );
  });
});
