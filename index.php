<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">  
    <head> 
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
        <meta http-equiv="X-UA-Compatible" content="chrome=1"/> 
        <meta http-equiv="Expires" content="Tue, 01 Jan 1980 1:00:00 GMT"/> 
        <meta http-equiv="Pragma" content="no-cache"/> 
        <meta name="robots" content="noindex"/>
        <title>DHCPD</title> 
        <script type="text/javascript" src="/mootools-1.2.4-core-nc.js"></script> 
        <script type="text/javascript" src="/mootools-1.2.4.4-more.js"></script> 

	<style type="text/css">
		* {
			font-family:sans-serif;
		}
		#conf div {
			margin-bottom:5px;
			margin-left:10px;
			border-left:20px solid #090;
			padding-left:10px;
		}
		#online div {
			margin-bottom:5px;
			margin-left:10px;
			border-left:20px solid #900;
			padding-left:10px;
			color:#999;
		}
		#online div.OK {
			border-left:20px solid #090;
			color:#000;
		}
        #info div.OK {
			border-left:20px solid #090;
			color:#000;
		}
		#info div {
			margin-bottom:5px;
			margin-left:10px;
			border-left:20px solid #900;
			padding-left:10px;
			color:#999;
		}
		#online div span {
			font-size:9px;
		}
	</style>
    </head> 
    <body> 
	<h1>Aktiva DHCP Leases</h1>

	<div id="online"></div>
    
    
    <div style="margin-top:30px;" id="info">Förklaringar:
        <div class="OK"> Aktivt Lease</div> 
        <div> Inaktivt Lease</div> 
    </div>
        <div>Listan uppdateras automatiskt var femte sekund</div> 
        <script type="text/javascript">
		updateMeetme = function() {
			new Request.JSON({
				url: 'dhcpd.php',
				onSuccess: function(data) {
					$('online').innerHTML = '';
                    for (key in data) {
						if ( data[key].state == 'active' ) {
						    $('online').innerHTML += '<div class="OK">'+data[key].ip+'<span> ('+data[key].hostname+')</span></div>';
						}
					}
				},
				initialDelay:0,
				delay: 5000
			}).startTimer();
		}
		updateMeetme();
        </script> 
    </body> 
</html> 
