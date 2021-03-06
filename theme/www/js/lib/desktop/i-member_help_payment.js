Util.Objects["member_help_payment"] = new function() {
	this.init = function(scene) {

		scene.resized = function() {
//			u.bug("scene.resized:" + u.nodeId(this));
		}

		scene.scrolled = function() {
//			u.bug("scene.scrolled:" + u.nodeId(this))
		}

		scene.ready = function() {
			u.bug("scene.ready:", this);

			var payment_options = u.qs("div.payment_options", this);
			var mobilepay_form = u.qs("form.mobilepay", payment_options);
			var mobilepay_fieldset = u.qs("fieldset", mobilepay_form);
			var mobilepay_checkbox_field = u.qs(".field.checkbox", mobilepay_fieldset);
			var mobilepay_checkbox = u.qs("input[type=checkbox]", mobilepay_checkbox_field);
			var mobilepay_code_div = u.qs("div.code", mobilepay_fieldset);
			var cash_form = u.qs("form.cash", payment_options);
			var cash_fieldset = u.qs("fieldset", cash_form);
			var cash_checkbox_field = u.qs(".field.checkbox", cash_fieldset);
			var cash_checkbox = u.qs("input[type=checkbox]", cash_checkbox_field);
			var cash_instructions = u.qs("div.instructions", cash_fieldset);
			
			// adjust mobile and cash forms to the same height
			var fieldset_height = u.actualHeight(mobilepay_fieldset);
			var mobilepay_code_div_height = u.actualHeight(mobilepay_code_div);
			u.as(cash_fieldset, "height", fieldset_height + "px"); 
			u.as(cash_instructions, "height", mobilepay_code_div_height + "px"); 

			// initialize forms
			if(mobilepay_form) {
				u.f.init(mobilepay_form);
			}
			if(cash_form) {
				u.f.init(cash_form);
			}

			// make checkboxes mutually exclusive
			if(mobilepay_form && cash_form) {
				u.e.addEvent(mobilepay_checkbox_field, "change", function() {
					if(u.hc(mobilepay_checkbox_field, "checked")) {
						if(u.hc(cash_checkbox_field, "checked")) {
							u.rc(cash_checkbox_field, "checked")
							cash_checkbox.checked = false;
							u.f.validate(cash_checkbox);
						}
					}

				});

				u.e.addEvent(cash_checkbox_field, "change", function() {
					if(u.hc(cash_checkbox_field, "checked")) {
						if(u.hc(mobilepay_checkbox_field, "checked")) {
							u.rc(mobilepay_checkbox_field, "checked")
							mobilepay_checkbox.checked = false;
							u.f.validate(mobilepay_checkbox);
						}
					}

				});

			}



			
			// add clickable tabs for mobilepay/cash
			var cash_tab = u.insertElement(payment_options, "h4", {"class":"tab cash_tab","html":"Kontant"});
			var mobilepay_tab = u.ie(payment_options, "h4", {"class":"tab mobilepay_tab","html":"MobilePay"});

			u.e.click(mobilepay_tab);
			mobilepay_tab.clicked = function () {
				u.as(cash_form, "display", "none");
				u.as(mobilepay_form, "display", "block");
				u.as(cash_tab, "backgroundColor", "#BBBBBB");
				u.as(mobilepay_tab, "backgroundColor", "#f2f2f2f2");
			}
			
			u.e.click(cash_tab);
			cash_tab.clicked = function () {
				u.as(mobilepay_form, "display", "none");
				u.as(cash_form, "display", "block");
				u.as(mobilepay_tab, "backgroundColor", "#BBBBBB");
				u.as(cash_tab, "backgroundColor", "#f2f2f2f2")
			}



		}

		// scene is ready
		scene.ready();
	}
}
