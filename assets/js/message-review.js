'use strict';jQuery(function($){$(document).on('click','a.hide-review-notice-soft',function(e){e.preventDefault();var $notice=$(this).closest('.ac-notice');$notice.find('.info').slideUp();$notice.find('.help').slideDown();$.post(ajaxurl,$notice.data('dismissible-callback'))})});