/**
 * AbuFramework Main JS File from AbuFramework
 * @since 1.0.0
 * @version 1.0.0
 *
 * AbuFramework - AbuFramework is Options Framework for WordPress themes and plugins.
 * @author    Abu Sufiyan <abusufiyan@muslim.com>
 * @link      http://abusufiyan.com/?ref=abuframework
 * @copyright 2020 Abu Sufiyan <abusufiyan@muslim.com>
 *
 */

;(function ( $, window, document ) {
  'use strict';
  var aAbu = 'a', bBu = 'b',
  ABUFRAMEWORK = ABUFRAMEWORK || {};

  ABUFRAMEWORK.fn = {}; 

  ABUFRAMEWORK.vars = {
    conformation: false,

  };

  // GLOBLE FUNCTIONS
  ABUFRAMEWORK.fn.Notice = function (text = '', type = 'success', dismissible = true, after = '.wrap' ) { 
    var l = '';
    l += '<div class="notice notice-' + type + ' settings-error is-dismissible">';
      l += '<p><strong>' + text + '</strong></p>';
      if( dismissible ) {
        l += '<button type="button" class="notice-dismiss">';
          l += '<span class="screen-reader-text">Dismiss this notice.</span>';
        l += '</button>';
      }
    l += '</div>';
    $(after).prepend(l);
    return true;
  }
  
  // adding a new Function
  $.fn.abuConformation = function () {
    return this.each(function(){
      var t = $(this);
      
      t.attr('data-conformed', false );
      t.on('click', function (e) {
        e.preventDefault();
        var l = $(this), 
            conf_text = l.data('conformation') || 'Are you conform',
            conf_ans  = confirm(conf_text);
  
        l.attr('data-conformed', conf_ans );
        if ( conf_ans ) {
          ABUFRAMEWORK.vars.conformation = true;
        } else {
          ABUFRAMEWORK.vars.conformation = false;
        }
  
      });
    });
  };
  $.fn.hasAttr = function(o) {
    o = o.toString().toLowerCase();
    var output, attr = $(this).attr(o);
    if (typeof attr !== typeof undefined && attr !== false) {
      output = true;
    } else {
      output = false;
    }
    return output;
  };
  $.fn.getAttr = function(o = null) {
    return this.each(function(o = null) {
      o = o.toString().toLowerCase();
      var output, attr = $(this).attr(o);
      if (typeof attr !== typeof undefined && attr !== false) {
        output = attr;
      } else {
        output = false;
      }
      return output;
    });
  };
  $.fn.abuRemover = function ( remover = '', shower = '', w = 'show' ) {
    $(this).on('click', function () {
      var l = $(this);
      l.closest(remover).fadeOut().remove();
      if ( shower.length !== 0 ) {
        if( w === 'show' ) {
          $(shower).fadeIn();
        } else {
          $(shower).fadeOut();
        }
      }
    })
  };

  $.fn.abuAjaxSave = function (options) {
    return this.each(function () {
      var t   = $(this),
        form  = t.children('form'),
        save  = form.find('.abu-save-botton[type="submit"]'),
        reset = form.find('.abu-section-reset-btn'),
        chngs = form.find('.abu-section-reset-chngs'),
        resetAll = form.find('.abu-reset-botton'),
        buttons = save.add(reset).add(chngs).add(resetAll),
        abuAction = {},
        is_able = t.data('abu-ajax');
      ABUFRAMEWORK.vars.ajax = is_able;
      
      if (!is_able) return;

      save.on('click', function (e) {

        e.preventDefault();
        var l = $(this),
          ltxt = l.data('load-text'),
          spnr = l.prev('.abu-spinner'),
          cval = l.val();

        spnr.addClass('is-active');
        l.val(ltxt);
        buttons.prop('disabled', true);
        form.children('.abu-reset-section').val('');

        window.wp.ajax.post(t.attr('id'), {
          data: form.serializeJSON()
        })
        .done(function (r) {

          spnr.removeClass('is-active');
          l.val(cval);
          buttons.prop('disabled', false);

          t.closest('.abu-options-body').find('[abu-section-id] > a > .abu-section-nav-error').fadeOut('fast').text(0);
          t.closest('.abu-options-body').find('.abu-single-section .abu-field-error').fadeOut('fast').text('');

          mdtoast(AbuFramework.i18n.saveSettings);

          var secs = [],
            counts = {};

          if (typeof r.errors == 'object') {
            $.each(r.errors, function (i, v) {
              if (v == 'success') return;
              var field = $('[abu-field-id="' + i + '"]'),
                secID = field.closest('.abu-single-section').attr('id');
              secID = secID.replace('abu-section-', '');
              field.find('.abu-field-error').fadeIn().empty().html(v);
              secs.push(secID);
              if (counts[secID] === undefined) {
                counts[secID] = 1;
              } else {
                counts[secID] = Number(counts[secID]) + 1;
              }

            });
          }


          if (Object.keys(counts).length > 0) {
            $.each(counts, function (i, s) {
              var l = $(this),
                parent = t.closest('.abu-options-framework').find('[abu-section-id="' + i + '"] > a > .abu-section-nav-error');
              parent.text(s).fadeIn('slow').css("display", "inline-block");
            });
          }

        })
        .fail(function (response) {
          spnr.removeClass('is-active');
          l.val(cval);
          buttons.prop('disabled', false);
          mdtoast(response.text);
        })

      });

      if (form.children('.abu-options-body').hasClass('single-section')) {
        var section = form.find('.abu-all-sections > .abu-single-section').attr('id');
        if (section == undefined) return;
        section = section.replace('abu-section-', '');
        buttons.prop('disabled', true);
        $.sendAjaxTab({ action: t.attr('id') + '_fields', data: { section_id: section } }, {
          'content_target': '#abu-section-' + section + ' > .abu-elements',
          'section': section
        }, () => buttons.prop('disabled', false) );
      }

      reset.on('click', function (e) {
        e.preventDefault();
        var l = $(this),
          target = l.closest('.abu-single-section').children('.abu-elements'),
          id = l.data('section-id');
        
        if (target.hasClass( 'no-elements' )) {
          l.prop('disabled', true);
          return;
        }

        buttons.prop('disabled', true);
        target.removeClass('ajax-completed');
        form.children('.abu-reset-section').val(id);

        $.post(AbuFramework.ajaxurl, {
          action: t.attr('id') + '_reset_section',
          data: form.serializeJSON()
        }, function (r, s) {
          $.sendAjaxTab({ action: t.attr('id') + '_fields', data: { section_id: id } }, {
            'content_target': '#abu-section-' + id + ' > .abu-elements',
            'section': id
          }, () => buttons.prop('disabled', false) );
        });

      })

      chngs.on('click', function(e){
        e.preventDefault();
        var l = $(this),
          target = l.closest('.abu-single-section').children('.abu-elements'),
          id = l.data('section-id');

        if (id == undefined) return;
        buttons.prop('disabled', true);
        target.removeClass('ajax-completed');

        $.sendAjaxTab({ action: t.attr('id') + '_fields', data: { section_id: id } }, {
          'content_target': '#abu-section-' + id + ' > .abu-elements',
          'section': id
        }, () => buttons.prop('disabled', false) );

      });

    });
  };

  $.sendAjaxTab = function (d, f, callback = function(){}) {
      
    if ( ! ABUFRAMEWORK.vars.ajax ) return;

    if( ! $( f.content_target ).hasClass('ajax-completed') ) {

      var secInput = $('#abu-section-' + f.section).closest('.abu-options-body').siblings('input[class="abu-ajax-sections"]'),
          secInputVal =  JSON.parse(secInput.val());
      
      if ( $.inArray( f.section, secInputVal ) === -1 ) {
        secInputVal.push( f.section );
        secInput.val(JSON.stringify(secInputVal) );
      }
      
      $.ajax({
        type : "post",
        dataType : "html",
        url: AbuFramework.ajaxurl,
        data : d,
        beforeSend: function(){
          $(f.content_target).empty().html('<div class="abu-section-load-wapper"><div class="abu-section-loading"><div></div><div></div></div></div>');
        },
        success: function( response, status ) {
          if( status == "success" ) {
            var t = 0;
            $(f.content_target)
            .addClass( 'ajax-completed' )
            .hide().empty().html( response ).show()
            .children('.abu-element').hide().each(function(){
              $(this).slideDown(t);
              t += 100;
            })
            .parent().abuFrameworkInit();                
          } else {
            mdtoast( status + ' : ' + response );
            mdtoast( AbuFramework.i18n.error );
          } 
        },
        error: function (xhr, status, error) {
          $(f.content_target).empty().html(xhr);
          console.log(status + ' : ' + error);
          mdtoast(error);
          mdtoast(AbuFramework.i18n.error);
        },
        complete: function () {
          return callback( d, f );
        }
      });

    }

  };

  // Abu Framework Tab & Section
  $.fn.abuFrameworkTabSecionToggles = function() {
    return this.each(function() {

      // declared global variables
      var abuSectionNav, abuTablinks, subMenuToggle,
          framework_id = $(this).closest('.abu-options-framework').attr('id');

      if ( pagenow ) {
        var toplevel = $('#' + pagenow  );      
        if( toplevel.length ) {
          toplevel.children( 'ul.wp-submenu-wrap' ).children('li').each( function (i,el) {
            var l = $(this), ind, src,
                c = l.children('a');
            var str = c.attr('href');
            if ($.type(str) == 'string') {
              src = '#section=';
              ind = str.slice( str.indexOf(src) + src.length) ;
              l.attr('abu-depend-controller' , ind );
            }
          });
        }
      }


      function abuHashFunction( Selector ) {
        if (Selector.length > 0 && Selector.indexOf( '#section=' ) > -1 ) {

          Selector = Selector.replace('#section=', '');
          Selector = $("[abu-section-id=" + Selector + "]" );
          
          if( Selector.length <= 0 ) return;

          $('.abu-section-nav').find('li').removeClass('opened');
          Selector.addClass('opened');
          Selector.children('a').trigger('click');

          return true;
        }
        return false;
      }

      $(window).on('hashchange', function(event) {
        abuHashFunction( window.location.hash );
      }).trigger('hashchange');

      abuSectionNav = $('.abu-section-nav li').hasClass('opened');
      // auto targeted to actived
      function autoTargetedSection(){
        var getOpenClasses = $('.abu-section-nav li.opened'),
            abuSectionAttr = getOpenClasses.attr(aAbu+bBu+'u-section-id');
            
        $('#abu-section-'+abuSectionAttr).show();
        getOpenClasses.children('a').trigger('click');
        if(getOpenClasses.hasClass('abu-tablinks')){
            getOpenClasses.addClass(' active').children('ul').slideDown(200, function() {
              if(getOpenClasses.hasClass('has-sub')){
                getOpenClasses.addClass('open');
              }
            });
        } else {
          getOpenClasses.parents('.has-sub').addClass('open child-activated').children('ul').slideDown('slow', function() {
              getOpenClasses.addClass('active').children('ul').slideDown('slow');
          });
        }
        
      }
      

      // displaying opend or closed sub-menus
      subMenuToggle = $('.abu-section-nav li.has-sub > a > span.abu-section-nav-toggle > i');
      subMenuToggle.on('click', function(event){

        // stoping extra events
        event.preventDefault();
        event.stopPropagation();

        // reclared local variables
        var athis = $(this), parent, parentNext, parentList;
        parent = athis.closest('a');

        // setting up element
        parentNext = parent.next();
        parentList = parent.parent('li.abu-tablinks');
      
        // Opening sub-menus
        if( parentList.hasClass('has-sub') ) {

          if (parentList.hasClass('open')) {
            
            parentList.removeClass('open');
            parentList.children('li').removeClass('open');
            parentList.children('ul').slideUp(200);

          } else {

            parentList.addClass('open');
            parentList.children('ul').slideDown(200);
            
          }
          
          // hiding anothers sub-menus. If nultiples is on
          if ( ! window[framework_id + '_var']['show_multi'] ) {
            parentList = parentList.siblings('li').not('.child-activated, .active');
            parentList.children('ul.sub-menus').slideUp(200);
            parentList.removeClass('open');
            parentList.find('li').removeClass('open');
            parentList.find('ul').slideUp(200);
          }

        }

      });

      // click to nav and so its section
      abuTablinks = $('.abu-section-nav .abu-tablinks', document);
      abuTablinks.find('a').on( 'click', function() {

         // reclared local variables
         var $this = $(this), abu, has='has-s', sub ='ub', hasSub = has+sub,
         abuSingleSection  = $('.abu-all-sections .abu-single-section'),
         parent = $this.parent('li'),
         navSection = $this.parents('.abu-section-nav'),
         is_empty = parent.data('is-empty'),
         is_parent = parent.hasClass('abu-tablinks'),
         has_sub = parent.hasClass('has-sub'),
         abuSectionAttr = parent.attr(aAbu+bBu+'u-section-id');
         

         // returning false, if, section already actived
         if( $this.parent('.abu-tablinks').hasClass('active') ){
           return false;
         }

         // removing all class (.active)
         navSection.find('.active, .child-activated').removeClass('active').removeClass('child-activated');

         // opening sub-menu. If, has
         if( parent.hasClass('has-sub') ){
           parent.addClass(' open');
           parent.children('ul').slideDown(200);
         }

         // activating parents class (.active)
         parent.parents('.hads-sub').each(function(index) { // TMC
           if($(this).hasClass('has-sub')){
             if(!$(this).hasClass('active')){
               $(this).addClass(' active');
             }
             $(this).siblings().each(function(index) {
               if ( $(this).hasClass('active') ) {
                 $(this).removeClass('active');
               }
             });
           }
         });

         // hiding unwanted sections
         abuSingleSection.each(function(index) {
            $(this).hide();
         });

         if( ! is_parent ) {
           $this.closest('.abu-tablinks').addClass('child-activated');
         }

         // displaying targeted section
         parent.addClass(' active');
         if( is_empty ) {
           if( has_sub && is_empty ) {
             if( ! parent.hasClass('active') ) {
               parent.children('a').children('span.abu-section-nav-toggle').children('i').trigger('click');
             }
             parent.find('[abu-section]').first().children('a').trigger('click');
           } else {
             $('#abu-section-'+abuSectionAttr).show();
           }
         } else {
           $('#abu-section-'+abuSectionAttr).show();
         };
        
        // hiding anothers sub-menus. If nultiples is on
        if (!window[framework_id + '_var']['show_multi']) {
          parent = parent.siblings('li').not('.child-activated, .active');
          parent.children('ul.sub-menus').slideUp(200);
          parent.removeClass('open');
          parent.find('li').removeClass('open');
          parent.find('ul').slideUp(200);
        }

        if ( parent.data('fields') > 0 ) {
          $.sendAjaxTab({
            action: framework_id + '_fields',
            data: {  section_id: abuSectionAttr, }
          }, {
            'content_target': '#abu-section-' + abuSectionAttr + ' > .abu-elements',
            'section': abuSectionAttr
          });
        }

      });
      // End of click to nave and so its section

      if (abuSectionNav) {
        autoTargetedSection();
      } else {
        $('.abu-section-nav li').first().addClass('opened').delay(1000);
        autoTargetedSection();
      }

    });
  };


  $.fn.abuInputsVal = function(){
    return this.each(function(o) {
      var g = $(this),
          s = $.extend({
            p : 'numbers'
          },o);
      g.on("keypress", function(e) {
        if( s.p == 'numbers' ) {
          if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
              return false;
          }
        } else if ( s.p == 'alpha' ) {
          if ( ! e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) ) {
              return false;
          }
        }
      });
    })
  };

  // Dependency;\
  $.fn.abuDependency = function(){
    return this.each(function( options ) {
      
      // declared function's global variables
      var abuTotalDepence, settings, abuText,
      gthis = $(this),
      opt_vals = gthis.closest('.abu-options-framework').attr('id'),
      abuDepenceControllers = $(this).find('[abu-depend-controller]');      
            

      // Default options
      settings = $.extend({
          selector : 'attr'
      }, options );

      // Started Working on every abuDependency
      abuDepenceControllers.each(function(index) {

        // declared functions local variables
        var lthis = $(this), abuController, abuCondition, abuValue, abuBoolean,
        abuTotal = 0, ba = 'ab', ab = 'u', abudont = 'Don\'t', abuDependency,
        abuLog = function(v1, v2 = ' does not exits') {
          console.log('%c'+v1+'%c'+v2, 'color:red','color:black');
        }, abuRemove = ' remove &copy;';

        // Getting controllers
        abuController = lthis.attr('abu-depend-controller');
        abuCondition = lthis.attr('abu-depend-condition');
        abuValue = lthis.attr('abu-depend-value');
        var uab = ba+ab;

        // Hiding/showing Every Element
        if( lthis.hasClass('div.'+ba+ab+'-element') ){
          lthis.slideUp('fast', function() {
            $(this).addClass('abu-closed').removeClass('abu-opened');
          });
        } else {
          lthis.parents('div.'+ba+ab+'-element').slideUp('fast', function() {
            $(this).addClass('abu-closed').removeClass('abu-opened');
          });
        }

        // function for converting value into Boolean
        abuBoolean = function(abuValue) {
          if(abuValue != '' && abuValue.length <= 7 && typeof abuValue != 'boolaen'){
            switch(abuValue.toLowerCase()) {
              case true:
              case 'true':
              case 1:
              case '1':
              case 'on':
              case 'yes':
              case 'enable':
              case 'enabled':
                abuValue = true;
              break;
              case false:
              case 'false':
              case 0:
              case '0':
              case 'off':
              case 'no':
              case 'disable':
              case 'disabled':
                abuValue = false;
              break;
            }
          }
          return abuValue;
        }

        // verifying to is it more then on controller
        if( lthis.attr('abu-depend-controller').indexOf("|") > -1 || true ) {


          // Abu Dependency Main Functions
          abuDependency = function(s = null, h = null) {

            // declared function local variables
            var allControllers = $.makeArray( s.attr('abu-depend-controller').split('|') ),
            abuCon = s.attr('abu-depend-condition'),
            abuVal = s.attr('abu-depend-value'),
            addable = s.hasClass('parent-section');

            // creating a array for storing every depends finale value
            var finalOutput;
            finalOutput = [];
            finalOutput.length = 0;

            // looping throw every Dependency
            $.each(allControllers, function(index, value) {

              var optVal = false, 
                  dependID = '[abu-depend-id="'+value+'"]';

              
              // return false for this. If, it does not have any value
              if ( !$(dependID).length ) {
                
                var opt_vals = s.closest('.abu-options-framework').attr('id');
                opt_vals = window[opt_vals];
                
                if( opt_vals[value] == undefined ) {
                  abuLog(dependID);
                  return true;
                } 

                optVal = true;
                value = opt_vals[value];
                
              }

              // spliting value of conditions and data
              var abuConsplted = abuCon.split('|'),
              abuValsplted = abuVal.split('|');

              // Getting current value of selectors
              var abuCaVal = function( selector ) {

                // declared function local variables
                var output, abuDataAttrVal, output, abuToboolean,
                s = $(selector),
                stype = s.attr('type'),
                tagName = s.prop("tagName").toLowerCase();

                // input="text" and textarea values
                if( stype == 'text' ||  tagName == 'textarea' ) {

                  // getting values
                  abuDataAttrVal = s.val();

                  // verifying Numeric
                  if($.isNumeric(abuDataAttrVal)) {
                    output = Number(abuDataAttrVal);
                  } else if (typeof abuDataAttrVal == 'string') {
                    output = abuDataAttrVal.toString();
                  }

                // getting value of radio buttons
                } else if ( stype == 'radio' ) {
                  var selected = $(selector+":checked");
                  if(selected.is(':checked')){
                    output = selected.val();
                  } else {
                    output = '';
                  }

                // getting value of checkboxs
                } else if ( stype == 'checkbox' ) {

                  // Getting values of Toggle buttons
                  if( s.attr('abu-type') == 'toggle' ){
                    var abuChechked = $(selector).is(':checked');
                    if( abuChechked && abuChechked != undefined ) {
                      output = true;
                    } else {
                      output = false;
                    }

                  // getting value of all chechbox
                  // and joining it by comma ','
                  } else {

                    var abuSelected, abuChkdbxArray = [];
                    abuChkdbxArray.length = 0;

                	  // look for all checkboes that have a parent and
                    // check if it was checked
                  	s.parents('.abu-field-wrap').find("input:checked").each(function() {
                  		abuChkdbxArray.push($(this).val());
                  	});

                  	// joining the array separated by the comma
                  	abuSelected = abuChkdbxArray ;

                  	// return values
                  	if(abuChkdbxArray.length > 0){
                  		output = abuSelected;
                  	} else {
                  		output = [];
                  	}

                  }

                } else if ( stype == 'hidden' ) {
                  if ( s.closest('.abu-element').hasClass('abu-field-icon-picker') ) {
                    output = s.val().length > 0 ? true : false ;
                  } 
                  output = s.val();
                } else if ( tagName == 'select' ) {
                  output = s.val();
                } else {
                  output = s.val();
                }
                              
                
                // returning finale values/result
                return output;

              }

              // Values comparing
              var abuFinale = function(a, b, c, el = '') {

                // declared function local variables
                var abuGetTrue, output, abuConpare = [];
                abuConpare.length = 0;


                // verifying it for is not boolaen
                if( typeof a != 'boolean' ) {
                  if (typeof a == 'undefined' || !a || a.length == 0 ) {
                    return false;
                  }
                }

                // converting value to lowecase
                if ( typeof a != 'boolean' && a.length == 0 && !$.isNumeric(abuCur) ){
                  a = a.toLowerCase();
                }

                b = b.toLowerCase();

                if ( typeof c != 'boolean' && c.length == 0 && !$.isNumeric(abuCur) ){
                  c = c.toLowerCase();
                }

                // returning finale value after comparing
                abuGetTrue = function(abuCur, abuCon, abuto){

                  // verifying values
                  if( abuCon == "==" || abuCon == "=" ) {
                    return abuCur == abuto;
                  } else if (abuCon == '!=' || abuCon == '!') {
                    return abuCur != abuto;
                  } else if (abuCon == 'any' ) {
                    return $.inArray(abuCur, abuto.split(',')) > -1;
                  } else if ( abuCon == 'not-any')  {
                    return  $.inArray(abuCur, abuto.split(',')) > -1;
                  } else if(abuCon == ">=") {
                    return Number(abuCur) >= Number(abuto);
                  } else if(abuCon == "<=") {
                    return Number(abuCur) <= Number(abuto);
                  } else if(abuCon == ">") {
                    return Number(abuCur) > Number(abuto);
                  } else if(abuCon == "<") {
                    return Number(abuCur) < Number(abuto);
                  } else if(abuCon == 'must') {
                    
                    return !( abuto.indexOf(abuCur) > -1 ) ? true : false ;
                  } else if(abuCon == 'not-must') {
                    return  aboto.indexOf(abuCur) > -1  ? true : false ;
                  } else if(abuCon == 'icon') {
                     var p;
                     switch (abuto.toLowerCase()) {
                       case 'added':
                       case 'yes'  :
                       case 'true' :
                       case 'add'  :
                       case true   :
                         p = true;
                         break;
                       default:
                         p = false;
                     }
                     
                    if (Boolean(abuCur) == p ) {
                       return true;
                     } else {
                       return false;
                     }

                  } else {
                    var getAttr = function(s = null, attr = 'id'){
                      var o;
                      if(s.attr(attr)){
                        o = s.attr(attr);
                      }
                      return attr+' : '+o;
                    },
                    msg = '\nTagName : '+s.prop('tagName')+',\n'+getAttr(s, 'id')+',\n'+getAttr(s, 'class'),
                    msg2 = s.attr('abu-depend-controller');
                    abuLog(abuCon,' is unknown condition.');
                    alert(value+' '+msg);
                    return false;
                  }

                }

                // verifying it to checkboxs
                if ( $.isArray( value ) ) {

                  // reclared variables
                  var abuChechkboxes;

                  // cheching value is not empty
                  if( a != '' && ! $.isArray(a) && typeof a != 'object' ) {
                    abuChechkboxes = a.split(',');
                  }

                  if( $.isArray(a) && typeof a == 'object' ) {
                    abuChechkboxes = a;
                  }

                  //looping throw every chechboxs
                  $.each(abuChechkboxes, function(i, v) {
                    abuConpare.push( abuGetTrue( v, b, c ) );
                  });

                  if( b == 'must' || b == 'not-must' ) {

                    
                    // declared variables
                    var abuMorVal = c.split(','),
                    abuMorValAr = [];
                    abuMorValAr.length = 0;
                    

                    $.each(abuMorVal, function(abuMoreIndex, abuMoreValue ) {
                      abuMorValAr.push( a.indexOf(abuMoreValue) > -1 );
                    });

                    if( b == 'must' ){
                      output = !($.inArray(false, abuMorValAr) > -1);
                    } else {
                      output = $.inArray(false, abuMorValAr) > -1;
                    }

                    //output = '';
                  } else if ( b == 'not-any' ) {
                    output = ! ($.inArray(true, abuConpare) > -1);
                  } else if (b == 'any') {
                    output = $.inArray(true, abuConpare) > -1;
                  } else {
                    output = abuGetTrue(a, b, c);
                  }

                } else {
                  output = abuGetTrue(a,b,c);
                }

                // verifying value
                if( output == '' || output.length == 0 || output == 'undefined' ) {
                  output = false;
                }

                
                // returning result into boolaen
                return output;

              };

              
              value = optVal ? value : abuCaVal(dependID);
              
              // adding boolaen to final arays
              finalOutput.push(abuFinale( value, abuConsplted[index], abuBoolean(abuValsplted[index]) ));              

            });
            

            // Showing/Hiding elements
            addable = addable ? $('.wp-submenu.wp-submenu-wrap').children('li[abu-depend-controller="' + s.attr('abu-section-id') + '"]') : $('nadaji');
            if( ! Boolean( $.inArray( false, finalOutput ) > -1 ) ) {
              s.add(addable).fadeIn('fast', function () {
                $(this).removeClass('abu-closed abu-depend-false').addClass('abu-opened').attr('abu-depend', 'true');
              });
            } else {
              s.add(addable).fadeOut('fast', function() {
                $(this).addClass('abu-closed abu-depend-false').removeClass('abu-opened').attr('abu-depend','false');
              });
            }

          }


          // Live Showing/Hiding Elements
          var abuEachBind = $.makeArray( abuController.split('|') );
          $.each(abuEachBind, function(i, v) {
            $('[abu-depend-id="' + v + '"]').on( 'input change click', function(){
              abuDependency(lthis, null);
            });
          });


          abuDependency(lthis, null);

        }

      });

    });
  };

  // Totally Search
  $.fn.abuTotallySearch = function(){
    return this.each(function( options ) {

      $('.abu-section-search-field').each( function() {
        var t = $(this), val,
        sec = t.closest('.abu-single-section'),
        els = sec.children('.abu-elements'),
        el = els.children('.abu-element');

        t.on({
          input (e) {
            e.preventDefault();
            el.off('click')
            val = t.val().toLowerCase();
            sec.addClass('abu-field-searching');
            if (val == '') {
              sec.removeClass('abu-field-searching');
              el.show();
              return;
            }
            el.hide().each(function () {
              var l = $(this),
                ltxt = l.text().toLowerCase();
              if (ltxt.indexOf(val) != -1) {
                l.show().removeClass('pulse animated');
                $(l).on('click', function (e) {
                  $(this).off(e);
                  el.off('click').show();
                  sec.removeClass('abu-field-searching');
                  t.val('');
                  window.scrollTo({
                    top: $(l).offset().top - 300,
                    behavior: 'smooth'
                  });
                  l.delay(1000).effect("highlight").addClass('pulse animated');
                });
              }
            });
          },
        })


      });

    });
  };

  $.fn.abuColorPickers = function(){
    return this.each(function() {
      var g = $(this);

      g.find('.abu-on-color-picker').each(function(i) {
        var lthis = $(this),
        abuaColorPicker = lthis.find('.abu-picker'),
        abucColorInput = abuaColorPicker.prev('div').find('input'),
        abuPickerPrewer = abuaColorPicker.prev('div').find('.abu-apicker-live-color'),
        options = abuaColorPicker.data('abu-color');

        var colorPicker = AColorPicker.createPicker( abuaColorPicker, options)
        .on('change', (picker, color) => {
          abucColorInput.val(color);
          abuPickerPrewer.css('background', color);
        });

        abucColorInput.on('change', function(){
          colorPicker.color = $(this).val();
        });

        $('body').on('click', function() {
          var lthis = $(this).find('.abu-color-opened');
          lthis.removeClass('abu-color-opened');
          lthis.nextAll('div').fadeOut('fast');
          lthis.parent().next().slideUp('fast');
        });

        lthis.find('.abu-apicker-live-color').on('click', function(e){
          var ll = $(this);
          e.preventDefault();
          e.stopPropagation();
          ll.closest('.abu-field-wrap').on('click', function(e){
            e.preventDefault();
            e.stopPropagation();
          })
          ll.toggleClass('abu-color-opened');
          ll.nextAll('div').fadeToggle('fast');
          ll.parent().next().slideToggle('fast');
        }).trigger('click');

        lthis.find('.abu-default').on('click', function(e){
          e.preventDefault();
          colorPicker.color = options.color;
        });

        lthis.find('.abu-transparent').on('click', function(e){
          e.preventDefault();
          colorPicker.color = 'rgba(0,0,0,0)';
        });

        abuPickerPrewer.css('background', colorPicker.color);

      });

      
      g.find('.abu-wp-color-picker')
      .wpColorPicker()      
      .closest('label')
      .next('input.wp-picker-clear')
      .removeClass('button-small')
      .css( 'margin-left', '6px' );


    });
  };

  // Image-select
  $.fn.AbuImagesSelects = function(){
    return this.each(function(index) {
      var abuSelectElement = $(this), is_abuMultipleSelect,
      abuSelectsWrap = abuSelectElement.children('.abu-field-wrap').find('ul.image-selects-images').first(),
      is_abuImgUnbordered = abuSelectsWrap.hasClass('unrounded'),
      abuSelectCustomSizeHeight = abuSelectsWrap.attr('abu-custom-height'),
      abuSelectCustomSizewidth = abuSelectsWrap.attr('abu-custom-width'),
      is_abuMultipleSelect = abuSelectsWrap.attr('abu-multiple'),
      abuTtlRchd = abuSelectsWrap.attr('abu-limit');


      // bordering to 0 percent
      if(is_abuImgUnbordered){
        abuSelectsWrap.find('label img').css('border-radius','0px');
        abuSelectsWrap.find('label').css('border-radius','0px');
        abuSelectsWrap.find('label:before').css('border-radius','0px');
      }

      // image custom sizing
      if ( abuSelectsWrap.hasAttr('abu-custom-height') ||  abuSelectsWrap.hasAttr('abu-custom-width') ) {
        // abuSelectsWrap.find('label img').css({ 'width' : abuSelectCustomSizewidth, 'height' : abuSelectCustomSizeHeight});
        abuSelectsWrap.find('li').css({ 'width' : abuSelectCustomSizewidth, 'height' : abuSelectCustomSizeHeight});
      }

      // image multiples select
      if(is_abuMultipleSelect == 'no'){
        var abuTotalselect = abuSelectsWrap.children('li');
        abuTotalselect.each(function(index) {
          $(this).on('click', function() {
            $(this).find('input').prop('checked', true);
            $(this).siblings('li').find('input').prop('checked', false);
          });
        });
      }

      // totally reached
      if( abuTtlRchd != 'infinity' || abuTtlRchd == 0 ) {

        var abuSelected, output,
        abuChkdbxArray = [],
        abuChkdCount = 0,
        abuInputID = abuSelectElement.find('input:checked');
        abuChkdbxArray.length = 0;

        // look for all checkboes that have a parent and
        // check if it was checked
        $(abuInputID).each(function() {
          abuChkdCount++;
          abuChkdbxArray.push($(this).val());
        });

        // joining the array separated by the comma
        abuSelected = abuChkdbxArray.join(',') ;

        // return values
        if(abuChkdbxArray.length > 0){
          output = abuSelected;
        } else {
          output = false;
        }

        // abuTtlRchd
        if(output){
          abuSelectsWrap.attr('abu-reached','{reached:"true",value:"'+output+'", count:'+abuChkdCount+'}')
        }

      }

      $( '.abu-select-image', this ).each(function() {
        var height = $(this).height() / 20;
        $(this).children('i').css( 'padding', height);
      });

    });
  };

  // abuIconPicker
  $.fn.abuIconPicker = function(){
    return this.each(function() {
      var gthis = $(this),
          sPicker = gthis.find('.abu-icon-picker').first(),
          iqpic = sPicker.data('iconoptions');
            
      sPicker.qlIconPicker(iqpic);

      $(".abu-remove-icon", gthis).appendTo(sPicker);

      $( '.abu-remove-icon', gthis ).on( 'click', function(e){
        e.preventDefault();
        gthis.find('.abu-ip-remove-btn').trigger('click');
      });
      
      if ($('.abu-ip-wrapper.dialog').hasClass('abu-bounced') ) return;
      $('.abu-ip-wrapper.dialog').addClass('abu-bounced');

      // searching icons
      $('.abu-ip-wrapper.dialog #abu-icons-search').on('input', function(){
        var sthis = $(this),
        sParent = sthis.parents('.icon-set'),
        sSingleIcon = sParent.find('[abu-type="abu-icon"]');
        if( sthis.val().length >= 0 && sthis.val() != '') {
          $.each(sSingleIcon, function(i, v) {
            var sSingleIcon = $(this).attr('data-code'),
            sSingleIcon = $(this).attr('data-class');
            if( sSingleIcon.indexOf( sthis.val() ) > -1 || sSingleIcon.indexOf( sthis.val() ) > -1 ) {
                $(this).show();
            } else {
                $(this).hide();
            }
          });
        } else {
          sSingleIcon.show();
        }
      });

      // display icons section
      $('.abu-ip-wrapper.dialog #abu-icon-display').on('change', function(){
        var abuVal = $(this).val(),
            abuAllWrp = $('.abu-ip-wrapper.dialog').find('.abu-icons-wrap');
        if(abuVal == 'abu-all') {
          abuAllWrp.children('.abu-icon-wrap').fadeIn('fast');
          return false;
        }
        
        abuAllWrp.children('.abu-icon-wrap').fadeOut('fast');
        abuAllWrp.children('#'+abuVal).fadeIn('fast');
      });

        // display sub icons section
      $('.abu-ip-wrapper.dialog #abu-subicon-display').on('change', function(){
        var abuVal = $(this).val(),
            abuAllWrp = $(this).parents('.abu-icon-wrap');
        if( abuVal == 'abu-subicon-all' ) {
          abuAllWrp.find('ul[class^="abu-subicon"]').fadeIn('fast');
          return false;
        }
        abuAllWrp.find('ul[class^="abu-subicon"]').fadeOut('fast');
        abuAllWrp.find('ul.'+abuVal).fadeIn('fast');
      });

    });
  };

  // abuSliders
  $.fn.abuSliders = function(){
    return this.each(function(i) {

      var gthis = $(this), abuV,
          abuA = '.abu-range-',
          abuSliderWrap = gthis.find('.abu-field-wrap'),
          abuMailer = abuSliderWrap.find('input.abu_val_mailer'),
          abuO = abuSliderWrap.find('.abu-slider'),
          abuMi = abuO.data('min') || 0,
          abuMa = abuO.data('max'),
          abuS = abuO.data('step') || 1,
          abuSliderObj = {
            range: "max",
            min: abuMi,
            max: abuMa,
            step: abuS,
            value: 500,
            slide: function(event, ui) {
              $(this).parent().next().find('input').val(ui.value).trigger('input');
            },
            animate: 400,
            classes: {
              "ui-slider": "ui-corner-all abu-simple-slider",
              "ui-slider-handle": "ui-corner-all simple-slider-handle abu-slider-handle",
              "ui-slider-range": "ui-corner-all ui-widget-header"
            }
          },
          abuSliderRange = {
            range: true,
            min: abuMi,
            max: abuMa,
            step: abuS,
            values: [200,400],
            slide: function(event, ui) {
              $(this).parents('.abu-range-slider-wrap').find('.abu-mailer-first').val(ui.values[0]).trigger('input');
              $(this).parents('.abu-range-slider-wrap').find('.abu-mailer-second').val(ui.values[1]).trigger('input');
            },
            classes: {
              "ui-slider": "ui-corner-all",
              "ui-slider-handle": "range-slider-handle",
              "ui-slider-range": "ui-corner-all ui-widget-header abu-range-highlight"
            }
          };

      if( abuO.parent('div').hasClass('abu-single-slider') ) {
        abuSliderObj.value = abuO.data('value');
        abuSliderWrap.find('.'+aAbu+bBu+'u-slider').slider( abuSliderObj );
        abuMailer.val(abuMailer.parent().prev().children('div').slider( "value" ));
        abuMailer.on('input', function(){
          $(this).parent().prev().children('div').slider("value", $(this).val());
        });
      }

      if( abuO.parent('div').hasClass('abu-range-slider') ) {

        // Setting Up Range slider Value
        abuV = abuO.data('values');
        abuSliderRange.values[0] = abuV['min'];
        abuSliderRange.values[1] = abuV['max'];
        abuSliderWrap.find('.'+aAbu+bBu+'u-slider').slider(abuSliderRange);

        abuSliderWrap.find('.abu-val-mailer').on('input', function() {
          var l = $(this);
          if( ! l.hasClass('abu-mailer-first') ) {
            var lv = l.val(),
                lcv = l.closest('.abu-range-slider-wrap').find('.abu-mailer-first').first();
              lcv.attr('max', lv);
              l.closest('.abu-range-slider-wrap').children('.abu-range-slider').children('.abu-slider').slider("values", 1, lv);
          } else {
            var lv = l.val(),
                lcv = l.closest('.abu-range-slider-wrap').find('.abu-mailer-second');
              lcv.attr('min', lv);
              l.closest('.abu-range-slider-wrap').children('.abu-range-slider').children('.abu-slider').slider("values", 0, lv);
          }
        });

      }

      $( 'input', gthis ).on( 'change', function(){
        var l = $(this),
            val = +l.val(),
            step = +l.attr('step'),
            min = +l.attr('min'),
            max = +l.attr('max');
        
        if (val < min) l.val( min + step ).trigger('input');
        if (val > max) l.val( max - step ).trigger('input');

      });

    });
  };

  $.fn.abuSorter = function(){
    return this.each(function() {
      var g = $(this);
      $('.abu-sorters-wrapper', g ).find('.sorter-list').sortable({
        connectWith: '.sorter-list',
        placeholder: 'ui-sorter-placeholder',
        start(event, ui) {
          ui.placeholder
          .width(ui.item.width())
          .height(ui.item.height());
        },
        update: function(event, ui) {
          var i = $(this).parents('.abu-sorters-wrapper').attr('abu-sorter-id'),
              n = $(this).attr('abu-name');
          $('input', this).each(function() {
            $(this).attr('name', i+'['+n+']'+'['+$(this).val()+']');
          });;
        }
      });
    });
  };

  $.fn.abuSortable = function(){
    return this.each(function() {      
      var gt = $(this),
          asw = gt.find('.abu-sortables-wrapper');
          asw.sortable({
            axis: 'y',
            placeholder: 'ui-sortable-placeholder',
            update: function(event, ui) {
              ui.item.css('cursor', '');
            },
            start: function(e, ui) {
              ui.item.css('cursor', 'move');
              $(this).find('.ui-sortable-placeholder').height( 50 );
            }
          });
    });
  };

  $.fn.abuDatepicker = function(){
    return this.each(function(i) {
      var g = $(this), abuS, abuFrom, abuTo,
          abuW = g.find('.abu-datepicker-wrapper'),
          abuI = abuW.find('input[abu-type="date-picker"]');
          abuS = $.extend({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            selectOtherMonths: true,
            beforeShow: function(input, inst) {
                $('#ui-datepicker-div').removeClass(function() {
                    return $('input').get(0).id;
                });
                $('#ui-datepicker-div').addClass(this.id+' abu-date-picker-wrap');
            },
            closeText: "Close",
            altField: abuW.find('.abu-show-date'),
            altFormat: "DD, d MM, yy"
          }, abuW.children('.abu-date-options').data('date-options') );

          if( g.hasClass('abu-field-range-date-picker') ) {
            abuFrom = $( "[abu-date='from']", abuW ).datepicker(abuS).on( "change", function() {
              abuTo.datepicker( "option", "minDate", $(this).datepicker( "getDate" ) );
            }),
            abuTo = $( "[abu-date='to']", abuW ).datepicker(abuS).on( "change", function() {
              abuFrom.datepicker( "option", "maxDate", $(this).datepicker( "getDate" ) );
            });
          } else {

            abuI.datepicker(abuS);
          }
    });
  };


  $.fn.abuImageSelect = function(options) {
    return this.each(function() {
          var g = $(this), abuC, chosenoptions,
             abuIsM = g.hasAttr('multiple'),
             abuImg  = {},
             abuIcon = {};

          if( typeof options != 'array' ) {
            options = [];
          }
          options = $.extend({
            'rtl': AbuFramework.vars.rtl,
            'allow_single_deselect': true,
            'no_results_text': ''
          }, options);

          // create a chosen first
          g.chosen(options);

          abuC = g.next('.chosen-container').addClass('image-icon-select');

          options.rtl = g.next('.image-icon-select').hasClass('chosen-rtl');

          // Retrieve img-src from data attribute.
          g.find('option').filter(function(){
              return $(this).text();
          }).each(function(i) {
              abuImg[i] = $(this).data('abu-img');
              abuIcon[i] = $(this).data('abu-icon');
          });

          // Creating a function to output css
          function abuImage(s) {
              return { 'background-image' : ( s ? 'url(' + s + ')' : 'none' ) };
          }

          function abubgImg(s) { // FMC
            return '';
          }

          // putting img in dropdown and multiple selections
          abuC.on('click.chosen keyup.chosen mousedown.chosen change.chosen selected.chosen', function(){
              var lis = function(v, c, t = 'span', padding = 5) {
                var lp = 'padding-' + ( !options.rtl ? 'right' : 'left' ) + ' : '+padding+'px;' ;
                return '<'+t+' class="'+c+'" style="'+lp+'">'+v+'</'+t+'>';
              };

              // this for Single selects
              $('.chosen-results li', abuC ).each(function() {
                  var l = $(this),
                  lt = l.text(),
                  lindex = l.attr('data-option-array-index'),
                  limg = abubgImg( abuImg[ lindex ]),
                  li = function(){
                    if(abuIcon[ lindex ] != undefined ){
                      return abuIcon[ lindex ] ;
                    } else {
                      return '';
                    }
                  };
                  l.text('');

                  // setting up backgroudn image
                  $(this).css(abuImage( abuImg[ lindex ] ) );

                  // Putting Div Element to list
                  if ( ! l.find('div').length ) {

                     var abuChosenResults = function(){
                       if( !l.parents('.image-icon-select').hasClass('chosen-rtl') ) {
                         return lis( '', 'abu-icon '+li(), 'i') + lis(lt, 'abu-value');
                       } else {
                         return lis(lt, 'abu-value') + lis( '', 'abu-icon ' + li(), 'i' );
                       }
                     };

                     $('<span/>', {
                          class: 'chosen-content ',
                          html: abuChosenResults()
                     }).appendTo(this);
                  }

                  if( l.css('background-image') == 'none' ) {
                    $(this).css({'padding-left':'5px', 'padding-right':'5px'});
                  }

               });

              // this for multiple selects
              if( abuIsM ) {
                $('.chosen-choices li', abuC).each(function(index) {
                  var abuMe = $(this),
                      abuI = abuMe.children('a').attr('data-option-array-index');

                    // image display
                    abuMe.children('span').css( abuImage(abuImg[abuI]) );
                    if( abuMe.children('span').css('background-image') == 'none' ) {
                      abuMe.children('span').css('padding', '0px');
                    }

                    // icon display
                    if ( ! abuMe.find('.abu-icon').length ) {
                      if( abuIcon[abuI] != '' || abuIcon[abuI] == undefined )
                      if( ! abuMe.parents('.image-icon-select').hasClass('chosen-rtl') ) {
                        abuMe.children('span').prepend( lis('', 'abu-icon '+abuIcon[abuI], 'i') );
                      } else {
                        abuMe.children('span').append( lis('', 'abu-icon '+abuIcon[abuI], 'i') );
                      }
                    }

                });
              }

          }).trigger('click');


          // Put on Selected options for single select
          g.on('change', function() {
            var lim = $('option:selected', g).data('abu-img') || '',
                lt = $('.chosen-single > span', abuC),
                li = function( rtl = false ){
                  var lic = $('option:selected', g).data('abu-icon') || '',
                  lp = 'padding-' + ( !rtl ? 'right' : 'left' ) + ' : 5px;' ;
                  if( lic ){
                    return $('<i/>', {
                         class : 'abu-select-icon '+lic,
                         attr : { 'style' : lp }
                    });
                  } else {
                    return '';
                  }
                };

            // adding background image
            lt.css( abuImage(lim) );
            if( lt.css('background-image') == 'none' ) {
              lt.css('padding', '0px');
            } else {
              if( options.rtl ) {
                lt.css('padding-right', '26px');
              } else {
                lt.css('padding-left', '26px');
              }
            }

            // for Single select
            if( li() != '' && ! lt.find('.abu-select-icon').length ) {
              if( options.rtl ) {
                return lt.append( li( true ) ) ;
              } else {
                return lt.prepend( li( false ) );
              }
            }

          }).trigger('change');

          
          
          if ( g.hasClass('abu-chosen-sortable') ) {
            $('.chosen-choices', abuC).sortable({
              'placeholder': 'search-choice ui-state-highlight',
              'items': 'li:not(.search-field)',
              start(event, ui) {
                ui.placeholder
                .width( ui.item.width() )
                .height( ui.item.height() );
              }
            })
            .on('mousedown', function (event) {
              if ($(event.target).is('span')) {
                event.stopPropagation();
              }
            });
          }

          // $('.abu-title-wrap').on('click', function(){
          //   g.next('.chosen-container').addClass('chosen-container-active chosen-with-drop');
          // });

      });
  };
  $.fn.abuSelect = function(){
    return this.each(function(i) {
      var g = $(this),
          selectWrap = $('.abu-select-wrapper', g),
          abuChosen = $( '.abu-select-chosen', selectWrap ),
          abuW = $('.abu-field-wrap', g);

      if( abuChosen.length ) {
        abuChosen.abuImageSelect( abuChosen.data('abu-chosen') );
      }
      
      // $('.chosen-container', selectWrap).css({ 'width':'auto', 'min-width' : '200' });

    });
  };

  $.fn.abuGroupButton = function(){
    return this.each(function(i) {
      var g = $(this),
          abuW = $('.abu-field-wrap', g).first(),
          abuBW = $('.abu-buttongroup-wrapper', abuW);
          
          $('input', abuBW).checkboxradio({
            icon: false,
            classes: {
              "ui-checkboxradio-label": " ",
              "ui-checkboxradio-icon": " ",
              'ui-widget': ' '
            }
          });
          $('label', abuBW).on('click', function(){
            $(this).parents('label').trigger('click');
          })
          if( abuBW.hasAttr('data-abu-icon') ){
            if( abuBW.data('abu-icon') == 'show' ) {
              $('input', abuBW).removeClass('ui-helper-hidden-accessible');
            }
          }


    });
  };

  $.fn.abuImageUpload = function(options){
    return this.each(function() {
      var g = $(this), s,
          gfw = $( '.abu-field-wrap', g).first(),
          abuIsBG = gfw.parents('.abu-element').hasClass('abu-field-background');

      s = $.extend({
        inputs: '.abu-all-inputs',
        parents: '.abu-media-uploads',
        remover: '.abu-img-remover'
      }, options);

      $(s.parents).find(s.remover).on({
          click: function(e){
            e.preventDefault();
            var l = $(this);

            l.parent().fadeOut('fast');

            l.next('.abu-prev').remove();

            l.parents(s.parents)
              .find(s.inputs)
                .find('[abu-input-type]')
                  .each(function(i) {
                    $(this).val('')
                  });
          }
        })

    })
  };

  $.fn.abuSpinners = function(options){
    return this.each(function() {
      var abuG = $(this),
          abuW = abuG.find('.abu-field-wrap').first(),
          abuS = abuW.find(".abu-spinner-wrapper", abuW),
          abuI = $('.abu-spinner-input', abuS);
      abuS.length && abuW.length, abuI.spinner({
          max: abuI.data("max") || 100,
          min: abuI.data("min") || 0,
          step: abuI.data("step") || 1,
      }).abuInputsVal('numbers').on('change', function(){
          var l = $(this),
              x = l.data('max'),
              n = l.data('min'),
              v = Number(l.val());
          if( v >= x) l.val(x);
          if (v <= n) l.val(n);
      }).trigger('change');
    });
  };


  $.fn.abuAccordion = function () {
    return this.each(function () {
      var t = $(this),
        accordion = $('h4.abu-accordion-title', t);
      
      if ( t.find('.abu-accordions').hasClass('accordions-sortable') ) {
        $('.accordions-sortable', t).sortable({ 
          axis: "y",
          placeholder: 'abu-accordion abu-accordion-placeholder'
        });
      }

      accordion.on( 'click', function(e) {
        e.preventDefault(); 
         var l = $(this),
             i = l.data('icon'),
             p = l.closest('.abu-accordion');
         if( p.hasClass('accordion-opened') ) {
           if ( ! i ) {
             l.children('i.abu-accordion-icon').first().addClass('fa-angle-right').removeClass('fa-angle-down');
           }
           l.next('.abu-accordion-content').first().slideUp();
           p.removeClass('accordion-opened');
         } else {
           if (!i) {
             l.children('i.abu-accordion-icon').first().removeClass('fa-angle-right').addClass('fa-angle-down');
           }
           l.next('.abu-accordion-content').first().slideDown();
           p.addClass('accordion-opened');
         }
         
      });


      $('.abu-accordion.accordion-opened', t).last().find('.abu-accordion-content').slideDown( 'fast', function () {
        $('.abu-accordion.accordion-opened', t).removeClass('accordion-opened').find('i.abu-accordion-icon').addClass('fa-angle-right').removeClass('fa-angle-down');
        $(this).closest('.abu-accordion').find('i.abu-accordion-icon').addClass('accordion-opened').removeClass('fa-angle-right').addClass('fa-angle-down');
      });

    });
  };

  $.fn.abuTabs = function () {
    return this.each(function () {
      var t = $(this),
        tab = $('a.abu-tab-title', t);


      tab.on('click', function () {
        var l = $(this),
          i = l.data('icon'),
          p = l.attr('abu-tab-target'),
          c = l.closest('.abu-tab-titles').next('.abu-tab-contents');

        if ( ! l.hasClass('tab-active') ) {

          l.addClass('tab-active');
          l.siblings().removeClass('tab-active');

          if( ! i ) {
            l.siblings().find('i.abu-tab-icon').removeClass('fa-angle-down').addClass('fa-angle-right');
            l.find('i.abu-tab-icon').removeClass('fa-angle-right').addClass('fa-angle-down');
          }

          c.children('.abu-tab-content').removeClass('activ-content');
          c.children('#' + p).addClass('activ-content');

        }

      });

      $('a.abu-tab-title.abu-tab-opened', t).last().trigger('click');
      tab.siblings().removeClass('abu-tab-opened');

      if (!tab.hasClass('tab-active')) tab.first().trigger('click');

    });
  };

  ABUFRAMEWORK.fn.uploadinputs = function ( option = '', media = '', selector = '', is_single = true, button ) {

    if ( ! $.isArray(media) ) return false;

    $.each(media, function (i, ele) {

      var outputs = '',
          all_inputs = '<div class="abu-all-inputs">',
          prev = '<div class="abu-upload-previewer">';
            prev += '<a class="abu-previewer-helper abu-upload-remover"><i class="fa fa-times"></i></a>';
            prev += ( option.multiple === false ) ? '' : '<a class="abu-previewer-helper abu-upload-coper"><i class="fas fa-copy"></i></a>' ;
            prev += '<img src="' + ele.sizes.thumbnail.url + '" class="abu-prev" alt="' + ele.alt + '" title="' + ele.title + '">';
          prev += '</div>';

          all_inputs += '<input type="text"';
          all_inputs += ' name="' + option.name + ( option.multiple ? '[]' : '' ) + '"';
          all_inputs += " value='" + JSON.stringify(ele) + "'";
          all_inputs += '>'; 

      all_inputs += '</div>';

      outputs += prev + all_inputs;    

      if (selector.length !== 0) {
        if ( option.multiple === false ) selector.html('');
        $('<div/>', {
          class: 'abu-upload-input ui-sortable-handle',
          html: outputs
        }).appendTo(selector).find('a.abu-upload-remover').abuRemover('.abu-upload-input');
        return true;
      } else {
        return outputs;
      }

    });

    return true;

  };

  $.fn.abuUpload = function () {
    return this.each(function () {
      var t   = $(this),
          wpr = $('.abu-upload-wrapper', t),
          ubtn = $('.abu-upload-buttons', wpr),
          inputs = ubtn.prev('div.abu-upload-inputs'), 
          uplaod_button = ubtn.children('a.abu-upload-btn'),
          options = uplaod_button.data('uploaderoptions');
      
          
      wpr.on('click', 'a.abu-upload-remover', function () {
        var l = $(this),
          el = l.closest('.abu-upload-input');
        el.remove();
        $('.abu-upload-inputs', wpr).attr('data-abu-inputs', $('.abu-upload-inputs', wpr).children().size());
        return;
      });
      if (options.multiple === true) {
        inputs.sortable({
          placeholder: 'abu-upload-input ui-sortable-placeholder',
          update: function (event, ui) {
            ui.item.css('cursor', '');
          },
          start: function (e, ui) {
            ui.item.css('cursor', 'move');
          }
        });
        wpr.on('click', 'a.abu-upload-coper', function () {
          var l = $(this),
            el = l.closest('.abu-upload-input');
          el.after(el.clone());
          $('.abu-upload-inputs', wpr).attr('data-abu-inputs', $('.abu-upload-inputs', wpr).children().size());
          return;
        });
      }

      uplaod_button.on( 'click', function(e){
        e.preventDefault();
        var l  = $(this),
        uploaderoptions = l.data('uploaderoptions'),
        wpMedia = $.extend({}, uploaderoptions),
        abu_uploader = wp.media(options).open()
        .on('select', function () {
          var media = abu_uploader.state().get('selection').toJSON(),
            uploaded = ABUFRAMEWORK.fn.uploadinputs(uploaderoptions, media, inputs, uploaderoptions.multiple, l );
            $('.abu-upload-inputs', wpr).attr('data-abu-inputs', $('.abu-upload-inputs', wpr).children().size() );
            return true;
        });

      });
      
      $('.abu-removeall-btn', ubtn).on( 'click', function(){
        var inp = $('.abu-upload-inputs', wpr).attr('data-abu-inputs', 0).children();
        inp.fadeOut(400, () => inp.remove() );
      });

    });
  };

  $.fn.abubackup = function (options) {
    return this.each(function () {
      var t = $(this),
          // wp = window.wp,
          imporwrp = $( '.abu-backup-import', t ),
          uplaodfile = $('button.abu-backup-upload', imporwrp ),
          importer = $('button.abu-backup-importer', imporwrp);

      importer.prop( 'disabled', true );
      $('.abu-backup-importer', t).on( 'input change', function(){
        if( $(this).val() != '' ) {
          importer.prop('disabled', false);
        } 
      })

      importer.on( 'click', function(e) { 
        e.preventDefault();
        var l = $(this),
            confrmTitle = l.data('confirm-title'),
            confirmed = l.data('confirm-text');

        new duDialog(confrmTitle, confirmed, duDialog.OK_CANCEL, {
          okText: AbuFramework.i18n.ok,
          cancelText: AbuFramework.i18n.cancel,
          callbacks: {
            okClick: function(){
              var dlg = this,
                  wpr = $(this.dialog).children('.dlg-wrapper');
              wpr.html('<div class="abu-section-load-wapper"><div class="abu-section-loading"><div></div><div></div></div></div>');
              window.wp.ajax.post('abu_backup_importer', {
                'secret': l.data('secret'),
                'importer': l.closest('.abu-backup-import').find('textarea.abu-backup-importer').val(),
                'imporder_to': l.data('abu-options')
              }).done(() => window.location.reload(true))
              .fail(function (resp) {
                dlg.hide();
                alert(resp.error);
              })
            }
          }
        });      
        return true; 
      });

      return; 
      
    });
  };

  $.fn.abuCodeEditor = function () {
    return this.each(function () {

      var t = $(this),
        wpr = $('.abu-code-editor-wrapper',t),
          txta = wpr.children('textarea'),
          tdata = txta.data('editor'),
          editor = ( wp.codeEditor.defaultSettings ? _.clone(wp.codeEditor.defaultSettings) : {} );
          editor.codemirror = $.extend({}, editor.codemirror, tdata);

      console.log(editor);
      editor = wp.codeEditor.initialize(txta, editor);
      editor.codemirror.on('change',function( a, b ){
        txta.val(editor.codemirror.getValue()).trigger('change');
      });
      console.log(editor);
      
    });
  };

  $.fn.abuNestables = function (options) {
    return this.each(function () {
      var t = $(this),
          c = '.abu-field-nestable',
          is_nestable = t.hasClass(c),
          l = is_nestable ? t.find('.abu-nestable-wrapper').first() : t.find('.abu-nestables-wrapper').first(),
          nesable = l.children('.dd'),
          nesableList = function() {
            var allnest = nesable.nestable('asNestedSet');
            allnest = allnest.length;          
            l.attr( 'total-list', allnest )
          },
          dialog = $('.abu-model', t).dialog({
            autoOpen: false,
            show: { effect: "fadeIn", duration: 'fast'},
            hide: { effect: "fadeOut", duration: 'fast' },
            minWidth: 500,
            buttons: [
              {
                text: "Add New",
                class: "button button-primary",
                click: function () {

                  var t = $(this), final = true,
                    allNesables = nesable.nestable('asNestedSet'),
                    val = $('.abu_nesable_id', t).val(),
                    title = $('.abu_nesable_title', t).val(),
                    allval = $('input, select, textarea', t).serializeArray();
                    allval = JSON.stringify(allval);
                  
                  if (title == '' ) {
                    $('.abu_nesable_title', t).css('border-color', 'red');
                    final = false;
                  }
                  
                  $.each(allNesables, function (i, a) {
                    if (val == a.id || val == '') {
                      $('.abu_nesable_id', t).css('border-color', 'red');
                      final = false;
                    }
                  });

                  if( ! final ) return;
                  
                  t.trigger('abu-nestabled-added', allval);
                  $('input, select, textarea', t).each(function () {
                    switch (this.type) {
                      case 'password':
                      case 'text':
                      case 'textarea':
                      case 'file':
                      case 'select-one':
                      case 'select-multiple':
                      case 'date':
                      case 'number':
                      case 'tel':
                      case 'email':
                        $(this).val('');
                        break;
                      case 'checkbox':
                      case 'radio':
                        this.checked = false;
                        break;
                    }
                  });
                  $('.abu_nesable_title, .abu_nesable_id', t).removeAttr('style');
                  t.dialog("close");

                }
              },
              {
                text: "close",
                class: "button",
                click: function () {
                  $(this).dialog("close");
                }
              }
              
            ]
          });

        if( ! is_nestable ) {
          nesable.nestable({
            itemClass: 'dd-item dd3-item',
            handleClass: 'dd-handle dd3-handle',
            contentClass: 'dd3-content',
            contentNodeName: 'div',
            scroll: true,
            emptyClass: 'abu-hidden',
            itemRenderer: function (item_attrs, content, children, options, item) {

              var item_attrs_string = $.map(item_attrs, function (value, key) {
                return ' ' + key + '="' + value + '"';
              }).join(' ');

              var html = '<' + options.itemNodeName + item_attrs_string + ' nestable-name="[' + item.id + ']">';

                html += '<' + options.handleNodeName + ' class="' + options.handleClass + '">';
                html += '</' + options.handleNodeName + '>';

                html += '<' + options.contentNodeName + ' class="' + options.contentClass + '">';
                  html += '<span class="dd-nestabel-title">' + content + '</span>';
                  html += '<div class="dd3-control">';
                    html += '<span class="dashicons dashicons-trash abu-remove-nestable"></span>';
                    html +='<span class="abu-content-divider">|</span>';
                    html += '<span class="dashicons dashicons-arrow-down abu-edit-contents "></span>';
                  html += '</div>';
                html += '</' + options.contentNodeName + '>';

                html += children;

              html += '</' + options.itemNodeName + '>';

              return html;

            },
          })
          .on('change', function(){
            var serialize_value = JSON.stringify(nesable.nestable('serialize'));
            l.children('.abu-nestable-serialized').val(serialize_value);
            l.children('a.abu-add-nesables').attr('data-nesablesData', JSON.stringify(nesable.nestable('asNestedSet')));
          }).trigger('change');
        }

        l.on('input', '.abu-nestable-title', function() {
          var l = $(this),
              item = l.closest('.dd-item.dd3-item'),
              dd3 = item.children('.dd3-content'),
              val = $(this).val();
          item.data('title', val);
          dd3.children('.dd-nestabel-title').text(val);
          nesable.trigger('change');
        });

        l.on('click', '.abu-edit-contents', function () {
          var t = $(this);
          if ( t.hasClass('nestables-opened') ) {
            t.addClass('dashicons-arrow-down').removeClass('dashicons-arrow-up');
            // t.parent().next().fadeIn('fast');
            t.parents('.dd3-content').next().slideUp('fast');
            t.removeClass('nestables-opened');
          } else {
            t.addClass('dashicons-arrow-up').removeClass('dashicons-arrow-down');
            // t.parent().next().fadeOut('fast');
            t.parents('.dd3-content').next().slideDown('fast');
            t.addClass('nestables-opened');
          }

        });
        
        $(l).on('click change', '.abu-remove-nestable', function(e){
          e.preventDefault();
          var l = $(this),
            lid = l.closest('.dd3-item').data('id');
          if (confirm("Are you sure to Remove Nestabel?")) { 
            nesable.nestable('remove', lid).trigger('change');
            nesableList();
          }
        });
        $('.abu-removeall-nesables', l).on('click change', function (e) {
          e.preventDefault();
          if ( confirm("Are you sure to Remove All Nestabels?") ) {
            nesable.nestable('removeAll',function () {
              nesableList();
            }).trigger('change');
          } 
        });

        l.children('a.abu-add-nesables').on('click', function(e) {
          e.preventDefault();
          dialog.dialog("open");
        });

        dialog.on('abu-nestabled-added', function (a, b, c) {
          
          var t = $(this), dialogBtn, id, title,
            val = JSON.parse(b),
            nesablesID = [],
            allNesables = nesable.nestable('asNestedSet'),
            adom = t.prev('.abu-adable-item').children().get(0);

          $.each(allNesables, function (i, a) {
            nesablesID.push(a.id);
          });

          $.each(val, function (i, v) {
            if (v.name.startsWith('nesable_title_nestables')) {
              id = v.value;
              return;
            }
            if (v.name.startsWith('nesable_id_nestables')) {
              title = v.value;
              return;
            }
          });          

          nesable.nestable('add', { "id": id }, function (item) {

            var l = $(this),
              htm = item.closest('.abu-nestables-wrapper').children('.abu-adable-item').find('.dd-contents').first().clone(true),
              v = item.closest('.abu-nestables-wrapper').attr('abu-nestable-name'),
              dd3C = item.children('.dd3-content');

            item.attr('nestable-name', v + '[values]' + item.attr('nestable-name'));
            item.attr('data-title', title);
            // dd3C.html(dd3C.html().replace(id, title));
            htm.appendTo( item );
            item.find('[name="abu_nestable_quene"]').each(function () {
              var l = $(this),
              pid = l.closest('.dd3-item').attr('nestable-name');
              l.attr('name', pid + '[' + l.data('temid') + ']' );
            });
            nesableList();

          }).trigger('change');

        });
      

          
    });
  };

  $.fn.abuAnimate = function () {
    return this.each(function () {
      
      var t = $(this),
          clss = 'abu-animate-title',
          ctrl = $('.abu-animate-controls', t),
          hlpr = $('.abu-animate-helper', ctrl),
          spd  = $('.abu-animate-speed', ctrl),
          ttl  = $('.abu-animate-title', t);

      hlpr.add(spd).on( 'input change', function(){
        var l = $(this);
        $(ttl).removeClass().addClass(clss + ' animated ' + spd.val() + ' ' + hlpr.val() ).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
          $(this).removeClass().addClass(clss);
        });
      }).trigger('input');

    });
  };
  

  $.fn.abuFrameworkInit = function() {
    return this.each(function() {

      var l = $(this);
      $('[abu-add-element-class]', l).each(function () {
        $(this).closest('.abu-element').addClass($(this).attr('abu-add-element-class'));
        $(this).removeAttr('abu-add-element-class');
      }).delay(1000);
      
      
      $('.abu-field-nestable, .abu-field-nestables', l).abuNestables();
      $('.abu-field-accordion', l).abuAccordion();
      $('.abu-field-tabs', l).abuTabs();
      $('.abu-field-backup', l).abubackup();
      $('.abu-field-animate', l).abuAnimate();
      $('.abu-field-select', l).abuSelect();
      $('.abu-field-spinner', l).abuSpinners();
      $('.abu-field-sortable', l).abuSortable();
      $('.abu-field-sorter', l).abuSorter();
      $('.abu-field-button-group', l).abuGroupButton();
      $('.abu-field-date-picker, .abu-field-range-date-picker', l).abuDatepicker();
      $('.abu-field-image-select', l).AbuImagesSelects();
      $('.abu-field-icon', l).abuIconPicker(); 
      $('.abu-field-slider, .abu-field-range-slider', l).abuSliders();
      $('.abu-field-upload', l).abuUpload();
      $('.abu-field-code-editor', l).abuCodeEditor();
      l.abuColorPickers();
  
      $('.abu-section-nav',l).abuTabsOn();

      if( l.closest('.abu-options-framework').length > 0 ) {
        l.closest('.abu-options-framework').abuDependency(); 
      } else {
        l.abuDependency();
      }
      
      if (l.hasClass('abu-options-framework') ) {
        l.abuTotallySearch();
      } else {
        l.closest('.abu-options-framework').abuTotallySearch();
      }
  
      // normal functions
      $('.abu-field-number').abuInputsVal('numbers');
    });
  }

  $.fn.abuOption = function (options) {
    return this.each(function () {
      var t = $(this), sticky,
          navbar = $('.abu-options-head').first();
          
      if( !navbar.length ) return;

      sticky = navbar.offset().top;
      window.onscroll = function () {
        if ((window.pageYOffset + 30) >= sticky) {
          navbar.addClass("abu-sticky-head")
        } else {
          navbar.removeClass("abu-sticky-head");
        }
      };
    });
  };

  $.fn.abuTabsOn = function (options) {
    return this.each(function () {

      var t = $(this);

      t.find('a.nav-tab').on('click', function (e) {
        e.preventDefault();
        var l = $(this),
          target = l.attr('abu-tab');

        l.siblings('.nav-tab').removeClass('nav-tab-active');
        l.addClass('nav-tab-active');

        $('.tab-wrapper').children('.abu-tab-content').removeClass('abu-tab-active');
        $('.tab-wrapper').find('#' + target).addClass('abu-tab-active');

      });
      t.find('a.nav-tab.nav-tab-active').trigger('click');

    });
  };


  // $ Document Ready
  $(document).ready( function() {

    var $this = $(this);

    $this.abuFrameworkInit();
    $( '.abu-options-framework', $this )
      .abuOption()
      .abuAjaxSave()
      .abuFrameworkTabSecionToggles();
    

    $this.on('widget-added widget-updated', function(e, widget){
      $(widget).abuFrameworkInit();
    });



  });

})( jQuery, window, document );
