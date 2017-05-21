jQuery(document).ready(function($) {    
    
    console.log('browser-detect.js loaded!');
    
    var BrowserDetect = {
        init: function () {
            this.browser = this.searchString(this.dataBrowser) || "Other";
            this.version = this.searchVersion(navigator.userAgent) || this.searchVersion(navigator.appVersion) || "Unknown";
        },
        searchString: function (data) {
            for (var i = 0; i < data.length; i++) {
                var dataString = data[i].string;
                this.versionSearchString = data[i].subString;

                if (dataString.indexOf(data[i].subString) !== -1) {
                    return data[i].identity;
                }
            }
        },
        searchVersion: function (dataString) {
            var index = dataString.indexOf(this.versionSearchString);
            if (index === -1) {
                return;
            }

            var rv = dataString.indexOf("rv:");
            if (this.versionSearchString === "Trident" && rv !== -1) {
                return parseFloat(dataString.substring(rv + 3));
            } else {
                return parseFloat(dataString.substring(index + this.versionSearchString.length + 1));
            }
        },

        dataBrowser: [
            {string: navigator.userAgent, subString: "Chrome", identity: "Chrome"},
            {string: navigator.userAgent, subString: "MSIE", identity: "Explorer"},
            {string: navigator.userAgent, subString: "Trident", identity: "Explorer"},
            {string: navigator.userAgent, subString: "Firefox", identity: "Firefox"},
            {string: navigator.userAgent, subString: "Safari", identity: "Safari"},
            {string: navigator.userAgent, subString: "Opera", identity: "Opera"}
        ]

    };

    BrowserDetect.init();
    
    browser_version = parseFloat(BrowserDetect.version);
    
    console.log('Browser: '+BrowserDetect.browser+' v'+browser_version);
    
    if (BrowserDetect.browser == "Explorer" && (browser_version <= 11) ) {
        alert('You are using an outdated browser ('+BrowserDetect.browser+' v'+browser_version+').\nWebpage elements may not render correctly.\nPlease upgrade to Microsoft Edge or use other browser such Chrome or Firefox.\nNOTE: Microsoft Edge is only available on Windows 10.');
		$('.genesis-nav-menu.menu-primary').css('padding-left', '200px');
    }
    
}); // End of jQuery(document).ready(function($)