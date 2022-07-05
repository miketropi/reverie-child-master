jQuery(document).ready(function($) {

	/* Scrolling Header */
	$(function() {
	    var header = $("header");
	    $(window).scroll(function() {
	        var scroll = $(window).scrollTop();
	        if (scroll >= 60) {
	            header.addClass("scrolled");
	        } else {
	            header.removeClass("scrolled");
	        }
	    });
	});


	/* Mobile Menu */
	$( "a.mobile-menu, .main-menu li.close" ).click(function(event) {
		event.preventDefault();
		$(this).toggleClass('active');
		$('body').toggleClass('active');
		$('nav').toggleClass('open');
	});

	$( "a.search-btn" ).click(function(event) {
		event.preventDefault();
		$(this).toggleClass('active');
		$('.searchHolder').toggleClass('active');
		//$('nav').toggleClass('open');
	});


	setTimeout(function(){
    	if ( $( "table.wdp_pricing_table" ).length ) {
        	// nothing
        } else {
            $('.woocommerce-product-details__long-description').addClass('full') ;
        }
	},1000);



	$( "a#calc" ).click(function(event) {
		event.preventDefault();
		var token = '';
		var weight = $( "input#weight" ).val();
		var suburb = $( "input#suburb" ).val();
		var postcode = $( "input#postcode" ).val();
		var price = '';
		//var temp_price;

		$.ajax({
			type: "POST",
			url: 'https://idserv.airroad.com.au/connect/token',
			data: {
				"grant_type": "password",
				"username":"RCCOATINGS",
				"password":"RCCSEALERS",
				"Client_id":"AirRoad_Web",
				"client_secret":"hHQyfi0uNKmHomqystOa",
				"scope":"openid profile connoteservice transitcalcservice postcodeservice holidayservice quoteservice"
			},
			dataType: 'json',
			crossDomain: true,
			//contentType: "application/x-www-form-urlencoded",
			success: function(result){
				token = result['access_token'];
				nextFunction(token);
			}
		});

		function nextFunction(token) {

			var weight = $( "input#weight" ).val();
			var suburb = $( "input#suburb" ).val();

			//suburb = suburb.replace(/\+/g, '%20');

			var postcode = $( "input#postcode" ).val();
			var surcharge = 0;
			var price;
			console.log(suburb);

			$.ajax({
				type: 'GET',
				url: "https://my.airroad.com.au/api/v2/quote",
				data: {
					"fromcode": 4129,
					"locid": 4272,
					"tocode":postcode,
					"wgt":weight,
					"fromsub":"loganholme",
					"tosub":suburb
				},
				headers: {"Authorization": "Bearer "+token},
				crossDomain: true,
				success: function(resultTwo){

					console.log(resultTwo);

					if (resultTwo['message']) {
						$('div#result').html('<p class="error">'+resultTwo['message']+'</p>');
					} else {

						if (resultTwo['surcharge']) {
							surcharge = resultTwo['surcharge'];
						}

						price = resultTwo['amount'] + resultTwo['fuelLevy'] + resultTwo['gst'] + surcharge;
						let percentage_price = (5 / 100) * price;
						price = price + percentage_price;
						price = parseFloat(price);
						if (price < 25) {
							price = 27.50;
						}

						nextFunctionFunction(price.toFixed(2));

					}
				},
				error: function(data) {
					console.log(data.responseJSON.message);
					if (data.responseJSON.message == 'This is a Price On Application area. Please contact your account manager to proceed.') {
						$('div#result').html('<p class="error">Your suburb is in a Price On Application area. Please contact us to get a quote for your shipping.</p>');
					} else if (data.responseJSON.message == 'To address not found') {
						$('div#result').html('<p class="error">Your Suburb or Postcode cannot be found. Please ensure these have been entered correctly</p>');
					} else {
						$('div#result').html('<p class="error">'+data.responseJSON.message+'</p>');
					}
    			}
			});
		}

		function nextFunctionFunction(price) {
			//alert(temp_price);
			if (price == "") {
				$('div#result').html('<p>error</p>');
			} else {
				$('div#result').html('<p>The estimated cost to ship '+weight+'L to '+suburb+' is $'+price+'</p>');
			}
		}

	});

	$( ".gfield_radio label" ).click(function() {
		$('.nothing-found').removeClass('active');
		setTimeout(function(){
			if (!$('li.gfield_html').is(':visible')) {
				$('.nothing-found').addClass('active');
			} else {

			}
		},100);
	});
	// fix click link downloads
	$( ".woocommerce-Tabs-panel--information-guides a" ).click(function(e) {
		e.preventDefault();
		e.stopPropagation();
		var url = $(this).attr('href');
		var target = $(this).attr('target');
		if(url && url != '#'){
			window.open(url, target).focus();
		}
	})

});
