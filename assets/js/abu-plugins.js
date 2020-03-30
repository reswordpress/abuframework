
/* Chosen v1.8.7 | (c) 2011-2018 by Harvest | MIT License, https://github.com/harvesthq/chosen/blob/master/LICENSE.md */

(function () {
  var t, e, s, i, n = function (t, e) {
    return function () {
      return t.apply(e, arguments)
    }
  },
    r = function (t, e) {
      function s() {
        this.constructor = t
      }
      for (var i in e) o.call(e, i) && (t[i] = e[i]);
      return s.prototype = e.prototype, t.prototype = new s, t.__super__ = e.prototype, t
    },
    o = {}.hasOwnProperty;
  (i = function () {
    function t() {
      this.options_index = 0, this.parsed = []
    }
    return t.prototype.add_node = function (t) {
      return "OPTGROUP" === t.nodeName.toUpperCase() ? this.add_group(t) : this.add_option(t)
    }, t.prototype.add_group = function (t) {
      var e, s, i, n, r, o;
      for (e = this.parsed.length, this.parsed.push({
        array_index: e,
        group: !0,
        label: t.label,
        title: t.title ? t.title : void 0,
        children: 0,
        disabled: t.disabled,
        classes: t.className
      }), o = [], s = 0, i = (r = t.childNodes).length; s < i; s++) n = r[s], o.push(this.add_option(n, e, t.disabled));
      return o
    }, t.prototype.add_option = function (t, e, s) {
      if ("OPTION" === t.nodeName.toUpperCase()) return "" !== t.text ? (null != e && (this.parsed[e].children += 1), this.parsed.push({
        array_index: this.parsed.length,
        options_index: this.options_index,
        value: t.value,
        text: t.text,
        html: t.innerHTML,
        title: t.title ? t.title : void 0,
        selected: t.selected,
        disabled: !0 === s ? s : t.disabled,
        group_array_index: e,
        group_label: null != e ? this.parsed[e].label : null,
        classes: t.className,
        style: t.style.cssText
      })) : this.parsed.push({
        array_index: this.parsed.length,
        options_index: this.options_index,
        empty: !0
      }), this.options_index += 1
    }, t
  }()).select_to_array = function (t) {
    var e, s, n, r, o;
    for (r = new i, s = 0, n = (o = t.childNodes).length; s < n; s++) e = o[s], r.add_node(e);
    return r.parsed
  }, e = function () {
    function t(e, s) {
      this.form_field = e, this.options = null != s ? s : {}, this.label_click_handler = n(this.label_click_handler, this), t.browser_is_supported() && (this.is_multiple = this.form_field.multiple, this.set_default_text(), this.set_default_values(), this.setup(), this.set_up_html(), this.register_observers(), this.on_ready())
    }
    return t.prototype.set_default_values = function () {
      return this.click_test_action = function (t) {
        return function (e) {
          return t.test_active_click(e)
        }
      }(this), this.activate_action = function (t) {
        return function (e) {
          return t.activate_field(e)
        }
      }(this), this.active_field = !1, this.mouse_on_container = !1, this.results_showing = !1, this.result_highlighted = null, this.is_rtl = this.options.rtl || /\bchosen-rtl\b/.test(this.form_field.className), this.allow_single_deselect = null != this.options.allow_single_deselect && null != this.form_field.options[0] && "" === this.form_field.options[0].text && this.options.allow_single_deselect, this.disable_search_threshold = this.options.disable_search_threshold || 0, this.disable_search = this.options.disable_search || !1, this.enable_split_word_search = null == this.options.enable_split_word_search || this.options.enable_split_word_search, this.group_search = null == this.options.group_search || this.options.group_search, this.search_contains = this.options.search_contains || !1, this.single_backstroke_delete = null == this.options.single_backstroke_delete || this.options.single_backstroke_delete, this.max_selected_options = this.options.max_selected_options || Infinity, this.inherit_select_classes = this.options.inherit_select_classes || !1, this.display_selected_options = null == this.options.display_selected_options || this.options.display_selected_options, this.display_disabled_options = null == this.options.display_disabled_options || this.options.display_disabled_options, this.include_group_label_in_selected = this.options.include_group_label_in_selected || !1, this.max_shown_results = this.options.max_shown_results || Number.POSITIVE_INFINITY, this.case_sensitive_search = this.options.case_sensitive_search || !1, this.hide_results_on_select = null == this.options.hide_results_on_select || this.options.hide_results_on_select
    }, t.prototype.set_default_text = function () {
      return this.form_field.getAttribute("data-placeholder") ? this.default_text = this.form_field.getAttribute("data-placeholder") : this.is_multiple ? this.default_text = this.options.placeholder_text_multiple || this.options.placeholder_text || t.default_multiple_text : this.default_text = this.options.placeholder_text_single || this.options.placeholder_text || t.default_single_text, this.default_text = this.escape_html(this.default_text), this.results_none_found = this.form_field.getAttribute("data-no_results_text") || this.options.no_results_text || t.default_no_result_text
    }, t.prototype.choice_label = function (t) {
      return this.include_group_label_in_selected && null != t.group_label ? "<b class='group-name'>" + this.escape_html(t.group_label) + "</b>" + t.html : t.html
    }, t.prototype.mouse_enter = function () {
      return this.mouse_on_container = !0
    }, t.prototype.mouse_leave = function () {
      return this.mouse_on_container = !1
    }, t.prototype.input_focus = function (t) {
      if (this.is_multiple) {
        if (!this.active_field) return setTimeout(function (t) {
          return function () {
            return t.container_mousedown()
          }
        }(this), 50)
      } else if (!this.active_field) return this.activate_field()
    }, t.prototype.input_blur = function (t) {
      if (!this.mouse_on_container) return this.active_field = !1, setTimeout(function (t) {
        return function () {
          return t.blur_test()
        }
      }(this), 100)
    }, t.prototype.label_click_handler = function (t) {
      return this.is_multiple ? this.container_mousedown(t) : this.activate_field()
    }, t.prototype.results_option_build = function (t) {
      var e, s, i, n, r, o, h;
      for (e = "", h = 0, n = 0, r = (o = this.results_data).length; n < r && (s = o[n], i = "", "" !== (i = s.group ? this.result_add_group(s) : this.result_add_option(s)) && (h++, e += i), (null != t ? t.first : void 0) && (s.selected && this.is_multiple ? this.choice_build(s) : s.selected && !this.is_multiple && this.single_set_selected_text(this.choice_label(s))), !(h >= this.max_shown_results)); n++);
      return e
    }, t.prototype.result_add_option = function (t) {
      var e, s;
      return t.search_match && this.include_option_in_results(t) ? (e = [], t.disabled || t.selected && this.is_multiple || e.push("active-result"), !t.disabled || t.selected && this.is_multiple || e.push("disabled-result"), t.selected && e.push("result-selected"), null != t.group_array_index && e.push("group-option"), "" !== t.classes && e.push(t.classes), s = document.createElement("li"), s.className = e.join(" "), t.style && (s.style.cssText = t.style), s.setAttribute("data-option-array-index", t.array_index), s.innerHTML = t.highlighted_html || t.html, t.title && (s.title = t.title), this.outerHTML(s)) : ""
    }, t.prototype.result_add_group = function (t) {
      var e, s;
      return (t.search_match || t.group_match) && t.active_options > 0 ? ((e = []).push("group-result"), t.classes && e.push(t.classes), s = document.createElement("li"), s.className = e.join(" "), s.innerHTML = t.highlighted_html || this.escape_html(t.label), t.title && (s.title = t.title), this.outerHTML(s)) : ""
    }, t.prototype.results_update_field = function () {
      if (this.set_default_text(), this.is_multiple || this.results_reset_cleanup(), this.result_clear_highlight(), this.results_build(), this.results_showing) return this.winnow_results()
    }, t.prototype.reset_single_select_options = function () {
      var t, e, s, i, n;
      for (n = [], t = 0, e = (s = this.results_data).length; t < e; t++)(i = s[t]).selected ? n.push(i.selected = !1) : n.push(void 0);
      return n
    }, t.prototype.results_toggle = function () {
      return this.results_showing ? this.results_hide() : this.results_show()
    }, t.prototype.results_search = function (t) {
      return this.results_showing ? this.winnow_results() : this.results_show()
    }, t.prototype.winnow_results = function (t) {
      var e, s, i, n, r, o, h, l, c, _, a, u, d, p, f;
      for (this.no_results_clear(), _ = 0, e = (h = this.get_search_text()).replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&"), c = this.get_search_regex(e), i = 0, n = (l = this.results_data).length; i < n; i++)(r = l[i]).search_match = !1, a = null, u = null, r.highlighted_html = "", this.include_option_in_results(r) && (r.group && (r.group_match = !1, r.active_options = 0), null != r.group_array_index && this.results_data[r.group_array_index] && (0 === (a = this.results_data[r.group_array_index]).active_options && a.search_match && (_ += 1), a.active_options += 1), f = r.group ? r.label : r.text, r.group && !this.group_search || (u = this.search_string_match(f, c), r.search_match = null != u, r.search_match && !r.group && (_ += 1), r.search_match ? (h.length && (d = u.index, o = f.slice(0, d), s = f.slice(d, d + h.length), p = f.slice(d + h.length), r.highlighted_html = this.escape_html(o) + "<em>" + this.escape_html(s) + "</em>" + this.escape_html(p)), null != a && (a.group_match = !0)) : null != r.group_array_index && this.results_data[r.group_array_index].search_match && (r.search_match = !0)));
      return this.result_clear_highlight(), _ < 1 && h.length ? (this.update_results_content(""), this.no_results(h)) : (this.update_results_content(this.results_option_build()), (null != t ? t.skip_highlight : void 0) ? void 0 : this.winnow_results_set_highlight())
    }, t.prototype.get_search_regex = function (t) {
      var e, s;
      return s = this.search_contains ? t : "(^|\\s|\\b)" + t + "[^\\s]*", this.enable_split_word_search || this.search_contains || (s = "^" + s), e = this.case_sensitive_search ? "" : "i", new RegExp(s, e)
    }, t.prototype.search_string_match = function (t, e) {
      var s;
      return s = e.exec(t), !this.search_contains && (null != s ? s[1] : void 0) && (s.index += 1), s
    }, t.prototype.choices_count = function () {
      var t, e, s;
      if (null != this.selected_option_count) return this.selected_option_count;
      for (this.selected_option_count = 0, t = 0, e = (s = this.form_field.options).length; t < e; t++) s[t].selected && (this.selected_option_count += 1);
      return this.selected_option_count
    }, t.prototype.choices_click = function (t) {
      if (t.preventDefault(), this.activate_field(), !this.results_showing && !this.is_disabled) return this.results_show()
    }, t.prototype.keydown_checker = function (t) {
      var e, s;
      switch (s = null != (e = t.which) ? e : t.keyCode, this.search_field_scale(), 8 !== s && this.pending_backstroke && this.clear_backstroke(), s) {
        case 8:
          this.backstroke_length = this.get_search_field_value().length;
          break;
        case 9:
          this.results_showing && !this.is_multiple && this.result_select(t), this.mouse_on_container = !1;
          break;
        case 13:
        case 27:
          this.results_showing && t.preventDefault();
          break;
        case 32:
          this.disable_search && t.preventDefault();
          break;
        case 38:
          t.preventDefault(), this.keyup_arrow();
          break;
        case 40:
          t.preventDefault(), this.keydown_arrow()
      }
    }, t.prototype.keyup_checker = function (t) {
      var e, s;
      switch (s = null != (e = t.which) ? e : t.keyCode, this.search_field_scale(), s) {
        case 8:
          this.is_multiple && this.backstroke_length < 1 && this.choices_count() > 0 ? this.keydown_backstroke() : this.pending_backstroke || (this.result_clear_highlight(), this.results_search());
          break;
        case 13:
          t.preventDefault(), this.results_showing && this.result_select(t);
          break;
        case 27:
          this.results_showing && this.results_hide();
          break;
        case 9:
        case 16:
        case 17:
        case 18:
        case 38:
        case 40:
        case 91:
          break;
        default:
          this.results_search()
      }
    }, t.prototype.clipboard_event_checker = function (t) {
      if (!this.is_disabled) return setTimeout(function (t) {
        return function () {
          return t.results_search()
        }
      }(this), 50)
    }, t.prototype.container_width = function () {
      return null != this.options.width ? this.options.width : this.form_field.offsetWidth + "px"
    }, t.prototype.include_option_in_results = function (t) {
      return !(this.is_multiple && !this.display_selected_options && t.selected) && (!(!this.display_disabled_options && t.disabled) && !t.empty)
    }, t.prototype.search_results_touchstart = function (t) {
      return this.touch_started = !0, this.search_results_mouseover(t)
    }, t.prototype.search_results_touchmove = function (t) {
      return this.touch_started = !1, this.search_results_mouseout(t)
    }, t.prototype.search_results_touchend = function (t) {
      if (this.touch_started) return this.search_results_mouseup(t)
    }, t.prototype.outerHTML = function (t) {
      var e;
      return t.outerHTML ? t.outerHTML : ((e = document.createElement("div")).appendChild(t), e.innerHTML)
    }, t.prototype.get_single_html = function () {
      return '<a class="chosen-single chosen-default">\n  <span>' + this.default_text + '</span>\n  <div><b></b></div>\n</a>\n<div class="chosen-drop">\n  <div class="chosen-search">\n    <input class="chosen-search-input" type="text" autocomplete="off" />\n  </div>\n  <ul class="chosen-results"></ul>\n</div>'
    }, t.prototype.get_multi_html = function () {
      return '<ul class="chosen-choices">\n  <li class="search-field">\n    <input class="chosen-search-input" type="text" autocomplete="off" value="' + this.default_text + '" />\n  </li>\n</ul>\n<div class="chosen-drop">\n  <ul class="chosen-results"></ul>\n</div>'
    }, t.prototype.get_no_results_html = function (t) {
      return '<li class="no-results">\n  ' + this.results_none_found + " <span>" + this.escape_html(t) + "</span>\n</li>"
    }, t.browser_is_supported = function () {
      return "Microsoft Internet Explorer" === window.navigator.appName ? document.documentMode >= 8 : !(/iP(od|hone)/i.test(window.navigator.userAgent) || /IEMobile/i.test(window.navigator.userAgent) || /Windows Phone/i.test(window.navigator.userAgent) || /BlackBerry/i.test(window.navigator.userAgent) || /BB10/i.test(window.navigator.userAgent) || /Android.*Mobile/i.test(window.navigator.userAgent))
    }, t.default_multiple_text = "Select Some Options", t.default_single_text = "Select an Option", t.default_no_result_text = "No results match", t
  }(), (t = jQuery).fn.extend({
    chosen: function (i) {
      return e.browser_is_supported() ? this.each(function (e) {
        var n, r;
        r = (n = t(this)).data("chosen"), "destroy" !== i ? r instanceof s || n.data("chosen", new s(this, i)) : r instanceof s && r.destroy()
      }) : this
    }
  }), s = function (s) {
    function n() {
      return n.__super__.constructor.apply(this, arguments)
    }
    return r(n, e), n.prototype.setup = function () {
      return this.form_field_jq = t(this.form_field), this.current_selectedIndex = this.form_field.selectedIndex
    }, n.prototype.set_up_html = function () {
      var e, s;
      return (e = ["chosen-container"]).push("chosen-container-" + (this.is_multiple ? "multi" : "single")), this.inherit_select_classes && this.form_field.className && e.push(this.form_field.className), this.is_rtl && e.push("chosen-rtl"), s = {
        "class": e.join(" "),
        title: this.form_field.title
      }, this.form_field.id.length && (s.id = this.form_field.id.replace(/[^\w]/g, "_") + "_chosen"), this.container = t("<div />", s), this.container.width(this.container_width()), this.is_multiple ? this.container.html(this.get_multi_html()) : this.container.html(this.get_single_html()), this.form_field_jq.hide().after(this.container), this.dropdown = this.container.find("div.chosen-drop").first(), this.search_field = this.container.find("input").first(), this.search_results = this.container.find("ul.chosen-results").first(), this.search_field_scale(), this.search_no_results = this.container.find("li.no-results").first(), this.is_multiple ? (this.search_choices = this.container.find("ul.chosen-choices").first(), this.search_container = this.container.find("li.search-field").first()) : (this.search_container = this.container.find("div.chosen-search").first(), this.selected_item = this.container.find(".chosen-single").first()), this.results_build(), this.set_tab_index(), this.set_label_behavior()
    }, n.prototype.on_ready = function () {
      return this.form_field_jq.trigger("chosen:ready", {
        chosen: this
      })
    }, n.prototype.register_observers = function () {
      return this.container.on("touchstart.chosen", function (t) {
        return function (e) {
          t.container_mousedown(e)
        }
      }(this)), this.container.on("touchend.chosen", function (t) {
        return function (e) {
          t.container_mouseup(e)
        }
      }(this)), this.container.on("mousedown.chosen", function (t) {
        return function (e) {
          t.container_mousedown(e)
        }
      }(this)), this.container.on("mouseup.chosen", function (t) {
        return function (e) {
          t.container_mouseup(e)
        }
      }(this)), this.container.on("mouseenter.chosen", function (t) {
        return function (e) {
          t.mouse_enter(e)
        }
      }(this)), this.container.on("mouseleave.chosen", function (t) {
        return function (e) {
          t.mouse_leave(e)
        }
      }(this)), this.search_results.on("mouseup.chosen", function (t) {
        return function (e) {
          t.search_results_mouseup(e)
        }
      }(this)), this.search_results.on("mouseover.chosen", function (t) {
        return function (e) {
          t.search_results_mouseover(e)
        }
      }(this)), this.search_results.on("mouseout.chosen", function (t) {
        return function (e) {
          t.search_results_mouseout(e)
        }
      }(this)), this.search_results.on("mousewheel.chosen DOMMouseScroll.chosen", function (t) {
        return function (e) {
          t.search_results_mousewheel(e)
        }
      }(this)), this.search_results.on("touchstart.chosen", function (t) {
        return function (e) {
          t.search_results_touchstart(e)
        }
      }(this)), this.search_results.on("touchmove.chosen", function (t) {
        return function (e) {
          t.search_results_touchmove(e)
        }
      }(this)), this.search_results.on("touchend.chosen", function (t) {
        return function (e) {
          t.search_results_touchend(e)
        }
      }(this)), this.form_field_jq.on("chosen:updated.chosen", function (t) {
        return function (e) {
          t.results_update_field(e)
        }
      }(this)), this.form_field_jq.on("chosen:activate.chosen", function (t) {
        return function (e) {
          t.activate_field(e)
        }
      }(this)), this.form_field_jq.on("chosen:open.chosen", function (t) {
        return function (e) {
          t.container_mousedown(e)
        }
      }(this)), this.form_field_jq.on("chosen:close.chosen", function (t) {
        return function (e) {
          t.close_field(e)
        }
      }(this)), this.search_field.on("blur.chosen", function (t) {
        return function (e) {
          t.input_blur(e)
        }
      }(this)), this.search_field.on("keyup.chosen", function (t) {
        return function (e) {
          t.keyup_checker(e)
        }
      }(this)), this.search_field.on("keydown.chosen", function (t) {
        return function (e) {
          t.keydown_checker(e)
        }
      }(this)), this.search_field.on("focus.chosen", function (t) {
        return function (e) {
          t.input_focus(e)
        }
      }(this)), this.search_field.on("cut.chosen", function (t) {
        return function (e) {
          t.clipboard_event_checker(e)
        }
      }(this)), this.search_field.on("paste.chosen", function (t) {
        return function (e) {
          t.clipboard_event_checker(e)
        }
      }(this)), this.is_multiple ? this.search_choices.on("click.chosen", function (t) {
        return function (e) {
          t.choices_click(e)
        }
      }(this)) : this.container.on("click.chosen", function (t) {
        t.preventDefault()
      })
    }, n.prototype.destroy = function () {
      return t(this.container[0].ownerDocument).off("click.chosen", this.click_test_action), this.form_field_label.length > 0 && this.form_field_label.off("click.chosen"), this.search_field[0].tabIndex && (this.form_field_jq[0].tabIndex = this.search_field[0].tabIndex), this.container.remove(), this.form_field_jq.removeData("chosen"), this.form_field_jq.show()
    }, n.prototype.search_field_disabled = function () {
      return this.is_disabled = this.form_field.disabled || this.form_field_jq.parents("fieldset").is(":disabled"), this.container.toggleClass("chosen-disabled", this.is_disabled), this.search_field[0].disabled = this.is_disabled, this.is_multiple || this.selected_item.off("focus.chosen", this.activate_field), this.is_disabled ? this.close_field() : this.is_multiple ? void 0 : this.selected_item.on("focus.chosen", this.activate_field)
    }, n.prototype.container_mousedown = function (e) {
      var s;
      if (!this.is_disabled) return !e || "mousedown" !== (s = e.type) && "touchstart" !== s || this.results_showing || e.preventDefault(), null != e && t(e.target).hasClass("search-choice-close") ? void 0 : (this.active_field ? this.is_multiple || !e || t(e.target)[0] !== this.selected_item[0] && !t(e.target).parents("a.chosen-single").length || (e.preventDefault(), this.results_toggle()) : (this.is_multiple && this.search_field.val(""), t(this.container[0].ownerDocument).on("click.chosen", this.click_test_action), this.results_show()), this.activate_field())
    }, n.prototype.container_mouseup = function (t) {
      if ("ABBR" === t.target.nodeName && !this.is_disabled) return this.results_reset(t)
    }, n.prototype.search_results_mousewheel = function (t) {
      var e;
      if (t.originalEvent && (e = t.originalEvent.deltaY || -t.originalEvent.wheelDelta || t.originalEvent.detail), null != e) return t.preventDefault(), "DOMMouseScroll" === t.type && (e *= 40), this.search_results.scrollTop(e + this.search_results.scrollTop())
    }, n.prototype.blur_test = function (t) {
      if (!this.active_field && this.container.hasClass("chosen-container-active")) return this.close_field()
    }, n.prototype.close_field = function () {
      return t(this.container[0].ownerDocument).off("click.chosen", this.click_test_action), this.active_field = !1, this.results_hide(), this.container.removeClass("chosen-container-active"), this.clear_backstroke(), this.show_search_field_default(), this.search_field_scale(), this.search_field.blur()
    }, n.prototype.activate_field = function () {
      if (!this.is_disabled) return this.container.addClass("chosen-container-active"), this.active_field = !0, this.search_field.val(this.search_field.val()), this.search_field.focus()
    }, n.prototype.test_active_click = function (e) {
      var s;
      return (s = t(e.target).closest(".chosen-container")).length && this.container[0] === s[0] ? this.active_field = !0 : this.close_field()
    }, n.prototype.results_build = function () {
      return this.parsing = !0, this.selected_option_count = null, this.results_data = i.select_to_array(this.form_field), this.is_multiple ? this.search_choices.find("li.search-choice").remove() : (this.single_set_selected_text(), this.disable_search || this.form_field.options.length <= this.disable_search_threshold ? (this.search_field[0].readOnly = !0, this.container.addClass("chosen-container-single-nosearch")) : (this.search_field[0].readOnly = !1, this.container.removeClass("chosen-container-single-nosearch"))), this.update_results_content(this.results_option_build({
        first: !0
      })), this.search_field_disabled(), this.show_search_field_default(), this.search_field_scale(), this.parsing = !1
    }, n.prototype.result_do_highlight = function (t) {
      var e, s, i, n, r;
      if (t.length) {
        if (this.result_clear_highlight(), this.result_highlight = t, this.result_highlight.addClass("highlighted"), i = parseInt(this.search_results.css("maxHeight"), 10), r = this.search_results.scrollTop(), n = i + r, s = this.result_highlight.position().top + this.search_results.scrollTop(), (e = s + this.result_highlight.outerHeight()) >= n) return this.search_results.scrollTop(e - i > 0 ? e - i : 0);
        if (s < r) return this.search_results.scrollTop(s)
      }
    }, n.prototype.result_clear_highlight = function () {
      return this.result_highlight && this.result_highlight.removeClass("highlighted"), this.result_highlight = null
    }, n.prototype.results_show = function () {
      return this.is_multiple && this.max_selected_options <= this.choices_count() ? (this.form_field_jq.trigger("chosen:maxselected", {
        chosen: this
      }), !1) : (this.container.addClass("chosen-with-drop"), this.results_showing = !0, this.search_field.focus(), this.search_field.val(this.get_search_field_value()), this.winnow_results(), this.form_field_jq.trigger("chosen:showing_dropdown", {
        chosen: this
      }))
    }, n.prototype.update_results_content = function (t) {
      return this.search_results.html(t)
    }, n.prototype.results_hide = function () {
      return this.results_showing && (this.result_clear_highlight(), this.container.removeClass("chosen-with-drop"), this.form_field_jq.trigger("chosen:hiding_dropdown", {
        chosen: this
      })), this.results_showing = !1
    }, n.prototype.set_tab_index = function (t) {
      var e;
      if (this.form_field.tabIndex) return e = this.form_field.tabIndex, this.form_field.tabIndex = -1, this.search_field[0].tabIndex = e
    }, n.prototype.set_label_behavior = function () {
      if (this.form_field_label = this.form_field_jq.parents("label"), !this.form_field_label.length && this.form_field.id.length && (this.form_field_label = t("label[for='" + this.form_field.id + "']")), this.form_field_label.length > 0) return this.form_field_label.on("click.chosen", this.label_click_handler)
    }, n.prototype.show_search_field_default = function () {
      return this.is_multiple && this.choices_count() < 1 && !this.active_field ? (this.search_field.val(this.default_text), this.search_field.addClass("default")) : (this.search_field.val(""), this.search_field.removeClass("default"))
    }, n.prototype.search_results_mouseup = function (e) {
      var s;
      if ((s = t(e.target).hasClass("active-result") ? t(e.target) : t(e.target).parents(".active-result").first()).length) return this.result_highlight = s, this.result_select(e), this.search_field.focus()
    }, n.prototype.search_results_mouseover = function (e) {
      var s;
      if (s = t(e.target).hasClass("active-result") ? t(e.target) : t(e.target).parents(".active-result").first()) return this.result_do_highlight(s)
    }, n.prototype.search_results_mouseout = function (e) {
      if (t(e.target).hasClass("active-result") || t(e.target).parents(".active-result").first()) return this.result_clear_highlight()
    }, n.prototype.choice_build = function (e) {
      var s, i;
      return s = t("<li />", {
        "class": "search-choice"
      }).html("<span>" + this.choice_label(e) + "</span>"), e.disabled ? s.addClass("search-choice-disabled") : ((i = t("<a />", {
        "class": "search-choice-close",
        "data-option-array-index": e.array_index
      })).on("click.chosen", function (t) {
        return function (e) {
          return t.choice_destroy_link_click(e)
        }
      }(this)), s.append(i)), this.search_container.before(s)
    }, n.prototype.choice_destroy_link_click = function (e) {
      if (e.preventDefault(), e.stopPropagation(), !this.is_disabled) return this.choice_destroy(t(e.target))
    }, n.prototype.choice_destroy = function (t) {
      if (this.result_deselect(t[0].getAttribute("data-option-array-index"))) return this.active_field ? this.search_field.focus() : this.show_search_field_default(), this.is_multiple && this.choices_count() > 0 && this.get_search_field_value().length < 1 && this.results_hide(), t.parents("li").first().remove(), this.search_field_scale()
    }, n.prototype.results_reset = function () {
      if (this.reset_single_select_options(), this.form_field.options[0].selected = !0, this.single_set_selected_text(), this.show_search_field_default(), this.results_reset_cleanup(), this.trigger_form_field_change(), this.active_field) return this.results_hide()
    }, n.prototype.results_reset_cleanup = function () {
      return this.current_selectedIndex = this.form_field.selectedIndex, this.selected_item.find("abbr").remove()
    }, n.prototype.result_select = function (t) {
      var e, s;
      if (this.result_highlight) return e = this.result_highlight, this.result_clear_highlight(), this.is_multiple && this.max_selected_options <= this.choices_count() ? (this.form_field_jq.trigger("chosen:maxselected", {
        chosen: this
      }), !1) : (this.is_multiple ? e.removeClass("active-result") : this.reset_single_select_options(), e.addClass("result-selected"), s = this.results_data[e[0].getAttribute("data-option-array-index")], s.selected = !0, this.form_field.options[s.options_index].selected = !0, this.selected_option_count = null, this.is_multiple ? this.choice_build(s) : this.single_set_selected_text(this.choice_label(s)), this.is_multiple && (!this.hide_results_on_select || t.metaKey || t.ctrlKey) ? t.metaKey || t.ctrlKey ? this.winnow_results({
        skip_highlight: !0
      }) : (this.search_field.val(""), this.winnow_results()) : (this.results_hide(), this.show_search_field_default()), (this.is_multiple || this.form_field.selectedIndex !== this.current_selectedIndex) && this.trigger_form_field_change({
        selected: this.form_field.options[s.options_index].value
      }), this.current_selectedIndex = this.form_field.selectedIndex, t.preventDefault(), this.search_field_scale())
    }, n.prototype.single_set_selected_text = function (t) {
      return null == t && (t = this.default_text), t === this.default_text ? this.selected_item.addClass("chosen-default") : (this.single_deselect_control_build(), this.selected_item.removeClass("chosen-default")), this.selected_item.find("span").html(t)
    }, n.prototype.result_deselect = function (t) {
      var e;
      return e = this.results_data[t], !this.form_field.options[e.options_index].disabled && (e.selected = !1, this.form_field.options[e.options_index].selected = !1, this.selected_option_count = null, this.result_clear_highlight(), this.results_showing && this.winnow_results(), this.trigger_form_field_change({
        deselected: this.form_field.options[e.options_index].value
      }), this.search_field_scale(), !0)
    }, n.prototype.single_deselect_control_build = function () {
      if (this.allow_single_deselect) return this.selected_item.find("abbr").length || this.selected_item.find("span").first().after('<abbr class="search-choice-close"></abbr>'), this.selected_item.addClass("chosen-single-with-deselect")
    }, n.prototype.get_search_field_value = function () {
      return this.search_field.val()
    }, n.prototype.get_search_text = function () {
      return t.trim(this.get_search_field_value())
    }, n.prototype.escape_html = function (e) {
      return t("<div/>").text(e).html()
    }, n.prototype.winnow_results_set_highlight = function () {
      var t, e;
      if (e = this.is_multiple ? [] : this.search_results.find(".result-selected.active-result"), null != (t = e.length ? e.first() : this.search_results.find(".active-result").first())) return this.result_do_highlight(t)
    }, n.prototype.no_results = function (t) {
      var e;
      return e = this.get_no_results_html(t), this.search_results.append(e), this.form_field_jq.trigger("chosen:no_results", {
        chosen: this
      })
    }, n.prototype.no_results_clear = function () {
      return this.search_results.find(".no-results").remove()
    }, n.prototype.keydown_arrow = function () {
      var t;
      return this.results_showing && this.result_highlight ? (t = this.result_highlight.nextAll("li.active-result").first()) ? this.result_do_highlight(t) : void 0 : this.results_show()
    }, n.prototype.keyup_arrow = function () {
      var t;
      return this.results_showing || this.is_multiple ? this.result_highlight ? (t = this.result_highlight.prevAll("li.active-result")).length ? this.result_do_highlight(t.first()) : (this.choices_count() > 0 && this.results_hide(), this.result_clear_highlight()) : void 0 : this.results_show()
    }, n.prototype.keydown_backstroke = function () {
      var t;
      return this.pending_backstroke ? (this.choice_destroy(this.pending_backstroke.find("a").first()), this.clear_backstroke()) : (t = this.search_container.siblings("li.search-choice").last()).length && !t.hasClass("search-choice-disabled") ? (this.pending_backstroke = t, this.single_backstroke_delete ? this.keydown_backstroke() : this.pending_backstroke.addClass("search-choice-focus")) : void 0
    }, n.prototype.clear_backstroke = function () {
      return this.pending_backstroke && this.pending_backstroke.removeClass("search-choice-focus"), this.pending_backstroke = null
    }, n.prototype.search_field_scale = function () {
      var e, s, i, n, r, o, h;
      if (this.is_multiple) {
        for (r = {
          position: "absolute",
          left: "-1000px",
          top: "-1000px",
          display: "none",
          whiteSpace: "pre"
        }, s = 0, i = (o = ["fontSize", "fontStyle", "fontWeight", "fontFamily", "lineHeight", "textTransform", "letterSpacing"]).length; s < i; s++) r[n = o[s]] = this.search_field.css(n);
        return (e = t("<div />").css(r)).text(this.get_search_field_value()), t("body").append(e), h = e.width() + 25, e.remove(), this.container.is(":visible") && (h = Math.min(this.container.outerWidth() - 10, h)), this.search_field.width(h)
      }
    }, n.prototype.trigger_form_field_change = function (t) {
      return this.form_field_jq.trigger("input", t), this.form_field_jq.trigger("change", t)
    }, n
  }()
}).call(this);



/**
 * Minified by jsDelivr using Terser v3.14.1.
 * Nestable jQuery Plugin - Copyright (c) 2014 Ramon Smit - https://github.com/RamonSmit/Nestable
 */
/*!
 * Nestable jQuery Plugin - Copyright (c) 2014 Ramon Smit - https://github.com/RamonSmit/Nestable
 */

(function ($, window, document, undefined) {
  var hasTouch = 'ontouchstart' in document;

  /**
   * Detect CSS pointer-events property
   * events are normally disabled on the dragging element to avoid conflicts
   * https://github.com/ausi/Feature-detection-technique-for-pointer-events/blob/master/modernizr-pointerevents.js
   */
  var hasPointerEvents = (function () {
    var el = document.createElement('div'),
      docEl = document.documentElement;
    if (!('pointerEvents' in el.style)) {
      return false;
    }
    el.style.pointerEvents = 'auto';
    el.style.pointerEvents = 'x';
    docEl.appendChild(el);
    var supports = window.getComputedStyle && window.getComputedStyle(el, '').pointerEvents === 'auto';
    docEl.removeChild(el);
    return !!supports;
  })();

  var defaults = {
    contentCallback: function (item) { return item.content || '' ? item.content : item.id; },
    listNodeName: 'ol',
    itemNodeName: 'li',
    handleNodeName: 'div',
    contentNodeName: 'span',
    rootClass: 'dd',
    listClass: 'dd-list',
    itemClass: 'dd-item',
    dragClass: 'dd-dragel',
    handleClass: 'dd-handle',
    contentClass: 'dd-content',
    collapsedClass: 'dd-collapsed',
    placeClass: 'dd-placeholder',
    noDragClass: 'dd-nodrag',
    noChildrenClass: 'dd-nochildren',
    emptyClass: 'dd-empty',
    expandBtnHTML: '<button class="dd-expand" data-action="expand" type="button">Expand</button>',
    collapseBtnHTML: '<button class="dd-collapse" data-action="collapse" type="button">Collapse</button>',
    group: 0,
    maxDepth: 5,
    threshold: 20,
    fixedDepth: false, //fixed item's depth
    fixed: false,
    includeContent: false,
    scroll: false,
    scrollSensitivity: 1,
    scrollSpeed: 5,
    scrollTriggers: {
      top: 40,
      left: 40,
      right: -40,
      bottom: -40
    },
    effect: {
      animation: 'none',
      time: 'slow'
    },
    callback: function (l, e, p) { },
    onDragStart: function (l, e, p) { },
    beforeDragStop: function (l, e, p) { },
    listRenderer: function (children, options) {
      var html = '<' + options.listNodeName + ' class="' + options.listClass + '">';
      html += children;
      html += '</' + options.listNodeName + '>';

      return html;
    },
    itemRenderer: function (item_attrs, content, children, options, item) {
      var item_attrs_string = $.map(item_attrs, function (value, key) {
        return ' ' + key + '="' + value + '"';
      }).join(' ');

      var html = '<' + options.itemNodeName + item_attrs_string + '>';
      html += '<' + options.handleNodeName + ' class="' + options.handleClass + '">';
      html += '<' + options.contentNodeName + ' class="' + options.contentClass + '">';
      html += content;
      html += '</' + options.contentNodeName + '>';
      html += '</' + options.handleNodeName + '>';
      html += children;
      html += '</' + options.itemNodeName + '>';

      return html;
    }
  };

  function Plugin(element, options) {
    this.w = $(document);
    this.el = $(element);
    options = options || defaults;

    if (options.rootClass !== undefined && options.rootClass !== 'dd') {
      options.listClass = options.listClass ? options.listClass : options.rootClass + '-list';
      options.itemClass = options.itemClass ? options.itemClass : options.rootClass + '-item';
      options.dragClass = options.dragClass ? options.dragClass : options.rootClass + '-dragel';
      options.handleClass = options.handleClass ? options.handleClass : options.rootClass + '-handle';
      options.collapsedClass = options.collapsedClass ? options.collapsedClass : options.rootClass + '-collapsed';
      options.placeClass = options.placeClass ? options.placeClass : options.rootClass + '-placeholder';
      options.noDragClass = options.noDragClass ? options.noDragClass : options.rootClass + '-nodrag';
      options.noChildrenClass = options.noChildrenClass ? options.noChildrenClass : options.rootClass + '-nochildren';
      options.emptyClass = options.emptyClass ? options.emptyClass : options.rootClass + '-empty';
    }

    this.options = $.extend({}, defaults, options);

    // build HTML from serialized JSON if passed
    if (this.options.json !== undefined) {
      this._build();
    }

    this.init();
  }

  Plugin.prototype = {

    init: function () {
      var list = this;

      list.reset();
      list.el.data('nestable-group', this.options.group);
      list.placeEl = $('<div class="' + list.options.placeClass + '"/>');

      var items = this.el.find(list.options.itemNodeName);
      $.each(items, function (k, el) {
        var item = $(el),
          parent = item.parent();
        list.setParent(item);
        if (parent.hasClass(list.options.collapsedClass)) {
          list.collapseItem(parent.parent());
        }
      });

      // Append the .dd-empty div if the list don't have any items on init
      if (!items.length) {
        this.appendEmptyElement(this.el);
      }

      list.el.on('click', 'button', function (e) {
        if (list.dragEl) {
          return;
        }
        var target = $(e.currentTarget),
          action = target.data('action'),
          item = target.parents(list.options.itemNodeName).eq(0);
        if (action === 'collapse') {
          list.collapseItem(item);
        }
        if (action === 'expand') {
          list.expandItem(item);
        }
      });

      var onStartEvent = function (e) {
        var handle = $(e.target);
        if (!handle.hasClass(list.options.handleClass)) {
          if (handle.closest('.' + list.options.noDragClass).length) {
            return;
          }
          handle = handle.closest('.' + list.options.handleClass);
        }
        if (!handle.length || list.dragEl) {
          return;
        }

        list.isTouch = /^touch/.test(e.type);
        if (list.isTouch && e.touches.length !== 1) {
          return;
        }

        e.preventDefault();
        list.dragStart(e.touches ? e.touches[0] : e);
      };

      var onMoveEvent = function (e) {
        if (list.dragEl) {
          e.preventDefault();
          list.dragMove(e.touches ? e.touches[0] : e);
        }
      };

      var onEndEvent = function (e) {
        if (list.dragEl) {
          e.preventDefault();
          list.dragStop(e.touches ? e.changedTouches[0] : e);
        }
      };

      if (hasTouch) {
        list.el[0].addEventListener('touchstart', onStartEvent, false);
        window.addEventListener('touchmove', onMoveEvent, false);
        window.addEventListener('touchend', onEndEvent, false);
        window.addEventListener('touchcancel', onEndEvent, false);
      }

      list.el.on('mousedown', onStartEvent);
      list.w.on('mousemove', onMoveEvent);
      list.w.on('mouseup', onEndEvent);

      var destroyNestable = function () {
        if (hasTouch) {
          list.el[0].removeEventListener('touchstart', onStartEvent, false);
          window.removeEventListener('touchmove', onMoveEvent, false);
          window.removeEventListener('touchend', onEndEvent, false);
          window.removeEventListener('touchcancel', onEndEvent, false);
        }

        list.el.off('mousedown', onStartEvent);
        list.w.off('mousemove', onMoveEvent);
        list.w.off('mouseup', onEndEvent);

        list.el.off('click');
        list.el.unbind('destroy-nestable');

        list.el.data("nestable", null);
      };

      list.el.bind('destroy-nestable', destroyNestable);

    },

    destroy: function () {
      this.el.trigger('destroy-nestable');
    },

    add: function (item, callback) {
      var listClassSelector = '.' + this.options.listClass;
      var tree = $(this.el).children(listClassSelector);

      if (item.parent_id !== undefined) {
        tree = tree.find('[data-id="' + item.parent_id + '"]');
        delete item.parent_id;

        if (tree.children(listClassSelector).length === 0) {
          tree = tree.append(this.options.listRenderer('', this.options));
        }

        tree = tree.find(listClassSelector + ':first');
        this.setParent(tree.parent());
      }

      tree.append(this._buildItem(item, this.options));
      
      if (callback) callback( tree.children('[data-id="' + item.id + '"]:first') );

    },

    replace: function (item) {
      var html = this._buildItem(item, this.options);

      this._getItemById(item.id)
        .replaceWith(html);
    },

    //removes item and additional elements from list
    removeItem: function (item) {
      var opts = this.options,
        el = this.el;

      // remove item
      item = item || this;
      item.remove();

      // remove empty children lists
      var emptyListsSelector = '.' + opts.listClass
        + ' .' + opts.listClass + ':not(:has(*))';
      $(el).find(emptyListsSelector).remove();

      // remove buttons if parents do not have children
      var buttonsSelector = '[data-action="expand"], [data-action="collapse"]';
      $(el).find(buttonsSelector).each(function () {
        var siblings = $(this).siblings('.' + opts.listClass);
        if (siblings.length === 0) {
          $(this).remove();
        }
      });
    },

    //removes item by itemId and run callback at the end
    remove: function (itemId, callback) {
      var opts = this.options;
      var list = this;
      var item = this._getItemById(itemId);

      //animation style
      var animation = opts.effect.animation || 'fade';

      //animation time
      var time = opts.effect.time || 'slow';

      //add fadeOut effect when removing
      if (animation === 'fade') {
        item.fadeOut(time, function () {
          list.removeItem(item);
        });
      }
      else {
        this.removeItem(item);
      }

      if (callback) callback();
    },

    //removes all items from the list and run callback at the end
    removeAll: function (callback) {

      var list = this,
        opts = this.options,
        node = list.el.find(opts.listNodeName).first(),
        items = node.children(opts.itemNodeName);

      //animation style
      var animation = opts.effect.animation || 'fade';

      //animation time
      var time = opts.effect.time || 'slow';

      function remove() {
        //Removes each item and its children.
        items.each(function () {
          list.removeItem($(this));
        });
        //Now we can again show our node element
        node.show();
        if (callback) callback();
      }

      //add fadeOut effect when removing
      if (animation === 'fade') {
        node.fadeOut(time, remove);
      }
      else {
        remove();
      }
    },

    _getItemById: function (itemId) {
      return $(this.el).children('.' + this.options.listClass)
        .find('[data-id="' + itemId + '"]');
    },

    _build: function () {
      var json = this.options.json;

      if (typeof json === 'string') {
        json = JSON.parse(json);
      }

      $(this.el).html(this._buildList(json, this.options));
    },

    _buildList: function (items, options) {
      if (!items) {
        return '';
      }

      var children = '';
      var that = this;

      $.each(items, function (index, sub) {
        children += that._buildItem(sub, options);
      });

      return options.listRenderer(children, options);
    },

    _buildItem: function (item, options) {
      function escapeHtml(text) {
        var map = {
          '&': '&amp;',
          '<': '&lt;',
          '>': '&gt;',
          '"': '&quot;',
          "'": '&#039;'
        };

        return text + "".replace(/[&<>"']/g, function (m) { return map[m]; });
      }

      function filterClasses(classes) {
        var new_classes = {};

        for (var k in classes) {
          // Remove duplicates
          new_classes[classes[k]] = classes[k];
        }

        return new_classes;
      }

      function createClassesString(item, options) {
        var classes = item.classes || {};

        if (typeof classes === 'string') {
          classes = [classes];
        }

        var item_classes = filterClasses(classes);
        item_classes[options.itemClass] = options.itemClass;

        // create class string
        return $.map(item_classes, function (val) {
          return val;
        }).join(' ');
      }

      function createDataAttrs(attr) {
        attr = $.extend({}, attr);

        delete attr.children;
        delete attr.classes;
        delete attr.content;

        var data_attrs = {};

        $.each(attr, function (key, value) {
          if (typeof value === 'object') {
            value = JSON.stringify(value);
          }

          data_attrs["data-" + key] = escapeHtml(value);
        });

        return data_attrs;
      }

      var item_attrs = createDataAttrs(item);
      item_attrs["class"] = createClassesString(item, options);

      var content = options.contentCallback(item);
      var children = this._buildList(item.children, options);
      var html = $(options.itemRenderer(item_attrs, content, children, options, item));

      this.setParent(html);

      return html[0].outerHTML;
    },

    serialize: function () {
      var data, list = this, step = function (level) {
        var array = [],
          items = level.children(list.options.itemNodeName);
        items.each(function () {
          var li = $(this),
            item = $.extend({}, li.data()),
            sub = li.children(list.options.listNodeName);

          if (list.options.includeContent) {
            var content = li.find('.' + list.options.contentClass).html();

            if (content) {
              item.content = content;
            }
          }

          if (sub.length) {
            item.children = step(sub);
          }
          array.push(item);
        });
        return array;
      };
      data = step(list.el.find(list.options.listNodeName).first());
      return data;
    },

    asNestedSet: function () {
      var list = this, o = list.options, depth = -1, ret = [], lft = 1;
      var items = list.el.find(o.listNodeName).first().children(o.itemNodeName);

      items.each(function () {
        lft = traverse(this, depth + 1, lft);
      });

      ret = ret.sort(function (a, b) { return (a.lft - b.lft); });
      return ret;

      function traverse(item, depth, lft) {
        var rgt = lft + 1, id, pid;

        if ($(item).children(o.listNodeName).children(o.itemNodeName).length > 0) {
          depth++;
          $(item).children(o.listNodeName).children(o.itemNodeName).each(function () {
            rgt = traverse($(this), depth, rgt);
          });
          depth--;
        }

        id = $(item).attr('data-id');
        if (isInt(id)) {
          id = parseInt(id);
        }

        pid = $(item).parent(o.listNodeName).parent(o.itemNodeName).attr('data-id') || '';
        if (isInt(pid)) {
          id = parseInt(pid);
        }

        if (id) {
          ret.push({ "id": id, "parent_id": pid, "depth": depth, "lft": lft, "rgt": rgt });
        }

        lft = rgt + 1;
        return lft;
      }

      function isInt(value) {
        return $.isNumeric(value) && Math.floor(value) == value;
      }
    },

    returnOptions: function () {
      return this.options;
    },

    serialise: function () {
      return this.serialize();
    },

    toHierarchy: function (options) {

      var o = $.extend({}, this.options, options),
        ret = [];

      $(this.element).children(o.items).each(function () {
        var level = _recursiveItems(this);
        ret.push(level);
      });

      return ret;

      function _recursiveItems(item) {
        var id = ($(item).attr(o.attribute || 'id') || '').match(o.expression || (/(.+)[-=_](.+)/));
        if (id) {
          var currentItem = {
            "id": id[2]
          };
          if ($(item).children(o.listType).children(o.items).length > 0) {
            currentItem.children = [];
            $(item).children(o.listType).children(o.items).each(function () {
              var level = _recursiveItems(this);
              currentItem.children.push(level);
            });
          }
          return currentItem;
        }
      }
    },

    toArray: function () {

      var o = $.extend({}, this.options, this),
        sDepth = o.startDepthCount || 0,
        ret = [],
        left = 2,
        list = this,
        element = list.el.find(list.options.listNodeName).first();

      var items = element.children(list.options.itemNodeName);
      items.each(function () {
        left = _recursiveArray($(this), sDepth + 1, left);
      });

      ret = ret.sort(function (a, b) {
        return (a.left - b.left);
      });

      return ret;

      function _recursiveArray(item, depth, left) {

        var right = left + 1,
          id,
          pid;

        if (item.children(o.options.listNodeName).children(o.options.itemNodeName).length > 0) {
          depth++;
          item.children(o.options.listNodeName).children(o.options.itemNodeName).each(function () {
            right = _recursiveArray($(this), depth, right);
          });
          depth--;
        }

        id = item.data().id;


        if (depth === sDepth + 1) {
          pid = o.rootID;
        } else {

          var parentItem = (item.parent(o.options.listNodeName)
            .parent(o.options.itemNodeName)
            .data());
          pid = parentItem.id;

        }

        if (id) {
          ret.push({
            "id": id,
            "parent_id": pid,
            "depth": depth,
            "left": left,
            "right": right
          });
        }

        left = right + 1;
        return left;
      }

    },

    reset: function () {
      this.mouse = {
        offsetX: 0,
        offsetY: 0,
        startX: 0,
        startY: 0,
        lastX: 0,
        lastY: 0,
        nowX: 0,
        nowY: 0,
        distX: 0,
        distY: 0,
        dirAx: 0,
        dirX: 0,
        dirY: 0,
        lastDirX: 0,
        lastDirY: 0,
        distAxX: 0,
        distAxY: 0
      };
      this.isTouch = false;
      this.moving = false;
      this.dragEl = null;
      this.dragRootEl = null;
      this.dragDepth = 0;
      this.hasNewRoot = false;
      this.pointEl = null;
    },

    expandItem: function (li) {
      li.removeClass(this.options.collapsedClass);
    },

    collapseItem: function (li) {
      var lists = li.children(this.options.listNodeName);
      if (lists.length) {
        li.addClass(this.options.collapsedClass);
      }
    },

    expandAll: function () {
      var list = this;
      list.el.find(list.options.itemNodeName).each(function () {
        list.expandItem($(this));
      });
    },

    collapseAll: function () {
      var list = this;
      list.el.find(list.options.itemNodeName).each(function () {
        list.collapseItem($(this));
      });
    },

    setParent: function (li) {
      //Check if li is an element of itemNodeName type and has children
      if (li.is(this.options.itemNodeName) && li.children(this.options.listNodeName).length) {
        // make sure NOT showing two or more sets data-action buttons
        li.children('[data-action]').remove();
        li.prepend($(this.options.expandBtnHTML));
        li.prepend($(this.options.collapseBtnHTML));
      }
    },

    unsetParent: function (li) {
      li.removeClass(this.options.collapsedClass);
      li.children('[data-action]').remove();
      li.children(this.options.listNodeName).remove();
    },

    dragStart: function (e) {
      var mouse = this.mouse,
        target = $(e.target),
        dragItem = target.closest(this.options.itemNodeName),
        position = {
          top: e.pageY,
          left: e.pageX
        };

      var continueExecution = this.options.onDragStart.call(this, this.el, dragItem, position);

      if (typeof continueExecution !== 'undefined' && continueExecution === false) {
        return;
      }

      this.placeEl.css('height', dragItem.height());

      mouse.offsetX = e.pageX - dragItem.offset().left;
      mouse.offsetY = e.pageY - dragItem.offset().top;
      mouse.startX = mouse.lastX = e.pageX;
      mouse.startY = mouse.lastY = e.pageY;

      this.dragRootEl = this.el;
      this.dragEl = $(document.createElement(this.options.listNodeName)).addClass(this.options.listClass + ' ' + this.options.dragClass);
      this.dragEl.css('width', dragItem.outerWidth());

      this.setIndexOfItem(dragItem);

      // fix for zepto.js
      //dragItem.after(this.placeEl).detach().appendTo(this.dragEl);
      dragItem.after(this.placeEl);
      dragItem[0].parentNode.removeChild(dragItem[0]);
      dragItem.appendTo(this.dragEl);

      $(document.body).append(this.dragEl);
      this.dragEl.css({
        'left': e.pageX - mouse.offsetX,
        'top': e.pageY - mouse.offsetY
      });
      // total depth of dragging item
      var i, depth,
        items = this.dragEl.find(this.options.itemNodeName);
      for (i = 0; i < items.length; i++) {
        depth = $(items[i]).parents(this.options.listNodeName).length;
        if (depth > this.dragDepth) {
          this.dragDepth = depth;
        }
      }
    },

    //Create sublevel.
    //  element : element which become parent
    //  item    : something to place into new sublevel
    createSubLevel: function (element, item) {
      var list = $('<' + this.options.listNodeName + '/>').addClass(this.options.listClass);
      if (item) list.append(item);
      element.append(list);
      this.setParent(element);
      return list;
    },

    setIndexOfItem: function (item, index) {
      index = index || [];

      index.unshift(item.index());

      if ($(item[0].parentNode)[0] !== this.dragRootEl[0]) {
        this.setIndexOfItem($(item[0].parentNode), index);
      }
      else {
        this.dragEl.data('indexOfItem', index);
      }
    },

    restoreItemAtIndex: function (dragElement, indexArray) {
      var currentEl = this.el,
        lastIndex = indexArray.length - 1;

      //Put drag element at current element position.
      function placeElement(currentEl, dragElement) {
        if (indexArray[lastIndex] === 0) {
          $(currentEl).prepend(dragElement.clone(true)); //using true saves added to element events.
        }
        else {
          $(currentEl.children[indexArray[lastIndex] - 1]).after(dragElement.clone(true)); //using true saves added to element events.
        }
      }
      //Diggin through indexArray to get home for dragElement.
      for (var i = 0; i < indexArray.length; i++) {
        if (lastIndex === parseInt(i)) {
          placeElement(currentEl, dragElement);
          return;
        }
        //element can have no indexes, so we have to use conditional here to avoid errors.
        //if element doesn't exist we defenetly need to add new list.
        var element = (currentEl[0]) ? currentEl[0] : currentEl;
        var nextEl = element.children[indexArray[i]];
        currentEl = (!nextEl) ? this.createSubLevel($(element)) : nextEl;
      }
    },

    dragStop: function (e) {
      // fix for zepto.js
      //this.placeEl.replaceWith(this.dragEl.children(this.options.itemNodeName + ':first').detach());
      var position = {
        top: e.pageY,
        left: e.pageX
      };
      //Get indexArray of item at drag start.
      var srcIndex = this.dragEl.data('indexOfItem');

      var el = this.dragEl.children(this.options.itemNodeName).first();

      el[0].parentNode.removeChild(el[0]);

      this.dragEl.remove(); //Remove dragEl, cause it can affect on indexing in html collection.

      //Before drag stop callback
      var continueExecution = this.options.beforeDragStop.call(this, this.el, el, this.placeEl.parent());
      if (typeof continueExecution !== 'undefined' && continueExecution === false) {
        var parent = this.placeEl.parent();
        this.placeEl.remove();
        if (!parent.children().length) {
          this.unsetParent(parent.parent());
        }
        this.restoreItemAtIndex(el, srcIndex);
        this.reset();
        return;
      }

      this.placeEl.replaceWith(el);

      if (this.hasNewRoot) {
        if (this.options.fixed === true) {
          this.restoreItemAtIndex(el, srcIndex);
        }
        else {
          this.el.trigger('lostItem');
        }
        this.dragRootEl.trigger('gainedItem');
      }
      else {
        this.dragRootEl.trigger('change');
      }

      this.options.callback.call(this, this.dragRootEl, el, position);

      this.reset();
    },

    dragMove: function (e) {
      var list, parent, prev, next, depth,
        opt = this.options,
        mouse = this.mouse;

      this.dragEl.css({
        'left': e.pageX - mouse.offsetX,
        'top': e.pageY - mouse.offsetY
      });

      // mouse position last events
      mouse.lastX = mouse.nowX;
      mouse.lastY = mouse.nowY;
      // mouse position this events
      mouse.nowX = e.pageX;
      mouse.nowY = e.pageY;
      // distance mouse moved between events
      mouse.distX = mouse.nowX - mouse.lastX;
      mouse.distY = mouse.nowY - mouse.lastY;
      // direction mouse was moving
      mouse.lastDirX = mouse.dirX;
      mouse.lastDirY = mouse.dirY;
      // direction mouse is now moving (on both axis)
      mouse.dirX = mouse.distX === 0 ? 0 : mouse.distX > 0 ? 1 : -1;
      mouse.dirY = mouse.distY === 0 ? 0 : mouse.distY > 0 ? 1 : -1;
      // axis mouse is now moving on
      var newAx = Math.abs(mouse.distX) > Math.abs(mouse.distY) ? 1 : 0;

      // do nothing on first move
      if (!mouse.moving) {
        mouse.dirAx = newAx;
        mouse.moving = true;
        return;
      }

      // do scrolling if enable
      if (opt.scroll) {
        if (typeof window.jQuery.fn.scrollParent !== 'undefined') {
          var scrolled = false;
          var scrollParent = this.el.scrollParent()[0];
          if (scrollParent !== document && scrollParent.tagName !== 'HTML') {
            if ((opt.scrollTriggers.bottom + scrollParent.offsetHeight) - e.pageY < opt.scrollSensitivity)
              scrollParent.scrollTop = scrolled = scrollParent.scrollTop + opt.scrollSpeed;
            else if (e.pageY - opt.scrollTriggers.top < opt.scrollSensitivity)
              scrollParent.scrollTop = scrolled = scrollParent.scrollTop - opt.scrollSpeed;

            if ((opt.scrollTriggers.right + scrollParent.offsetWidth) - e.pageX < opt.scrollSensitivity)
              scrollParent.scrollLeft = scrolled = scrollParent.scrollLeft + opt.scrollSpeed;
            else if (e.pageX - opt.scrollTriggers.left < opt.scrollSensitivity)
              scrollParent.scrollLeft = scrolled = scrollParent.scrollLeft - opt.scrollSpeed;
          } else {
            if (e.pageY - $(document).scrollTop() < opt.scrollSensitivity)
              scrolled = $(document).scrollTop($(document).scrollTop() - opt.scrollSpeed);
            else if ($(window).height() - (e.pageY - $(document).scrollTop()) < opt.scrollSensitivity)
              scrolled = $(document).scrollTop($(document).scrollTop() + opt.scrollSpeed);

            if (e.pageX - $(document).scrollLeft() < opt.scrollSensitivity)
              scrolled = $(document).scrollLeft($(document).scrollLeft() - opt.scrollSpeed);
            else if ($(window).width() - (e.pageX - $(document).scrollLeft()) < opt.scrollSensitivity)
              scrolled = $(document).scrollLeft($(document).scrollLeft() + opt.scrollSpeed);
          }
        } else {
          console.warn('To use scrolling you need to have scrollParent() function, check documentation for more information');
        }
      }

      if (this.scrollTimer) {
        clearTimeout(this.scrollTimer);
      }

      if (opt.scroll && scrolled) {
        this.scrollTimer = setTimeout(function () {
          $(window).trigger(e);
        }, 10);
      }

      // calc distance moved on this axis (and direction)
      if (mouse.dirAx !== newAx) {
        mouse.distAxX = 0;
        mouse.distAxY = 0;
      }
      else {
        mouse.distAxX += Math.abs(mouse.distX);
        if (mouse.dirX !== 0 && mouse.dirX !== mouse.lastDirX) {
          mouse.distAxX = 0;
        }
        mouse.distAxY += Math.abs(mouse.distY);
        if (mouse.dirY !== 0 && mouse.dirY !== mouse.lastDirY) {
          mouse.distAxY = 0;
        }
      }
      mouse.dirAx = newAx;

      /**
       * move horizontal
       */
      if (mouse.dirAx && mouse.distAxX >= opt.threshold) {
        // reset move distance on x-axis for new phase
        mouse.distAxX = 0;
        prev = this.placeEl.prev(opt.itemNodeName);
        // increase horizontal level if previous sibling exists, is not collapsed, and can have children
        if (mouse.distX > 0 && prev.length && !prev.hasClass(opt.collapsedClass) && !prev.hasClass(opt.noChildrenClass)) {
          // cannot increase level when item above is collapsed
          list = prev.find(opt.listNodeName).last();
          // check if depth limit has reached
          depth = this.placeEl.parents(opt.listNodeName).length;
          if (depth + this.dragDepth <= opt.maxDepth) {
            // create new sub-level if one doesn't exist
            if (!list.length) {
              this.createSubLevel(prev, this.placeEl);
            }
            else {
              // else append to next level up
              list = prev.children(opt.listNodeName).last();
              list.append(this.placeEl);
            }
          }
        }
        // decrease horizontal level
        if (mouse.distX < 0) {
          // we can't decrease a level if an item preceeds the current one
          next = this.placeEl.next(opt.itemNodeName);
          if (!next.length) {
            parent = this.placeEl.parent();
            this.placeEl.closest(opt.itemNodeName).after(this.placeEl);
            if (!parent.children().length) {
              this.unsetParent(parent.parent());
            }
          }
        }
      }

      var isEmpty = false;

      // find list item under cursor
      if (!hasPointerEvents) {
        this.dragEl[0].style.visibility = 'hidden';
      }
      this.pointEl = $(document.elementFromPoint(e.pageX - document.body.scrollLeft, e.pageY - (window.pageYOffset || document.documentElement.scrollTop)));
      if (!hasPointerEvents) {
        this.dragEl[0].style.visibility = 'visible';
      }
      if (this.pointEl.hasClass(opt.handleClass)) {
        this.pointEl = this.pointEl.closest(opt.itemNodeName);
      }
      if (this.pointEl.hasClass(opt.emptyClass)) {
        isEmpty = true;
      }
      else if (!this.pointEl.length || !this.pointEl.hasClass(opt.itemClass)) {
        return;
      }

      // find parent list of item under cursor
      var pointElRoot = this.pointEl.closest('.' + opt.rootClass),
        isNewRoot = this.dragRootEl.data('nestable-id') !== pointElRoot.data('nestable-id');

      /**
       * move vertical
       */
      if (!mouse.dirAx || isNewRoot || isEmpty) {
        // check if groups match if dragging over new root
        if (isNewRoot && opt.group !== pointElRoot.data('nestable-group')) {
          return;
        }

        // fixed item's depth, use for some list has specific type, eg:'Volume, Section, Chapter ...'
        if (this.options.fixedDepth && this.dragDepth + 1 !== this.pointEl.parents(opt.listNodeName).length) {
          return;
        }

        // check depth limit
        depth = this.dragDepth - 1 + this.pointEl.parents(opt.listNodeName).length;
        if (depth > opt.maxDepth) {
          return;
        }
        var before = e.pageY < (this.pointEl.offset().top + this.pointEl.height() / 2);
        parent = this.placeEl.parent();
        // if empty create new list to replace empty placeholder
        if (isEmpty) {
          list = $(document.createElement(opt.listNodeName)).addClass(opt.listClass);
          list.append(this.placeEl);
          this.pointEl.replaceWith(list);
        }
        else if (before) {
          this.pointEl.before(this.placeEl);
        }
        else {
          this.pointEl.after(this.placeEl);
        }
        if (!parent.children().length) {
          this.unsetParent(parent.parent());
        }
        if (!this.dragRootEl.find(opt.itemNodeName).length) {
          this.appendEmptyElement(this.dragRootEl);
        }
        // parent root list has changed
        this.dragRootEl = pointElRoot;
        if (isNewRoot) {
          this.hasNewRoot = this.el[0] !== this.dragRootEl[0];
        }
      }
    },

    // Append the .dd-empty div to the list so it can be populated and styled
    appendEmptyElement: function (element) {
      element.append('<div class="' + this.options.emptyClass + '"/>');
    }
  };

  $.fn.nestable = function (params) {
    var lists = this,
      retval = this,
      args = arguments;

    if (!('Nestable' in window)) {
      window.Nestable = {};
      Nestable.counter = 0;
    }

    lists.each(function () {
      var plugin = $(this).data("nestable");

      if (!plugin) {
        Nestable.counter++;
        $(this).data("nestable", new Plugin(this, params));
        $(this).data("nestable-id", Nestable.counter);
      }
      else {
        if (typeof params === 'string' && typeof plugin[params] === 'function') {
          if (args.length > 1) {
            var pluginArgs = [];
            for (var i = 1; i < args.length; i++) {
              pluginArgs.push(args[i]);
            }
            retval = plugin[params].apply(plugin, pluginArgs);
          }
          else {
            retval = plugin[params]();
          }
        }
      }
    });

    return retval || lists;
  };

})(window.jQuery || window.Zepto, window, document);



/* Icon Picker by QueryLoop
 * Author: @eliorivero
 * URL: http://queryloop.com/
 * License: GPLv2
 */
 ;(function ( $ ) {

  'use strict';

  var defaults = {
    'mode'       : 'dialog',// show overlay 'dialog' panel or slide down 'inline' panel
    'closeOnPick': true,   // whether to close panel after picking or 'no'
    'save'       : 'class', // save icon 'class' or 'code'
    'size'       : '',
    'classes'    : {
      'launcher' : '', // extra classes for launcher buttons
      'clear'    : 'remove-times', // extra classes for button that removes preview and clears field
      'highlight': '', // extra classes when highlighting an icon
      'close'    : ''  // extra classes for close button
    },
    'iconSets' : {          // example data structure. Used to specify which launchers will be created
      'genericon' : 'Genericon', // create a launcher to pick genericon icons
      'fa' : 'FontAwesome' // create a launcher to pick fontawesome icons
    }
  };

  function QL_Icon_Picker ( element, options ) {
    this.element = element;
    this.settings = $.extend( {}, defaults, options );
    this._defaults = defaults;
    this.init();
  }

  QL_Icon_Picker.prototype = {

    iconSet: '',
    iconSetName: '',
    $field: '',

    init: function(){

      var $brick = $(this.element),
        pickerId = $brick.data('pickerid'),
        $preview = $('<div class="icon-preview icon-preview-' + pickerId + '" />');

      this.$field = $brick.find('input');

      // Add preview area
      this.makePreview( $brick, pickerId, $preview );

      // Make button to clear field and remove preview
      this.makeClear( pickerId, $preview );

      // Make buttons that open the panel of icons
      this.makeLaunchers( $brick, pickerId );

      // Prepare display styles, inline and dialog
      this.makeDisplay( $brick );
    },

    makePreview: function( $brick, pickerId, $preview ) {
      var $icon = $('<i />'),
        iconValue = this.$field.val();
      $preview.prependTo($brick);
      $icon.prependTo($preview);
      if ( '' != iconValue ) {
        $preview.addClass('icon-preview-on');
        $icon.addClass(iconValue);
        
        var save = JSON.parse($(this.element).attr('abu-save'));
        if ($.isArray(save)) {
          if ($.inArray('class', save) >= 0) {
            save = 'class';
          } else if ($.inArray('label', save) >= 0) {
            save = 'label';
          } else if ($.inArray('code', save) >= 0) {
            save = 'code';
          } else {
            save = 'class';
          }
        }
        // AbuFramework
        $icon.addClass($('[data-' + save + '="' + iconValue + '"]').first().data('class') );

      }
    },

    makeClear: function( pickerId, $preview ) {
      var base = this,
        $clear = $('<a class="remove-icon ' + base.settings.classes.clear + '" />');

      // Hide button to remove icon and preview and append it to preview area
      $clear.hide().prependTo($preview);
      // If there's a icon saved in the field, show remove icon button
      if ( '' != base.$field.val() ) {
        $clear.show();
      }

      $preview.on('click', '.remove-icon', function(e){
        e.preventDefault();
        base.$field.val('').trigger('input');
        $preview.removeClass('icon-preview-on').find('i').removeClass();
        $(this).hide();
        $($preview).closest('.abu-icon-wrapper').find('input').val(''); // AbuFramework
      });
    },

    makeDisplay: function( $brick ) {
      var base = this,
        close = base.settings.classes.close,
        $body = $('body'),
        $close = $('<a href="#" class="icon-picker-close"/>');

      if ( 'inline' == base.settings.mode ) {
        $brick.find('.icon-set').append($close).removeClass('dialog').addClass('inline ' + base.settings.size).parent().addClass('icon-set-wrap');
      } else if ( 'dialog' == base.settings.mode ) {
        $('.icon-set').addClass('dialog ' + base.settings.size);
        if ( $('.icon-picker-overlay').length <= 0 ) {
          $body.append('<div class="icon-picker-overlay"/>').append($close);
        }
      }
      $body
        .on('click', '.icon-picker-close, .icon-picker-overlay', function(e){
          e.preventDefault();
          base.closePicker( $brick, $(base.iconSet), base.settings.mode);
        })
        .on('mouseenter mouseleave', '.icon-picker-close', function(e){
          if( 'mouseenter' == e.type ) {
            $(this).addClass(close);
          } else {
            $(this).removeClass(close);
          }
        });
    },

    makeLaunchers: function( $brick ) {
      var base = this,
        dataIconSets = $brick.data('iconsets'),
        iconSet;

      if ( 'undefined' == typeof dataIconSets ) {
        dataIconSets = base.settings.iconSets;
      }
      for ( iconSet in dataIconSets ) {
        if( dataIconSets.hasOwnProperty( iconSet ) ) {
          $brick.append('<a class="launch-icons ' + base.settings.classes.launcher + '" data-icons="' + iconSet + '">' + dataIconSets[iconSet] + '</a>');
        }
      }

      $brick.find('.launch-icons').on('click', function(e){
        e.preventDefault();
        var $self = $(this),
          theseIcons = $self.data('icons');
        base.iconSetName = theseIcons;
        base.iconSet = '.' + theseIcons + '-set';

        // Initialize picker
        base.iconPick( $brick );

        // Show icon picker
        base.showPicker( $brick, $(base.iconSet), base.settings.mode );
      });
    },

    iconPick:function( $brick ){
      var base = this,
        highlight = 'icon-highlight ' + base.settings.classes.highlight;
      $(base.iconSet).on('click', 'li', function(e){
        e.preventDefault();
        var $icon = $(this),
          save = JSON.parse($brick.attr('abu-save')), // AbuFramework
          is_all = $.type(save) == 'string' ? ('all' == save ? true : false) : false, // AbuFramework
          icon = $icon; // AbuFramework

        // Mark as selected
        $('.icon-selected').removeClass('icon-selected');
        $icon.addClass('icon-selected');

        // Save icon value to field
        
        // AbuFramework
        if ($.isArray(save)) {
          if ( $.inArray('class', save) >= 0) {
            save = 'class';
          } else if ($.inArray('label', save) >= 0) {
            save = 'label';
          } else if ($.inArray('code', save) >= 0) {
            save = 'code';
          } else {
            save = 'class';
          }
        }
        save = is_all ? 'class' : save;
        base.$field.val($icon.data(save)).trigger('input');
        
        $brick.siblings('input.abu-code-input').val($icon.data('code'));
        $brick.siblings('input.abu-label-input').val($icon.data('label'));

        // END AbuFramework
        
        // Close icon picker
        if ( base.settings.closeOnPick ) {
          base.closePicker( $brick, $icon.closest(base.iconSet), base.settings.mode );
        }

        // Set preview
        base.setPreview($icon.data('class'), { 'code': $icon.data('code'), 'label': $icon.data('label') });

        // Broadcast event passing the selected icon.
        $('body').trigger('iconselected.queryloop', icon);
      });
      $(base.iconSet).on('mouseenter mouseleave', 'li', function(e){
        if( 'mouseenter' == e.type ) {
          $(this).addClass(highlight);
        } else {
          $(this).removeClass(highlight);
        }
      });
    },

    showPicker: function( $brick, $icons, mode ){
      if ( 'inline' == mode ) {
        $('.icon-set').removeClass('inline-open');
        $brick.find($icons).toggleClass('inline-open');
      } else if ( 'dialog' == mode ) {
        $('.icon-picker-close, .icon-picker-overlay').addClass('make-visible');
        $icons.addClass('dialog-open');
      }

      $icons.find('.icon-selected').removeClass('icon-selected');
      var selectedIcon = this.$field.val().replace(' ', '.');
      if ( '' != selectedIcon ) {
        if ( 'class' == this.settings.save ) {
          $icons.find('.' + selectedIcon).addClass('icon-selected');
        } else {
          $icons.find('[data-code="' + selectedIcon + '"]').addClass('icon-selected');
        }
      }
      // Broadcast event when the picker is shown passing the picker mode.
      $('body').trigger('iconpickershow.queryloop', mode);
    },

    closePicker: function( $brick, $icons, mode ){
      // Remove event so they don't fire from a different picker
      $(this.iconSet).off('click', 'li');

      if ( 'inline' == mode ) {
        $brick.find($icons).removeClass('inline-open');
      } else if ( 'dialog' == mode ) {
        $('.icon-picker-close, .icon-picker-overlay').removeClass('make-visible');
        $icons.removeClass('dialog-open');
      }
      // Broadcast event when the picker is closed passing the picker mode.
      $('body').trigger('iconpickerclose.queryloop', mode);
    },

    setPreview: function( preview, attr = {} ){
      var $preview = $(this.element).find('.icon-preview');
      $preview.addClass('icon-preview-on').find('i').removeClass()
        .addClass( this.iconSetName )
        .attr( attr )
        .addClass( preview );
      $preview.find('a').show();
    }
  };

  $.fn.qlIconPicker = function ( options ) {
    this.each(function() {
      if ( !$.data( this, 'plugin_qlIconPicker' ) ) {
        $.data( this, 'plugin_qlIconPicker', new QL_Icon_Picker( this, options ) );
      }
    });
    return this;
  };

 })( jQuery );



/*!
 SerializeJSON jQuery plugin.
 https://github.com/marioizquierdo/jquery.serializeJSON
 version 2.9.0 (Jan, 2018)

 Copyright (c) 2012-2018 Mario Izquierdo
 Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
*/
! function (e) {
  if ("function" == typeof define && define.amd) define(["jquery"], e);
  else if ("object" == typeof exports) {
    var n = require("jquery");
    module.exports = e(n)
  } else e(window.jQuery || window.Zepto || window.$)
}(function (e) {
  "use strict";
  e.fn.serializeJSON = function (n) {
    var r, s, t, i, a, u, l, o, p, c, d, f, y;
    return r = e.serializeJSON, s = this, t = r.setupOpts(n), i = s.serializeArray(), r.readCheckboxUncheckedValues(i, t, s), a = {}, e.each(i, function (e, n) {
      u = n.name, l = n.value, p = r.extractTypeAndNameWithNoType(u), c = p.nameWithNoType, (d = p.type) || (d = r.attrFromInputWithName(s, u, "data-value-type")), r.validateType(u, d, t), "skip" !== d && (f = r.splitInputNameIntoKeysArray(c), o = r.parseValue(l, u, d, t), (y = !o && r.shouldSkipFalsy(s, u, c, d, t)) || r.deepSet(a, f, o, t))
    }), a
  }, e.serializeJSON = {
    defaultOptions: {
      checkboxUncheckedValue: void 0,
      parseNumbers: !1,
      parseBooleans: !1,
      parseNulls: !1,
      parseAll: !1,
      parseWithFunction: null,
      skipFalsyValuesForTypes: [],
      skipFalsyValuesForFields: [],
      customTypes: {},
      defaultTypes: {
        string: function (e) {
          return String(e)
        },
        number: function (e) {
          return Number(e)
        },
        boolean: function (e) {
          return -1 === ["false", "null", "undefined", "", "0"].indexOf(e)
        },
        null: function (e) {
          return -1 === ["false", "null", "undefined", "", "0"].indexOf(e) ? e : null
        },
        array: function (e) {
          return JSON.parse(e)
        },
        object: function (e) {
          return JSON.parse(e)
        },
        auto: function (n) {
          return e.serializeJSON.parseValue(n, null, null, {
            parseNumbers: !0,
            parseBooleans: !0,
            parseNulls: !0
          })
        },
        skip: null
      },
      useIntKeysAsArrayIndex: !1
    },
    setupOpts: function (n) {
      var r, s, t, i, a, u;
      u = e.serializeJSON, null == n && (n = {}), t = u.defaultOptions || {}, s = ["checkboxUncheckedValue", "parseNumbers", "parseBooleans", "parseNulls", "parseAll", "parseWithFunction", "skipFalsyValuesForTypes", "skipFalsyValuesForFields", "customTypes", "defaultTypes", "useIntKeysAsArrayIndex"];
      for (r in n)
        if (-1 === s.indexOf(r)) throw new Error("serializeJSON ERROR: invalid option '" + r + "'. Please use one of " + s.join(", "));
      return i = function (e) {
        return !1 !== n[e] && "" !== n[e] && (n[e] || t[e])
      }, a = i("parseAll"), {
        checkboxUncheckedValue: i("checkboxUncheckedValue"),
        parseNumbers: a || i("parseNumbers"),
        parseBooleans: a || i("parseBooleans"),
        parseNulls: a || i("parseNulls"),
        parseWithFunction: i("parseWithFunction"),
        skipFalsyValuesForTypes: i("skipFalsyValuesForTypes"),
        skipFalsyValuesForFields: i("skipFalsyValuesForFields"),
        typeFunctions: e.extend({}, i("defaultTypes"), i("customTypes")),
        useIntKeysAsArrayIndex: i("useIntKeysAsArrayIndex")
      }
    },
    parseValue: function (n, r, s, t) {
      var i, a;
      return i = e.serializeJSON, a = n, t.typeFunctions && s && t.typeFunctions[s] ? a = t.typeFunctions[s](n) : t.parseNumbers && i.isNumeric(n) ? a = Number(n) : !t.parseBooleans || "true" !== n && "false" !== n ? t.parseNulls && "null" == n ? a = null : t.typeFunctions && t.typeFunctions.string && (a = t.typeFunctions.string(n)) : a = "true" === n, t.parseWithFunction && !s && (a = t.parseWithFunction(a, r)), a
    },
    isObject: function (e) {
      return e === Object(e)
    },
    isUndefined: function (e) {
      return void 0 === e
    },
    isValidArrayIndex: function (e) {
      return /^[0-9]+$/.test(String(e))
    },
    isNumeric: function (e) {
      return e - parseFloat(e) >= 0
    },
    optionKeys: function (e) {
      if (Object.keys) return Object.keys(e);
      var n, r = [];
      for (n in e) r.push(n);
      return r
    },
    readCheckboxUncheckedValues: function (n, r, s) {
      var t, i, a;
      null == r && (r = {}), e.serializeJSON, t = "input[type=checkbox][name]:not(:checked):not([disabled])", s.find(t).add(s.filter(t)).each(function (s, t) {
        if (i = e(t), null == (a = i.attr("data-unchecked-value")) && (a = r.checkboxUncheckedValue), null != a) {
          if (t.name && -1 !== t.name.indexOf("[][")) throw new Error("serializeJSON ERROR: checkbox unchecked values are not supported on nested arrays of objects like '" + t.name + "'. See https://github.com/marioizquierdo/jquery.serializeJSON/issues/67");
          n.push({
            name: t.name,
            value: a
          })
        }
      })
    },
    extractTypeAndNameWithNoType: function (e) {
      var n;
      return (n = e.match(/(.*):([^:]+)$/)) ? {
        nameWithNoType: n[1],
        type: n[2]
      } : {
          nameWithNoType: e,
          type: null
        }
    },
    shouldSkipFalsy: function (n, r, s, t, i) {
      var a = e.serializeJSON.attrFromInputWithName(n, r, "data-skip-falsy");
      if (null != a) return "false" !== a;
      var u = i.skipFalsyValuesForFields;
      if (u && (-1 !== u.indexOf(s) || -1 !== u.indexOf(r))) return !0;
      var l = i.skipFalsyValuesForTypes;
      return null == t && (t = "string"), !(!l || -1 === l.indexOf(t))
    },
    attrFromInputWithName: function (e, n, r) {
      var s, t;
      return s = n.replace(/(:|\.|\[|\]|\s)/g, "\\$1"), t = '[name="' + s + '"]', e.find(t).add(e.filter(t)).attr(r)
    },
    validateType: function (n, r, s) {
      var t, i;
      if (i = e.serializeJSON, t = i.optionKeys(s ? s.typeFunctions : i.defaultOptions.defaultTypes), r && -1 === t.indexOf(r)) throw new Error("serializeJSON ERROR: Invalid type " + r + " found in input name '" + n + "', please use one of " + t.join(", "));
      return !0
    },
    splitInputNameIntoKeysArray: function (n) {
      var r;
      return e.serializeJSON, r = n.split("["), "" === (r = e.map(r, function (e) {
        return e.replace(/\]/g, "")
      }))[0] && r.shift(), r
    },
    deepSet: function (n, r, s, t) {
      var i, a, u, l, o, p;
      if (null == t && (t = {}), (p = e.serializeJSON).isUndefined(n)) throw new Error("ArgumentError: param 'o' expected to be an object or array, found undefined");
      if (!r || 0 === r.length) throw new Error("ArgumentError: param 'keys' expected to be an array with least one element");
      i = r[0], 1 === r.length ? "" === i ? n.push(s) : n[i] = s : (a = r[1], "" === i && (o = n[l = n.length - 1], i = p.isObject(o) && (p.isUndefined(o[a]) || r.length > 2) ? l : l + 1), "" === a ? !p.isUndefined(n[i]) && e.isArray(n[i]) || (n[i] = []) : t.useIntKeysAsArrayIndex && p.isValidArrayIndex(a) ? !p.isUndefined(n[i]) && e.isArray(n[i]) || (n[i] = []) : !p.isUndefined(n[i]) && p.isObject(n[i]) || (n[i] = {}), u = r.slice(1), p.deepSet(n[i], u, s, t))
    }
  }
});



/* Toast */
/* !Don't remove this!
 * Material Toast plugin styles
 *
 * Author: Dionlee Uy
 * Email: dionleeuy@gmail.com
 */
! function (t, e) {
  "function" == typeof define && define.amd ? define("mdtoast", [], e(t)) : "object" == typeof exports ? module.exports = e(t) : t.mdtoast = e(t)
}("undefined" != typeof global ? global : this.window || this.global, function (t) {
  "use strict";

  function e(t, e, o, n) {
    e.appendChild(t.docFrag), setTimeout(function () {
      t.toast.classList.remove("mdt--load"), setTimeout(function () {
        o && o.shown && o.shown.apply(t), n && "function" == typeof n && n.apply(t)
      }, t.animateTime), t.options.interaction ? t.options.interactionTimeout && (t.timeout = setTimeout(function () {
        t.hide()
      }, t.options.interactionTimeout)) : t.options.duration && (t.timeout = setTimeout(function () {
        t.hide()
      }, t.options.duration)), e.classList.add(a), t.options.modal && e.classList.add(s)
    }, 15)
  }

  function o() {
    var t = {},
      e = !1,
      o = 0,
      n = arguments.length;
    "[object Boolean]" === Object.prototype.toString.call(arguments[0]) && (e = arguments[0], o++);
    for (var i = function (o) {
      for (var n in o) Object.prototype.hasOwnProperty.call(o, n) && (e && "[object Object]" === Object.prototype.toString.call(o[n]) ? t[n] = extend(!0, t[n], o[n]) : t[n] = o[n])
    }; n > o; o++) {
      var a = arguments[o];
      i(a)
    }
    return t
  }
  var n = !!document.querySelector && !!t.addEventListener,
    i = {
      init: !1,
      duration: 5e3,
      type: "default",
      modal: !1,
      interaction: !1,
      interactionTimeout: null,
      actionText: "OK",
      action: function () {
        this.hide()
      },
      callbacks: {}
    },
    a = "mdtoast--open",
    s = "mdtoast--modal",
    c = function () {
      if (!(this instanceof c)) return c.apply(Object.create(c.prototype), arguments);
      var t = this,
        e = arguments;
      return t.animateTime = 230, t.message = e[0], t.options = o(i, e[1]), t.timeout = null, t.options.init || d.apply(t), t
    },
    d = function () {
      if (n) {
        var t, e, o = this,
          i = o.options,
          a = (i.callbacks, function (t, e, o, n) {
            var i = document.createElement(t);
            return i.className = e, "undefined" != typeof o && (i[n ? "innerHTML" : "innerText"] = o), i
          }),
          s = function (t) {
            t.target.matches(".mdt-action") && ("click" === t.type || "keypress" === t.type && 13 === t.keyCode) && i.action && i.action.apply(o, [t])
          };
        o.docFrag = document.createDocumentFragment(), o.toast = a("div", "mdtoast mdt--load"), o.toast.tabIndex = 0, o.docFrag.appendChild(o.toast), "default" !== i.type && o.toast.classList.add("mdt--" + i.type), t = a("div", "mdt-message", o.message, !0), o.toast.appendChild(t), e = a("span", "mdt-action"), i.interaction && (e.innerText = i.actionText, e.tabIndex = 0, o.toast.classList.add("mdt--interactive"), o.toast.appendChild(e)), o.toast.addEventListener("click", s, !1), o.toast.addEventListener("keypress", s, !1), o.toast.mdtoast = o, o.options.init || o.show()
      }
    };
  return Object.defineProperties(c, {
    INFO: {
      value: "info"
    },
    ERROR: {
      value: "error"
    },
    WARNING: {
      value: "warning"
    },
    SUCCESS: {
      value: "success"
    }
  }), c.prototype.show = function (t) {
    var o = this,
      n = o.options.callbacks,
      i = document.getElementsByClassName("mdtoast"),
      a = document.body;
    if (!a.contains(o.toast))
      if (o.options.init && d.apply(this), i.length > 0)
        for (var s = i.length - 1; s >= 0; s--) i[s].mdtoast.hide(function () {
          0 > s && e(o, a, n, t)
        });
      else e(o, a, n, t)
  }, c.prototype.hide = function (t) {
    var e = this,
      o = e.options.callbacks,
      n = document.body;
    clearTimeout(e.timeout), e.toast.classList.add("mdt--load"), n.classList.remove(a), n.classList.remove(s), setTimeout(function () {
      n.removeChild(e.toast), o && o.hidden && o.hidden.apply(e), t && "function" == typeof t && t.apply(e)
    }, e.animateTime)
  }, c
});



/* !Don't remove this!
 * duDialog v1.0 plugin
 * https://github.com/dmuy/duDialog
 *
 * Author: Dionlee Uy
 * Email: dionleeuy@gmail.com
 */
! function (e, t) {
  "function" == typeof define && define.amd ? define("duDialog", [], t(e)) : "object" == typeof exports ? module.exports = t(e) : e.duDialog = t(e)
}("undefined" != typeof global ? global : this.window || this.global, function (e) {
  "use strict";
  var t = !!document.querySelector && !!e.addEventListener,
    l = {
      id: null,
      init: !1,
      okText: "Ok",
      cancelText: "Cancel",
      selection: !1,
      multiple: !1,
      allowSearch: !1,
      selectedValue: null,
      valueField: "value",
      textField: "item",
      callbacks: null
    },
    c = function () {
      var e = {},
        t = !1,
        l = 0,
        o = arguments.length;
      "[object Boolean]" === Object.prototype.toString.call(arguments[0]) && (t = arguments[0], l++);
      for (var i = function (l) {
        for (var o in l) Object.prototype.hasOwnProperty.call(l, o) && (t && "[object Object]" === Object.prototype.toString.call(l[o]) ? e[o] = c(!0, e[o], l[o]) : e[o] = l[o])
      }; o > l; l++) {
        var a = arguments[l];
        i(a)
      }
      return e
    },
    o = function () {
      if (!(this instanceof o)) return o.apply(Object.create(o.prototype), arguments);
      var e = this,
        t = arguments,
        i = typeof t[0],
        a = typeof t[1],
        n = typeof t[2];
      e.config = c(l, "object" === n ? t[2] : t[3]);
      var r = e.config.selection ? e.config.multiple ? o.OK_CANCEL : o.NO_ACTION : o.DEFAULT;
      if (e.type = "object" === n ? r : t[2] || r, "undefined" === i || "string" !== i && null !== t[0]) throw new Error("Dialog title is missing or incorrect format.");
      if (("undefined" === a || "string" !== a) && !e.config.selection || !Array.isArray(t[1]) && e.config.selection) throw new Error("Dialog message is missing or incorrect format.");
      return e.title = t[0], e.message = t[1], e.cache = {}, e.config.init || g.apply(e), e
    },
    i = function (e, t) {
      var l = function (e, t) {
        for (var c in e) {
          var o = e[c];
          "object" == typeof o && null !== o && void 0 === o.dataset && void 0 === o[0] ? l(o, t[c]) : c in t && (null !== o ? t[c] = o : null !== o ? t.setAttribute(c, o) : t.removeAttribute(c))
        }
      };
      l(t, e)
    },
    a = function (e) {
      return e.replace(/\s+/g, "")
    },
    n = function (e, t) {
      return e ? void 0 === e[0] ? !1 : e.filter(function (e) {
        return e === t
      }).length > 0 : !1
    },
    r = function (e, t, l) {
      Array.isArray(e) ? e.forEach(function (e) {
        e.addEventListener(t, l, !1)
      }) : e.addEventListener(t, l, !1)
    },
    s = function (e, t, l) {
      t.forEach(function (t) {
        e.addEventListener(t, l, !1)
      })
    },
    d = function (e, t) {
      Array.isArray(e) ? e.forEach(function (e) {
        t.appendChild(e)
      }) : t.appendChild(e)
    },
    g = function () {
      if (t) {
        var e, l, c, g, f = this,
          u = f.config.callbacks,
          p = function (e, t, l, c) {
            var o = document.createElement(e);
            return "undefined" != typeof l && (o[c ? "innerHTML" : "innerText"] = l), "undefined" != typeof t && i(o, t), o
          },
          m = function (e) {
            if ("click" === e.type && (e.target.matches(".du-dialog") && (f.type === o.NO_ACTION ? f.hide() : (f.dialog.classList.add("dlg--pulse"), setTimeout(function () {
              f.dialog.classList.remove("dlg--pulse")
            }, 200))), e.target.matches(".dlg-select-item") && e.target.querySelector(".dlg-select-lbl").click(), e.target.matches(".dlg-action"))) {
              if (e.target.matches(".ok-action"))
                if (f.config.selection && f.config.multiple) {
                  for (var t = c.querySelectorAll(".dlg-select-checkbox:checked"), l = [], i = [], a = 0; a < t.length; a++) {
                    var n = f.cache[t[a].id];
                    i.push(n), l.push("string" == typeof n ? t[a].value : n[f.config.valueField])
                  }
                  f.config.selectedValue = l, u.itemSelect.apply({
                    value: l
                  }, [e, i]), f.hide()
                } else u && u.okClick ? u.okClick.apply(f, e) : f.hide();
              e.target.matches(".cancel-action") && (u && u.cancelClick ? u.cancelClick.apply(f, e) : f.hide())
            }
            if ("change" === e.type && e.target.matches(".dlg-select-radio")) {
              var r = e.target;
              if (r.checked && u && u.itemSelect) {
                var n = f.cache[r.id];
                f.config.selectedValue = "string" == typeof n ? r.value : n[f.config.valueField], u.itemSelect.apply(r, [e, n]), f.hide()
              }
            }
            if ("scroll" === e.type && e.target.matches(".dlg-content") && e.target.classList[e.target.scrollTop > 5 ? "add" : "remove"]("content--scrolled"), "keyup" === e.type && e.target.matches(".dlg-search"))
              for (var s = e.target.value, d = c.querySelectorAll(".dlg-select-item"), a = 0; a < d.length; a++) {
                var g = d[a],
                  p = g.querySelector(f.config.multiple ? ".dlg-select-checkbox" : ".dlg-select-radio"),
                  n = f.cache[p.id],
                  m = typeof n,
                  h = "string" === m ? n : n[f.config.textField],
                  y = !1;
                y = u && u.onSearch ? u.onSearch.call(f, n, s) : h.toLowerCase().indexOf(s.toLowerCase()) >= 0, g.classList[y ? "remove" : "add"]("item--nomatch")
              }
          };
        if (f.docFrag = document.createDocumentFragment(), f.dialog = p("div", {
          className: "du-dialog",
          id: f.config.id
        }), d(f.dialog, f.docFrag), e = p("div", {
          className: "dlg-wrapper",
          tabIndex: 0
        }), d(e, f.dialog), f.title ? (l = p("div", {
          className: "dlg-header"
        }, f.title), d(l, e)) : f.dialog.classList.add("dlg--no-title"), c = p("div", {
          className: "dlg-content"
        }), f.config.selection) {
          f.config.allowSearch && d(p("input", {
            className: "dlg-search",
            placeholder: "Search..."
          }), l);
          for (var h = 0; h < f.message.length; h++) {
            var y = f.message[h],
              v = typeof y,
              b = "string" === v ? y : y[f.config.valueField],
              k = "string" === v ? y : y[f.config.textField],
              N = (f.config.multiple ? "dlg-cb" : "dlg-radio") + a(b.toString()),
              E = p("div", {
                className: "dlg-select-item"
              }),
              S = p("input", {
                className: f.config.multiple ? "dlg-select-checkbox" : "dlg-select-radio",
                id: N,
                name: "dlg-selection",
                type: f.config.multiple ? "checkbox" : "radio",
                value: b,
                checked: f.config.multiple ? f.config.selectedValue && n(f.config.selectedValue, b) : f.config.selectedValue === b
              }),
              A = p("label", {
                className: "dlg-select-lbl",
                htmlFor: N
              }, u && u.itemRender ? u.itemRender.call(f, y) : '<span class="select-item">' + k + "</span>", !0);
            f.cache[N] = y, d([S, A], E), d(E, c)
          }
        } else c.innerHTML = f.message;
        switch (d(c, e), f.type !== o.NO_ACTION && (g = p("div", {
          className: "dlg-actions"
        }), d(g, e)), f.type) {
          case o.OK_CANCEL:
            d([p("button", {
              className: "dlg-action cancel-action",
              tabIndex: 2
            }, f.config.cancelText), p("button", {
              className: "dlg-action ok-action",
              tabIndex: 1
            }, f.config.okText)], g);
            break;
          case o.DEFAULT:
            d(p("button", {
              className: "dlg-action ok-action",
              tabIndex: 1
            }, f.config.okText), g)
        }
        r(c, "scroll", m), s(f.dialog, ["click", "change", "keyup"], m), f.config.init || f.show()
      }
    };
  return Object.defineProperties(o, {
    DEFAULT: {
      value: 1
    },
    OK_CANCEL: {
      value: 2
    },
    NO_ACTION: {
      value: 3
    }
  }), o.prototype.show = function () {
    var e = this;
    e.config.init && g.apply(this), d(e.docFrag, document.body), setTimeout(function () {
      if (e.dialog.classList.add("dlg--open"), e.config.selection && !e.config.multiple) {
        var t = e.dialog.querySelector(".dlg-content"),
          l = t.querySelector(".dlg-select-radio:checked");
        if (l) {
          for (var c = Array.prototype.slice.call(t.childNodes), o = 0, i = 0; i < c.indexOf(l.parentNode); i++) {
            var a = c[i].offsetHeight;
            o += a
          }
          t.scrollTop = o
        }
      }
      var n = document.getElementsByClassName("dlg-action");
      n && n.length ? n[n.length - 1].focus() : e.dialog.getElementsByClassName("dlg-wrapper")[0].focus()
    }, 15)
  }, o.prototype.hide = function () {
    var e = this;
    e.dialog.classList.add("dlg--closing"), setTimeout(function () {
      document.body.removeChild(e.dialog)
    }, 200)
  }, o
}), Element.prototype.matches || (Element.prototype.matches = Element.prototype.matchesSelector || Element.prototype.mozMatchesSelector || Element.prototype.msMatchesSelector || Element.prototype.oMatchesSelector || Element.prototype.webkitMatchesSelector || function (e) {
  for (var t = (this.document || this.ownerDocument).querySelectorAll(e), l = t.length; --l >= 0 && t.item(l) !== this;);
  return l > -1
});