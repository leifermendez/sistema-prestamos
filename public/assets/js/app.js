+function ($, window) {
    'use strict';

    var app = {
        name: 'Infinity',
        version: '2.0.0'
    };

    app.defaults = {
        menubar: {
            folded: false,
            theme: 'light',
            themes: ['light', 'dark']
        },
        navbar: {
            theme: 'primary',
            themes: ['primary', 'success', 'warning', 'danger', 'pink', 'purple', 'inverse', 'dark']
        }
    };

    // Cache DOM
    app.$body = $('body');
    app.$menubar = $('#menubar');
    app.$appMenu = app.$menubar.find('.app-menu').first();
    app.$navbar = $('#app-navbar');
    app.$main = $('#app-main');

    // Which is the original loaded layout ?
    app.defaultLayout = app.$body.hasClass('menubar-left');
    app.topbarLayout = app.$body.hasClass('menubar-top');

    // TODO
    app.settings = app.defaults;

    var appSettings = app.name + app.version + "Settings";
    app.storage = $.localStorage;

    if (app.storage.isEmpty(appSettings)) {
        app.storage.set(appSettings, app.settings);
    } else {
        app.settings = app.storage.get(appSettings);
    }

    app.saveSettings = function () {
        app.storage.set(appSettings, app.settings);
    };

    // initialize navbar
    app.$navbar.removeClass('primary').addClass(app.settings.navbar.theme).addClass('in');
    app.$body.removeClass('theme-primary').addClass('theme-' + app.settings.navbar.theme);

    // initialize menubar
    app.$menubar.removeClass('light').addClass(app.settings.menubar.theme).addClass('in');
    app.$body.removeClass('menubar-light').addClass('menubar-' + app.settings.menubar.theme);

    // initialize main
    app.$main.addClass('in');

    app.init = function () {

        $('[data-plugin]').plugins();
        $('.scrollable-container').perfectScrollbar();

        // load some needed libs listed at: LIBS.others => library.js
        var loadingLibs = loader.load(LIBS["others"]);

        loadingLibs.done(function () {

            $('[data-switchery]').each(function () {
                var $this = $(this),
                    color = $this.attr('data-color') || '#188ae2',
                    jackColor = $this.attr('data-jackColor') || '#ffffff',
                    size = $this.attr('data-size') || 'default'

                new Switchery(this, {
                    color: color,
                    size: size,
                    jackColor: jackColor
                });
            });
        });
    };


    window.app = app;
}(jQuery, window);

function initialize() {
    const input = document.querySelector('.g-autoplaces-address');
    const autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.addListener('place_changed', function () {
        const place = autocomplete.getPlace();
        console.log(place)
        const mapElement = document.querySelector(".over-change-display")
        if (place) {
            console.log(mapElement)
            mapElement.setAttribute('style', 'display:block !important');
            initMap({lat: place.geometry['location'].lat(), lng: place.geometry['location'].lng()})
        }
        // $('#latitude').val(place.geometry['location'].lat());
        // $('#longitude').val(place.geometry['location'].lng());
        //
        // // --------- show lat and long ---------------
        // $("#lat_area").removeClass("d-none");
        // $("#long_area").removeClass("d-none");
    });
}

function toggleBounce(event){
	// initMap({lat:event.latLng.lat(), lng:event.latLng.lng()})
	$('body .new-register #lat').val(event.latLng.lat());
	$('body .new-register #lng').val(event.latLng.lng());

}

function initMap({lat, lng}) {
    // The location of Uluru
    const uluru = {lat, lng};
    // The map, centered at Uluru
    const map = new google.maps.Map(document.querySelector(".map-google"), {
        zoom: 9,
        center: uluru,
    });
    // The marker, positioned at Uluru
    const marker = new google.maps.Marker({
        position: uluru,
        map: map,
        draggable: true
    });

	$('body .new-register #lat').val(lat);
	$('body .new-register #lng').val(lng);

	marker.addListener("dragend", toggleBounce);
}


