(function($){
  // Show/hide sections based on the section types dropdown.
  $(document).on('change', '.fm-section-type-wrapper input[type=radio]:checked', function() {
    var el = $(this),
    val = el.val(),
    sectionClassSelector = '.fm-' + val + '-wrapper';
    el.parents('.fm-section-type-wrapper').siblings().hide();
    el.parents('.fm-section-type-wrapper').siblings(sectionClassSelector).show();
  });
  $(document).ready(function(){
    $('.fm-section-type-wrapper input[type=radio]:checked').each(function(index){
      var el = $(this),
      val = el.val(),
      sectionClassSelector = '.fm-' + val + '-wrapper';
      if(val){
        el.parents('.fm-section-type-wrapper').siblings().hide();
        el.parents('.fm-section-type-wrapper').siblings(sectionClassSelector).show();
      }
    });
  });
  $(document).on( 'click', '.fm-sections-add-another', function(){
    $('.fm-section-type-wrapper input[type=radio]:checked').each(function(index){
      var el = $(this),
      val = el.val(),
      sectionClassSelector = '.fm-' + val + '-wrapper';
      if(val){
        el.parents('.fm-section-type-wrapper').siblings().hide();
        el.parents('.fm-section-type-wrapper').siblings(sectionClassSelector).show();
      }
    });
  });
})(jQuery);