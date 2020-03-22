(function($) {
  'use strict';

  function aga_send_event(category, action, label, event_delay) {

		//console.log(category);
		//console.log(action);
		//console.log(label);
		//console.log(event_delay);

    if (event_delay) {

      var aga_redirect_link = function() {
        window.location.href = label;
      };

      gtag("event", action, {
        'event_category': category,
        'event_label': label,
        'event_callback': aga_redirect_link
      });

      setTimeout(aga_redirect_link, 150);

    } else {
      gtag("event", action, {
        'event_category': category,
        'event_label': label
      });
    }

  }

  $(window).on("load", function() {

    if (window.gtag == null) {
      return;
    }

    // Download Link Match
    var link_match = new RegExp(".*\\.(" + aga_event_data.options.event_downloads + ")(\\?.*)?$");
    // Link Click
    $(document).on("click", "a", function(e) {
      if (e.target.protocol === "mailto:") {
        aga_send_event(this.getAttribute("data-ga-category") || "email", this.getAttribute("data-ga-action") || "send", this.getAttribute("data-ga-label") || this.href);
      } else if (e.target.protocol === "tel:") {
        aga_send_event(this.getAttribute("data-ga-category") || "telephone", this.getAttribute("data-ga-action") || "call", this.getAttribute("data-ga-label") || this.href);
      } else if (this.href.indexOf(aga_event_data.options.root_domain) == -1 && (e.target.protocol === "http:" || e.target.protocol === "https:")) {
        if (this.target != "_blank") {
          aga_send_event(this.getAttribute("data-ga-category") || "outbound", this.getAttribute("data-vars-ga-action") || "click", this.getAttribute("data-vars-ga-label") || this.href, true);
          e.preventDefault();
        } else {
          aga_send_event(this.getAttribute("data-ga-category") || "outbound", this.getAttribute("data-vars-ga-action") || "click", this.getAttribute("data-vars-ga-label") || this.href);
        }
      } else if (this.href.match(link_match)) {
        aga_send_event(this.getAttribute("data-ga-category") || "download", this.getAttribute("data-ga-action") || "click", this.getAttribute("data-ga-label") || this.href);
      }
    });
  });

})(jQuery);