// menubar MODULE
// =====================

+function ($, window) {
    'use strict';
    // Cache DOM
    var $body = app.$body,
        $menubar = app.$menubar,
        $appMenu = app.$appMenu,
        $menubarFoldButton = $('#menubar-fold-btn'),
        $menubarToggleButton = $('#menubar-toggle-btn');

    // menubar object
    var menubar = {
        open: false,
        folded: app.settings.menubar.folded,
        scrollInitialized: false,

        init: function () {
            app.defaultLayout && this.folded && this.fold();

            this.listenForEvents();
        },

        listenForEvents: function () {
            var self = this;

            $(window).on('load', function (e) {
                // initialize();

                var current = Breakpoints.current();

                // highlight the open page's link
                if (app.topbarLayout && current.name !== 'xs')
                    $(document).on('app-menu.reduce.done', self.highlightOpenLink.bind(self));
                else
                    self.highlightOpenLink();

                // if (default) layout then init scroll
                app.defaultLayout && !self.folded && self.initScroll();

                self.cloneAppUser() && self.foldAppUser();

                // mobile or tablet
                if (current.name === 'xs') {
                    // if the original layout is (topbar) then set the layout to (default) and initialize scroll
                    app.topbarLayout && self.setDefaultLayout() && self.initScroll();

                    // push the menubar out
                    self.pushOut();

                    // if the menubar is folded then unfold it
                    self.folded && self.unFold();
                }

                // desktop (small, medium and large) screens
                if (app.topbarLayout && current.name !== 'xs') self.reduceAppMenu();

                if (app.defaultLayout && (current.name !== 'xs' && current.name !== 'lg')) self.fold();
            });

            // changing the the layout according to breakpoints
            Breakpoints.on('change', function () {
                if (app.defaultLayout) {
                    if (/sm|md/g.test(this.current.name)) {
                        self.folded || self.fold();
                    } else if (/lg/g.test(this.current.name)) {
                        !app.settings.menubar.folded && self.unFold();
                    } else {
                        self.unFold();
                    }
                }
            });

            Breakpoints.on('xs', {
                enter: function () {
                    // if the initial layout is (topbar) layout
                    app.topbarLayout && self.setDefaultLayout() && self.initScroll() && self.toggleScroll();
                    // push the (menubar) out
                    self.pushOut();
                },
                leave: function () {
                    // if the initial layout is (default) layout
                    app.defaultLayout && self.pullIn();
                    // if the initial layout is (topbar) layout
                    app.topbarLayout && self.setTopbarLayout() && self.reduceAppMenu() && self.toggleScroll();
                }
            });

            // folding and unfolding the menubar
            $menubarFoldButton.on('click', function (e) {
                !self.folded ? self.fold() : self.unFold();
                e.preventDefault();
            });

            // showing and hiding the menubar
            $menubarToggleButton.on('click', function (e) {
                self.open ? self.pushOut() : self.pullIn();
                e.preventDefault();
            });

            // toggling submenus when the menubar is folded
            $(document).on('mouseenter mouseleave', 'body.menubar-fold ul.app-menu > li.has-submenu', function (e) {
                $(this).toggleClass('open').siblings('li').removeClass('open');
            });

            // toggling submenus in the (topbar) layout
            $(document).on('mouseenter mouseleave', 'body.menubar-top ul.app-menu li.has-submenu', self.toggleTopbarSubmneuOnHover);

            // toggling submenus on click
            $(document).on('click', 'body.menubar-unfold .app-menu .submenu-toggle, body.menubar-fold .app-menu .submenu .submenu-toggle', self.toggleSubmenuOnClick);

            // readjust the scroll height on resize and orientationchange
            $(window).on('resize orientationchange', self.readjustScroll);
        },

        setDefaultLayout: function () {
            app.$body.removeClass('menubar-top').addClass('menubar-left menubar-unfold');
            return true;
        },

        setTopbarLayout: function () {
            app.$body.removeClass('menubar-left menubar-unfold menubar-fold').addClass('menubar-top');
            return true;
        },

        cloneAppUser: function () {
            var $navbarCollapse = $('.navbar .navbar-collapse');
            if ($navbarCollapse.find('.app-user').length == 0) {
                $menubar.find('.app-user').clone().appendTo($navbarCollapse);
            }
            return true;
        },

        foldAppUser: function () {
            $('.app-user .avatar').addClass('dropdown').find('>a').attr('data-toggle', 'dropdown');
            $('.app-user .dropdown-menu').first().clone().appendTo('.app-user .avatar')
            return true;
        },

        reduceAppMenu: function () {
            var $appMenu = $('body.menubar-top .app-menu');
            // if the menu is already customized return true
            if ($appMenu.find('>li.more-items-li').length) return true;

            var $menuItems = $appMenu.find('> li:not(.menu-separator)');
            if ($menuItems.length > 5) {
                var $moreItemsLi = $('<li class="more-items-li has-submenu"></li>'),
                    $moreItemsUl = $('<ul class="submenu"></ul>'),
                    $moreItemsToggle = $('<a href="javascript:void(0)" class="submenu-toggle"></a>');
                $moreItemsToggle.append(['<i class="menu-icon zmdi zmdi-more-vert zmdi-hc-lg"></i>', '<span class="menu-text">More...</span>', '<i class="menu-caret zmdi zmdi-hc-sm zmdi-chevron-right"></i>']);

                $menuItems.each(function (i, item) {
                    if (i >= 5) $(item).clone().appendTo($moreItemsUl);
                });

                $moreItemsLi.append([$moreItemsToggle, $moreItemsUl]).insertAfter($appMenu.find('>li:nth-child(5)'));
            }

            $(document).trigger('app-menu.reduce.done');

            return true;
        },

        toggleSubmenuOnClick: function (e) {
            $(this).parent().toggleClass('open').find('> .submenu').slideToggle(500).end().siblings().removeClass('open').find('> .submenu').slideUp(500);
            e.preventDefault();
        },

        toggleTopbarSubmneuOnHover: function (e) {
            var $this = $(this), total = $this.offset().left + $this.width();
            var ww = $(window).width();
            if ((ww - total) < 220) {
                $this.find('> .submenu').css({left: 'auto', right: '100%'});
            } else if ((ww - total) >= 220 && !$this.is('.app-menu > li')) {
                $this.find('> .submenu').css({left: '100%', right: 'auto'});
            }
            $(this).toggleClass('open').siblings().removeClass('open');
        },

        fold: function () {
            $body.removeClass('menubar-unfold').addClass('menubar-fold');
            $menubarFoldButton.removeClass('is-active');
            this.toggleScroll() && this.toggleMenuHeading() && (this.folded = true);
            $appMenu.find('li.open').removeClass('open') && $appMenu.find('.submenu').slideUp();
            return true;
        },

        unFold: function () {
            $body.removeClass('menubar-fold').addClass('menubar-unfold');
            $menubarFoldButton.addClass('is-active');
            // initialize the scroll if it's not initialized
            this.scrollInitialized || this.initScroll();
            this.toggleScroll() && this.toggleMenuHeading() && (this.folded = false);
            $appMenu.find('li.open').removeClass('open') && $appMenu.find('.submenu').slideUp();
            return true;
        },

        pullIn: function () {
            $body.addClass('menubar-in') && $menubarToggleButton.addClass('is-active') && (this.open = true);
            return true;
        },

        pushOut: function () {
            $body.removeClass('menubar-in') && $menubarToggleButton.removeClass('is-active') && (this.open = false);
            return true;
        },

        initScroll: function () {
            var $scrollInner = $('body.menubar-left.menubar-unfold .menubar-scroll-inner');
            if (!this.scrollInitialized) {
                $scrollInner.slimScroll({
                    height: 'auto',
                    position: 'right',
                    size: "5px",
                    color: '#98a6ad',
                    wheelStep: 10,
                    touchScrollStep: 50
                });
                this.scrollInitialized = true;
            }
            return true;
        },

        readjustScroll: function (e) {
            if ($body.hasClass('menubar-top') || this.folded) return;

            var parentHeight = $menubar.height(),
                $targets = $('.menubar-scroll, .menubar-scroll-inner, .slimScrollDiv');
            if (Breakpoints.current().name === 'xs') {
                $targets.height(parentHeight);
            } else {
                $targets.height(parentHeight - 75);
            }
        },

        toggleScroll: function () {
            var $scrollContainer = $('.menubar-scroll-inner');
            if (!$body.hasClass('menubar-unfold')) {
                $scrollContainer.css('overflow', 'inherit').parent().css('overflow', 'inherit');
                $scrollContainer.siblings('.slimScrollBar').css('visibility', 'hidden');
            } else {
                $scrollContainer.css('overflow', 'hidden').parent().css('overflow', 'hidden');
                $scrollContainer.siblings('.slimScrollBar').css('visibility', 'visible');
            }
            return true;
        },

        toggleMenuHeading: function () {
            if ($body.hasClass("menubar-fold")) {
                $('.app-menu > li:not(.menu-separator)').each(function (i, item) {
                    if (!$(item).hasClass('has-submenu')) {
                        $(item).addClass('has-submenu').append('<ul class="submenu"></ul>');
                    }
                    var href = $(item).find('a:first-child').attr("href");
                    var menuHeading = $(item).find('> a > .menu-text').text();
                    $(item).find('.submenu').first().prepend('<li class="menu-heading"><a href="' + href + '">' + menuHeading + '</a></li>');
                });
            } else {
                $appMenu.find('.menu-heading').remove();
            }

            return true;
        },

        highlightOpenLink: function () {
            var currentPageName = location.pathname.slice(location.pathname.lastIndexOf('/') + 1),
                currentPageLink = $appMenu.find('a[href="' + currentPageName + '"]').first();

            currentPageLink.parents('li').addClass('active');

            if ($body.hasClass('menubar-left') && !this.folded) {
                currentPageLink.parents('.has-submenu').addClass('open').find('>.submenu').slideDown(500);
            }

            return true;
        },

        // gets the DOM applied theme
        getAppliedTheme: function () {
            var appliedTheme = "", themes = app.settings.menubar.themes, theme;
            for (theme in themes) {
                if ($menubar.hasClass(themes[theme])) {
                    appliedTheme = themes[theme];
                    break;
                }
            }
            return appliedTheme;
        },

        getCurrentTheme: function () {
            return app.settings.menubar.theme;
        },

        setTheme: function (theme) {
            if (theme) app.settings.menubar.theme = theme;
        },

        // applies the theme to the DOM
        applyTheme: function () {
            $body.removeClass('menubar-' + this.getAppliedTheme())
                .addClass('menubar-' + this.getCurrentTheme());
            $menubar.removeClass(this.getAppliedTheme())
                .addClass(this.getCurrentTheme());
        }
    };

    window.app.menubar = menubar;
}(jQuery, window);


