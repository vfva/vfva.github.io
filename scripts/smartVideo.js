function getDeviceType() {
	var userAgent = navigator.userAgent;
	var deviceType = 'Other';
	
	if (userAgent.indexOf("(iPod") > 0) {
		deviceType = 'iPod';
	} else if (userAgent.indexOf("(iPad") > 0) {
		deviceType = 'iPad';
	} else if (userAgent.indexOf("(iPhone") > 0) {
		deviceType = 'iPhone';
	} else if (userAgent.indexOf("Android") > 0) {
		deviceType = 'Android';
	}
	return deviceType;
}

function supportsH264(deviceType) {
	var knownSupport = false;
	if ((deviceType == 'iPod') || (deviceType == 'iPad') || (deviceType == 'iPhone')) {
		knownSupport = true;
	} else if (deviceType == 'Android') {
		knownSupport = true;
	}
	return knownSupport;
}

function smartVideo(divName, h264Src, h264Width, h264Height, h264posterImage, h264Autoplay, h264Controls, h264Loop, h264Preload, swfSrc, swfWidth, swfHeight, swfVersion, swfExpressInstallSrc, swfVars, swfParams, swfAttributes) {
	if (document.getElementById) {
		var targetDiv = document.getElementById(divName);
		if (targetDiv) {
			var deviceType = getDeviceType();
			
			if (supportsH264(deviceType)) {
				// embed H264 video as HTML5 for mobile devices
				
				var now = new Date();
				var uniqueId = "smartVideo_" + now.getTime() + "_" + Math.floor(Math.random() * 10000000000) + "_" + now.getMilliseconds();	
		
				var videoContents = "<video id='" + uniqueId + "' width='" + Math.abs(h264Width) + "' height='" + Math.abs(h264Height) + "' ";
				if (h264posterImage != '') {
					if (deviceType == 'iPad') {
						// iPad plays inline - the posterImage doesn't work quite right (covers the controls)
					} else {
						videoContents += "poster='" + escape(h264posterImage) + "' ";
					}
				}
				if (h264Autoplay) {
					videoContents += "autoplay='autoplay' ";
				}
				if (h264Controls) {
					videoContents += "controls='controls' ";
				}
				if (h264Loop) {
					videoContents += "loop='loop' ";
				}
				if (h264Preload) {
					videoContents += "preload='auto' ";
				}
				
				videoContents += "><source src='" + h264Src + "' type='video/mp4' /></video>";
				
				targetDiv.innerHTML = videoContents;
				
				if (deviceType == 'iPad') {
					// bug on iPad for dynamically written video tags
					var vidTag = document.getElementById(uniqueId);
					vidTag.src = h264Src;
					vidTag.load();
				}
				
			} else {
				if (swfVersion == '') {
					swfVersion = "9.0.0"; // set default version of the swfplayer to use
				}
				swfobject.embedSWF(swfSrc, divName, swfWidth, swfHeight, swfVersion, swfExpressInstallSrc, swfVars, swfParams, swfAttributes);
	
			}
			
			
			
			
		} else {
			alert("Target object missing or unsupported: '" + divName + "'");
		}
	} else {
		alert("Unsupported DOM");

	}
}







