import './styles/main.scss';

jQuery(document).ready(function($) {

	let now = new Date().getTime();
	let timer = (parseInt(mwcb.cdtimerseconds)*1000) + (parseInt(mwcb.cdtimerminutes) * 60 * 1000) + (parseInt(mwcb.cdtimerhours) * 60 * 60 * 1000) + (parseInt(mwcb.cdtimerdays) * 60 * 60 * 24 * 1000);
	let until = now + timer;
	let show = false; 
	let cookie = Cookies.get('mwcb');
	//console.log(typeof cookie);
	//console.log('ahora: ' + now);
	//console.log('diferencia: ' + timer);
	if (typeof cookie == 'undefined') {	
		show = true;
		//console.log('nueva cookie ' + until);
		mwcb_banner_update(now, parseInt(until));
		Cookies.set('mwcb', until , { expires: parseInt(mwcb.cookieduration) });
	} else if (parseInt(cookie) > now) {
		show = true;
		//console.log('cookie vieja ' + parseInt(cookie));
		mwcb_banner_update(now, parseInt(cookie));
	} else {
		//console.log('no muestra: ' + parseInt(cookie));
	}
	
    if (show) {

    	let banner =`	<div class="mwcb-container" style="background:`+ mwcb.bgcolor +`; color:`+ mwcb.textcolor +`;">
						<div class="mwcb-container-inner">
							<div class="mwcb-col-1 mwcb-image">
							<img src="`+ mwcb.imgurl +`"/>
							</div>
							<div class="mwcb-col-2">
								<div class="mwcb-text">`+ mwcb.text +`</div>
								<div class="mwcb-counter"> `
									
		if (mwcb.cdtimerdays != 0) {
		banner +=						`<div class="mwcb-datebox mwcb-days">
											<div class="mwcb-number mwcb-days-number"></div>
											<div class="mwcb-t-name">`+ mwcb.days +`</div>
										</div>`
		}

		banner +=						`<div class="mwcb-datebox mwcb-hours">
											<div class="mwcb-number mwcb-hours-number"></div>
											<div class="mwcb-t-name">`+ mwcb.hours +`</div>
										</div>
										<div class="mwcb-datebox mwcb-minutes">
											<div class="mwcb-number mwcb-minutes-number"></div>
											<div class="mwcb-t-name">`+ mwcb.min +`</div>
										</div>
										<div class="mwcb-datebox mwcb-seconds">
											<div class="mwcb-number mwcb-seconds-number"></div>
											<div class="mwcb-t-name">`+ mwcb.sec +`</div>
										</div>
									</div>
								</div>
							</div>
					 	</div>`;

	    $(banner).prependTo('body');
    }
	
	function mwcb_banner_update (now , until ) {
			let dif, days, mod, hours, minutes, seconds;
		setInterval( function mwcb_update () {
			
			dif = until - now;

			days = dif / (1000 * 60 * 60 * 24);
			mod = days % 1;
			days = Math.floor(days);

			hours = mod * 24;
			mod = hours % 1;
			hours = Math.floor(hours);

			minutes = mod * 60;
			//mod = minutes % 1;
			minutes = Math.floor(minutes);

			seconds = mod * 60;
			//mod = seconds % 1;
			seconds = Math.floor(seconds);

			console.log(mod);

	    	$('.mwcb-days-number').html(days);
	    	$('.mwcb-hours-number').html(hours);
	    	$('.mwcb-minutes-number').html(minutes);
	    	$('.mwcb-seconds-number').html(seconds);

	   		now += 1;
	    },1000);
	}

    $('.et_pb_button').click(function(event){
    	event.preventDefault();
 		console.log('eliminar cookie');
    	Cookies.remove('mwcb');
    })

});