// NAVBAR MODULE
// =====================

+function ($, window) {
    'use strict';

    // Cache DOM
    var $body = app.$body,
        $navbar = app.$navbar;

    var navbar = {

        init: function () {
            this.listenForEvents();
        },

        listenForEvents: function () {
            $(document).on("click", '[data-toggle="collapse"]', function (e) {
                var $trigger = $(e.target);
                $trigger.is('[data-toggle="collapse"]') || ($trigger = $trigger.parents('[data-toggle="collapse"]'));
                var $target = $($trigger.attr('data-target'));
                if ($target.attr('id') === 'navbar-search') {
                    if (!$trigger.hasClass('collapsed')) {
                        var $field = $target.find('input[type="search"]').focus();
                        document.querySelector($field.selector).setSelectionRange(0, $field.val().length);
                    } else {
                        $target.find('input[type="search"]').blur();
                    }
                } else if ($target.attr('id') === 'app-navbar-collapse') {
                    $body.toggleClass('navbar-collapse-in', !$trigger.hasClass('collapsed'));
                }
                e.preventDefault();
            });
        },

        // get the DOM applied theme
        getAppliedTheme: function () {
            var appliedTheme = "", themes = app.settings.navbar.themes, theme;
            for (theme in themes) {
                if ($navbar.hasClass(themes[theme])) {
                    appliedTheme = themes[theme];
                    break;
                }
            }
            return appliedTheme;
        },

        getCurrentTheme: function () {
            return app.settings.navbar.theme;
        },

        setTheme: function (theme) {
            if (theme) app.settings.navbar.theme = theme;
        },

        // applies the theme to the DOM
        applyTheme: function () {
            var appliedTheme = this.getAppliedTheme();
            var currentTheme = this.getCurrentTheme();
            $navbar.removeClass(appliedTheme).addClass(currentTheme);
            $body.removeClass('theme-' + appliedTheme).addClass('theme-' + currentTheme);
        }
    };
    window.app.navbar = navbar;
}(jQuery, window);


