"use strict";

;
/* global wppopups_settings,*/

(function ($) {
  'use strict';

  var WPPopups = {
    popups: {},
    byBind: {
      'class': [],
      'href': []
    },

    /**
     * Start the engine.
     *
     * @since 2.0.0
     */
    init: function init() {
      // Document ready
      $(document).ready(WPPopups.ready); // Page load

      $(window).on('load', WPPopups.load); // Document ready

      $(document).on('wppopupsReady', WPPopups.start);
      WPPopups.bindUIActions();
    },

    /**
    * Document ready.
    *
    * @since 2.0.0
    */
    ready: function ready() {
      $(document).trigger('wppopupsBeforeReady');
      if ($(".spu-box").length == 0) return false;
      var data = {
        action: 'wppopups_rules',
        pid: wppopups_vars.pid,
        referrer: document.referrer,
        url: document.documentURI,
        query_string: document.location.search,
        is_category: wppopups_vars.is_category,
        is_archive: wppopups_vars.is_archive,
        is_singular: wppopups_vars.is_singular,
        is_preview: wppopups_vars.is_preview,
        is_search: wppopups_vars.is_search,
        is_front_page: wppopups_vars.is_front_page,
        is_blog_page: wppopups_vars.is_blog_page,
        popups: []
      }; // save all popups rules into data

      $(".spu-box").each(function () {
        var $popup = $(this),
            $id = $popup.data('id'),
            $rules = WPPopups.settings($popup, 'rules'); // if old popup it's enabled id will be empty and break things

        if ($id) {
          data.popups.push({
            id: $id,
            rules: JSON.stringify($rules),
            parent: $popup.data('parent')
          });
        }
      });
      var ajax = {
        url: wppopups_vars.ajax_url,
        data: window.wp.hooks.applyFilters('wppopups_pre_ready_data', data),
        cache: false,
        type: 'POST',
        dataType: 'json',
        timeout: 30000,
        success: function success(r) {
          if (r.success) {
            r.success.forEach(function (id) {
              WPPopups.removePopup(id);
            });
          }

          $(document).trigger('wppopupsReady');
        },
        error: function error(r) {
          console.log(r);
        }
      };
      $.ajax(ajax);
    },

    /**
     * Page load.
     *
     * @since 2.0.0
     */
    load: function load() {
      // center again once it's loaded
      $(".spu-box").each(function () {
        var $popup = $(this);
        WPPopups.centerPopup($popup, true);
      });
    },
    start: function start() {
      WPPopups.initVideoSources();
      WPPopups.resetPopupsContent();
      WPPopups.hashTriggerPopups();
      WPPopups.loopPopups(); // Set user identifier
      // WPPopups.setUserIndentifier(); not needed for now

      WPPopups.initSocialShortcodes();
      $(document).trigger('wppopupsStarted');
    },

    /**
     * Configure each popup
     */
    loopPopups: function loopPopups() {
      $(".spu-box").each(function () {
        var $popup = $(this),
            $id = $popup.data('id'); // Save popup for later

        WPPopups.popups[$id] = $popup; // all triggers added by users

        WPPopups.bindPopupTriggers($popup); // click triggers

        WPPopups.bindClickTriggers($popup); // Forms inside popups

        WPPopups.formSubmissions($popup); // Forms Email Marketing

        WPPopups.formOptinSubmissions($popup); // Events bindings

        $(window).resize(function () {
          WPPopups.checkPopupSize($popup);
          WPPopups.centerPopup($popup, true);
        }); // This hook will be used by third parties

        window.wp.hooks.doAction('wppopups_loop', $popup);
        window.wp.hooks.addAction('wppopups_show_popup', 'wppopups', WPPopups.centerPopup, 99); // hide it

        $popup.hide();
      });
    },
    // --------------------------------------------------------------------//
    // Triggers
    // --------------------------------------------------------------------//

    /**
    * Trigger popup after N seconds
     * @param value
     * @param $popup
     */
    triggerBySeconds: function triggerBySeconds(value, $popup) {
      // if not value provided abort
      if (value === '') {
        return;
      }

      if ($popup.timer) {
        clearTimeout($popup.timer);
      }

      $popup.timer = window.setTimeout(function () {
        if (WPPopups.checkConvertion($popup)) {
          WPPopups.showPopup($popup);
        }
      }, parseInt(value, 10) * 1000);
    },

    /**
    * Trigger if scroll % amount of screen
     * @param value
     * @param $popup
     */
    triggerByPercentage: function triggerByPercentage(value, $popup) {
      // if not value provided abort
      if (value === '') {
        return;
      }

      var $settings = WPPopups.settings($popup, 'settings'); // use custom namespace bind for off later

      $(window).on('scroll.per' + $popup.data('id'), function () {
        if ($popup.timer) {
          clearTimeout($popup.timer);
        }

        $popup.timer = window.setTimeout(function () {
          var triggerHeight = parseInt(value, 10) / 100 * $(document).height();
          var scrollY = $(window).scrollTop(),
              trigger = scrollY + $(window).height() >= triggerHeight; // show box when criteria for this box is matched

          if (trigger && WPPopups.checkConvertion($popup)) {
            // remove listen event if box shouldn't be hidden again. TODO: add auto hide in trigger settings
            if (!$settings.auto_hide) {
              $(window).off('scroll.per' + $popup.data('id'));
            }

            WPPopups.showPopup($popup);
          } else {
            WPPopups.hidePopup($popup, false, 10, false);
          }
        }, 100);
      });
    },

    /**
    * Bind TRigger after user scrolled X pixels
     * @param value
     * @param $popup
     */
    triggerByPixels: function triggerByPixels(value, $popup) {
      // if not pixels provided abort
      if (value === '') {
        return;
      }

      var $settings = WPPopups.settings($popup, 'settings');
      $(window).on('scroll.pix' + $popup.data('id'), function () {
        if ($popup.timer) {
          clearTimeout($popup.timer);
        }

        $popup.timer = window.setTimeout(function () {
          var scrollY = $(window).scrollTop(),
              trigger = scrollY >= parseInt(value, 10); //triggerSeconds equals to the number field really
          // show box when criteria for this box is matched

          if (trigger && WPPopups.checkConvertion($popup)) {
            // remove listen event if box shouldn't be hidden again
            if (!$settings.auto_hide) {
              $(window).off('scroll.pix' + $popup.data('id'));
            }

            WPPopups.showPopup($popup);
          } else {
            WPPopups.hidePopup($popup, false, 10, false);
          }
        }, 100);
      });
    },
    triggerByClass: function triggerByClass(value, $popup) {
      // if not class provided abort
      if (value === '') {
        return;
      } // add . to class attribute if missing


      value = value.charAt(0) != '.' ? '.' + value : value;
      WPPopups.setBindActions(value, 'class'); // Only add the trigger if not cookies are set for popup

      if (WPPopups.hasCookies($popup)) {
        return;
      }

      $(document.body).on('click', value, function (e) {
        e.preventDefault();
        WPPopups.showPopup($popup);
      });
    },
    // --------------------------------------------------------------------//
    // Binds
    // --------------------------------------------------------------------//

    /**
    * Bind document triggers for popups
     * @param $popup
     */
    bindClickTriggers: function bindClickTriggers($popup) {
      var id = $popup.data('id');
      WPPopups.setBindActions('.spu-open-' + id, 'class');
      WPPopups.setBindActions('#spu-' + id, 'href'); // Only add the trigger if not cookies are set for popup

      if (WPPopups.hasCookies($popup)) {
        return;
      } // add link listener for this box


      $(document.body).on('click', 'a[href="#spu-' + id + '"], .spu-open-' + id, function (e) {
        e.preventDefault();
        WPPopups.showPopup($popup, true);
      });
      $('a[href="#spu-' + id + '"], .spu-open-' + id).css('cursor', 'pointer').addClass('spu-clickable');
    },

    /**
    * Bind triggers set in popup settings
     * @param $popup
     */
    bindPopupTriggers: function bindPopupTriggers($popup) {
      if (window.wp.hooks.applyFilters('wppopups_disable_triggers', false, $popup)) return;
      var $triggers = WPPopups.settings($popup, 'triggers');

      if (Object.keys($triggers).length) {
        for (var i in $triggers) {
          var func = 'triggerBy' + $triggers[i].trigger.charAt(0).toUpperCase() + $triggers[i].trigger.substr(1),
              settings = WPPopups.settings($popup, 'settings');

          if (!WPPopups.hasCookies($popup) || wppopups_vars.is_preview || func == 'triggerByClass' || wppopups_vars.is_admin && settings.test_mode == '1') {
            // only try if func really exist , may be premium one
            if (typeof WPPopups[func] == 'function') {
              WPPopups[func]($triggers[i].value, $popup);
            } // hook for premium


            window.wp.hooks.doAction('wppopups_trigger_popup', func, $triggers[i].value, $popup);
          }
        }
      }
    },

    /**
    * Element bindings.
    *
    * @since 2.0.0
    */
    bindUIActions: function bindUIActions() {
      // Custom links inside popups conversion
      $(document).on('click', '.spu-box a:not(".spu-close-popup, .spu-box .flp_wrapper a, .spu-box .spu-not-close, .spu-box .spu-not-close a, .spu-box .spu-gdpr a")', function () {
        // hide the popup and track conversion
        WPPopups.hidePopup($(this), true);
      }); // Close and convert button, similar to above

      $(document).on('click', '.spu-box .spu-close-convert,.spu-box .spu-close-convert a', function (e) {
        e.preventDefault(); // hide the popup and track conversion

        WPPopups.hidePopup($(this), true);
      }); //close popup

      $(document).on('click', '.spu-box .spu-close-popup', function (e) {
        e.preventDefault(); // hide box, no conversion

        WPPopups.hidePopup($(this), false);
      }); //close with esc

      $(document).keyup(function (e) {
        if (e.keyCode == 27) {
          WPPopups.togglePopups(false, false);
        }
      }); // close by clicking outside of popup
      // get event by device or browser

      var ua = navigator.userAgent,
          event = ua.match(/iPad/i) || ua.match(/iPhone/i) ? "touchstart" : "click";
      $('body').on(event, function (ev) {
        var $target = $(ev.target); // TODO:
        // for some reason ninja form not working, added this dirty workaround
        // $target.is('.spu-box *, .spu-box') return false, same for .has .parents, etc
        // so no popup closing when form is clicked

        if ($target.is('input.nf-element')) return; // verify if some bindAction is present

        if (WPPopups.checkBindActions($target)) return;
        if (window.wp.hooks.applyFilters('wppopups_disable_click_out', false, $target)) return; // test that event is user triggered and not programatically,
        // and that it is not fired  within the box

        if (ev.originalEvent !== undefined && !$target.is('.spu-box *, .spu-box')) {
          WPPopups.togglePopups(false, false);
        }
      });
    },

    /**
    * Return setting from popup
     * @param popup
     * @param key
     * @returns {*}
     */
    settings: function settings(popup, key) {
      var settings = {};

      if (popup.data('settings')) {
        settings = popup.data('settings');
      }

      if (key && typeof settings[key] != 'undefined') {
        return settings[key];
      }

      return settings;
    },

    /**
    * Wrapper to execute toggle box on all popups
     * @param elements
     * @param show
     * @param conversion
     */
    togglePopups: function togglePopups(show, conversion) {
      $('.spu-box').each(function () {
        if (show) {
          WPPopups.showPopup($(this));
        } else {
          // premium version may disable advanced closing methods which use tooglePopups
          if (window.wp.hooks.applyFilters('wppopups_allow_togglePopups', true, $(this))) {
            WPPopups.hidePopup($(this), conversion);
          }
        }
      });
    },

    /**
    * Show given popup
     * @param popup
     * @param forse true/false
     * @returns {boolean}
     */
    showPopup: function showPopup(popup) {
      var force = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
      var $popup = WPPopups.getPopup(popup),
          $id = $popup.data('id'),
          $bg = $('#spu-bg-' + $id); // don't do anything if box is undergoing an animation or already visible

      if ($popup.is(":animated") || $popup.is(":visible")) {
        return false;
      } // don't do anything if popup has any cookie created


      if (!force && WPPopups.hasCookies($popup)) {
        return false;
      } // show container and the popup


      $popup.parent('.wppopups-whole').show(); // Overlay Blur

      WPPopups.toggleBlur($popup, true);
      WPPopups.centerPopup($popup); // I want to stop  supporting social shortcodes, let's see how many complain

      /* setTimeout(function(){
           WPPopups.centerShortcodes($popup);
       },1500);*/
      // Add scroll if needed

      WPPopups.checkPopupSize($popup); // show box

      var animation = WPPopups.settings($popup, 'animation');

      switch (animation.animation) {
        case 'fade':
          $popup.hide().fadeIn('slow');
          break;

        case 'slide':
          $popup.hide().slideDown('slow');
          break;

        default:
          $popup.show();
          break;
      } //background only if not bottom/top bars


      if (!$popup.hasClass('spu-position-top-bar') && !$popup.hasClass('spu-position-bottom-bar')) {
        if (animation.animation === 'disable') {
          $bg.show();
        } else {
          $bg.fadeIn();
        }
      } // Hook for show popup, used for example for premium animations


      window.wp.hooks.doAction('wppopups_show_popup', $popup); // show videos if any

      WPPopups.toggleVideoSources($popup, true); // trigger opening

      $popup.trigger('wppopups.popup_opened', [$id]);
    },

    /**
    * Hide given popup
     * @param popup
     * @param conversion
     * @param time
     * @returns {boolean}
     */
    hidePopup: function hidePopup(popup, conversion) {
      var time = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 0;
      var cookie = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : true;
      var $popup = WPPopups.getPopup(popup),
          $id = $popup.data('id'),
          $bg = $('#spu-bg-' + $id); // don't do anything if box is undergoing an animation or already visible

      if ($popup.is(":animated") || $popup.is(":hidden") || window.wp.hooks.applyFilters('wppopups_cancel_hide', false, $popup, conversion)) {
        return false;
      } // save cookie


      if (conversion === true) {
        WPPopups.popupConverted($popup, cookie);
      }

      var settings = WPPopups.settings($popup, 'settings');

      if (settings.close_on_conversion == '1' && conversion || !conversion) {
        setTimeout(function () {
          var animation = WPPopups.settings($popup, 'animation'); // Hide with animation

          switch (animation.animation) {
            case 'slide':
              $popup.slideUp('slow');
              $bg.fadeOut();
              break;

            case 'disable':
              $popup.hide();
              $bg.hide();
              break;

            default:
              $popup.removeClass('spu-animation-animated');
              $popup.fadeOut('slow');
              $bg.fadeOut();
              break;
          } // Hook for show popup, used for example for premium animations


          window.wp.hooks.doAction('wppopups_hide_popup', $popup); // hide videos if any

          WPPopups.toggleVideoSources($popup, false);
        }, parseInt(time, 10));
      } // Overlay Blur


      WPPopups.toggleBlur($popup, false); // save cookie

      WPPopups.popupClosed($popup, cookie);
    },
    centerPopup: function centerPopup(popup, animate) {
      if (!popup.hasClass('spu-position-centered') && !popup.hasClass('spu-position-float-right') && !popup.hasClass('spu-position-float-left')) {
        return;
      }

      if (popup.is(':animated')) {
        return;
      }

      var ww = $(window).width(),
          wh = $(window).height(),
          pw = popup.outerWidth(),
          ph = popup.outerHeight(); // To center the box

      var boxLeft = ww / 2 - pw / 2,
          boxTop = wh / 2 - ph / 2;
      var css = {
        top: boxTop
      };

      if (popup.hasClass('spu-position-centered')) {
        css.left = boxLeft;
      }

      if (animate) {
        popup.animate(css, {
          queue: !1,
          duration: 200
        });
      } else {
        popup.css(css);
      }
    },

    /**
     * Removes the popup from DOM
     * @param $popup
     */
    removePopup: function removePopup(popup) {
      var $popup = WPPopups.getPopup(popup),
          $id = $popup.data('id'),
          $bg = $('#spu-bg-' + $id),
          $css = $('#spu-css-' + $id);
      $popup.remove();
      $bg.remove();
      $css.remove();
    },

    /**
     * Track popup conversion (save cookie)
     * @param $popup
     */
    popupConverted: function popupConverted($popup) {
      var cookie = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;

      if (cookie) {
        // set cookie
        var settings = WPPopups.settings($popup, 'settings'),
            duration = parseFloat(settings.conversion_cookie_duration),
            _cookie = settings.conversion_cookie_name,
            type = settings.conversion_cookie_type;

        if (duration > 0) {
          WPPopups.createCookie(_cookie, true, duration, type);
        }
      }

      $popup.trigger('wppopups.popup_converted', [$popup.data('id')]);
    },

    /**
     * Track popup closing (save cookie)
     * @param $popup
     */
    popupClosed: function popupClosed($popup) {
      var cookie = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;

      if (cookie) {
        // set cookie
        var settings = WPPopups.settings($popup, 'settings'),
            duration = parseFloat(settings.closing_cookie_duration),
            _cookie2 = settings.closing_cookie_name,
            type = settings.closing_cookie_type;

        if (duration > 0) {
          WPPopups.createCookie(_cookie2, true, duration, type);
        }
      }

      $popup.trigger('wppopups.popup_closed', [$popup.data('id')]);
    },

    /**
     * Check if the popup has any cookies created.
     * @param $popup
     */
    hasCookies: function hasCookies($popup) {
      var $settings = WPPopups.settings($popup, 'settings'),
          conversion_name = $settings.conversion_cookie_name,
          closing_name = $settings.closing_cookie_name;
      var hasCookies = false;

      if (!(wppopups_vars.is_admin && $settings.test_mode == '1') && (WPPopups.getCookie(conversion_name) || WPPopups.getCookie(closing_name))) {
        hasCookies = true;
      }

      return hasCookies;
    },

    /**
     * Apply Overlay Blur
     * @param  $popup
     * @param  show   true/false
     * @return        
     */
    toggleBlur: function toggleBlur($popup, show) {
      // Overlay Blur
      var colors = WPPopups.settings($popup, 'colors'),
          $id = $popup.data('id'),
          $box_css = $('#spu-css-' + $id);

      if (colors.show_overlay == 'yes-blur') {
        if (show) {
          var blur_px = colors.overlay_blur ? colors.overlay_blur : 2,
              blur_css = '/* ini:blur */body > *:not(.wppopups-whole) { -webkit-filter: blur(' + blur_px + 'px); -moz-filter: blur(' + blur_px + 'px); -o-filter: blur(' + blur_px + 'px); -ms-filter: blur(' + blur_px + 'px); filter: blur(' + blur_px + 'px); }/* fin:blur */';
          $box_css.append(blur_css);
        } else {
          var css = $box_css.text(),
              ini = css.indexOf('/* ini:blur */'),
              pro = css.substring(ini);
          $box_css.text(css.replace(pro, ''));
        }
      }
    },

    /**
    * Check all iframes and set source to empty on page load
     */
    initVideoSources: function initVideoSources() {
      var iframe = $('.spu-box iframe');

      if (iframe && iframe.length) {
        iframe.each(function () {
          $(this).attr('spusrc', $(this).attr('src'));
          $(this).attr('src', 'https://#');
        });
      }
    },

    /**
    * Toggle a popup iframe source
     * @param popup
     * @param show
     */
    toggleVideoSources: function toggleVideoSources(popup, show) {
      var iframe = popup.find('iframe');

      if (iframe && iframe.length) {
        iframe.each(function () {
          if (show) {
            if ($(this).attr('spusrc')) {
              $(this).attr('src', $(this).attr('spusrc'));
            }
          } else {
            // destroy videos so they stop playing
            $(this).attr('src', 'https://#');
          }
        });
      }
    },

    /**
    * remove paddings and margins from first and last items inside popups
    * so it looks even with the given padding
     */
    resetPopupsContent: function resetPopupsContent() {
      $(".spu-content").children().first().not('.spu-fields-container').css({
        "margin-top": 0,
        "padding-top": 0
      }).end().last().not('.spu-fields-container').css({
        'margin-bottom': 0,
        'padding-bottom': 0
      });
    },

    /**
     * Trigger popup opening if anyone use #spu-open-123 in url
     */
    hashTriggerPopups: function hashTriggerPopups() {
      // shows the box when hash refers to a box
      if (window.location.hash && window.location.hash.length > 0) {
        var hash = window.location.hash,
            form_key = hash.substring(1).indexOf('spu-form'),
            link_key = hash.substring(1).indexOf('spu-open'),
            form_popup = form_key !== -1,
            link_popup = link_key !== -1;
        if (form_popup) var i = form_key + 10;else if (link_popup) var i = link_key + 10;

        if ((link_popup || form_popup) && $('#spu-' + hash.substring(i)).is('.spu-box')) {
          var popup = $('#spu-' + hash.substring(i)); // if triggered by a form add a close button if don't exist already one

          if (form_popup && popup.find('.spu-close-popup').length < 2) {
            popup.find('.spu-content').append('<p style="text-align: center"><button class="btn btn-primary spu-close-popup">Close</button></p>');
          } // unbind regular triggers and set conversion


          if (form_popup) {
            $(window).off('scroll.per' + popup.data('id'));
            $(window).off('scroll.pix' + popup.data('id'));
            WPPopups.popupConverted(popup);
          }

          setTimeout(function () {
            WPPopups.showPopup(popup, true);
          }, 200);
        }
      }
    },

    /**
    * Handle form submissions in two ways. Adding ajax most known forms callbacks
     * and adding #spu-form to action for regular forms that will open on page load
     * @param $popup
     */
    formSubmissions: function formSubmissions($popup) {
      var popup_id = $popup.data('id');
      $popup.find('form').each(function () {
        var box_form = $(this),
            action = box_form.attr('action') || '';
        box_form.attr('action', action + '#spu-form-' + popup_id); // only run if not our form

        if (box_form.hasClass('spu-optin-form')) {
          return;
        } // If url is external, we need to track popup before submission


        if (WPPopups.isExternal(action)) {
          box_form.on('submit', function () {
            WPPopups.hidePopup($popup, true);
          });
        }
      }); // Ninja forms don't use form elements O_o

      $(document).on('nfFormSubmitResponse', function () {
        $popup.trigger('wppopups.form_submitted', [popup_id]);
        WPPopups.hidePopup($popup, true, 2000);
      }); // Contact form 7

      $popup.on('wpcf7mailsent', function () {
        $popup.trigger('wppopups.form_submitted', [popup_id]);
        WPPopups.hidePopup($popup, true, 2000);
      }); // Gravity forms (ajax mode)

      $(document).on('gform_post_render', function (jqXHR, form_id) {
        var $form = jQuery('#gform_ajax_frame_' + form_id),
            contents = $form.contents().find('*').html(),
            form_content = $form.contents().find('#gform_wrapper_' + form_id),
            is_confirmation = $form.contents().find('#gform_confirmation_wrapper_' + form_id).length > 0,
            is_redirect = contents.indexOf('gformRedirect(){') >= 0;

        if (is_confirmation || is_redirect) {
          $popup.trigger('wppopups.form_submitted', [popup_id]);
          WPPopups.hidePopup($popup, true, 2000);
        }
      }); // Caldera Forms (ajax mode)

      $(document).on('cf.submission', function () {
        $popup.trigger('wppopups.form_submitted', [popup_id]);
        WPPopups.hidePopup($popup, true, 2000);
      }); // WPForms (ajax mode)

      $(document).on('wpformsAjaxSubmitSuccess', function () {
        $popup.trigger('wppopups.form_submitted', [popup_id]);
        WPPopups.hidePopup($popup, true, 2000);
      }); // Yikes form

      $(document).on('yikes_mailchimp_ajax_submission', function (e, response) {
        if (response.success) {
          $popup.trigger('wppopups.form_submitted', [popup_id]);
          WPPopups.hidePopup($popup, true, 2000);
        }
      });
    },

    /**
     * Check if url is external
     * @param url
     * @returns {boolean}
     */
    isExternal: function isExternal(url) {
      if (url.length === 0) {
        return false;
      }

      var domain = function domain(url) {
        return url.replace('http://', '').replace('https://', '').split('/')[0];
      };

      return domain(location.href) !== domain(url);
    },

    /**
     * Forms to Email Marketing
     * @param $popup
     */
    formOptinSubmissions: function formOptinSubmissions($popup) {
      var popup_id = $popup.data('id'),
          $form = $popup.find('.spu-optin-form'),
          $submit_btn = $form.find('.spu-submit');
      $form.on('submit', function (e) {
        e.preventDefault();
        WPPopups.toggleButton($submit_btn, true);
        var data = $form.serializeArray();
        data.push({
          name: 'action',
          value: 'wppopups_optin_submit'
        });
        data.push({
          name: 'nonce',
          value: wppopups_vars.nonce
        });
        data.push({
          name: 'id',
          value: popup_id
        });
        var ajax = {
          url: wppopups_vars.ajax_url,
          data: data,
          cache: false,
          type: 'POST',
          dataType: 'json',
          timeout: 30000,
          success: function success(r) {
            if (r.success) {
              // redirect if set in settings
              if (r.data[1] && r.data[1].optin_redirect) {
                $popup.trigger('wppopups.optin_on_redirect', [popup_id]);
                var redirect = r.data[1].optin_redirect;

                if (r.data[1].pass_lead_data && r.data[1].pass_lead_data == 1) {
                  var qstring = [];
                  var sep = redirect.match(/[\?]/g) ? '&' : '?';

                  for (var key in data) {
                    if (data[key]['value'] == '') continue;
                    qstring.push(encodeURIComponent(data[key]['name']) + '=' + encodeURIComponent(data[key]['value']));
                  }

                  redirect = redirect + sep + qstring.join('&');
                }

                WPPopups.hidePopup($popup, true);
                window.location.href = redirect;
                return;
              } // clear errors


              $form.find('.optin-errors').html('').hide(); // success message

              if (r.data[0] && r.data[0].optin_success) {
                WPPopups.popupConverted($popup);
                $popup.find('.spu-content').html(r.data[0].optin_success);
                WPPopups.centerPopup($popup, true);

                if (r.data[0].optin_success_seconds && parseInt(r.data[0].optin_success_seconds) > 0) {
                  var seconds = parseInt(r.data[0].optin_success_seconds, 10) * 1000;
                  WPPopups.hidePopup($popup, false, seconds);
                }
              } else {
                WPPopups.hidePopup($popup, true);
              }
            } else {
              $form.find('.optin-errors').html(r.data).fadeIn();
            }

            $popup.trigger('wppopups.optin_form_submitted', [popup_id, r]);
            WPPopups.toggleButton($submit_btn, false);
          },
          error: function error(r) {
            console.log(r);
            WPPopups.toggleButton($submit_btn, false);
          }
        };
        $.ajax(ajax);
      });
    },

    /**
     * Helper func to toggle optin button
     * @param $submit_btn
     * @param disable
     */
    toggleButton: function toggleButton($submit_btn, disable) {
      if (disable) {
        $submit_btn.addClass('spu-sending');
        $submit_btn.attr("disabled", true);
      } else {
        $submit_btn.removeClass('spu-sending');
        $submit_btn.removeAttr("disabled");
      }
    },

    /**
     * Check if popup it's bigger than windows to add scroll bars
     * @param $popup
     */
    checkPopupSize: function checkPopupSize($popup) {
      // add 150 to give some margins on top/bottom
      if ($popup.outerHeight() + 150 >= $(window).height()) {
        $popup.css('overflow', 'auto').addClass('spu-scrollable');
        $popup.css('max-height', $(window).height());
      } else {
        $popup.css('overflow', 'initial').removeClass('spu-scrollable');
        $popup.css('max-height', '');
      }
    },
    initSocialShortcodes: function initSocialShortcodes() {
      // if facebook being used on any popup
      if (wppopups_vars.facebook) {
        var SPUfb = false,
            FbTimer = setInterval(function () {
          if (typeof FB !== 'undefined' && !SPUfb) {
            try {
              FB.Event.subscribe('edge.create', function (href, html_element) {
                var $popup = $(html_element).parents('.spu-box');

                if ($popup.length) {
                  WPPopups.hidePopup($popup, true);
                }
              });
            } catch (ex) {
              console.log(ex);
            }

            SPUfb = true;
            clearInterval(FbTimer);
          }
        }, 1000);
      }

      if (wppopups_vars.twitter) {
        if (typeof twttr !== 'undefined') {
          try {
            twttr.ready(function (twttr) {
              twttr.events.bind('tweet', WPPopups.twitterCB);
              twttr.events.bind('follow', WPPopups.twitterCB);
            });
          } catch (ex) {}
        }
      }

      if (wppopups_vars.google) {
        if (typeof twttr !== 'undefined') {
          try {
            twttr.ready(function (twttr) {
              twttr.events.bind('tweet', WPPopups.twitterCB);
              twttr.events.bind('follow', WPPopups.twitterCB);
            });
          } catch (ex) {}
        }
      }
    },
    googleCB: function googleCB(a) {
      if ("on" == a.state) {
        var box_id = $('.spu-gogl').data('box-id');

        if (box_id) {
          WPPopups.hidePopup(box_id, true);
        }
      }
    },
    closeGoogle: function closeGoogle(a) {
      if ("confirm" == a.type) {
        var box_id = $('.spu-gogl').data('box-id');

        if (box_id) {
          WPPopups.hidePopup(box_id, true);
        }
      }
    },

    /**
     * Twitter callback function
     * @param intent_event
     */
    twitterCB: function twitterCB(intent_event) {
      var $popup = $(intent_event.target).parents('.spu-box');

      if ($popup) {
        WPPopups.hidePopup($popup, true);
      }
    },

    /**
     * Set cookie container user UUID.
     *
     */
    setUserIndentifier: function setUserIndentifier() {
      if (wppopups_settings.uuid_cookie && !WPPopups.getCookie('_wpfuuid')) {
        // Generate UUID - http://stackoverflow.com/a/873856/1489528
        var s = new Array(36),
            hexDigits = '0123456789abcdef',
            uuid;

        for (var i = 0; i < 36; i++) {
          s[i] = hexDigits.substr(Math.floor(Math.random() * 0x10), 1);
        }

        s[14] = "4";
        s[19] = hexDigits.substr(s[19] & 0x3 | 0x8, 1);
        s[8] = s[13] = s[18] = s[23] = '-';
        uuid = s.join("");
        WPPopups.createCookie('_wpfuuid', uuid, 3999);
      }
    },

    /**
     * Set classes or href link in a global array
     * @param bind_name
     * @param bind_type
     */
    setBindActions: function setBindActions() {
      var bind_name = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
      var bind_type = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'class';

      if (bind_name != '') {
        switch (bind_type) {
          case 'class':
            bind_name = bind_name.charAt(0) == '.' ? bind_name.substring(1) : bind_name;
            if ($.inArray(bind_name, WPPopups.byBind['class']) === -1) WPPopups.byBind['class'].push(bind_name);
            break;

          case 'href':
            if ($.inArray(bind_name, WPPopups.byBind['href']) === -1) WPPopups.byBind['href'].push(bind_name);
            break;
        }

        window.wp.hooks.doAction('wppopups_set_bindactions', bind_name, bind_type);
      }
    },

    /**
     * Check if exists any BindActions when happen a event
     * @param target
     */
    checkBindActions: function checkBindActions(target) {
      var $classes = WPPopups.byBind['class'];

      for (var i = 0; i < $classes.length; i++) {
        if ($classes[i]) {
          if (target.hasClass($classes[i]) || target.closest('.' + $classes[i]).length) {
            return true;
          }
        }
      }

      var $href = WPPopups.byBind['href'];

      for (var _i = 0; _i < $href.length; _i++) {
        if ($href[_i] && target.attr('href') == $href[_i]) {
          return true;
        }
      }

      return false;
    },

    /**
     * Create cookie.
     *
     * @since 2.0.0
     */
    createCookie: function createCookie(name, value) {
      var duration = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 999;
      var type = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : 'd';
      var expires = ''; // If we have a duration value, set it in the expiry of the cookie.

      if (duration && type) {
        // If -1 is our value, set a session based cookie instead of a persistent cookie.
        if ('-1' === duration) {
          expires = '';
        } else {
          var cookie_time;

          switch (type) {
            case 'm':
              cookie_time = 60 * 1000;
              break;

            case 'h':
              cookie_time = 60 * 60 * 1000;
              break;

            default:
              cookie_time = 24 * 60 * 60 * 1000;
          }

          var date = new Date();
          date.setTime(date.getTime() + parseInt(duration) * cookie_time);
          expires = '; expires=' + date.toGMTString();
        }
      } else {
        expires = '; expires=Thu, 01 Jan 1970 00:00:01 GMT';
      } // Write the cookie.


      document.cookie = name + '=' + value + expires + '; path=/';
    },

    /**
     * Retrieve cookie.
     *
     * @since 2.0.0
     */
    getCookie: function getCookie(name) {
      var nameEQ = name + '=',
          ca = document.cookie.split(';');

      for (var i = 0; i < ca.length; i++) {
        var c = ca[i];

        while (c.charAt(0) === ' ') {
          c = c.substring(1, c.length);
        }

        if (c.indexOf(nameEQ) == 0) {
          return c.substring(nameEQ.length, c.length);
        }
      }

      return null;
    },

    /**
     * Delete cookie.
     */
    removeCookie: function removeCookie(name) {
      WPPopups.createCookie(name, '', -1);
    },

    /**
     * Check if it's a number. So (12) and ('12') will be good
     * @param n
     * @returns {boolean}
     */
    isNumber: function isNumber(n) {
      return !isNaN(parseFloat(n)) && !isNaN(n - 0);
    },

    /**
     * Get a popup from a string, or selector or inner selector such as coming from event
     * @param popup
     */
    getPopup: function getPopup(popup) {
      if (WPPopups.isNumber(popup)) {
        return $('#spu-' + parseInt(popup));
      }

      if (popup.is('.spu-box')) {
        return popup;
      }

      return popup.closest('.spu-box');
    },

    /**
     * Check if the popup has convertion rules and fire if needed
     * We need to runt his check on js because some popups fire when other convert in the same page load
     * Eg: Show exit popup A if popup B fails
     * @param $popup
     * @returns {boolean}
     */
    checkConvertion: function checkConvertion($popup) {
      // if no class trigger as normal
      if (!$popup.hasClass('yes-convert') && !$popup.hasClass('no-convert')) return true;
      var $settings = WPPopups.settings($('#spu-' + $popup.data('convert-id')), 'settings');
      var popup_converted = false;

      if (WPPopups.getCookie($settings.conversion_cookie_name)) {
        popup_converted = true;
      }

      if ($popup.hasClass('yes-convert')) {
        return popup_converted;
      } else {
        return !popup_converted;
      }
    },
    isMobile: function isMobile() {
      var Android = navigator.userAgent.match(/Android/i),
          BlackBerry = navigator.userAgent.match(/BlackBerry/i),
          iOS = navigator.userAgent.match(/iPhone|iPad|iPod/i),
          Opera = navigator.userAgent.match(/Opera Mini/i),
          Windows = navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i);
      return Android || BlackBerry || iOS || Opera || Windows;
    }
  }; // Initialize.

  WPPopups.init(); // Add to global scope.

  window.wppopups = WPPopups;
})(jQuery);