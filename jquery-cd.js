
jQuery(document).ready(function () {
  var name = '#' + jQueryCD.output_id;
  var width;
  jQueryCD.dc_started = false;
  jQuery(jQueryCD.source_selector +' '+ jQueryCD.header_tag).each(function (index) {
    // 创建主体
    if(!jQueryCD.dc_started) {
      jQuery(jQueryCD.source_selector).prepend('<div id="'+jQueryCD.output_id+'"><strong>'+ jQueryCD.output_title +'</strong><span id="jhidden">[隐藏]</span><ul id="jul"></ul></div>');
      jQueryCD.dc_started = true;
    }

    // 创建标签 h* tag
    var header = jQuery(this);
    var headerId = 'header-'+index;
    header.attr('id', headerId);
    // 创建列表
    var li = jQuery('<li></li>').appendTo('#' + jQueryCD.output_id + ' ul');
    jQuery('<a></a>').text(header.text()).attr({ 'title': '跳转至 '+header.text(), 'href': '#'+headerId }).appendTo(li);
  });
  
  $('#jhidden').click(
		function(event) {
		if($('#jhidden').html() == '[隐藏]')
		{
      		width = $(name).css("width");
			$(name).css('width','auto');
			$('#jul').hide();
			$('#jhidden').html('[显示]');
		}
		else
		{
			$(name).css('width',width);
			$('#jul').show();
			$('#jhidden').html('[隐藏]');
		}
	}
);

});