// CUSTOMIZER MODULE
// =====================

+function ($, window) {
    'use strict';

    // Cache DOM
    var $body = app.$body,
        $menubar = app.$menubar,
        $navbar = app.$navbar;

    var customizer = {

        init: function () {
            this.initCustomizer();
            this.listenForEvents();
        },

        initCustomizer: function () {
            this.renderNavbarThemeChoices();
            $('[data-toggle="menubar-theme"][data-theme="' + app.menubar.getCurrentTheme() + '"]').prop('checked', true);
            $('[data-toggle="navbar-theme"][data-theme="' + app.navbar.getCurrentTheme() + '"]').prop('checked', true);
            app.settings.menubar.folded && $('#menubar-fold-switch').prop('checked', true);
        },

        listenForEvents: function () {
            // change navbar theme
            $(document).on('change', '[data-toggle="menubar-theme"]', this.setMenubarTheme);
            // change navbar theme
            $(document).on('change', '[data-toggle="navbar-theme"]', this.setNavbarTheme);
            // Toggle menubar fold
            $(document).on('change', '#menubar-fold-switch', this.toggleMenubarFold);
            // Resets settings to defaults
            $(document).on('click', '#customizer-reset-btn', this.resetSettings);
        },

        setMenubarTheme: function () {
            var $this = $(this);
            if (app.menubar.getCurrentTheme() !== $this.attr('data-theme')) {
                app.menubar.setTheme($this.attr('data-theme'));
                app.menubar.applyTheme();
                app.saveSettings();
            }
        },

        setNavbarTheme: function (e) {
            var $this = $(this);
            if (app.navbar.getCurrentTheme() !== $this.attr('data-theme')) {
                app.navbar.setTheme($this.attr('data-theme'));
                app.navbar.applyTheme();
                app.saveSettings();
            }
        },

        toggleMenubarFold: function () {
            if ($(this).is(':checked')) {
                app.settings.menubar.folded = true;
                if ($body.hasClass('menubar-fold')) return;
                app.menubar.fold();
            } else {
                app.settings.menubar.folded = false;
                app.menubar.unFold();
            }
            app.saveSettings();
        },

        resetSettings: function (e) {
            app.settings = app.defaults;
            app.saveSettings();
            location.reload();
        },

        renderNavbarThemeChoices: function () {
            var html = '';
            app.settings.navbar.themes.forEach(function (themeName, index) {
                html += this.getTemplate(themeName);
            }.bind(this));

            $('#navbar-customizer').prepend(html);
        },

        getTemplate: function (themeName) {
            var html = '<div class="theme-choice radio radio-' + themeName + ' m-b-md">';
            html += '<input type="radio" id="navbar-' + themeName + '-theme" name="navbar-theme" data-toggle="navbar-theme" data-theme="' + themeName + '">';
            html += '<label for="navbar-' + themeName + '-theme" class="text-' + themeName + '">' + themeName + '</label>';
            html += '</div>';
            return html;
        }
    };

    window.app.customizer = customizer;
}(jQuery, window);

