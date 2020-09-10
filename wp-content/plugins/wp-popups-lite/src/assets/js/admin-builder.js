"use strict";

;
/* global wppopups_builder, wp */

(function ($) {
  var s, $builder;
  var WPPopupsBuilder = {
    settings: {
      form: $('#wppopups-builder-popup'),
      //spinner: '<i class="fa fa-spinner fa-spin"></i>',
      spinner: '<i class="fa fa-circle-o-notch fa-spin wppopups-button-icon" />',
      spinnerInline: '<i class="fa fa-spinner fa-spin wppopups-loading-inline"></i>',
      pagebreakTop: false,
      pagebreakBottom: false,
      upload_img_modal: false
    },

    /**
     * Start the engine.
     *
     * @since 2.0.0
     */
    init: function init() {
      window.wppopups_panel_switch = true;
      s = this.settings; // Document ready

      $(document).ready(WPPopupsBuilder.ready); // Page load

      $(window).on('load', WPPopupsBuilder.load);
    },

    /**
     * Page load.
     *
     * @since 2.0.0
     */
    load: function load() {
      // Remove Loading overlay
      $('#wppopups-builder-overlay').fadeOut(); // Maybe display informational informational modal

      if (wppopups_builder_vars.template_modal_display == '1' && 'fields' == wpp.getQueryString('view')) {
        $.alert({
          title: wppopups_builder_vars.template_modal_title,
          content: wppopups_builder_vars.template_modal_msg,
          icon: 'fa fa-info-circle',
          type: 'blue',
          buttons: {
            confirm: {
              text: wppopups_builder_vars.close,
              btnClass: 'btn-confirm',
              keys: ['enter']
            }
          }
        });
      }
    },

    /**
     * Document ready.
     *
     * @since 2.0.0
     */
    ready: function ready() {
      // Cache builder element.
      $builder = $('#wppopups-builder'); // Bind all actions.

      WPPopupsBuilder.bindUIActions(); // Trigger initial save for new popups

      var newForm = wpp.getQueryString('newform');

      if (newForm) {
        WPPopupsBuilder.formSave(false);
      } // Setup/cache some vars not available before


      s.popupID = $('#wppopups-builder-popup').data('id');
      s.pagebreakTop = $('.wppopups-pagebreak-top').length;
      s.pagebreakBottom = $('.wppopups-pagebreak-bottom').length;
      s.templateList = new List('wppopups-setup-templates-additional', {
        valueNames: ['wppopups-template-name']
      }); // If there is a section configured, display it. Otherwise
      // we show the first panel by default.

      $('.wppopups-panel').each(function (index, el) {
        var $this = $(this);
        window.$configured = $this.find('.wppopups-panel-sidebar-section.configured').first();

        if (window.$configured.length) {
          var section = window.$configured.data('section');
          window.$configured.addClass('active').find('.wppopups-toggle-arrow').toggleClass('fa-angle-down fa-angle-right');
          $this.find('.wppopups-panel-content-section-' + section).show().addClass('active');
        } else {
          $this.find('.wppopups-panel-content-section:first-of-type').show().addClass('active');
          $this.find('.wppopups-panel-sidebar-section:first-of-type').addClass('active').find('.wppopups-toggle-arrow').toggleClass('fa-angle-down fa-angle-right');
        }
      }); // Load match heights

      $('.wppopups-setup-templates.core .wppopups-template-inner').matchHeight({
        byRow: false
      });
      $('.wppopups-setup-templates.additional .wppopups-template-inner').matchHeight({
        byRow: false
      }); // Trim long popup titles

      WPPopupsBuilder.trimPopupTitle(); // Load Tooltips

      WPPopupsBuilder.loadTooltips(); // Load ColorPickers

      WPPopupsBuilder.loadColorPickers(); // Choices for select fields

      WPPopupsBuilder.initChoicesJS(); // Clone form title to setup page

      $('#wppopups-setup-name').val($('#wppopups-panel-field-settings-popup_title').val()); // jquery-confirmd defaults

      jconfirm.defaults = {
        closeIcon: true,
        backgroundDismiss: true,
        escapeKey: true,
        animationBounce: 1,
        useBootstrap: false,
        theme: 'modern',
        boxWidth: '400px',
        animateFromElement: false
      };
      $('[data-depend][data-depend!=""]').each(function (e) {
        var depend_value = $(this).data('depend-value'),
            field_container = $(this).parent('.wppopups-panel-field'),
            dependent_field = $('#' + $(this).data('depend'));
        dependent_field.on('keyup mouseup change', function () {
          var current_value;

          if (dependent_field.is(':checkbox')) {
            if (dependent_field.is(':checked')) current_value = dependent_field.val();else current_value = 0;
          } else current_value = dependent_field.val();

          if (depend_value.toString().indexOf(current_value) != -1) field_container.show();else field_container.hide();
        });
        dependent_field.trigger('change');
      }); // check if trigger

      WPPopupsBuilder.maybeTriggerAutoHide();
      window.wp.hooks.doAction('wppopupsAdminBuilderReady');
    },
    alterClass: function alterClass(element, removals, additions) {
      if (removals.indexOf('*') === -1) {
        // Use native jQuery methods if there is no wildcard matching
        element.removeClass(removals);
        return !additions ? element : element.addClass(additions);
      }

      var patt = new RegExp('\\s' + removals.replace(/\*/g, '[A-Za-z0-9-_]+').split(' ').join('\\s|\\s') + '\\s', 'g');
      element.each(function (i, it) {
        var cn = ' ' + it.className + ' ';

        while (patt.test(cn)) {
          cn = cn.replace(patt, ' ');
        }

        it.className = $.trim(cn);
      });
      return !additions ? element : element.addClass(additions);
    },

    /**
     * Initilize Choices JS elements.
     *
     */
    initChoicesJS: function initChoicesJS() {
      $('.choicesjs-select').each(function () {
        // if already initiated continue
        if (typeof $(this)[0].choices != 'undefined') return true;
        var $this = $(this),
            args = {
          searchEnabled: false
        };

        if ($this.attr('multiple')) {
          args.searchEnabled = true;
          args.removeItemButton = true;
        }

        if ($this.data('placeholder')) {
          args.placeholderValue = $this.data('placeholder');
        }

        if ($this.data('sorting') === 'off') {
          args.shouldSort = false;
        }

        if ($this.data('search')) {
          args.searchEnabled = true;
        }

        $(this)[0].choices = new Choices($this[0], args);
      });
    },

    /**
     * Element bindings.
     *
     * @since 2.0.0
     */
    bindUIActions: function bindUIActions() {
      // General Panels
      WPPopupsBuilder.bindUIActionsPanels(); // Setup Panel

      WPPopupsBuilder.bindUIActionsSetup(); // Content Panel

      WPPopupsBuilder.bindUIActionsContent(); // Appearance Panel

      WPPopupsBuilder.bindUIActionsAppearance(); // Settings Panel

      WPPopupsBuilder.bindUIActionsSettings(); // Rules

      WPPopupsBuilder.bindUIActionsRules(); // Optin Forms

      WPPopupsBuilder.optinUIActions(); // Providers

      WPPopupsBuilder.providersUIActions(); // Save and Exit

      WPPopupsBuilder.bindUIActionsSaveExit();
    },
    // --------------------------------------------------------------------//
    // General Panels
    // --------------------------------------------------------------------//

    /**
     * Optin form ui actions
     */
    optinUIActions: function optinUIActions() {
      // Disable form submission in builder
      $('.spu-optin-form').on('submit', function (e) {
        e.preventDefault();
        return false;
      }); // Form class

      $('#wppopups-panel-field-fields-optin_form_css').on('keyup', function (e) {
        $('.spu-optin-form').prop('class', 'spu-optin-form ' + $(this).val());
      }); // Email placeholder

      $('#wppopups-panel-field-fields-email_field_text').on('keyup', function (e) {
        $('.spu-optin-fields .spu-email').attr('placeholder', $(this).val());
      }); // Display name field

      $('#wppopups-panel-field-fields-name_field').on('change', function (e) {
        var display_name = $(this).val(),
            $input_name = $('.spu-optin-fields').find('.spu-name');

        if (display_name == '1') {
          if ($input_name.length == 0) {
            $('.spu-optin-fields').prepend(WPPopupsBuilder.optinNameField());
            $('.spu-fields-container').addClass('with-spu-name');
          }
        } else {
          $('.spu-optin-fields .spu-name').fadeOut().remove();
          $('.spu-fields-container').removeClass('with-spu-name');
        }
      }); // Name placeholder

      $('#wppopups-panel-field-fields-name_field_text').on('keyup', function (e) {
        $('.spu-optin-fields .spu-name').attr('placeholder', $(this).val());
      }); // Submit button

      $('#wppopups-panel-field-fields-submit_text').on('keyup', function (e) {
        $('.spu-fields.spu-submit').text($(this).val());
      }); // Submit button class

      $('#wppopups-panel-field-fields-submit_css').on('keyup', function (e) {
        $('.spu-fields.spu-submit').prop('class', 'spu-fields spu-submit ' + $(this).val());
      }); // Display GDPR field

      $('#wppopups-panel-field-fields-gdpr_field').on('change', function (e) {
        var display_gdpr = $(this).val(),
            $input_gdpr = $('.spu-fields.spu-gdpr');

        if (display_gdpr == '1') {
          if ($input_gdpr.length == 0) {
            WPPopupsBuilder.gdprField().insertBefore('.spu-fields.spu-submit');
          }
        } else {
          $('.spu-fields.spu-gdpr').remove();
        }
      }); // GDPR text

      $('#wppopups-panel-field-fields-gdpr_field_text').on('keyup', function (e) {
        $('.spu-fields.spu-gdpr').replaceWith(WPPopupsBuilder.gdprField());
      }); // GDPR url

      $('#wppopups-panel-field-fields-gdpr_url').on('keyup', function (e) {
        $('.spu-fields.spu-gdpr').replaceWith(WPPopupsBuilder.gdprField());
      }); // Styles
      // Inline fields

      $('#wppopups-panel-field-optin_styles-inline_fields').on('change', function (e) {
        var $inline_fields = $(this).val();

        if ($inline_fields == '1') {
          // if we are in top/bottom bar add class to content
          if ($('.spu-box').hasClass('spu-position-top-bar') || $('.spu-box').hasClass('spu-position-bottom-bar')) {
            return;
          }

          $('.spu-optin-fields').addClass('spu-inline-fields');
        } else {
          $('.spu-optin-fields').removeClass('spu-inline-fields');
        }
      }); // Submit BG color

      $('#wppopups-panel-field-optin_styles-submit_bg_color').on('change', function (e) {
        $('.spu-fields.spu-submit').css('background-color', $(this).val());
      }); // Submit BG color

      $('#wppopups-panel-field-optin_styles-submit_text_color').on('change', function (e) {
        $('.spu-fields.spu-submit').css('color', $(this).val());
      }); // Submit Border color

      $('#wppopups-panel-field-optin_styles-submit_bg_color').on('change', function (e) {
        $('.spu-fields.spu-submit').css('background-color', $(this).val());
      });
      $('.spu-fields.spu-submit').hover(function () {
        $('.spu-fields.spu-submit').css('background-color', $('#wppopups-panel-field-optin_styles-submit_bg_color_hover').val());
      }, function (e) {
        $('.spu-fields.spu-submit').css('background-color', $('#wppopups-panel-field-optin_styles-submit_bg_color').val());
      }); // Submit border color

      $('#wppopups-panel-field-optin_styles-submit_border_color').on('change', function (e) {
        $('.spu-fields.spu-submit').css('border-color', $(this).val());
      });
    },

    /**
     * Optin name field
     * @returns {*|jQuery|HTMLElement}
     */
    optinNameField: function optinNameField() {
      var $placeholder = $('#wppopups-panel-field-fields-name_field_text').val();
      return $('<input type="text" name="spu-name" class="spu-fields spu-name" placeholder="' + $placeholder + '"/>');
    },

    /**
     * GDPR field
     * @returns {*|jQuery|HTMLElement}
     */
    gdprField: function gdprField() {
      var $url = $('#wppopups-panel-field-fields-gdpr_url').val();
      var $text = $('#wppopups-panel-field-fields-gdpr_field_text').val();

      if ($url.length) {
        $text = '<a href="' + $url + '" target="_blank" rel="nofollow">' + $text + '</a>';
      }

      return $('<label class="spu-fields spu-gdpr"><input type="checkbox" name="gdpr" value="1" />' + $text + '</label>');
    },

    /**
     * UI Actions for providers tab
     */
    providersUIActions: function providersUIActions() {
      // Delete connection.
      $(document).on('click', '.wppopups-provider-connection-delete', function (e) {
        WPPopupsBuilder.connectionDelete(this, e);
      }); // Add new connection.

      $(document).on('click', '.wppopups-provider-connections-add', function (e) {
        WPPopupsBuilder.connectionAdd(this, e);
      }); // Add new provider account.

      $(document).on('click', '.wppopups-provider-account-add button', function (e) {
        WPPopupsBuilder.accountAdd(this, e);
      }); // Select provider account.

      $(document).on('change', '.wppopups-provider-accounts select', function (e) {
        WPPopupsBuilder.accountSelect(this, e);
      }); // Select account list.

      $(document).on('change', '.wppopups-provider-lists select', function (e) {
        WPPopupsBuilder.accountListSelect(this, e);
      });
      $(document).on('wppopupsBeforePanelSwitch', function (e, targetPanel, currentPanel) {
        WPPopupsBuilder.providerPanelConfirm(targetPanel, currentPanel);
      }); //Extra Options.

      $(document).on('click', '.wppopups-addon-options-save', function (e) {
        WPPopupsBuilder.addonSave(this, e);
      }); //Save connection.

      $(document).on('click', '.wppopups-provider-connections-save', function (e) {
        WPPopupsBuilder.connectionSave(this, e);
      });
    },

    /**
     * Delete provider connection
     *
     * @since 2.0.0
     */
    connectionDelete: function connectionDelete(el, e) {
      e.preventDefault();
      var $this = $(el);
      $.confirm({
        title: false,
        content: wppopups_builder_providers.confirm_connection,
        backgroundDismiss: false,
        closeIcon: false,
        icon: 'fa fa-exclamation-circle',
        type: 'orange',
        buttons: {
          confirm: {
            text: wppopups_builder_vars.ok,
            btnClass: 'btn-confirm',
            keys: ['enter'],
            action: function action() {
              $this.closest('.wppopups-provider-connection').remove();
              $(document).trigger('wppopups_connection_delete', [$this]);
            }
          },
          cancel: {
            text: wppopups_builder_vars.cancel
          }
        }
      });
    },

    /**
     * Add new provider connection.
     *
     * @since 2.0.0
     */
    connectionAdd: function connectionAdd(el, e) {
      e.preventDefault();
      var $this = $(el),
          $connections = $this.parent().parent(),
          $container = $this.parent(),
          provider = $this.data('provider'),
          type = $this.data('type'),
          namePrompt = wppopups_builder_providers.prompt_connection,
          nameField = '<input autofocus="" type="text" id="provider-connection-name" placeholder="' + wppopups_builder_providers.prompt_placeholder + '">',
          nameError = '<p class="error">' + wppopups_builder_providers.error_name + '</p>',
          modalContent = namePrompt + nameField + nameError;
      modalContent = modalContent.replace(/%type%/g, type);
      $.confirm({
        title: false,
        content: modalContent,
        icon: 'fa fa-info-circle',
        type: 'blue',
        backgroundDismiss: false,
        closeIcon: false,
        buttons: {
          confirm: {
            text: wppopups_builder_vars.ok,
            btnClass: 'btn-confirm',
            keys: ['enter'],
            action: function action() {
              var input = this.$content.find('input#provider-connection-name');
              var error = this.$content.find('.error');

              if (input.val() === '') {
                error.show();
                return false;
              } else {
                var name = input.val(); // Disable button.

                WPPopupsBuilder.inputToggle($this, 'disable'); // Fire AJAX.

                var data = {
                  action: 'wppopups_provider_ajax_' + provider,
                  provider: provider,
                  task: 'new_connection',
                  name: name,
                  id: s.form.data('id'),
                  nonce: wppopups_builder_vars.nonce
                };
                WPPopupsBuilder.fireAJAX($this, data, function (res) {
                  if (res.success) {
                    $connections.find('.wppopups-provider-connections').prepend(res.data.html); // Process and load the accounts if they exist

                    var $connection = $connections.find('.wppopups-provider-connection:first');

                    if ($connection.find('.wppopups-provider-accounts option:selected')) {
                      $connection.find('.wppopups-provider-accounts option:first').prop('selected', true);
                      $connection.find('.wppopups-provider-accounts select').trigger('change');
                    }
                  } else {
                    WPPopupsBuilder.errorDisplay(res.data.error, $container);
                  }

                  $(document).trigger('wppopups_connection_add', [res, $this]);
                });
              }
            }
          },
          cancel: {
            text: wppopups_builder_vars.cancel
          }
        }
      });
    },

    /**
     * Add and authorize provider account.
     *
     * @since 2.0.0
     */
    accountAdd: function accountAdd(el, e) {
      e.preventDefault();
      var $this = $(el),
          provider = $this.data('provider'),
          $connection = $this.closest('.wppopups-provider-connection'),
          $container = $this.parent(),
          $fields = $container.find(':input'),
          errors = WPPopupsBuilder.requiredCheck($fields, $container); // Disable button.

      WPPopupsBuilder.inputToggle($this, 'disable'); // Bail if we have any errors.

      if (errors) {
        $this.prop('disabled', false).find('i').remove();
        return false;
      } // Fire AJAX.


      var data = {
        action: 'wppopups_provider_ajax_' + provider,
        provider: provider,
        connection_id: $connection.data('connection_id'),
        task: 'new_account',
        data: WPPopupsBuilder.fakeSerialize($fields)
      };
      WPPopupsBuilder.fireAJAX($this, data, function (res) {
        if (res.success) {
          $container.nextAll('.wppopups-connection-block').remove();
          $container.nextAll('.wppopups-conditional-block').remove();
          $container.after(res.data.html);
          $container.slideUp();
          $connection.find('.wppopups-provider-accounts select').trigger('change');
        } else {
          WPPopupsBuilder.errorDisplay(res.data.error, $container);
        }
      });
    },

    /**
     * Selecting a provider account
     *
     * @since 2.0.0
     */
    accountSelect: function accountSelect(el, e) {
      e.preventDefault();
      var $this = $(el),
          $connection = $this.closest('.wppopups-provider-connection'),
          $container = $this.parent(),
          provider = $connection.data('provider'); // Disable select, show loading.

      WPPopupsBuilder.inputToggle($this, 'disable'); // Remove any blocks that might exist as we prep for new account.

      $container.nextAll('.wppopups-connection-block').remove();
      $container.nextAll('.wppopups-conditional-block').remove();

      if (!$this.val()) {
        // User selected to option to add new account.
        $connection.find('.wppopups-provider-account-add input').val('');
        $connection.find('.wppopups-provider-account-add').slideDown();
        WPPopupsBuilder.inputToggle($this, 'enable');
      } else {
        $connection.find('.wppopups-provider-account-add').slideUp(); // Fire AJAX.

        var data = {
          action: 'wppopups_provider_ajax_' + provider,
          provider: provider,
          connection_id: $connection.data('connection_id'),
          task: 'select_account',
          account_id: $this.find(':selected').val()
        };
        WPPopupsBuilder.fireAJAX($this, data, function (res) {
          if (res.success) {
            $container.after(res.data.html); // Process first list found.

            $connection.find('.wppopups-provider-lists option:first').prop('selected', true);
            $connection.find('.wppopups-provider-lists select').trigger('change');
          } else {
            WPPopupsBuilder.errorDisplay(res.data.error, $container);
          }
        });
      }
    },

    /**
     * Selecting a provider account list.
     *
     * @since 2.0.0
     */
    accountListSelect: function accountListSelect(el, e) {
      e.preventDefault();
      var $this = $(el),
          $connection = $this.closest('.wppopups-provider-connection'),
          $container = $this.parent(),
          provider = $connection.data('provider'); // Disable select, show loading.

      WPPopupsBuilder.inputToggle($this, 'disable'); // Remove any blocks that might exist as we prep for new account.

      $container.nextAll('.wppopups-connection-block').remove();
      $container.nextAll('.wppopups-conditional-block').remove();
      var data = {
        action: 'wppopups_provider_ajax_' + provider,
        provider: provider,
        connection_id: $connection.data('connection_id'),
        task: 'select_list',
        account_id: $connection.find('.wppopups-provider-accounts option:selected').val(),
        list_id: $this.find(':selected').val(),
        popup_id: s.popupID
      };
      WPPopupsBuilder.fireAJAX($this, data, function (res) {
        if (res.success) {
          $container.after(res.data.html);
        } else {
          WPPopupsBuilder.errorDisplay(res.data.error, $container);
        }
      });
    },

    /**
     * Confirm form save before loading Provider panel.
     * If confirmed, save and reload panel.
     *
     * @since 2.0.0
     */
    providerPanelConfirm: function providerPanelConfirm(targetPanel, currentPanel) {
      if (targetPanel === 'providers') {
        if (wpp.savedState != wpp.getFormState('#wppopups-builder-popup') || currentPanel === 'providers') {
          $.confirm({
            title: false,
            content: wppopups_builder_providers.confirm_save,
            backgroundDismiss: false,
            closeIcon: false,
            icon: 'fa fa-info-circle',
            type: 'blue',
            buttons: {
              confirm: {
                text: wppopups_builder_vars.ok,
                btnClass: 'btn-confirm',
                keys: ['enter'],
                action: function action() {
                  $('#wppopups-save').trigger('click');
                  $(document).on('wppopupsSaved', function () {
                    window.location.href = wppopups_builder_providers.url + encodeURI('&view=') + targetPanel;
                  });
                }
              },
              cancel: {
                text: wppopups_builder_vars.cancel,
                action: function action() {
                  if (currentPanel === 'providers') {
                    var $panel = $('#wppopups-panel-' + currentPanel),
                        $panelBtn = $('.wppopups-panel-' + currentPanel + '-button');
                    $('#wppopups-panels-toggle').find('button').removeClass('active');
                    $('.wppopups-panel').removeClass('active');
                    $panelBtn.addClass('active');
                    $panel.addClass('active');
                    history.replaceState({}, null, wpp.updateQueryString('view', currentPanel));
                  }
                }
              }
            }
          });
        }
      }
    },

    /**
     * Save new extra options.
     *
     * @since 2.0.0
     */
    addonSave: function addonSave(el, e) {
      e.preventDefault();
      $('#wppopups-save').trigger('click');
      $(document).on('wppopupsSaved', function () {
        window.location.href = wppopups_builder_addons.url;
      });
    },

    /**
     * Save new provider connection.
     *
     * @since 2.0.0
     */
    connectionSave: function connectionSave(el, e) {
      e.preventDefault();
      $('#wppopups-save').trigger('click');
      $(document).on('wppopupsSaved', function () {
        window.location.href = wppopups_builder_providers.url + encodeURI('&view=optin');
      });
    },

    /**
     * Element bindings for general panel tasks.
     *
     * @since 2.0.0
     */
    bindUIActionsPanels: function bindUIActionsPanels() {
      // Panel switching
      $builder.on('click', '#wppopups-panels-toggle button, .wppopups-panel-switch', function (e) {
        e.preventDefault();
        WPPopupsBuilder.panelSwitch($(this).data('panel'));
      }); // Panel sections switching

      $builder.on('click', '.wppopups-panel .wppopups-panel-sidebar-section:not(".not-clickable")', function (e) {
        WPPopupsBuilder.panelSectionSwitch(this, e);
      });
      $builder.on('click', '.wppopups-panel .wppopups-panel-content-wrap .back-section', function (e) {
        WPPopupsBuilder.panelSectionBack(this, e);
      });
    },

    /**
     * Switch Panels.
     *
     * @since 2.0.0
     */
    panelSwitch: function panelSwitch(panel) {
      var $panel = $('#wppopups-panel-' + panel),
          $panelBtn = $('.wppopups-panel-' + panel + '-button');

      if (!$panel.hasClass('active') && !$panelBtn.hasClass('upgrade-modal')) {
        // trigger event with future panel and current panel
        var active_panel = $('#wppopups-panels-toggle .active').data('panel');
        $builder.trigger('wppopupsBeforePanelSwitch', [panel, active_panel]);

        if (!window.wppopups_panel_switch) {
          return false;
        }

        $('#wppopups-panels-toggle').find('button').removeClass('active');
        $('.wppopups-panel').removeClass('active');
        $panelBtn.addClass('active');
        $panel.addClass('active');
        history.replaceState({}, null, wpp.updateQueryString('view', panel));
        $builder.trigger('wppopupsAfterPanelSwitch', [panel, active_panel]);
      }
    },

    /**
     * Switch Panel section.
     *
     * @since 2.0.0
     */
    panelSectionSwitch: function panelSectionSwitch(el, e) {
      e.preventDefault();
      var $this = $(el),
          $panel = $this.parent().parent(),
          $superpa = $panel.parent(),
          superid = $superpa.attr('id'),
          section = $this.data('section'),
          $sectionButtons = $panel.find('.wppopups-panel-sidebar-section'),
          $sectionButton = $panel.find('.wppopups-panel-sidebar-section-' + section),
          allowed_superp = ['wppopups-panel-providers', 'wppopups-panel-settings', 'wppopups-panel-addons'];

      if (!$sectionButton.hasClass('active')) {
        $sectionButtons.removeClass('active');
        $sectionButtons.find('.wppopups-toggle-arrow').removeClass('fa-angle-down').addClass('fa-angle-right');
        $sectionButton.addClass('active');
        $sectionButton.find('.wppopups-toggle-arrow').toggleClass('fa-angle-right fa-angle-down');
        $panel.find('.wppopups-panel-content-section').slideUp();
        $panel.find('.wppopups-panel-content-section-' + section).slideDown();

        if (wppopups_builder_vars.is_mobile && $.inArray(superid, allowed_superp) != -1) {
          $panel.find('.wppopups-panel-content-wrap').css('left', 60);
          $panel.find('.wppopups-panel-content-wrap').prepend('<a href="#" class="back-section">< Back</a>');
        }
      } else {
        // simple toggle open section
        $sectionButton.removeClass('active');
        $sectionButton.find('.wppopups-toggle-arrow').toggleClass('fa-angle-right fa-angle-down');
        $panel.find('.wppopups-panel-content-section').slideUp();
      }
    },

    /**
     * Switch Panel section.
     *
     * @since 2.0.0
     */
    panelSectionBack: function panelSectionBack(el, e) {
      e.preventDefault();
      var $this = $(el),
          $panel = $this.parent();
      $panel.css('left', 695);
      $this.remove();
    },
    // --------------------------------------------------------------------//
    // Setup Panel
    // --------------------------------------------------------------------//

    /**
     * Element bindings for Setup panel.
     *
     * @since 2.0.0
     */
    bindUIActionsSetup: function bindUIActionsSetup() {
      // Focus on the form title field when displaying setup panel
      $(window).load(function (e) {
        WPPopupsBuilder.setupTitleFocus(e, wpp.getQueryString('view'));
      }); // Select and apply a template

      $builder.on('click', '.wppopups-template-select', function (e) {
        WPPopupsBuilder.templateSelect(this, e);
      }); // "Blank form" text should trigger template selection

      $builder.on('click', '.wppopups-trigger-blank', function (e) {
        e.preventDefault();
        $('#wppopups-template-blank .wppopups-template-select').trigger('click');
      }); // Keep Setup title and settings title instances the same

      $builder.on('input ', '#wppopups-panel-field-settings-popup_title', function () {
        $('#wppopups-setup-name').val($('#wppopups-panel-field-settings-popup_title').val());
      });
      $builder.on('input', '#wppopups-setup-name', function () {
        $('#wppopups-panel-field-settings-popup_title').val($('#wppopups-setup-name').val());
      }); // Additional template searching

      $builder.on('keyup', '#wppopups-setup-template-search', function () {
        s.templateList.search($(this).val());
      });
    },

    /**
     * Force focus on the form title field when the Setup panel is displaying.
     *
     * @since 2.0.0
     */
    setupTitleFocus: function setupTitleFocus(e, view) {
      if (typeof view !== 'undefined' && view == 'setup') {
        setTimeout(function () {
          $('#wppopups-setup-name').focus();
        }, 100);
      }
    },

    /**
     * Select template.
     *
     * @since 2.0.0
     */
    templateSelect: function templateSelect(el, e) {
      e.preventDefault();
      var $this = $(el),
          $parent = $this.parent().parent();
      var $formName = $('#wppopups-setup-name'),
          $templateBtns = $('.wppopups-template-select'),
          formName = '',
          labelOriginal = $this.html();
      var template = $this.data('template'),
          templateName = $this.data('template-name-raw'),
          title = '',
          action = ''; // Don't do anything for selects that trigger modal

      if ($parent.hasClass('pro-modal')) {
        return;
      } // Disable all template buttons


      $templateBtns.prop('disabled', true); // Display loading indicator

      $this.html(s.spinner + ' ' + wppopups_builder_vars.loading); // This is an existing form

      if (s.popupID) {
        $.confirm({
          title: wppopups_builder_vars.heads_up,
          content: wppopups_builder_vars.template_confirm,
          backgroundDismiss: false,
          closeIcon: false,
          icon: 'fa fa-exclamation-circle',
          type: 'orange',
          buttons: {
            confirm: {
              text: wppopups_builder_vars.ok,
              btnClass: 'btn-confirm',
              action: function action() {
                // Ajax update form
                var data = {
                  title: $formName.val(),
                  action: 'wppopups_update_popup_template',
                  template: template,
                  popup_id: s.popupID,
                  nonce: wppopups_builder_vars.nonce
                };
                $.post(wppopups_builder_vars.ajax_url, data, function (res) {
                  if (res.success) {
                    window.location.href = res.data.redirect;
                  } else {
                    console.log(res);
                  }
                }).fail(function (xhr, textStatus, e) {
                  WPPopupsBuilder.xhrFailed();
                });
              }
            },
            cancel: {
              text: wppopups_builder_vars.cancel,
              action: function action() {
                $templateBtns.prop('disabled', false);
                $this.html(labelOriginal);
              }
            }
          }
        }); // This is a new form
      } else {
        // Check that form title is provided
        if (!$formName.val()) {
          formName = templateName;
        } else {
          formName = $formName.val();
        } // Ajax create new form


        var data = {
          title: formName,
          action: 'wppopups_new_popup',
          template: template,
          popup_id: s.popupID,
          nonce: wppopups_builder_vars.nonce
        };
        $.post(wppopups_builder_vars.ajax_url, data, function (res) {
          if (res.success) {
            window.location.href = res.data.redirect;
          } else {
            console.log(res);
          }
        }).fail(function (xhr, textStatus, e) {
          WPPopupsBuilder.xhrFailed();
        });
      }
    },
    // --------------------------------------------------------------------//
    // Appearance Panel
    // --------------------------------------------------------------------//
    bindUIActionsAppearance: function bindUIActionsAppearance() {
      // Box position
      $('#wppopups-panel-field-position-position').on('change', function (e) {
        var class_name = 'spu-position-' + $(this).val();
        WPPopupsBuilder.alterClass($('.spu-box'), 'spu-position-*', class_name);
      }); // Box animation

      $('#wppopups-panel-field-animation-animation').on('change', function (e) {
        var class_name = 'spu-animation-' + $(this).val();
        $('.spu-box').removeClass('spu-animation-animated');

        if ('fade' == $(this).val()) {
          $('.spu-box').hide().fadeIn();
        }

        if ('slide' == $(this).val()) {
          $('.spu-box').hide().slideDown();
        }

        WPPopupsBuilder.alterClass($('.spu-box'), 'spu-animation-*', class_name).addClass('spu-animation-animated');
      }); // Box width

      $('#wppopups-panel-field-popup_box-width').on('keyup', function (e) {
        $('.spu-box').css('max-width', WPPopupsBuilder.sanitizeSize($(this).val()));
      }); // Box padding

      $('#wppopups-panel-field-popup_box-padding').on('keyup mouseup', function (e) {
        $('.spu-box .spu-container').css('padding', $(this).val() + 'px');
      }); // Box height

      $('#wppopups-panel-field-popup_box-auto_height').on('change', function (e) {
        if ($(this).val() == 'yes') {
          $('.spu-box').css('height', 'auto');
        } else {
          $('.spu-box').css('height', WPPopupsBuilder.sanitizeSize($('#wppopups-panel-field-popup_box-height').val()));
        }
      });
      $('#wppopups-panel-field-popup_box-height').on('keyup', function (e) {
        if ($('#wppopups-panel-field-popup_box-auto_height').val() == 'no') {
          $('.spu-box').css('height', WPPopupsBuilder.sanitizeSize($(this).val()));
        }
      }); // Overlay color

      $('#wppopups-panel-field-colors-overlay_color').on('change', function (e) {
        $('.wppopups-panel-content .spu-bg').css('background-color', $(this).val());
      }); // BG color

      $('#wppopups-panel-field-colors-bg_color').on('change', function (e) {
        $('.spu-box').css('background-color', $(this).val());
      }); // Border type

      $('#wppopups-panel-field-border-border_type').on('change', function (e) {
        $('.spu-box .spu-container').css('border-style', $(this).val());
      }); // Border Color

      $('#wppopups-panel-field-border-border_color').on('change', function (e) {
        $('.spu-box .spu-container').css('border-color', $(this).val());
      }); // Border width

      $('#wppopups-panel-field-border-border_width').on('keyup mouseup', function (e) {
        $('.spu-box .spu-container').css('border-width', $(this).val() + 'px');
      }); // Border radius

      $('#wppopups-panel-field-border-border_radius').on('keyup mouseup', function (e) {
        $('.spu-box .spu-container').css('border-radius', $(this).val() + 'px');
      }); // Border margin

      $('#wppopups-panel-field-border-border_margin').on('keyup mouseup', function (e) {
        $('.spu-box .spu-container').css('margin', $(this).val() + 'px');
        $('.spu-box .spu-container').css('height', 'calc( 100% - ' + parseInt($(this).val()) * 2 + 'px)');
      }); // Shadow

      $('#wppopups-panel-field-shadow-shadow_color,#wppopups-panel-field-shadow-shadow_type,#wppopups-panel-field-shadow-shadow_blur,#wppopups-panel-field-shadow-shadow_x_offset,#wppopups-panel-field-shadow-shadow_y_offset,#wppopups-panel-field-shadow-shadow_spread').on('change mouseup keyup', function (e) {
        WPPopupsBuilder.updateBoxShadow();
      }); // Close color

      $('#wppopups-panel-field-close-close_color').on('change', function (e) {
        $('.spu-box .spu-close').css('color', $(this).val());
      }); // Close hover

      $('.spu-box .spu-close').hover(function () {
        $('.spu-box .spu-close').css('color', $('#wppopups-panel-field-close-close_hover_color').val());
      }, function (e) {
        $('.spu-box .spu-close').css('color', $('#wppopups-panel-field-close-close_color').val());
      }); // Close shadow

      $('#wppopups-panel-field-close-close_shadow_color').on('change', function (e) {
        $('.spu-box .spu-close').css('text-shadow', '2px 3px 2px ' + $(this).val());
      }); // Close size

      $('#wppopups-panel-field-close-close_size').on('keyup mouseup', function (e) {
        $('.spu-box .spu-close').css('font-size', $(this).val() + 'px');
      }); // Close position

      $('#wppopups-panel-field-close-close_position').on('change', function (e) {
        var class_name = 'spu-close-' + $(this).val();
        WPPopupsBuilder.alterClass($('.spu-box .spu-close'), 'spu-close-*', class_name);
      }); // Overlays

      $('#wppopups-panel-field-colors-show_overlay').on('change', function (e) {
        if ($('.spu-bg').length == 0) {
          $('<div class="spu-bg" id="spu-bg-' + s.popupID + '"></div>').insertBefore('.spu-box');
        }

        if ($(this).val() == 'yes-color' || $(this).val() == 'yes') {
          $('.spu-bg').fadeIn();
          $('.spu-bg').removeAttr('style');
          $('.spu-bg').css('background-image', 'none');
        } else if ($(this).val() == 'yes-blur') {
          $('.spu-bg').fadeIn();
          $('.spu-bg').css('background-color', 'transparent');
          $('.spu-bg').css('background-image', '');
          $('#wppopups-panel-field-colors-overlay_blur').change();
        } else {
          $('.spu-bg').hide();
        }
      }); // Overlay Blur

      $('#wppopups-panel-field-colors-overlay_blur').on('change', function (e) {
        var $box_css = $('#wppopups-builder .spu-bg'),
            blur_px = $(this).val() ? 'blur(' + $(this).val() + 'px)' : 'blur(2px)';
        $box_css.css('filter', blur_px).css('webkitFilter', blur_px).css('mozFilter', blur_px).css('oFilter', blur_px).css('msFilter', blur_px);
      }); // Background repeat

      $('#wppopups-panel-field-colors-bg_img_repeat').on('change', function (e) {
        $('.spu-box').css('background-repeat', $(this).val());
      }); // Background size

      $('#wppopups-panel-field-colors-bg_img_size').on('change', function (e) {
        $('.spu-box').css('background-size', $(this).val());
      }); // Upload or add an image.

      $builder.on('click', '.wppopups-image-upload-add', function (event) {
        event.preventDefault();
        var $this = $(this),
            $container = $this.parent(),
            mediaModal;
        mediaModal = wp.media.frames.wppopups_media_frame = wp.media({
          className: 'media-frame wppopups-media-frame',
          frame: 'select',
          multiple: false,
          title: wppopups_builder_vars.upload_image_title,
          library: {
            type: 'image'
          },
          button: {
            text: wppopups_builder_vars.upload_image_button
          }
        });
        mediaModal.on('select', function () {
          var media_attachment = mediaModal.state().get('selection').first().toJSON();
          $container.find('#wppopups-panel-field-colors-bg_img').val(media_attachment.url);
          $('.spu-box').css('background-image', 'url(' + media_attachment.url + ')');
          $container.find('.image-preview').empty();
          $container.find('.image-preview').prepend('<a href="#" title="' + wppopups_builder_vars.upload_image_remove + '" class="wppopups-image-upload-remove"><img src="' + media_attachment.url + '"></a>');

          if ('hide' === $this.data('after-upload')) {
            $this.hide();
          }

          $builder.trigger('wppopupsImageUploadAdd', [$this, $container]);
        }); // Now that everything has been set, let's open up the frame.

        mediaModal.open();
      }); // Remove and uploaded image.

      $builder.on('click', '.wppopups-image-upload-remove', function (event) {
        event.preventDefault();
        var $container = $(this).parent().parent();
        $container.find('.image-preview').empty();
        $container.find('.wppopups-image-upload-add').show();
        $container.find('#wppopups-panel-field-colors-bg_img').val('');
        $('.spu-box').css('background-image', 'none');
        $builder.trigger('wppopupsImageUploadRemove', [$(this), $container]);
      });
    },
    updateBoxShadow: function updateBoxShadow() {
      var $shadow_type = $('#wppopups-panel-field-shadow-shadow_type').val(),
          $shadow_color = $('#wppopups-panel-field-shadow-shadow_color').val(),
          $shadow_blur = $('#wppopups-panel-field-shadow-shadow_blur').val(),
          $shadow_x_offset = $('#wppopups-panel-field-shadow-shadow_x_offset').val(),
          $shadow_y_offset = $('#wppopups-panel-field-shadow-shadow_y_offset').val(),
          $shadow_spread = $('#wppopups-panel-field-shadow-shadow_spread').val();

      if ($shadow_type != 'none') {
        var $box_shadow = ($shadow_type == 'inset' ? 'inset ' : '') + $shadow_x_offset + 'px ' + $shadow_y_offset + 'px ' + $shadow_blur + 'px ' + $shadow_spread + 'px ' + $shadow_color;
        $('.spu-box').css('box-shadow', $box_shadow);
      } else {
        $('.spu-box').css('box-shadow', 'none');
      }
    },
    // --------------------------------------------------------------------//
    // Content Panel
    // --------------------------------------------------------------------//
    bindUIActionsContent: function bindUIActionsContent() {
      if (typeof window.parent.tinymce !== 'undefined') {
        window.parent.tinymce.on('addeditor', function (event) {
          var editor = event.editor; //only for content editor

          if (editor.id != 'wppopups_panel_field_content_popup_content') {
            return;
          }

          editor.on('change', function () {
            WPPopupsBuilder.updateEditorContent(this);
          });
          editor.on('input', function () {
            WPPopupsBuilder.updateEditorContent(this);
          });
        }, true);
      }
    },
    updateEditorContent: function updateEditorContent(editor) {
      var fields_container = $('.spu-content').find('.spu-fields-container');
      var addon_container = $('.spu-content').find('.spu-addon-container');
      var html = editor.getContent();

      if (fields_container && fields_container.length) {
        html = html + fields_container[0].outerHTML;
      }

      if (addon_container && addon_container.length) {
        html = html + addon_container[0].outerHTML;
      }

      if (html) {
        $('.spu-content').html(html);
      }
    },
    // --------------------------------------------------------------------//
    // Settings Panel
    // --------------------------------------------------------------------//

    /**
     * Element bindings for Settings panel.
     *
     * @since 2.0.0
     */
    bindUIActionsSettings: function bindUIActionsSettings() {
      // Clicking form title/desc opens Settings panel
      $builder.on('click', '.wppopups-title-desc, .wppopups-field-submit-button, .wppopups-center-popup-name', function (e) {
        e.preventDefault();
        WPPopupsBuilder.panelSwitch('settings');
      }); // Real-time updates for editing the popup title

      $builder.on('input', '#wppopups-panel-field-settings-popup_title, #wppopups-setup-name', function () {
        var title = $(this).val();

        if (title.length > 38) {
          title = $.trim(title).substring(0, 38).split(" ").slice(0, -1).join(" ") + "...";
        }

        $('.wppopups-popup-name').text(title);
      });
      /** TRIGGERS EVENTS **/
      // change trigger

      $builder.on('change', '.trigger-option .choicesjs-select', function () {
        WPPopupsBuilder.triggersChangeTrigger($(this));
        WPPopupsBuilder.maybeTriggerAutoHide();
      }); // Delete row

      $builder.on('click', '.trigger-actions .remove', function (e) {
        e.preventDefault();
        WPPopupsBuilder.triggersDeleteRow(e, $(this));
      }); // Add row

      $builder.on('click', '.trigger-actions .add', function (e) {
        e.preventDefault();
        WPPopupsBuilder.triggersClone($(this));
      });
    },

    /**
     * Show or hide the auto hide checkbox for triggers
     */
    maybeTriggerAutoHide: function maybeTriggerAutoHide() {
      var show = false;
      $('.choicesjs-select').each(function () {
        if ($(this).val() == 'pixels' || $(this).val() == 'percentage') {
          show = true;
        }
      });

      if (show) {
        $('#wppopups-panel-field-settings-auto_hide-wrap').fadeIn();
      } else {
        $('#wppopups-panel-field-settings-auto_hide-wrap').hide();
      }
    },
    // --------------------------------------------------------------------//
    // Triggers
    // --------------------------------------------------------------------//

    /**
     * Triggers - Change trigger
     *
     * @since 2.0.0
     */
    triggersChangeTrigger: function triggersChangeTrigger(el) {
      var $this = $(el),
          $row = $this.closest('div.trigger-tr'),
          $group = $row.closest('div.trigger-group'),
          $wpp = this;
      this.renderRulesLoading($row, true); // Ajax create new form

      var data = {
        trigger: $this.val(),
        row_key: $row.data('key'),
        group_key: $group.data('key'),
        action: 'wppopups_render_trigger',
        nonce: wppopups_builder_vars.nonce
      };
      $.post(wppopups_builder_vars.ajax_url, data, function (res) {
        if (res.success) {
          $row.find('.trigger-value').html(res.data.trigger_value);
          $wpp.initChoicesJS();
          $wpp.renderRulesLoading($row);
        } else {
          console.log(res);
        }
      }).fail(function (xhr, textStatus, e) {
        WPPopupsBuilder.xhrFailed();
      });
    },

    /**
     * Triggers - Delete row
     *
     * @since 2.0.0
     */
    triggersDeleteRow: function triggersDeleteRow(e, el) {
      var $this = $(el),
          $row = $this.closest('div.trigger-tr'),
          $table = $this.closest('div.trigger-group'),
          total = $table.find('div.trigger-tr').length; // Delete only if one more than row exist

      if (total > '1') {
        $row.remove();
      }
    },

    /**
     * Triggers - Clone
     *
     * @since 2.0.0
     */
    triggersClone: function triggersClone(el) {
      var $this = $(el),
          $row = $this.closest('div.trigger-tr'),
          $new_row = $('.trigger-group-clone.trigger-tr').clone(),
          row_old_id = $row.attr('data-key'),
          row_new_id = 'trigger_' + (parseInt(row_old_id.replace('trigger_', ''), 10) + 1);
      $new_row.attr('data-key', row_new_id);
      $new_row.insertAfter($row);
      $new_row.removeClass('trigger-group-clone').show();
      this.renderRulesLoading($new_row, true);
      $new_row.find('[name]').each(function () {
        // update names
        $(this).attr('name', $(this).attr('name').replace('trigger_id', row_new_id)); // update ids

        $(this).attr('id', $(this).attr('id').replace('trigger_id', row_new_id)); // update classes

        $(this).addClass('choicesjs-select'); // remove disabled attr

        $(this).removeAttr('disabled');
      });
      this.initChoicesJS();
      this.renderRulesLoading($new_row, false);
    },
    // --------------------------------------------------------------------//
    // Save and Exit
    // --------------------------------------------------------------------//

    /**
     * Element bindings for Embed and Save/Exit items.
     *
     * @since 2.0.0
     */
    bindUIActionsSaveExit: function bindUIActionsSaveExit() {
      // Save popup
      $builder.on('click', '#wppopups-save', function (e) {
        e.preventDefault();
        WPPopupsBuilder.popupSave(false);
      }); // Publish popup

      $builder.on('click', '#wppopups-publish', function (e) {
        e.preventDefault();
        WPPopupsBuilder.popupSave(false, true);
      }); // Exit builder

      $builder.on('click', '#wppopups-exit', function (e) {
        e.preventDefault();
        WPPopupsBuilder.popupExit();
      });
    },

    /**
     * Save popup.
     *
     * @since 2.0.0
     */
    popupSave: function popupSave(redirect, publish) {
      var $saveBtn = publish ? $('#wppopups-publish') : $('#wppopups-save'),
          $icon = $saveBtn.find('i'),
          $label = $saveBtn.find('span'),
          text = wppopups_builder_vars.save;

      if (typeof tinyMCE !== 'undefined') {
        tinyMCE.triggerSave();
      }

      $label.text(wppopups_builder_vars.saving);
      $icon.toggleClass('fa-check fa-cog fa-spin');
      var data = {
        action: 'wppopups_save_popup',
        data: JSON.stringify($('#wppopups-builder-popup').serializeArray()),
        id: s.popupID,
        nonce: wppopups_builder_vars.nonce,
        publish: publish ? 1 : 0
      };
      $.post(wppopups_builder_vars.ajax_url, data, function (res) {
        if (res.success) {
          $label.text(text);
          $icon.toggleClass('fa-check fa-cog fa-spin');
          wpp.savedState = wpp.getFormState('#wppopups-builder-popup');
          $builder.trigger('wppopupsSaved');

          if (publish) {
            $saveBtn.remove();
          }

          if (true === redirect) {
            window.location.href = wppopups_builder_vars.exit_url;
          }
        } else {
          alert(res.data.error);
          console.log(res);
        }
      }).fail(function (xhr, textStatus, e) {
        WPPopupsBuilder.xhrFailed();
      });
    },

    /**
     * Exit popup builder.
     *
     * @since 2.0.0
     */
    popupExit: function popupExit() {
      if (WPPopupsBuilder.popupIsSaved()) {
        window.location.href = wppopups_builder_vars.exit_url;
      } else {
        $.confirm({
          title: false,
          content: wppopups_builder_vars.exit_confirm,
          icon: 'fa fa-exclamation-circle',
          type: 'orange',
          backgroundDismiss: false,
          closeIcon: false,
          buttons: {
            confirm: {
              text: wppopups_builder_vars.save_exit,
              btnClass: 'btn-confirm',
              keys: ['enter'],
              action: function action() {
                WPPopupsBuilder.popupSave(true);
              }
            },
            cancel: {
              text: wppopups_builder_vars.exit,
              action: function action() {
                window.location.href = wppopups_builder_vars.exit_url;
              }
            }
          }
        });
      }
    },

    /**
     * Check current popup state.
     *
     * @since 2.0.0
     */
    popupIsSaved: function popupIsSaved() {
      if (wpp.savedState == wpp.getFormState('#wppopups-builder-popup')) {
        return true;
      } else {
        return false;
      }
    },
    // --------------------------------------------------------------------//
    // General / global
    // --------------------------------------------------------------------//

    /**
     * Element bindings for rules
     *
     * @since 2.0.0
     */
    bindUIActionsRules: function bindUIActionsRules() {
      // change rule
      $builder.on('change', '.rule-option .choicesjs-select', function () {
        WPPopupsBuilder.rulesChangeRule($(this));
      }); // Delete row

      $builder.on('click', '.rule-actions .remove', function (e) {
        e.preventDefault();
        WPPopupsBuilder.rulesDeleteRow(e, $(this));
      }); // Add row

      $builder.on('click', '.rule-actions .add', function (e) {
        e.preventDefault();
        WPPopupsBuilder.rulesClone($(this), 'row');
      }); // Add group

      $builder.on('click', '.add-group', function (e) {
        e.preventDefault();
        WPPopupsBuilder.rulesClone($(this), 'group');
      });
    },

    /**
     * Disable/Enable rules fields until ajax it's finished
     * @param $row
     */
    renderRulesLoading: function renderRulesLoading($row, disable) {
      var spinner = ' <i class="fa fa-spinner fa-spin wppopups-loading-inline"></i>';

      if (disable) {
        $('.wppopups-panel-content-section-title').append(spinner);
      } else {
        $('.wppopups-panel-content-section-title .wppopups-loading-inline').remove();
      }

      $row.find('.choicesjs-select').each(function () {
        if (typeof $(this)[0].choices !== 'undefined') {
          if (disable) {
            $(this)[0].choices.disable();
          } else {
            $(this)[0].choices.enable();
          }
        }
      });
      $row.find('input').each(function () {
        if (disable) {
          $(this).prop('disabled', true);
        } else {
          $(this).prop('disabled', false);
        }
      });
    },

    /**
     * Rules - Change rule
     *
     * @since 2.0.0
     */
    rulesChangeRule: function rulesChangeRule(el) {
      var $this = $(el),
          $row = $this.closest('div.rule-tr'),
          $group = $row.closest('div.rule-group'),
          $wpp = this;
      this.renderRulesLoading($row, true); // Ajax create new popup

      var data = {
        rule: $this.val(),
        row_key: $row.data('key'),
        group_key: $group.data('key'),
        action: 'wppopups_render_rule',
        nonce: wppopups_builder_vars.nonce
      };
      $.post(wppopups_builder_vars.ajax_url, data, function (res) {
        if (res.success) {
          $row.find('.rule-operator').html(res.data.rule_operator);
          $row.find('.rule-value').html(res.data.rule_values);
          $wpp.initChoicesJS();
          $wpp.renderRulesLoading($row);
        } else {
          console.log(res);
        }
      }).fail(function (xhr, textStatus, e) {
        WPPopupsBuilder.xhrFailed();
      });
    },

    /**
     * Rules - Delete row
     *
     * @since 2.0.0
     */
    rulesDeleteRow: function rulesDeleteRow(e, el) {
      var $this = $(el),
          $row = $this.closest('div.rule-tr'),
          $table = $this.closest('div.rule-group'),
          $first_group = $('div.rule-group').first(),
          total = $table.find('div.rule-tr').length; // Delete only if one more than row exist

      if (total > '1') {
        $row.remove();
      } else {
        // if only 1 row but no main table, delete group entirely
        if (!$first_group.is($table)) {
          $table.remove();
        }
      }
    },

    /**
     * Rules - Clone
     *
     * @since 2.0.0
     */
    rulesClone: function rulesClone(el, cloning) {
      var $this = $(el),
          $row = $this.closest('div.rule-tr'),
          $group = $row.closest('div.rule-group'); // if we are cloning group (OR)

      if ('group' == cloning) {
        // our old group is the last group
        $group = $('div.rule-group:not(".rule-group-clone")').last();
        var $new_group = $('.rule-group-clone').clone(),
            group_old_id = $group.attr('data-key'),
            group_new_id = 'group_' + (parseInt(group_old_id.replace('group_', ''), 10) + 1),
            row_new_id = 'rule_0',
            $new_row = $new_group.find('div.rule-tr');
        $new_row.attr('data-key', row_new_id);
        $new_group.attr('data-key', group_new_id);
        $new_group.removeClass('rule-group-clone');
        $new_group.insertAfter($group).show();
      } else {
        // or we cloning a row (AND)
        var $new_row = $('.rule-group-clone .rule-tr').clone(),
            group_new_id = $group.attr('data-key'),
            row_old_id = $row.attr('data-key'),
            row_new_id = 'rule_' + (parseInt(row_old_id.replace('rule_', ''), 10) + 1);
        $new_row.attr('data-key', row_new_id);
        $new_row.insertAfter($row);
      }

      this.renderRulesLoading($new_row, true);
      $new_row.find('[name]').each(function () {
        // update names
        $(this).attr('name', $(this).attr('name').replace('rule_id', row_new_id));
        $(this).attr('name', $(this).attr('name').replace('group_id', group_new_id)); // update ids

        $(this).attr('id', $(this).attr('id').replace('rule_id', row_new_id));
        $(this).attr('id', $(this).attr('id').replace('group_id', group_new_id)); // update classes

        $(this).addClass('choicesjs-select'); // remove disabled attr

        $(this).removeAttr('disabled');
      }); // add last-item class
      //  $new_row.find('.rules-td').removeClass('last-item').last().addClass('last-item')

      this.initChoicesJS();
      this.renderRulesLoading($new_row, false);
    },

    /**
     * Check if valid unit in size
     * @param size
     * @returns {string}
     */
    sanitizeSize: function sanitizeSize(size) {
      if (size.indexOf('%') == -1 && size.indexOf('px') == -1 && size.indexOf('em') == -1 && size.indexOf('vh') == -1 && size.indexOf('vw') == -1 && size.indexOf('vmin') == -1 && size.indexOf('vmax') == -1) {
        size = size + 'px';
      }

      return size;
    },
    // --------------------------------------------------------------------//
    // Other functions
    // --------------------------------------------------------------------//
    //--------------------------------------------------------------------//
    // Helper functions.
    //--------------------------------------------------------------------//

    /**
     * Fire AJAX call.
     *
     * @since 2.0.0
     */
    fireAJAX: function fireAJAX(el, d, success) {
      var $this = $(el);
      var data = {
        id: $('#wppopups-builder-popup').data('id'),
        nonce: wppopups_builder_vars.nonce
      };
      $.extend(data, d);
      $.post(wppopups_builder_vars.ajax_url, data, function (res) {
        success(res);
        WPPopupsBuilder.inputToggle($this, 'enable');
      }).fail(function (xhr, textStatus, e) {
        console.log(xhr.responseText);
      });
    },

    /**
     * Toggle input with loading indicator.
     *
     * @since 2.0.0
     */
    inputToggle: function inputToggle(el, status) {
      var $this = $(el);

      if (status === 'enable') {
        if ($this.is('select')) {
          $this.prop('disabled', false).next('i').remove();
        } else {
          $this.prop('disabled', false).find('i').remove();
        }
      } else if (status === 'disable') {
        if ($this.is('select')) {
          $this.prop('disabled', true).after(s.spinner);
        } else {
          $this.prop('disabled', true).prepend(s.spinner);
        }
      }
    },

    /**
     * Display error.
     *
     * @since 2.0.0
     */
    errorDisplay: function errorDisplay(msg, location) {
      location.find('.wppopups-error-msg').remove();
      location.prepend('<p class="wppopups-alert-danger wppopups-alert wppopups-error-msg">' + msg + '</p>');
    },

    /**
     * Check for required fields.
     *
     * @since 2.0.0
     */
    requiredCheck: function requiredCheck(fields, location) {
      var error = false; // Remove any previous errors.

      location.find('.wppopups-alert-required').remove(); // Loop through input fields and check for values.

      fields.each(function (index, el) {
        if ($(el).hasClass('wppopups-required') && $(el).val().length === 0) {
          $(el).addClass('wppopups-error');
          error = true;
        } else {
          $(el).removeClass('wppopups-error');
        }
      });

      if (error) {
        location.prepend('<p class="wppopups-alert-danger wppopups-alert wppopups-alert-required">' + wppopups_builder_providers.required_field + '</p>');
      }

      return error;
    },

    /**
     * Pseudo serializing. Fake it until you make it.
     *
     * @since 2.0.0
     */
    fakeSerialize: function fakeSerialize(els) {
      var fields = els.clone();
      fields.each(function (index, el) {
        if ($(el).data('name')) {
          $(el).attr('name', $(el).data('name'));
        }
      });
      return fields.serialize();
    },

    /**
     * Trim long popup titles.
     *
     * @since 2.0.0
     */
    trimPopupTitle: function trimPopupTitle() {
      var $title = $('.wppopups-center-popup-name');

      if ($title.text().length > 38) {
        var shortTitle = $.trim($title.text()).substring(0, 38).split(" ").slice(0, -1).join(" ") + "...";
        $title.text(shortTitle);
      }
    },

    /**
     * Load or refresh tooltips.
     *
     * @since 2.0.0
     */
    loadTooltips: function loadTooltips() {
      $('.wppopups-help-tooltip').tooltipster({
        contentAsHTML: true,
        position: 'right',
        maxWidth: 300,
        multiple: true
      });
    },

    /**
     * Load or refresh tooltips.
     *
     * @since 2.0.0
     */
    loadColorPickers: function loadColorPickers() {
      $('.wppopups-color-picker').spectrum({
        showAlpha: true,
        showInput: true,
        preferredFormat: "rgb",
        allowEmpty: true,
        move: function move(tinycolor) {
          $(this).val(tinycolor.toRgbString());
        }
      });
    },
    xhrFailed: function xhrFailed() {
      $.alert({
        title: 'Error',
        content: wppopups_builder_vars.xhr_failed,
        icon: 'fa fa-exclamation-circle',
        type: 'red',
        buttons: {
          confirm: {
            text: wppopups_builder_vars.close,
            btnClass: 'btn-confirm',
            keys: ['enter']
          }
        }
      });
    }
  };
  WPPopupsBuilder.init(); // Add to global scope.

  window.wppopups_builder = WPPopupsBuilder;
})(jQuery);