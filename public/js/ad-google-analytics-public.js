(function($) {
  'use strict';

  function aga_send_event(category, action, label) {

    gtag("event", action, {
      'event_category': category,
      'event_label': label
    });

  }

  $(window).on("load", function() {

    if (window.gtag == null) {
      return;
    }

    // Download Link Match
    var link_match = new RegExp(".*\\.(" + aga_event_data.options.event_downloads + ")(\\?.*)?$");

    // Link Click
    $(document).on("click", "a", function(e) {
      var url_parse;
      try {
        url_parse = new URL(this.href);
      } catch (error) {}
      // Email Links
      if (url_parse.protocol === "mailto:") {
        aga_send_event(this.getAttribute("data-ga-category") || "email", this.getAttribute("data-ga-action") || "send", this.getAttribute("data-ga-label") || this.href);
      // Telephone Links
      } else if (url_parse.protocol === "tel:") {
        aga_send_event(this.getAttribute("data-ga-category") || "telephone", this.getAttribute("data-ga-action") || "call", this.getAttribute("data-ga-label") || this.href);
      // External Links Opening in New Tab/Window.
      // NOTE: Excluding links not opening in new tab due to limiations of
      // having to stop default link action, send event and then trigger redirect issues
      } else if (this.href.indexOf(aga_event_data.options.root_domain) == -1 && (url_parse.protocol === "http:" || url_parse.protocol === "https:") && this.target === "_blank") {
        aga_send_event(this.getAttribute("data-ga-category") || "outbound", this.getAttribute("data-ga-action") || "click", this.getAttribute("data-ga-label") || this.href);
      // Download Links
      } else if (this.href.match(link_match)) {
        aga_send_event(this.getAttribute("data-ga-category") || "download", this.getAttribute("data-ga-action") || "click", this.getAttribute("data-ga-label") || this.href);
      }
    });
  });

})(jQuery);
