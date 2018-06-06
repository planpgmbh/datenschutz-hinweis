jQuery(function($) {
  var expiryDate = new Date();
  expiryDate.setTime(expiryDate.getTime()+(90*24*60*60*1000));
  var expires = "; expires="+expiryDate.toGMTString();
  $('#data-privacy .ok').click(function() {
  	document.cookie = "data-privacy=yes"+expires;
  	$('#data-privacy').hide();
  });
  if (document.cookie.indexOf("data-privacy") > -1) {
		$('#data-privacy').hide();
	} else {
    $('#data-privacy').show();
  }
});
