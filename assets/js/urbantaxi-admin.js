jQuery(document).ready(function ($) {
    // Tab switching
    $('.nav-link').on('click', function (e) {
        e.preventDefault();

        var target = $(this).data('tab');

        // Update nav active state
        $('.nav-link').removeClass('active');
        $(this).addClass('active');

        // Update content active state
        $('.tab-content').removeClass('active');
        $('#' + target + '-tab').addClass('active');
    });

    // Save all settings button (colors + general)
    $('#save-settings').on('click', function () {
        var button = $(this);
        button.prop('disabled', true).html('<span class="dashicons dashicons-update spin"></span> Saving...');

        // Remove any existing notices
        $('.urbantaxi-admin-notice').remove();

        var savedCount = 0;
        var totalSaves = 5;
        var errors = [];

        function checkComplete() {
            if (savedCount === totalSaves) {
                button.prop('disabled', false).html('<span class="dashicons dashicons-yes"></span> Save Changes');

                if (errors.length === 0) {
                    // Show success notice
                    var notice = $('<div class="notice notice-success is-dismissible urbantaxi-admin-notice"><p><strong>Success:</strong> All settings saved successfully!</p></div>');
                    notice.insertAfter('.urbantaxi-header').hide().slideDown(300);

                    setTimeout(function () {
                        notice.slideUp(300, function () { notice.remove(); });
                    }, 4000);
                } else {
                    // Show error notice
                    var errorNotice = $('<div class="notice notice-error is-dismissible urbantaxi-admin-notice"><p><strong>Error:</strong> Some settings failed to save: ' + errors.join(', ') + '</p></div>');
                    errorNotice.insertAfter('.urbantaxi-header').hide().slideDown(300);

                    setTimeout(function () {
                        errorNotice.slideUp(300, function () { errorNotice.remove(); });
                    }, 5000);
                }
            }
        }

        // Save colors
        var colorData = {
            action: 'urbantaxi_save_colors',
            nonce: urbantaxiAdmin.nonces.colors,
            urbantaxi_first_theme_color: $('#first-theme-color').val(),
            urbantaxi_second_theme_color: $('#second-theme-color').val(),
            urbantaxi_third_theme_color: $('#third-theme-color').val(),
            urbantaxi_fourth_theme_color: $('#fourth-theme-color').val(),
        };

        $.post(urbantaxiAdmin.ajaxurl, colorData, function (response) {
            savedCount++;
            if (!response.success) {
                errors.push('Colors');
            }
            checkComplete();
        }).fail(function () {
            savedCount++;
            errors.push('Colors (connection error)');
            checkComplete();
        });

        // Save general settings
        var generalData = {
            action: 'urbantaxi_save_general',
            nonce: urbantaxiAdmin.nonces.general,
            urbantaxi_preloader_hide: $('#preloader-toggle').is(':checked') ? 1 : 0,
            header_image: $('#banner-image-upload').val(),
            'urbantaxi_header_image_height[mobile]': $('#banner-height-mobile').val(),
            'urbantaxi_header_image_height[tablet]': $('#banner-height-tablet').val(),
            'urbantaxi_header_image_height[desktop]': $('#banner-height-desktop').val()
        };

        $.post(urbantaxiAdmin.ajaxurl, generalData, function (response) {
            savedCount++;
            if (!response.success) {
                errors.push('General Settings');
            }
            checkComplete();
        }).fail(function () {
            savedCount++;
            errors.push('General Settings (connection error)');
            checkComplete();
        });

        // Save 404 settings
        var error404Data = {
            action: 'urbantaxi_save_404',
            nonce: urbantaxiAdmin.nonces.error404,
            urbantaxi_404_heading: $('#error404-heading').val(),
            urbantaxi_404_image: $('#error404-image-upload').val(),
            urbantaxi_404_text: $('#error404-text').val(),
            urbantaxi_404_button_text: $('#error404-button-text').val()
        };

        $.post(urbantaxiAdmin.ajaxurl, error404Data, function (response) {
            savedCount++;
            if (!response.success) {
                errors.push('404 Settings');
            }
            checkComplete();
        }).fail(function () {
            savedCount++;
            errors.push('404 Settings (connection error)');
            checkComplete();
        });

        // Save transportation settings
        var transportationData = {
            action: 'urbantaxi_save_transportation',
            nonce: urbantaxiAdmin.nonces.transportation,
            single_transportation_text_one: $('#transportation-text-one').val(),
            single_transportation_text_two: $('#transportation-text-two').val(),
            single_transportation_head_title: $('#transportation-head-title').val(),
            single_transportation_text_three: $('#transportation-text-three').val(),
            single_transportation_book_now_text: $('#transportation-book-now-text').val(),
            single_transportation_book_now_url: $('#transportation-book-now-url').val(),
            single_transportation_paragraph_font_size: $('#transportation-paragraph-font-size').val(),
            single_transportation_paragraph_color: $('#transportation-paragraph-color').val(),
            single_transportation_heading_font_size: $('#transportation-heading-font-size').val(),
            single_transportation_heading_color: $('#transportation-heading-color').val(),
            single_transportation_feature_title_font_size: $('#transportation-feature-title-font-size').val(),
            single_transportation_feature_title_color: $('#transportation-feature-title-color').val(),
            single_transportation_feature_text_font_size: $('#transportation-feature-text-font-size').val(),
            single_transportation_feature_text_color: $('#transportation-feature-text-color').val(),
            single_transportation_book_now_font_size: $('#transportation-book-now-font-size').val(),
            single_transportation_book_now_text_color: $('#transportation-book-now-text-color').val(),
            single_transportation_book_now_bg_color: $('#transportation-book-now-bg-color').val(),
            single_transportation_book_now_hover_text_color: $('#transportation-book-now-hover-text-color').val(),
            single_transportation_book_now_hover_bg_color: $('#transportation-book-now-hover-bg-color').val()
        };

        for (var i = 1; i <= 6; i++) {
            transportationData['single_transportation_icon' + i] = $('#transportation-feature-icon-' + i).val();
            transportationData['single_transportation_title' + i] = $('#transportation-feature-title-' + i).val();
            transportationData['single_transportation_text' + i] = $('#transportation-feature-text-' + i).val();
        }

        $.post(urbantaxiAdmin.ajaxurl, transportationData, function (response) {
            savedCount++;
            if (!response.success) {
                errors.push('Transportation Settings');
            }
            checkComplete();
        }).fail(function () {
            savedCount++;
            errors.push('Transportation Settings (connection error)');
            checkComplete();
        });
    });

    // Manual notice dismissal
    $(document).on('click', '.urbantaxi-admin-notice .notice-dismiss', function () {
        $(this).closest('.urbantaxi-admin-notice').slideUp(300, function () {
            $(this).remove();
        });
    });

    // Reset all settings button (colors + general)
    $('#reset-settings').on('click', function () {
        if (confirm('Are you sure you want to reset all settings? This action cannot be undone.')) {
            var button = $(this);
            button.prop('disabled', true).html('<span class="dashicons dashicons-update spin"></span> Resetting...');

            // Remove any existing notices
            $('.urbantaxi-admin-notice').remove();

            var resetCount = 0;
            var totalResets = 5;
            var errors = [];

            function checkResetComplete() {
                if (resetCount === totalResets) {
                    button.prop('disabled', false).html('<span class="dashicons dashicons-update"></span> Reset');

                    if (errors.length === 0) {
                        // Show success notice
                        var notice = $('<div class="notice notice-warning is-dismissible urbantaxi-admin-notice"><p><strong>Reset:</strong> All settings have been reset to defaults!</p></div>');
                        notice.insertAfter('.urbantaxi-header').hide().slideDown(300);

                        setTimeout(function () {
                            notice.slideUp(300, function () { notice.remove(); });
                        }, 4000);
                    } else {
                        // Show error notice
                        var errorNotice = $('<div class="notice notice-error is-dismissible urbantaxi-admin-notice"><p><strong>Error:</strong> Some settings failed to reset: ' + errors.join(', ') + '</p></div>');
                        errorNotice.insertAfter('.urbantaxi-header').hide().slideDown(300);

                        setTimeout(function () {
                            errorNotice.slideUp(300, function () { errorNotice.remove(); });
                        }, 5000);
                    }
                }
            }

            // Reset colors
            var colorResetData = {
                action: 'urbantaxi_reset_colors',
                nonce: urbantaxiAdmin.nonces.colors
            };

            $.post(urbantaxiAdmin.ajaxurl, colorResetData, function (response) {
                resetCount++;
                if (response.success) {
                    // Update color picker values
                    $('#first-theme-color').val('#FDC702');
                    $('#second-theme-color').val('#DAE5E7');
                    $('#third-theme-color').val('#2B2B2B');
                    $('#fourth-theme-color').val('#FFFDEE');
                    $('#fifth-theme-color').val('#783E65');
                    updateColorPreviews();
                } else {
                    errors.push('Colors');
                }
                checkResetComplete();
            }).fail(function () {
                resetCount++;
                errors.push('Colors (connection error)');
                checkResetComplete();
            });

            // Reset general settings
            var generalResetData = {
                action: 'urbantaxi_reset_general',
                nonce: urbantaxiAdmin.nonces.general
            };

            $.post(urbantaxiAdmin.ajaxurl, generalResetData, function (response) {
                resetCount++;
                if (response.success) {
                    // Reset form values
                    $('#preloader-toggle').prop('checked', false);
                    $('#banner-image-upload').val('');
                    $('#banner-height-mobile').val('250px');
                    $('#banner-height-tablet').val('300px');
                    $('#banner-height-desktop').val('350px');
                    $('.banner-image-preview').html('');
                } else {
                    errors.push('General Settings');
                }
                checkResetComplete();
            }).fail(function () {
                resetCount++;
                errors.push('General Settings (connection error)');
                checkResetComplete();
            });

            // Reset 404 settings
            var error404ResetData = {
                action: 'urbantaxi_reset_404',
                nonce: urbantaxiAdmin.nonces.error404
            };

            $.post(urbantaxiAdmin.ajaxurl, error404ResetData, function (response) {
                resetCount++;
                if (response.success) {
                    // Reset form values
                    $('#error404-image-upload').val('');
                    $('#error404-heading').val('404');
                    $('#error404-text').val('We\'re Sorry — Something Has Gone Wrong On Our End.');
                    $('#error404-button-text').val('Back To Home');
                    $('.error404-image-section .banner-image-preview').html('');
                } else {
                    errors.push('404 Settings');
                }
                checkResetComplete();
            }).fail(function () {
                resetCount++;
                errors.push('404 Settings (connection error)');
                checkResetComplete();
            });

            // Reset transportation settings
            var transportationResetData = {
                action: 'urbantaxi_reset_transportation',
                nonce: urbantaxiAdmin.nonces.transportation
            };

            $.post(urbantaxiAdmin.ajaxurl, transportationResetData, function (response) {
                resetCount++;
                if (response.success) {
                    // Reset form values
                    $('#transportation-text-one').val('We offer competitive and affordable taxi pricing that is thoughtfully designed to suit every budget, whether you\'re traveling for daily commutes, business trips, airport transfers, or special occasions. Our goal is to make reliable transportation accessible without compromising on comfort, safety, or service quality. With a clear and straightforward fare structure, we ensure complete transparency from the moment you book your ride. You\'ll always know exactly what you\'re paying before your journey begins, giving you peace of mind and confidence in your travel plans.');
                    $('#transportation-text-two').val('Our pricing system is built on fairness and honesty. There are no hidden fees, unexpected surcharges, or confusing calculations. What you see is what you pay—no surge pricing during peak hours, no last-minute additions, and no unpleasant surprises at the end of your trip. We believe trust starts with transparency, and our pricing reflects that commitment.');
                    $('#transportation-head-title').val('Features Available:');
                    $('#transportation-text-three').val('We offer competitive and affordable taxi pricing that is thoughtfully designed to suit every budget, whether you\'re traveling for daily commutes, business trips, airport transfers, or special occasions. Our goal is to make reliable transportation accessible without compromising on comfort, safety, or service quality. With a clear and straightforward fare structure, we ensure complete transparency from the moment you book your ride. You\'ll always know exactly what you\'re paying before your journey begins, giving you peace of mind and confidence in your travel plans.');
                    $('#transportation-book-now-text').val('Book Now');
                } else {
                    errors.push('Transportation Settings');
                }
                checkResetComplete();
            }).fail(function () {
                resetCount++;
                errors.push('Transportation Settings (connection error)');
                checkResetComplete();
            });
        }
    });

    // Color picker change handler
    $('.color-picker').on('input change', function () {
        updateColorPreviews();
    });

    // Update color previews
    function updateColorPreviews() {
        $('#preview-first').css('background-color', $('#first-theme-color').val());
        $('#preview-second').css('background-color', $('#second-theme-color').val());
        $('#preview-third').css('background-color', $('#third-theme-color').val());
        $('#preview-fourth').css('background-color', $('#fourth-theme-color').val());
        $('#preview-fifth').css('background-color', $('#fifth-theme-color').val());
    }

    // Initialize color previews
    updateColorPreviews();


    // Save blogs
    $('#save-blogs').on('click', function () {
        var button = $(this);
        button.prop('disabled', true).html('<span class="dashicons dashicons-update spin"></span> Saving...');

        var blogsData = {
            action: 'urbantaxi_save_blogs',
            nonce: urbantaxiAdmin.nonces.blogs,
            related_blog_post_subtitle: $('#banner-post-subtitle').val(),
            related_blog_post_heading: $('#banner-post-heading').val(),
            related_blog_post_text: $('#banner-post-text').val()
        };

        $.post(urbantaxiAdmin.ajaxurl, blogsData, function (response) {
            button.prop('disabled', false).html('<span class="dashicons dashicons-yes"></span> Save Blogs');

            if (response.success) {
                // Remove any existing notices
                $('.urbantaxi-admin-notice').remove();

                // Show success notice
                var notice = $('<div class="notice notice-success is-dismissible urbantaxi-admin-notice"><p><strong>Success:</strong> ' + response.data.message + '</p></div>');
                notice.insertAfter('.urbantaxi-header').hide().slideDown(300);

                // Auto-hide after 4 seconds
                setTimeout(function () {
                    notice.slideUp(300, function () {
                        notice.remove();
                    });
                }, 4000);
            } else {
                // Remove any existing notices
                $('.urbantaxi-admin-notice').remove();

                // Show error notice
                var errorNotice = $('<div class="notice notice-error is-dismissible urbantaxi-admin-notice"><p><strong>Error:</strong> ' + (response.data ? response.data.message : 'An error occurred while saving blogs.') + '</p></div>');
                errorNotice.insertAfter('.urbantaxi-header').hide().slideDown(300);

                // Auto-hide after 5 seconds
                setTimeout(function () {
                    errorNotice.slideUp(300, function () {
                        errorNotice.remove();
                    });
                }, 5000);
            }
        });
    });

    // Reset blogs
    $('#reset-blogs').on('click', function () {
        if (confirm('Are you sure you want to reset all blogs to defaults?')) {
            var button = $(this);
            button.prop('disabled', true).html('<span class="dashicons dashicons-update spin"></span> Resetting...');

            var resetData = {
                action: 'urbantaxi_reset_blogs',
                nonce: urbantaxiAdmin.nonces.blogs
            };

            $.post(urbantaxiAdmin.ajaxurl, resetData, function (response) {
                button.prop('disabled', false).html('<span class="dashicons dashicons-update"></span> Reset to Defaults');

                if (response.success) {
                    // Update blogs values
                    $('#banner-post-subtitle').val('Related Posts');
                    $('#banner-post-heading').val('Related News & Blogs');
                    $('#banner-post-text').val('An education platform needed to support massive traffic spikes during online sessions.');

                    // Remove any existing notices
                    $('.urbantaxi-admin-notice').remove();

                    // Show warning notice
                    var notice = $('<div class="notice notice-warning is-dismissible urbantaxi-admin-notice"><p><strong>Reset:</strong> ' + response.data.message + '</p></div>');
                    notice.insertAfter('.urbantaxi-header').hide().slideDown(300);

                    // Auto-hide after 4 seconds
                    setTimeout(function () {
                        notice.slideUp(300, function () {
                            notice.remove();
                        });
                    }, 4000);
                } else {
                    // Remove any existing notices
                    $('.urbantaxi-admin-notice').remove();

                    // Show error notice
                    var errorNotice = $('<div class="notice notice-error is-dismissible urbantaxi-admin-notice"><p><strong>Error:</strong> ' + (response.data ? response.data.message : 'An error occurred while resetting blogs.') + '</p></div>');
                    errorNotice.insertAfter('.urbantaxi-header').hide().slideDown(300);

                    // Auto-hide after 5 seconds
                    setTimeout(function () {
                        errorNotice.slideUp(300, function () {
                            errorNotice.remove();
                        });
                    }, 5000);
                }
            });
        }
    });

    // Save colors
    $('#save-colors').on('click', function () {
        var button = $(this);
        button.prop('disabled', true).html('<span class="dashicons dashicons-update spin"></span> Saving...');

        var colorData = {
            action: 'urbantaxi_save_colors',
            nonce: urbantaxiAdmin.nonces.colors,
            urbantaxi_first_theme_color: $('#first-theme-color').val(),
            urbantaxi_second_theme_color: $('#second-theme-color').val(),
            urbantaxi_third_theme_color: $('#third-theme-color').val(),
            urbantaxi_fourth_theme_color: $('#fourth-theme-color').val(),
        };

        $.post(urbantaxiAdmin.ajaxurl, colorData, function (response) {
            button.prop('disabled', false).html('<span class="dashicons dashicons-yes"></span> Save Colors');

            if (response.success) {
                // Remove any existing notices
                $('.urbantaxi-admin-notice').remove();

                // Show success notice
                var notice = $('<div class="notice notice-success is-dismissible urbantaxi-admin-notice"><p><strong>Success:</strong> ' + response.data.message + '</p></div>');
                notice.insertAfter('.urbantaxi-header').hide().slideDown(300);

                // Auto-hide after 4 seconds
                setTimeout(function () {
                    notice.slideUp(300, function () {
                        notice.remove();
                    });
                }, 4000);
            } else {
                // Remove any existing notices
                $('.urbantaxi-admin-notice').remove();

                // Show error notice
                var errorNotice = $('<div class="notice notice-error is-dismissible urbantaxi-admin-notice"><p><strong>Error:</strong> ' + (response.data ? response.data.message : 'An error occurred while saving colors.') + '</p></div>');
                errorNotice.insertAfter('.urbantaxi-header').hide().slideDown(300);

                // Auto-hide after 5 seconds
                setTimeout(function () {
                    errorNotice.slideUp(300, function () {
                        errorNotice.remove();
                    });
                }, 5000);
            }
        });
    });

    // Reset colors
    $('#reset-colors').on('click', function () {
        if (confirm('Are you sure you want to reset all colors to defaults?')) {
            var button = $(this);
            button.prop('disabled', true).html('<span class="dashicons dashicons-update spin"></span> Resetting...');

            var resetData = {
                action: 'urbantaxi_reset_colors',
                nonce: urbantaxiAdmin.nonces.colors
            };

            $.post(urbantaxiAdmin.ajaxurl, resetData, function (response) {
                button.prop('disabled', false).html('<span class="dashicons dashicons-update"></span> Reset to Defaults');

                if (response.success) {
                    // Update color picker values
                    $('#first-theme-color').val('#FDC702');
                    $('#second-theme-color').val('#DAE5E7');
                    $('#third-theme-color').val('#2B2B2B');
                    $('#fourth-theme-color').val('#FFFDEE');
                    $('#fifth-theme-color').val('#783E65');
                    updateColorPreviews();

                    // Remove any existing notices
                    $('.urbantaxi-admin-notice').remove();

                    // Show warning notice
                    var notice = $('<div class="notice notice-warning is-dismissible urbantaxi-admin-notice"><p><strong>Reset:</strong> ' + response.data.message + '</p></div>');
                    notice.insertAfter('.urbantaxi-header').hide().slideDown(300);

                    // Auto-hide after 4 seconds
                    setTimeout(function () {
                        notice.slideUp(300, function () {
                            notice.remove();
                        });
                    }, 4000);
                } else {
                    // Remove any existing notices
                    $('.urbantaxi-admin-notice').remove();

                    // Show error notice
                    var errorNotice = $('<div class="notice notice-error is-dismissible urbantaxi-admin-notice"><p><strong>Error:</strong> ' + (response.data ? response.data.message : 'An error occurred while resetting colors.') + '</p></div>');
                    errorNotice.insertAfter('.urbantaxi-header').hide().slideDown(300);

                    // Auto-hide after 5 seconds
                    setTimeout(function () {
                        errorNotice.slideUp(300, function () {
                            errorNotice.remove();
                        });
                    }, 5000);
                }
            });
        }
    });

    // General settings save
    $('#save-general').on('click', function () {
        var button = $(this);
        button.prop('disabled', true).html('<span class="dashicons dashicons-update spin"></span> Saving...');

        var generalData = {
            action: 'urbantaxi_save_general',
            nonce: urbantaxiAdmin.nonces.general,
            urbantaxi_preloader_hide: $('#preloader-toggle').is(':checked') ? 1 : 0,
            header_image: $('#banner-image-upload').val(),
            'urbantaxi_header_image_height[mobile]': $('#banner-height-mobile').val(),
            'urbantaxi_header_image_height[tablet]': $('#banner-height-tablet').val(),
            'urbantaxi_header_image_height[desktop]': $('#banner-height-desktop').val()
        };

        $.post(urbantaxiAdmin.ajaxurl, generalData, function (response) {
            button.prop('disabled', false).html('<span class="dashicons dashicons-yes"></span> Save General Settings');

            if (response.success) {
                // Remove any existing notices
                $('.urbantaxi-admin-notice').remove();

                // Show success notice
                var notice = $('<div class="notice notice-success is-dismissible urbantaxi-admin-notice"><p><strong>Success:</strong> ' + response.data.message + '</p></div>');
                notice.insertAfter('.urbantaxi-header').hide().slideDown(300);

                // Auto-hide after 4 seconds
                setTimeout(function () {
                    notice.slideUp(300, function () {
                        notice.remove();
                    });
                }, 4000);
            } else {
                // Remove any existing notices
                $('.urbantaxi-admin-notice').remove();

                // Show error notice
                var errorNotice = $('<div class="notice notice-error is-dismissible urbantaxi-admin-notice"><p><strong>Error:</strong> ' + (response.data ? response.data.message : 'An error occurred while saving settings.') + '</p></div>');
                errorNotice.insertAfter('.urbantaxi-header').hide().slideDown(300);

                // Auto-hide after 5 seconds
                setTimeout(function () {
                    errorNotice.slideUp(300, function () {
                        errorNotice.remove();
                    });
                }, 5000);
            }
        });
    });

    // General settings reset
    $('#reset-general').on('click', function () {
        if (confirm('Are you sure you want to reset general settings to defaults?')) {
            var button = $(this);
            button.prop('disabled', true).html('<span class="dashicons dashicons-update spin"></span> Resetting...');

            var resetData = {
                action: 'urbantaxi_reset_general',
                nonce: urbantaxiAdmin.nonces.general
            };

            $.post(urbantaxiAdmin.ajaxurl, resetData, function (response) {
                button.prop('disabled', false).html('<span class="dashicons dashicons-update"></span> Reset to Defaults');

                if (response.success) {
                    // Reset form values
                    $('#preloader-toggle').prop('checked', false);
                    $('#banner-image-upload').val('');
                    $('#banner-height-mobile').val('250px');
                    $('#banner-height-tablet').val('300px');
                    $('#banner-height-desktop').val('350px');
                    $('.banner-image-preview').html('');

                    // Remove any existing notices
                    $('.urbantaxi-admin-notice').remove();

                    // Show warning notice
                    var notice = $('<div class="notice notice-warning is-dismissible urbantaxi-admin-notice"><p><strong>Reset:</strong> ' + response.data.message + '</p></div>');
                    notice.insertAfter('.urbantaxi-header').hide().slideDown(300);

                    // Auto-hide after 4 seconds
                    setTimeout(function () {
                        notice.slideUp(300, function () {
                            notice.remove();
                        });
                    }, 4000);
                } else {
                    // Remove any existing notices
                    $('.urbantaxi-admin-notice').remove();

                    // Show error notice
                    var errorNotice = $('<div class="notice notice-error is-dismissible urbantaxi-admin-notice"><p><strong>Error:</strong> ' + (response.data ? response.data.message : 'An error occurred while resetting settings.') + '</p></div>');
                    errorNotice.insertAfter('.urbantaxi-header').hide().slideDown(300);

                    // Auto-hide after 5 seconds
                    setTimeout(function () {
                        errorNotice.slideUp(300, function () {
                            errorNotice.remove();
                        });
                    }, 5000);
                }
            });
        }
    });

    // Banner image upload
    $(document).on('click', '.upload-banner-button', function (e) {
        e.preventDefault();
        var button = $(this);
        var targetField = button.data('target');

        if (typeof wp !== 'undefined' && wp.media && wp.media.editor) {
            var frame = wp.media({
                title: 'Select Banner Image',
                button: {
                    text: 'Use this image'
                },
                multiple: false,
                library: {
                    type: 'image'
                }
            });

            frame.on('select', function () {
                var attachment = frame.state().get('selection').first().toJSON();
                $('#' + targetField).val(attachment.url);
                var preview = '<img src="' + attachment.url + '" style="max-width: 300px; height: auto; display: block; margin-bottom: 10px; border: 1px solid #ddd; padding: 5px; border-radius: 4px;" />';
                button.closest('.banner-image-section').find('.banner-image-preview').html(preview);
            });

            frame.open();
        } else {
            alert('WordPress Media Library not available. Please refresh the page.');
        }
    });

    // Remove banner image
    $(document).on('click', '.remove-banner-button', function (e) {
        e.preventDefault();
        var button = $(this);
        var targetField = button.data('target');

        $('#' + targetField).val('');
        button.closest('.banner-image-section').find('.banner-image-preview').html('');
    });

    // Save 404 settings
    $('#save-404').on('click', function () {
        var button = $(this);
        button.prop('disabled', true).html('<span class="dashicons dashicons-update spin"></span> Saving...');

        var error404Data = {
            action: 'urbantaxi_save_404',
            nonce: urbantaxiAdmin.nonces.error404,
            urbantaxi_404_heading: $('#error404-heading').val(),
            urbantaxi_404_image: $('#error404-image-upload').val(),
            urbantaxi_404_text: $('#error404-text').val(),
            urbantaxi_404_button_text: $('#error404-button-text').val()
        };

        $.post(urbantaxiAdmin.ajaxurl, error404Data, function (response) {
            button.prop('disabled', false).html('<span class="dashicons dashicons-yes"></span> Save 404 Settings');

            if (response.success) {
                // Remove any existing notices
                $('.urbantaxi-admin-notice').remove();

                // Show success notice
                var notice = $('<div class="notice notice-success is-dismissible urbantaxi-admin-notice"><p><strong>Success:</strong> ' + response.data.message + '</p></div>');
                notice.insertAfter('.urbantaxi-header').hide().slideDown(300);

                // Auto-hide after 4 seconds
                setTimeout(function () {
                    notice.slideUp(300, function () {
                        notice.remove();
                    });
                }, 4000);
            } else {
                // Remove any existing notices
                $('.urbantaxi-admin-notice').remove();

                // Show error notice
                var errorNotice = $('<div class="notice notice-error is-dismissible urbantaxi-admin-notice"><p><strong>Error:</strong> ' + (response.data ? response.data.message : 'An error occurred while saving 404 settings.') + '</p></div>');
                errorNotice.insertAfter('.urbantaxi-header').hide().slideDown(300);

                // Auto-hide after 5 seconds
                setTimeout(function () {
                    errorNotice.slideUp(300, function () {
                        errorNotice.remove();
                    });
                }, 5000);
            }
        });
    });

    // Reset 404 settings
    $('#reset-404').on('click', function () {
        if (confirm('Are you sure you want to reset 404 settings to defaults?')) {
            var button = $(this);
            button.prop('disabled', true).html('<span class="dashicons dashicons-update spin"></span> Resetting...');

            var resetData = {
                action: 'urbantaxi_reset_404',
                nonce: urbantaxiAdmin.nonces.error404
            };

            $.post(urbantaxiAdmin.ajaxurl, resetData, function (response) {
                button.prop('disabled', false).html('<span class="dashicons dashicons-update"></span> Reset to Defaults');

                if (response.success) {
                    // Update 404 form values
                    $('#error404-image-upload').val('');
                    $('#error404-heading').val('404');
                    $('#error404-text').val('We\'re Sorry — Something Has Gone Wrong On Our End.');
                    $('#error404-button-text').val('Back To Home');
                    $('.error404-image-section .banner-image-preview').html('');

                    // Remove any existing notices
                    $('.urbantaxi-admin-notice').remove();

                    // Show warning notice
                    var notice = $('<div class="notice notice-warning is-dismissible urbantaxi-admin-notice"><p><strong>Reset:</strong> ' + response.data.message + '</p></div>');
                    notice.insertAfter('.urbantaxi-header').hide().slideDown(300);

                    // Auto-hide after 4 seconds
                    setTimeout(function () {
                        notice.slideUp(300, function () {
                            notice.remove();
                        });
                    }, 4000);
                } else {
                    // Remove any existing notices
                    $('.urbantaxi-admin-notice').remove();

                    // Show error notice
                    var errorNotice = $('<div class="notice notice-error is-dismissible urbantaxi-admin-notice"><p><strong>Error:</strong> ' + (response.data ? response.data.message : 'An error occurred while resetting 404 settings.') + '</p></div>');
                    errorNotice.insertAfter('.urbantaxi-header').hide().slideDown(300);

                    // Auto-hide after 5 seconds
                    setTimeout(function () {
                        errorNotice.slideUp(300, function () {
                            errorNotice.remove();
                        });
                    }, 5000);
                }
            });
        }
    });

    // Transportation settings save
    $('#save-transportation').on('click', function () {
        var button = $(this);
        button.prop('disabled', true).html('<span class="dashicons dashicons-update spin"></span> Saving...');

        var transportationData = {
            action: 'urbantaxi_save_transportation',
            nonce: urbantaxiAdmin.nonces.transportation,
            single_transportation_text_one: $('#transportation-text-one').val(),
            single_transportation_text_two: $('#transportation-text-two').val(),
            single_transportation_head_title: $('#transportation-head-title').val(),
            single_transportation_text_three: $('#transportation-text-three').val(),
            single_transportation_book_now_text: $('#transportation-book-now-text').val(),
            single_transportation_book_now_url: $('#transportation-book-now-url').val(),
            single_transportation_paragraph_font_size: $('#transportation-paragraph-font-size').val(),
            single_transportation_paragraph_color: $('#transportation-paragraph-color').val(),
            single_transportation_heading_font_size: $('#transportation-heading-font-size').val(),
            single_transportation_heading_color: $('#transportation-heading-color').val(),
            single_transportation_feature_title_font_size: $('#transportation-feature-title-font-size').val(),
            single_transportation_feature_title_color: $('#transportation-feature-title-color').val(),
            single_transportation_feature_text_font_size: $('#transportation-feature-text-font-size').val(),
            single_transportation_feature_text_color: $('#transportation-feature-text-color').val(),
            single_transportation_book_now_font_size: $('#transportation-book-now-font-size').val(),
            single_transportation_book_now_text_color: $('#transportation-book-now-text-color').val(),
            single_transportation_book_now_bg_color: $('#transportation-book-now-bg-color').val(),
            single_transportation_book_now_hover_text_color: $('#transportation-book-now-hover-text-color').val(),
            single_transportation_book_now_hover_bg_color: $('#transportation-book-now-hover-bg-color').val()
        };

        for (var i = 1; i <= 6; i++) {
            transportationData['single_transportation_icon' + i] = $('#transportation-feature-icon-' + i).val();
            transportationData['single_transportation_title' + i] = $('#transportation-feature-title-' + i).val();
            transportationData['single_transportation_text' + i] = $('#transportation-feature-text-' + i).val();
        }

        $.post(urbantaxiAdmin.ajaxurl, transportationData, function (response) {
            button.prop('disabled', false).html('<span class="dashicons dashicons-yes"></span> Save Transportation Settings');

            if (response.success) {
                // Remove any existing notices
                $('.urbantaxi-admin-notice').remove();

                // Show success notice
                var notice = $('<div class="notice notice-success is-dismissible urbantaxi-admin-notice"><p><strong>Success:</strong> ' + response.data.message + '</p></div>');
                notice.insertAfter('.urbantaxi-header').hide().slideDown(300);

                // Auto-hide after 4 seconds
                setTimeout(function () {
                    notice.slideUp(300, function () {
                        notice.remove();
                    });
                }, 4000);
            } else {
                // Remove any existing notices
                $('.urbantaxi-admin-notice').remove();

                // Show error notice
                var errorNotice = $('<div class="notice notice-error is-dismissible urbantaxi-admin-notice"><p><strong>Error:</strong> ' + (response.data ? response.data.message : 'An error occurred while saving transportation settings.') + '</p></div>');
                errorNotice.insertAfter('.urbantaxi-header').hide().slideDown(300);

                // Auto-hide after 5 seconds
                setTimeout(function () {
                    errorNotice.slideUp(300, function () {
                        errorNotice.remove();
                    });
                }, 5000);
            }
        });
    });

    // Transportation settings reset
    $('#reset-transportation').on('click', function () {
        if (confirm('Are you sure you want to reset transportation settings to defaults?')) {
            var button = $(this);
            button.prop('disabled', true).html('<span class="dashicons dashicons-update spin"></span> Resetting...');

            var resetData = {
                action: 'urbantaxi_reset_transportation',
                nonce: urbantaxiAdmin.nonces.transportation
            };

            $.post(urbantaxiAdmin.ajaxurl, resetData, function (response) {
                button.prop('disabled', false).html('<span class="dashicons dashicons-update"></span> Reset to Defaults');

                if (response.success) {
                    // Reset form values
                    $('#transportation-text-one').val('We offer competitive and affordable taxi pricing that is thoughtfully designed to suit every budget, whether you\'re traveling for daily commutes, business trips, airport transfers, or special occasions. Our goal is to make reliable transportation accessible without compromising on comfort, safety, or service quality. With a clear and straightforward fare structure, we ensure complete transparency from the moment you book your ride. You\'ll always know exactly what you\'re paying before your journey begins, giving you peace of mind and confidence in your travel plans.');
                    $('#transportation-text-two').val('Our pricing system is built on fairness and honesty. There are no hidden fees, unexpected surcharges, or confusing calculations. What you see is what you pay—no surge pricing during peak hours, no last-minute additions, and no unpleasant surprises at the end of your trip. We believe trust starts with transparency, and our pricing reflects that commitment.');
                    $('#transportation-head-title').val('Features Available:');
                    $('#transportation-text-three').val('We offer competitive and affordable taxi pricing that is thoughtfully designed to suit every budget, whether you\'re traveling for daily commutes, business trips, airport transfers, or special occasions. Our goal is to make reliable transportation accessible without compromising on comfort, safety, or service quality. With a clear and straightforward fare structure, we ensure complete transparency from the moment you book your ride. You\'ll always know exactly what you\'re paying before your journey begins, giving you peace of mind and confidence in your travel plans.');
                    $('#transportation-book-now-text').val('Book Now');
                    $('#transportation-book-now-url').val('');
                    $('#transportation-paragraph-font-size').val('16px');
                    $('#transportation-paragraph-color').val('#333333');
                    $('#transportation-heading-font-size').val('24px');
                    $('#transportation-heading-color').val('#000000');
                    $('#transportation-feature-title-font-size').val('18px');
                    $('#transportation-feature-title-color').val('#000000');
                    $('#transportation-feature-text-font-size').val('14px');
                    $('#transportation-feature-text-color').val('#333333');
                    $('#transportation-book-now-font-size').val('16px');
                    $('#transportation-book-now-text-color').val('#000000');
                    $('#transportation-book-now-bg-color').val('#FDC702');
                    $('#transportation-book-now-hover-text-color').val('#ffffff');
                    $('#transportation-book-now-hover-bg-color').val('#000000');

                    var defaultFeatureTitles = [
                        'Bluetooth Connectivity',
                        'Mobile Charging Port',
                        'GPS Navigation',
                        'Air Conditioning',
                        'Sanitized Interior',
                        'Comfortable Seating'
                    ];
                    var defaultFeatureTexts = [
                        'Seamless wireless pairing',
                        'Fast device charging',
                        'Accurate route guidance',
                        'Cool climate control',
                        'Clean hygienic cabin',
                        'Soft cushioned seats'
                    ];
                    for (var i = 1; i <= 6; i++) {
                        var input = $('#transportation-feature-icon-' + i);
                        var icon = input.data('default-icon') || '';
                        $('#transportation-feature-icon-' + i).val(icon);
                        $('#transportation-feature-title-' + i).val(defaultFeatureTitles[i - 1]);
                        $('#transportation-feature-text-' + i).val(defaultFeatureTexts[i - 1]);

                        var section = $('#transportation-feature-icon-' + i).closest('.banner-image-section');
                        section.find('.banner-image-preview').html(icon ? '<img src="' + icon + '" />' : '');
                    }

                    // Remove any existing notices
                    $('.urbantaxi-admin-notice').remove();

                    // Show warning notice
                    var notice = $('<div class="notice notice-warning is-dismissible urbantaxi-admin-notice"><p><strong>Reset:</strong> ' + response.data.message + '</p></div>');
                    notice.insertAfter('.urbantaxi-header').hide().slideDown(300);

                    // Auto-hide after 4 seconds
                    setTimeout(function () {
                        notice.slideUp(300, function () {
                            notice.remove();
                        });
                    }, 4000);
                } else {
                    // Remove any existing notices
                    $('.urbantaxi-admin-notice').remove();

                    // Show error notice
                    var errorNotice = $('<div class="notice notice-error is-dismissible urbantaxi-admin-notice"><p><strong>Error:</strong> ' + (response.data ? response.data.message : 'An error occurred while resetting transportation settings.') + '</p></div>');
                    errorNotice.insertAfter('.urbantaxi-header').hide().slideDown(300);

                    // Auto-hide after 5 seconds
                    setTimeout(function () {
                        errorNotice.slideUp(300, function () {
                            errorNotice.remove();
                        });
                    }, 5000);
                }
            });
        }
    });

    // Taxonomy Location settings save
    $('#save-taxonomy-location').on('click', function () {
        var button = $(this);
        button.prop('disabled', true).html('<span class="dashicons dashicons-update spin"></span> Saving...');

        var taxonomyLocationData = {
            action: 'urbantaxi_save_taxonomy_location',
            nonce: urbantaxiAdmin.nonces.taxonomy_location,
            taxonomy_location_title_font_size: $('#taxonomy-location-title-font-size').val(),
            taxonomy_location_title_color: $('#taxonomy-location-title-color').val(),
            taxonomy_location_content_font_size: $('#taxonomy-location-content-font-size').val(),
            taxonomy_location_content_color: $('#taxonomy-location-content-color').val(),
            taxonomy_location_price_font_size: $('#taxonomy-location-price-font-size').val(),
            taxonomy_location_price_color: $('#taxonomy-location-price-color').val(),
            taxonomy_location_button_text: $('#taxonomy-location-button-text').val(),
            taxonomy_location_button_url: $('#taxonomy-location-button-url').val(),
            taxonomy_location_button_font_size: $('#taxonomy-location-button-font-size').val(),
            taxonomy_location_button_text_color: $('#taxonomy-location-button-text-color').val(),
            taxonomy_location_button_bg_color: $('#taxonomy-location-button-bg-color').val(),
            taxonomy_location_button_hover_text_color: $('#taxonomy-location-button-hover-text-color').val(),
            taxonomy_location_button_hover_bg_color: $('#taxonomy-location-button-hover-bg-color').val()
        };

        $.post(urbantaxiAdmin.ajaxurl, taxonomyLocationData, function (response) {
            button.prop('disabled', false).html('<span class="dashicons dashicons-yes"></span> Save Location Settings');

            if (response.success) {
                // Remove any existing notices
                $('.urbantaxi-admin-notice').remove();

                // Show success notice
                var notice = $('<div class="notice notice-success is-dismissible urbantaxi-admin-notice"><p><strong>Success:</strong> ' + response.data.message + '</p></div>');
                notice.insertAfter('.urbantaxi-header').hide().slideDown(300);

                // Auto-hide after 4 seconds
                setTimeout(function () {
                    notice.slideUp(300, function () {
                        notice.remove();
                    });
                }, 4000);
            } else {
                // Remove any existing notices
                $('.urbantaxi-admin-notice').remove();

                // Show error notice
                var errorNotice = $('<div class="notice notice-error is-dismissible urbantaxi-admin-notice"><p><strong>Error:</strong> ' + (response.data ? response.data.message : 'An error occurred while saving location settings.') + '</p></div>');
                errorNotice.insertAfter('.urbantaxi-header').hide().slideDown(300);

                // Auto-hide after 5 seconds
                setTimeout(function () {
                    errorNotice.slideUp(300, function () {
                        errorNotice.remove();
                    });
                }, 5000);
            }
        });
    });

    // Taxonomy Location settings reset
    $('#reset-taxonomy-location').on('click', function () {
        if (confirm('Are you sure you want to reset location settings to defaults?')) {
            var button = $(this);
            button.prop('disabled', true).html('<span class="dashicons dashicons-update spin"></span> Resetting...');

            var resetData = {
                action: 'urbantaxi_reset_taxonomy_location',
                nonce: urbantaxiAdmin.nonces.taxonomy_location
            };

            $.post(urbantaxiAdmin.ajaxurl, resetData, function (response) {
                button.prop('disabled', false).html('<span class="dashicons dashicons-update"></span> Reset to Defaults');

                if (response.success) {
                    // Reset form values
                    $('#taxonomy-location-title-font-size').val('20px');
                    $('#taxonomy-location-title-color').val('#000000');
                    $('#taxonomy-location-content-font-size').val('14px');
                    $('#taxonomy-location-content-color').val('#333333');
                    $('#taxonomy-location-price-font-size').val('18px');
                    $('#taxonomy-location-price-color').val('#FDC702');
                    $('#taxonomy-location-button-text').val('Book Now');
                    $('#taxonomy-location-button-url').val('');
                    $('#taxonomy-location-button-font-size').val('14px');
                    $('#taxonomy-location-button-text-color').val('#000000');
                    $('#taxonomy-location-button-bg-color').val('#FDC702');
                    $('#taxonomy-location-button-hover-text-color').val('#ffffff');
                    $('#taxonomy-location-button-hover-bg-color').val('#000000');

                    // Remove any existing notices
                    $('.urbantaxi-admin-notice').remove();

                    // Show warning notice
                    var notice = $('<div class="notice notice-warning is-dismissible urbantaxi-admin-notice"><p><strong>Reset:</strong> ' + response.data.message + '</p></div>');
                    notice.insertAfter('.urbantaxi-header').hide().slideDown(300);

                    // Auto-hide after 4 seconds
                    setTimeout(function () {
                        notice.slideUp(300, function () {
                            notice.remove();
                        });
                    }, 4000);
                } else {
                    // Remove any existing notices
                    $('.urbantaxi-admin-notice').remove();

                    // Show error notice
                    var errorNotice = $('<div class="notice notice-error is-dismissible urbantaxi-admin-notice"><p><strong>Error:</strong> ' + (response.data ? response.data.message : 'An error occurred while resetting location settings.') + '</p></div>');
                    errorNotice.insertAfter('.urbantaxi-header').hide().slideDown(300);

                    // Auto-hide after 5 seconds
                    setTimeout(function () {
                        errorNotice.slideUp(300, function () {
                            errorNotice.remove();
                        });
                    }, 5000);
                }
            });
        }
    });

    // Banner height input formatting for responsive inputs
    $('.responsive-input').on('blur', function () {
        var value = $(this).val().replace(/[^0-9]/g, '');
        if (value && !isNaN(value)) {
            var numValue = parseInt(value);
            if (numValue < 200) numValue = 200;
            if (numValue > 800) numValue = 800;
            $(this).val(numValue + 'px');
        } else {
            var defaultValues = {
                'banner-height-mobile': '250px',
                'banner-height-tablet': '300px',
                'banner-height-desktop': '350px'
            };
            $(this).val(defaultValues[$(this).attr('id')] || '300px');
        }
    });
});