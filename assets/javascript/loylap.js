// Only do this when the DOM has loaded
jQuery(function() {
  var browser = (function(agent) {
    switch (true) {
      case agent.indexOf('edge') > -1:
        return 'edge'
      case agent.indexOf('opr') > -1 && !!window.opr:
        return 'opera'
      case agent.indexOf('chrome') > -1 && !!window.chrome:
        return 'chrome'
      case agent.indexOf('trident') > -1:
        return 'ie'
      case agent.indexOf('firefox') > -1:
        return 'firefox'
      case agent.indexOf('safari') > -1:
        return 'safari'
      default:
        return 'other'
    }
  })(window.navigator.userAgent.toLowerCase())

  switch (browser) {
    case 'firefox':
    case 'ie':
      var message = document.createElement('div')
      message.className = 'loylap-box'
      message.innerHTML =
        'For the loylap plugin to work correctly, please allow popups!'

      var close = document.createElement('div')
      close.addEventListener('click', function(e) {
        message.style.display = 'none'
      })
      message.appendChild(close)
      document.body.appendChild(message)
      break
    default:
      break
  }

  // Onclick Listeners:

  // NOTE: This is a little complicated but
  // if someone was to put the shortcode in multiple times
  // on the same page. We would end up with multiple elements all having the same ID,
  // Thus assigning the click handler can't be done like:
  //
  //    jQuery("#loylap_toggle").click(OnLoylapButtonClick);
  //
  // So we need to check wheter the result of looking for an element with id `loylap_toggle`
  // returns an array. If so ( and this is where it gets annoying) we will need to go
  // through the array and assign a OnClick handler for each on of them, since we
  // can't ( for as far as I am aware ) know which one will show on top !
  try {
    // check if it returns an array
    if (Array.isArray(jQuery('#loylap_toggle'))) {
      // Go through and assign OnClick handler to all of them
      jQuery('#loylap_toggle').forEach(function(item, index) {
        jQuery(item).click(OnLoylapButtonClick)
      })
    } else {
      // Assign a OnClick handler to that object
      jQuery('#loylap_toggle').click(OnLoylapButtonClick)
    }
  } catch (e) {
    // if we end up here we have failed to assign
    // one or more click handlers
    console.error(e.message)
  }

  // OnClick Handlers
  /**
   * @param {*} e
   */
  function OnLoylapButtonClick(e) {
    try {
      obj = jQuery('#loylap_widget')
      if (obj.is(':hidden')) {
        obj.show()
      } else {
        obj.hide()
      }
    } catch (e) {
      console.error(e.message)
    }
  }
})