// initialize app
+function ($, window) {
    'use strict';
    window.app.init();
    window.app.menubar.init();
    window.app.navbar.init();
    window.app.customizer.init();
}(jQuery, window);

// other
+function ($, window) {
    'use strict';

    $(window).on('load resize orientationchange', function () {
        // readjust panels on load, resize and orientationchange
        readjustActionPanel();

        // activate bootstrap tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });

    function readjustActionPanel() {
        var $actionPanel = $('.app-action-panel');
        if (!$actionPanel.length > 0) return;
        var $actionList = $actionPanel.children('.app-actions-list').first();
        $actionList.height($actionPanel.height() - $actionList.position().top);
    }

}(jQuery, window);

+function ($, window) {
    function calc() {
        var amount = parseFloat($('.amount-input').val());
        var utility = parseFloat($('#utility').val());
        var total = parseFloat(amount * utility) + parseFloat(amount);
        var quote = parseFloat(total) / parseFloat($('#payment_number').val())

        $('.total-box #total_show').html(total.toFixed(2));
        $('.total-box #quote').html(quote.toFixed(2));
        if (isNaN(total)) {
            $('.total-box').addClass('hidden');
        } else {
            $('.total-box').removeClass('hidden');
        }
    }

    $('body').on('keyup', '.amount-input', function (e) {
        return calc();
    });
    $('body').on('change', '#utility', function () {
        return calc();
    });
    $('body').on('change', '#payment_number', function () {
        return calc();
    });
    $(".datepicker-trigger").datepicker({
        "dateFormat": "dd/mm/yy"
    });
    $('body .datepicker-trigger').prop("readonly", true);
    $('body').on('change', '.supervisor-client #wallet', function () {
        $('#link_client_audit').attr('disabled', false);
        $('#link_client_audit').attr('href', $('#link_client_audit').attr('href') + '/' + $(this).val());
    });

    $('body').on('submit', '.payment-create', function () {
        if (confirm('Esta seguro de realizar el pago (' + $('.payment-create #amount').val() + ')')) {
            return true;
        } else {
            return false;
        }
    });

    $('body').on('click', '.ajax-btn', function () {
        var id_user = $(this).attr('id_user');
        var id_credit = $(this).attr('id_credit');
        $(this).prop("disabled", true);
        $.get("/payment/" + id_user + "/edit",
            {
                id_credit: id_credit,
                ajax: true
            }
        )
            .done(function (data) {
                $('#td_' + id_credit).addClass('hidden');
            });
    });

    $('body table').addClass('table-striped');

    $('#modal_pay').on('show.bs.modal', function (e) {
        $('body form').submit(function (event) {
            $(this).find(":submit").prop("disabled", false);
        });
        $('body .modal-pay .msg-success .text-success').val(0);
        $('body .modal-pay .msg-success .text-primary').val(0);
        $('body .modal-pay .main-body').removeClass('hidden');
        $('body .modal-pay .msg-success').addClass('hidden');
        $('body .modal-pay #name').val('');
        $('body .modal-pay #credit_id').val('');
        $('body .modal-pay #amount_value').val('');
        $('body .modal-pay #done').val('');
        $('body .modal-pay #saldo').val('');
        $('body .modal-pay #payment_quote').val('');
        $('body .modal-pay #done_payment').val('');
        $('body .modal-pay #amount').attr('max', '');
        $('body .modal-pay #amount').val('')
        var attr = e.relatedTarget.attributes;
        for (var a in attr) {
            if (a == 3) {
                $.get("/payment/" + attr[a].nodeValue, {
                    format: 'json'
                })
                    .done(function (res) {
                        $('body .modal-pay #name').val(res.data.user.name + ' ' + res.data.user.last_name);
                        $('body .modal-pay #credit_id').val(res.data.id);
                        $('body .modal-pay #amount_value').val(res.data.amount_neto + ' en ' + res.data.payment_number);
                        $('body .modal-pay #done').val(res.data.credit_data.positive);
                        $('body .modal-pay #saldo').val(res.data.credit_data.rest);
                        $('body .modal-pay #payment_quote').val(res.data.credit_data.payment_quote);
                        $('body .modal-pay #done_payment').val(res.data.credit_data.payment_done);
                        $('body .modal-pay #amount').attr('max', res.data.credit_data.rest);
                        $('body .modal-pay #amount').val(res.data.credit_data.payment_quote)
                    });
            }
        }
    });

    $('body form').submit(function (event) {
        $(this).find(":submit").prop("disabled", true);
    });

    $('body .modal-pay').submit(function (event) {

        console.log(event);
        event.preventDefault();
        var data = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            credit_id: $('body .modal-pay #credit_id').val(),
            amount: $('body .modal-pay #amount').val(),
            format: 'json'
        };
        var actionurl = event.currentTarget.action;
        console.log(data);
        //do your own request an handle the results
        $.post(actionurl,
            data, function (res) {
                if (res.status === 'success') {
                    var id_credit = $('body .modal-pay #credit_id').val();
                    $('body .agente-route-table #td_' + id_credit).addClass('hidden');
                    $('body .modal-pay .msg-success .text-success').html(res.data.recent);
                    $('body .modal-pay .msg-success .text-primary').html(res.data.rest);
                    $('body .modal-pay .main-body').addClass('hidden');
                    $('body .modal-pay .msg-success').removeClass('hidden');
                } else {
                    var conf = confirm('Ya realizo un pago hoy, deseas realizar otro?');

                    if (conf) {
                        var data = {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            credit_id: $('body .modal-pay #credit_id').val(),
                            amount: $('body .modal-pay #amount').val(),
                            format: 'json',
                            rev: true
                        };
                        var actionurl = event.currentTarget.action;
                        $.post(actionurl,
                            data, function (res) {
                                if (res.status === 'success') {
                                    var id_credit = $('body .modal-pay #credit_id').val();
                                    $('body .agente-route-table #td_' + id_credit).addClass('hidden');
                                    $('body .modal-pay .msg-success .text-success').html(res.data.recent);
                                    $('body .modal-pay .msg-success .text-primary').html(res.data.rest);
                                    $('body .modal-pay .main-body').addClass('hidden');
                                    $('body .modal-pay .msg-success').removeClass('hidden');
                                } else {
                                    alert('Algo sucedio');
                                }
                            });
                    }

                }
            })
    });

}(jQuery, window);

//= public function for adding themes
function addNewTheme(themeName) {
    var app = window.app;
    // Only if the theme is not already exist
    if (app.settings.navbar.themes.indexOf(themeName) === -1) {
        app.settings.navbar.themes.push(themeName);
        app.saveSettings();
        location.reload();
    }
}

//= public function for removing themes
function removeTheme(themeName) {
    var app = window.app,
        index = app.settings.navbar.themes.indexOf(themeName);
    if (index !== -1 && themeName !== 'primary') {
        app.settings.navbar.themes.splice(index, 1);

        // if the removed theme is the applied theme then fallback to primary
        if (themeName === app.settings.navbar.theme)
            app.settings.navbar.theme = 'primary';

        app.saveSettings();
        location.reload();
    }
}

