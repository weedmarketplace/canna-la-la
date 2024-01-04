(function(){
    var Loading = function Loading() {
        this.el = false;
        this.add = function(el) {
            el.addClass('loading');
        }
        this.remove = function(el) {
            el.removeClass('loading');
        }
    };
  window.Loading = new Loading();
})(window);

$(document).on('click', '.order_feed a', function(e) {
    e.preventDefault();
    updateOrders($(this).attr('href'));
});

function updateOrders(url) {

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        type: 'GET',
        data: {},
        success: function(data) {
			$('html, body').animate({
				scrollTop: $('.load_order_feed').offset().top -150
			}, 500, function(){
			});
            $('.load_order_feed').html(data.orders).removeClass('content_loader');
        },
        beforeSend: function() {
            $('.load_order_feed').addClass('content_loader');
        }
    });
}