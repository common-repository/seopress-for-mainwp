(function ($) {
	$(function () {
		const $messageBox = $("#mainwp-seopress-message-box");
		const $exportSettingsTextArea = $("#mainwp-seopress-exported-settings");
		let originalToggleFeatureCheck = false;

		let originalProToggleFeatureCheck = [];

		const proToggleSlugs = [
			"local-business",
			"dublin-core",
			"ai",
			"rich-snippets",
			"breadcrumbs",
			"woocommerce",
			"inspect-url",
			"edd",
			"robots",
			"news",
			"404",
			"rewrite",
			"white-label",
		];

		const proToggleLabel = function () {
			proToggleSlugs.forEach(function (slug) {
				$("#" + slug + "-state-default").hide();
				$("#" + slug + "-state").hide();
				if ($("#toggle-" + slug).is(":checked")) {
					if ("robots" === slug || "404" === slug) {
						$("#" + slug + "-state-default").show();
					} else {
						$("#" + slug + "-state").show();
					}
				} else {
					if ("robots" === slug || "404" === slug) {
						$("#" + slug + "-state").show();
					} else {
						$("#" + slug + "-state-default").show();
					}
				}
			});
		};

		$(".mainwp-seopress-titles-menu a").on("click", function (e) {
			e.preventDefault();

			$(".mainwp-seopress-titles-menu a.active").removeClass("active");
			$(this).addClass("active");

			$(".mainwp-seopress-tab-content").addClass("hidden");

			$($(this).attr("href")).removeClass("hidden");
		});

		$(".mainwp-seopress-titles-menu a.active").trigger("click");

		if (window.location.hash.length) {
			$(
				".mainwp-seopress-titles-menu a[href='" + window.location.hash + "']"
			).trigger("click");
		}

		$(".wrap-toggle-checkboxes input[type=checkbox]").each(function () {
			originalProToggleFeatureCheck[$(this).attr("name")] = 0;
			$(this).prop("checked", false);
			if (1 === parseInt($(this).data("toggle"))) {
				$(this).prop("checked", true);
				originalProToggleFeatureCheck[$(this).attr("name")] = 1;
			}
		});

		if ($(".mainwp-seopress-pro-dashboard-toggles").length) {
			$(".mainwp-seopress-pro-dashboard-toggles input[type=checkbox]").each(
				function () {
					originalProToggleFeatureCheck[$(this).attr("name")] = 0;
					if ($(this).is(":checked")) {
						originalProToggleFeatureCheck[$(this).attr("name")] = 1;
					}
				}
			);
		}

		proToggleLabel();

		$("#mainwp-seopress-dashboard-settings-form").on("submit", function (e) {
			e.preventDefault();

			const formData = new FormData($(this)[0]);

			$.ajax({
				url: ajaxurl,
				type: "POST",
				data: formData,
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function () {
					$messageBox.html("");
					$messageBox.hide();
					$messageBox.removeClass("red").removeClass("green");
				},
				success: function (response) {
					if (response.success) {
						$messageBox.html(response.data);
						$messageBox.addClass("green");
						$messageBox.show();

						setTimeout(function () {
							location.reload();
						}, 600);
					}
				},
				error: function (xhr, status, error) {
					const message = xhr.responseJSON.data;
					$messageBox.html(message);
					$messageBox.addClass("red");
					$messageBox.show();
				},
			});
		});

		$(
			".wrap-toggle-checkboxes input[type=checkbox], .mainwp-seopress-pro-dashboard-toggles input[type=checkbox]"
		).on("change", function () {
			const $this = $(this);

			const formData = new FormData();

			formData.append("action", "mainwp_seopress_titles_meta_toggle");
			formData.append("__nonce", mainWPSEOPress.proPageToggleNonce);

			let feature = "";

			if ($this.parents(".mainwp-seopress-pro-dashboard-toggles").length) {
				feature = $this.val();
			} else {
				feature = $this.attr("name");
			}

			formData.append("feature", feature);

			const $selectedSites = $(
				"#mainwp-select-sites-list input[type=checkbox]:checked"
			);

			if ($selectedSites.length) {
				$selectedSites.each(function () {
					formData.append("selected_sites[]", $(this).val());
				});
			}

			$.ajax({
				url: ajaxurl,
				type: "POST",
				data: formData,
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function () {
					$messageBox.html("");
					$messageBox.hide();
					$messageBox.removeClass("red").removeClass("green");
				},
				success: function (response) {
					if (response.success) {
						$messageBox.html(response.data);
						$messageBox.addClass("green");
						$messageBox.show();
						if (originalProToggleFeatureCheck[$this.attr("name")]) {
							$this.prop("checked", false);
						} else {
							$this.prop("checked", true);
						}
						originalProToggleFeatureCheck[$this.attr("name")] =
							!originalProToggleFeatureCheck[$this.attr("name")];
						proToggleLabel();
					}
				},
				error: function (xhr, status, error) {
					const message = xhr.responseJSON.data;
					$messageBox.html(message);
					$messageBox.addClass("red");
					$messageBox.show();
					if (originalToggleFeatureCheck) {
						$this.prop("checked", true);
					} else {
						$this.prop("checked", false);
					}
				},
			});
		});

		$(
			".mainwp-seopress-toggle-feature, .mainwp-seopress-dashboard-toggles input[type=checkbox]"
		).on("change", function () {
			const $this = $(this);

			originalToggleFeatureCheck = !$(this).is(":checked");

			const formData = new FormData();

			formData.append("action", "mainwp_seopress_titles_meta_toggle");
			formData.append("__nonce", $(this).data("nonce"));
			formData.append("feature", $(this).val());

			const $selectedSites = $(
				"#mainwp-select-sites-list input[type=checkbox]:checked"
			);

			if ($selectedSites.length) {
				$selectedSites.each(function () {
					formData.append("selected_sites[]", $(this).val());
				});
			}

			$.ajax({
				url: ajaxurl,
				type: "POST",
				data: formData,
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function () {
					$messageBox.html("");
					$messageBox.hide();
					$messageBox.removeClass("red").removeClass("green");
				},
				success: function (response) {
					if (response.success) {
						$messageBox.html(response.data);
						$messageBox.addClass("green");
						$messageBox.show();
						if (originalToggleFeatureCheck) {
							$this.prop("checked", false);
							$this.parents("ui.checkbox").removeClass("checked");
							originalToggleFeatureCheck = false;
							$this.checkbox();
						} else {
							$this.prop("checked", true);
							$this.parents("ui.checkbox").addClass("checked");
							originalToggleFeatureCheck = true;
							$this.checkbox();
						}
					}
				},
				error: function (xhr, status, error) {
					const message = xhr.responseJSON.data;
					$messageBox.html(message);
					$messageBox.addClass("red");
					$messageBox.show();
					if (originalToggleFeatureCheck) {
						$this.parents("ui.checkbox").addClass("checked");
						$this.prop("checked", true);
					} else {
						$this.prop("checked", false);
						$this.parents("ui.checkbox").removeClass("checked");
					}
				},
			});
		});

		$(".mainwp-seoress-toggle-export-import-form").on("click", function (e) {
			e.preventDefault();
			$messageBox.html("");
			$messageBox.hide();
			$messageBox.removeClass("red").removeClass("green");
			$exportSettingsTextArea.val("");

			const formArea = "#" + $(this).attr("id") + "-area";
			if (
				formArea == "#mainwp-seopress-show-export-form-area" &&
				$(formArea).css("display") == "none"
			) {
				$(formArea).css("display", "block");
				$(this).removeClass("basic");
				$("#mainwp-seopress-show-import-form-area").css("display", "none");
				$("#mainwp-seopress-show-import-form").addClass("basic");
			} else if (
				formArea == "#mainwp-seopress-show-import-form-area" &&
				$(formArea).css("display") == "none"
			) {
				$(formArea).css("display", "block");
				$(this).removeClass("basic");
				$("#mainwp-seopress-show-export-form-area").css("display", "none");
				$("#mainwp-seopress-show-export-form").addClass("basic");
			} else {
				$(formArea).css("display", "none");
				$(this).addClass("basic");
			}
		});

		$(
			"#mainwp-seopress-export-settings-form, #mainwp-seopress-import-settings-form"
		).on("submit", function (e) {
			e.preventDefault();

			const $submitButton = $(this).find("button[type=submit]");

			const formData = new FormData($(this)[0]);

			const $this = $(this);

			$.ajax({
				url: ajaxurl,
				type: "POST",
				data: formData,
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function () {
					if ($this.attr("id") === "mainwp-seopress-export-settings-form") {
						$exportSettingsTextArea.val("");
					}
					$messageBox.html("");
					$messageBox.hide();
					$messageBox.removeClass("red").removeClass("green");
					$submitButton.prop("disabled", true);
				},
				success: function (response) {
					if (response.success) {
						if ($this.attr("id") === "mainwp-seopress-export-settings-form") {
							$exportSettingsTextArea.val(
								JSON.stringify(response.data.settings, null, "  ")
							);
						} else {
							$("#mainwp-seopress-imported-settings").val("");
							setTimeout(function () {
								window.location.reload();
							}, 1000);
						}
						$messageBox.html(response.data.message);
						$messageBox.addClass("green");
						$messageBox.show();
					}

					$submitButton.prop("disabled", false);
				},
				error: function (xhr, status, error) {
					const message = xhr.responseJSON.data;
					$submitButton.prop("disabled", false);
					$messageBox.html(message);
					$messageBox.addClass("red");
					$messageBox.show();
				},
			});
		});

		$("#mainwp-seopress-load-settings-button").on("click", function (e) {
			e.preventDefault();

			const formData = new FormData();

			const $selectedSites = $(
				"#mainwp-select-sites-list input[type=checkbox]:checked"
			);

			if ($selectedSites.length !== 1) {
				$messageBox.html(mainWPSEOPress.selectOneSiteMessage);
				$messageBox.addClass("red");
				$messageBox.show();
				return;
			}

			formData.append("action", "mainwp_seopress_load_site_settings");
			formData.append("__nonce", mainWPSEOPress.wpLoadSiteSettingsNonce);

			if ($selectedSites.length) {
				formData.append("selected_site", $($selectedSites[0]).val());
			}

			const $this = $(this);

			$.ajax({
				url: ajaxurl,
				type: "POST",
				data: formData,
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function () {
					$messageBox.html("");
					$messageBox.hide();
					$messageBox.removeClass("red").removeClass("green");
					$this.prop("disabled", true);
				},
				success: function (response) {
					if (response.success) {
						$messageBox.html(response.data);
						$messageBox.addClass("green");
						$messageBox.show();
						setTimeout(function () {
							$messageBox.html("");
							$messageBox.hide();
							$messageBox.removeClass("red").removeClass("green");
							location.reload();
						}, 2000);
					}

					$this.prop("disabled", false);
				},
				error: function (xhr, status, error) {
					const message = xhr.responseJSON.data;
					$this.prop("disabled", false);
					$messageBox.html(message);
					$messageBox.addClass("red");
					$messageBox.show();
				},
			});
		});

		const $settingsSubmitButton = $(
			".mainwp-select-sites #mainwp-seopress-apply-changes-button"
		);

		$settingsSubmitButton.on("click", function (e) {
			e.preventDefault();
			$(".mainwp-seopress-settings-form").submit();
		});

		$(".mainwp-seopress-settings-form").on("submit", function (e) {
			e.preventDefault();

			const formData = new FormData($(this)[0]);

			const $selectedSites = $(
				"#mainwp-select-sites-list input[type=checkbox]:checked"
			);

			if ($selectedSites.length) {
				$selectedSites.each(function () {
					formData.append("selected_sites[]", $(this).val());
				});
			}

			const $this = $(this);

			$.ajax({
				url: ajaxurl,
				type: "POST",
				data: formData,
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function () {
					$messageBox.html("");
					$messageBox.hide();
					$messageBox.removeClass("red").removeClass("green");
					$settingsSubmitButton.prop("disabled", true);
				},
				success: function (response) {
					if (response.success) {
						$messageBox.html(response.data.message);
						$messageBox.addClass("green");
						$messageBox.show();
					}

					$settingsSubmitButton.prop("disabled", false);
				},
				error: function (xhr, status, error) {
					const message = xhr.responseJSON.data;
					$settingsSubmitButton.prop("disabled", false);
					$messageBox.html(message);
					$messageBox.addClass("red");
					$messageBox.show();
				},
			});
		});

		$(document).on(
			"click",
			"#seopress-flush-permalinks.ui.green.button, #seopress-flush-permalinks2.ui.green.button",
			function (e) {
				e.preventDefault();

				const formData = new FormData();

				formData.append("action", "mainwp_seopress_flush_rewrite_rules");
				formData.append("__nonce", mainWPSEOPress.wpFlushRulesNonce);

				const $selectedSites = $(
					"#mainwp-select-sites-list input[type=checkbox]:checked"
				);

				if ($selectedSites.length) {
					$selectedSites.each(function () {
						formData.append("selected_sites[]", $(this).val());
					});
				}

				const $this = $(this);

				const originalText = $this.text();

				$.ajax({
					url: ajaxurl,
					type: "POST",
					data: formData,
					contentType: false,
					cache: false,
					processData: false,
					beforeSend: function () {
						$messageBox.html("");
						$messageBox.hide();
						$messageBox.removeClass("red").removeClass("green");
						$this.prop("disabled", true);
						$this.text(mainWPSEOPress.flushRulesButtonLoadingText);
					},
					success: function (response) {
						if (response.success) {
							$messageBox.html(response.data.message);
							$messageBox.addClass("green");
							$messageBox.show();
						}

						$this.prop("disabled", false);
						$this.text(originalText);
						$("html, body").animate({ scrollTop: 0 }, "fast");
					},
					error: function (xhr, status, error) {
						const message = xhr.responseJSON.data;
						$this.prop("disabled", false);
						$this.text(originalText);
						$messageBox.html(message);
						$messageBox.addClass("red");
						$messageBox.show();
						$("html, body").animate({ scrollTop: 0 }, "fast");
					},
				});
			}
		);

		$(document).on(
			"click",
			"#seopress_pro_license_reset.ui.green.button",
			function (e) {
				e.preventDefault();

				const formData = new FormData();

				formData.append("action", "mainwp_seopress_reset_pro_licence");
				formData.append("__nonce", mainWPSEOPress.resetLicenceKeyNonce);

				const $selectedSites = $(
					"#mainwp-select-sites-list input[type=checkbox]:checked"
				);

				if ($selectedSites.length) {
					$selectedSites.each(function () {
						formData.append("selected_sites[]", $(this).val());
					});
				}

				const $this = $(this);

				const originalText = $this.text();

				$.ajax({
					url: ajaxurl,
					type: "POST",
					data: formData,
					contentType: false,
					cache: false,
					processData: false,
					beforeSend: function () {
						$messageBox.html("");
						$messageBox.hide();
						$messageBox.removeClass("red").removeClass("green");
						$this.prop("disabled", true);
						$this.text(mainWPSEOPress.resetLicenceLoadingText);
					},
					success: function (response) {
						if (response.success) {
							$messageBox.html(response.data.message);
							$messageBox.addClass("green");
							$messageBox.show();
						}

						$this.prop("disabled", false);
						$this.text(originalText);
						$("html, body").animate({ scrollTop: 0 }, "fast");
					},
					error: function (xhr, status, error) {
						const message = xhr.responseJSON.data;
						$this.prop("disabled", false);
						$this.text(originalText);
						$messageBox.html(message);
						$messageBox.addClass("red");
						$messageBox.show();
						$("html, body").animate({ scrollTop: 0 }, "fast");
					},
				});
			}
		);

		const beautifyMenuContent = function () {
			$(".seopress-notice:not(.is-error)")
				.addClass("ui ignored info message")
				.removeClass("seopress-notice");

			$(".seopress-notice.is-error")
				.addClass("ui ignored negative message")
				.removeClass("seopress-notice")
				.removeClass("is-error");

			$(
				"#mainwp-seopress-titles-tabs-content #mainwp-seopress-titles-home .form-table td"
			).addClass("ui input");

			$(
				"#mainwp-seopress-titles-tabs-content #mainwp-seopress-titles-archives .form-table td input[type=text]"
			).wrap('<div class="ui input fluid"></div>');

			$(
				"#mainwp-seopress-titles-tabs-content #mainwp-seopress-titles-archives .form-table td textarea"
			).wrap('<div class="ui input fluid"></div>');
			$(
				"#mainwp-seopress-titles-tabs-content #mainwp-seopress-pro-robots-txt .form-table td textarea"
			).wrap('<div class="ui input fluid"></div>');
			$(
				"#mainwp-seopress-titles-tabs-content #mainwp-seopress-pro-htaccess .form-table td textarea"
			).wrap('<div class="ui input fluid"></div>');
			$(
				"#mainwp-seopress-titles-tabs-content #mainwp-seopress-pro-rss .form-table td textarea"
			).wrap('<div class="ui input fluid"></div>');
			$(
				"#mainwp-seopress-titles-tabs-content #mainwp-seopress-pro-google-inspect-url .form-table td textarea"
			).wrap('<div class="ui input fluid"></div>');

			$(
				"#mainwp-seopress-titles-tabs-content #mainwp-seopress-titles-taxonomies .form-table td input[type=text]"
			).wrap('<div class="ui input fluid"></div>');

			$(
				"#mainwp-seopress-titles-tabs-content #mainwp-seopress-titles-taxonomies .form-table td textarea"
			).wrap('<div class="ui input fluid"></div>');

			$(
				"#mainwp-seopress-titles-tabs-content td .seopress_wrap_single_cpt"
			).addClass("ui input");

			$(
				"#mainwp-seopress-titles-tabs-content #mainwp-seopress-titles-home .form-table td p.description"
			).addClass("ui label tag");

			$(
				"#mainwp-seopress-titles-tabs-content #mainwp-seopress-titles-post-types p.description"
			).addClass("ui label");

			$(".mainwp-seopress-analytics-content p.description").addClass(
				"ui label"
			);

			$(".mainwp-seopress-instant-indexing-content p.description").addClass(
				"ui label"
			);

			$(".mainwp-seopress-advanced-content p.description").addClass("ui label");
			$(".mainwp-seopress-pro-content p.description").addClass("ui label");

			$("#mainwp-seopress-titles-tabs-content .form-table .btn").addClass(
				"ui button basic green"
			);
			$("#mainwp-seopress-titles-tabs-content .btn.btnSecondary").addClass(
				"ui button basic green"
			);
			$("#mainwp-seopress-titles-tabs-content .btn.btnPrimary").addClass(
				"ui button green"
			);

			$(".mainwp-seopress-tab-content div:not(.ui.message) .seopress-help")
				.next()
				.find("a")
				.addClass("ui button basic green");
			$(".mainwp-seopress-tab-content .seopress-help")
				.next()
				.find("button")
				.addClass("ui button basic green");

			$(".seopress-tag-dropdown").on("click", function (e) {
				e.preventDefault();

				$(this).next().toggle();
				$(this).toggleClass("basic");
			});

			$("#mainwp-seopressxml-html-sitemap-tabs-content .form-table input[type=text]"
			).wrap("<div class='ui input fluid'></div>");
			$(
				"#mainwp-seopress-pro-local-business .form-table input[type=text]"
			).wrap("<div class='ui input fluid'></div>");
			$("#mainwp-seopress-pro-structured-data-types .form-table input[type=text]"
			).wrap("<div class='ui input fluid'></div>");
			$("#mainwp-seopress-pro-breadcrumbs .form-table input[type=text]").wrap(
				"<div class='ui input fluid'></div>"
			);
			$("#mainwp-seopress-pro-pagespeed-insights .form-table input[type=text]"
			).wrap("<div class='ui input fluid'></div>");
			$("#mainwp-seopress-pro-google-news .form-table input[type=text]").wrap(
				"<div class='ui input fluid'></div>"
			);
			$("#mainwp-seopress-pro-url-rewriting .form-table input[type=text]").wrap(
				"<div class='ui input fluid'></div>"
			);
			$("#mainwp-seopress-pro-white-label .form-table input[type=text]").wrap(
				"<div class='ui input fluid'></div>"
			);
			$("#mainwp-seopressxml-html-sitemap-tabs-content .form-table select"
			).wrap("<div class='ui form'><div class='field fluid'></div></div>");

			$("#mainwp-seopress-pro-local-business .form-table select").wrap(
				"<div class='ui form'><div class='field fluid'></div></div>"
			);
			$("#mainwp-seopress-pro-ai .form-table input[type=password]").wrap(
				"<div class='ui input fluid'></div>"
			);
			$("#mainwp-seopress-pro-ai .form-table input[type=text]").wrap(
				"<div class='ui input fluid'></div>"
			);
			$("#mainwp-seopress-pro-ai .form-table select").wrap(
				"<div class='ui form'><div class='field fluid'></div></div>"
			);
			$("#mainwp-seopress-pro-structured-data-types .form-table select").wrap(
				"<div class='ui form'><div class='field fluid'></div></div>"
			);
			$("#mainwp-seopress-pro-breadcrumbs .form-table select").wrap(
				"<div class='ui form'><div class='field fluid'></div></div>"
			);
			$("#mainwp-seopress-pro-redirections-404 .form-table select").wrap(
				"<div class='ui form'><div class='field fluid'></div></div>"
			);
			$("#mainwp-seopress-pro-redirections-404 .form-table input[type=text]"
			).wrap("<div class='ui input fluid'></div>");

			$(".mainwp-seopress-social-networks-content .form-table input[type=text]"
			).wrap("<div class='ui input fluid'></div>");

			$(".mainwp-seopress-social-networks-content .form-table select").wrap(
				"<div class='ui form'><div class='field fluid'></div></div>"
			);

			$(".mainwp-seopress-analytics-content .form-table input[type=text]").wrap(
				"<div class='ui input fluid'></div>"
			);

			$(".mainwp-seopress-analytics-content .form-table input[type=number]"
			).wrap("<div class='ui input fluid'></div>");

			$(".mainwp-seopress-analytics-content .form-table select").wrap(
				"<div class='ui form'><div class='field fluid'></div></div>"
			);

			$(".mainwp-seopress-analytics-content .form-table textarea").wrap(
				"<div class='ui input fluid'></div>"
			);

			$(".mainwp-seopress-instant-indexing-content .form-table input[type=text]"
			).wrap("<div class='ui input fluid'></div>");

			$(".mainwp-seopress-instant-indexing-content .form-table select").wrap(
				"<div class='ui form'><div class='field fluid'></div></div>"
			);

			$(".mainwp-seopress-instant-indexing-content .form-table textarea").wrap(
				"<div class='ui input fluid'></div>"
			);

			$(".mainwp-seopress-advanced-content .form-table input[type=text]").wrap(
				"<div class='ui input fluid'></div>"
			);

			$(".mainwp-seopress-advanced-content .form-table select").wrap(
				"<div class='ui form'><div class='field fluid'></div></div>"
			);

			$("#mainwp-seopress-analytics-stats-in-dashboard > form > table tr")
				.first()
				.remove();
			$("#mainwp-seopress-analytics-stats-in-dashboard > form > table tr")
				.first()
				.remove();
			$("#mainwp-seopress-analytics-stats-in-dashboard > form > table tr")
				.first()
				.remove();
			$(
				"#mainwp-seopress-pro-structured-data-types > table tr:nth-child(3)"
			).remove();
			$(
				"#mainwp-seopress-pro-structured-data-types a[href*='post_type=seopress_schemas']"
			).remove();

			$("#seopress_social_knowledge_img_upload").next().remove();
			$("#seopress_social_knowledge_img_upload").remove();
			$("#seopress_social_fb_img_upload").next().remove();
			$("#seopress_social_fb_img_upload").remove();
			$("#seopress_social_twitter_img_upload").next().remove();
			$("#seopress_social_twitter_img_upload").remove();
			$("#seopress_social_facebook_img_upload").remove();
			$("#seopress_rich_snippets_publisher_logo_upload").remove();

			$(
				"#mainwp-seopress-titles-tabs-content .mainwp-seopress-tab-content:not(#mainwp-seopress-titles-post-types):not(#mainwp-seopress-titles-taxonomies) .tag-title:not(.seopress-tag-dropdown)"
			).on("click", function () {
				let $el = $(this).parent().prev().find("input[type=text]");

				if (!$el.length) {
					$el = $(this).parent().prev().parent().find("textarea");
				}

				if (!$el.length) {
					$el = $(this).parent().prev().parent().find("input[type=text]");
				}

				if (!$el.length) {
					$el = $(this).parent().prev().parent().find("textarea");
				}

				if (!$el.length) {
					$el = $(this).parent().prev().closest("input[type=text]");
				}

				if (!$el.length) {
					$el = $(this).parent().prev().closest("textarea");
				}

				if (!$el.length) {
					$el = $(this).parent().prev();
				}

				if ("seopress_robots_file" == $el.attr("id")) {
					$el.val($el.val() + $(this).attr("data-tag") + "\n");
				} else {
					$el.val($el.val() + $(this).attr("data-tag"));
				}
			});

			$(
				"#mainwp-seopress-titles-tabs-content .mainwp-seopress-tab-content .sp-tag-variables-list li"
			).on("click", function () {
				let $el = $(this)
					.parents(".sp-wrap-tag-variables-list")
					.parent()
					.prev()
					.find("input[type=text]");

				if (!$el.length) {
					$el = $(this)
						.parents(".sp-wrap-tag-variables-list")
						.parent()
						.prev()
						.find("textarea");
				}

				if (!$el.length) {
					$el = $(this)
						.parents(".sp-wrap-tag-variables-list")
						.parent()
						.prev()
						.parent()
						.find("input[type=text]");
				}

				if (!$el.length) {
					$el = $(this)
						.parents(".sp-wrap-tag-variables-list")
						.parent()
						.prev()
						.parent()
						.find("textarea");
				}

				if (!$el.length) {
					$el = $(this)
						.parents(".sp-wrap-tag-variables-list")
						.parent()
						.prev()
						.closest("input[type=text]");
				}

				if (!$el.length) {
					$el = $(this)
						.parents(".sp-wrap-tag-variables-list")
						.parent()
						.prev()
						.closest("textarea");
				}

				if (!$el.length) {
					$el = $(this).parents(".sp-wrap-tag-variables-list").parent().prev();
				}

				$el.val($el.val() + $(this).attr("data-value"));
			});

			$(document).find("input[type=checkbox].toggle").removeClass("toggle");
		};

		beautifyMenuContent();

		if ($("#seopress_instant_indexing_manual_batch").length) {
			newLines = $("#seopress_instant_indexing_manual_batch")
				.val()
				.split("\n").length;
			$("#seopress_instant_indexing_url_count").text(newLines);
			var lines = 50;
			var linesUsed = $("#seopress_instant_indexing_url_count");

			if (newLines) {
				var progress = Math.round((newLines / 50) * 100);

				if (progress >= 100) {
					progress = 100;
				}

				$("#seopress_instant_indexing_url_progress").attr(
					"aria-valuenow",
					progress
				),
					$("#seopress_instant_indexing_url_progress").text(progress + "%"),
					$("#seopress_instant_indexing_url_progress").css(
						"width",
						progress + "%"
					);
			}

			$("#seopress_instant_indexing_manual_batch").on(
				"keyup paste change click focus mouseout",
				function (e) {
					newLines = $(this).val().split("\n").length;
					linesUsed.text(newLines);

					if (newLines > lines) {
						linesUsed.css("color", "red");
					} else {
						linesUsed.css("color", "");
					}

					if (newLines) {
						var progress = Math.round((newLines / 50) * 100);
					}

					if (progress >= 100) {
						progress = 100;
					}
					$("#seopress_instant_indexing_url_progress").attr(
						"aria-valuenow",
						progress
					),
						$("#seopress_instant_indexing_url_progress").text(progress + "%"),
						$("#seopress_instant_indexing_url_progress").css(
							"width",
							progress + "%"
						);
				}
			);
		}

		$("#seopress_instant_indexing_google_action_include[URL_UPDATED]").is(
			":checked"
		)
			? true
			: false,
			//Instant Indexing: Batch URLs
			$(".seopress-instant-indexing-batch").on("click", function () {
				$("#seopress-tabs .spinner").css("visibility", "visible");
				$("#seopress-tabs .spinner").css("float", "none");

				$.ajax({
					method: "POST",
					url: ajaxurl,
					data: {
						action: "seopress_instant_indexing_post",
						urls_to_submit: $("#seopress_instant_indexing_manual_batch").val(),
						indexnow_api: $("#seopress_instant_indexing_bing_api_key").val(),
						google_api: $("#seopress_instant_indexing_google_api_key").val(),
						update_action: $(
							"#seopress_instant_indexing_google_action_include_URL_UPDATED"
						).is(":checked")
							? "URL_UPDATED"
							: false,
						delete_action: $(
							"#seopress_instant_indexing_google_action_include_URL_DELETED"
						).is(":checked")
							? "URL_DELETED"
							: false,
						google: $("#seopress_instant_indexing_engines_google").is(
							":checked"
						)
							? true
							: false,
						bing: $("#seopress_instant_indexing_engines_bing").is(":checked")
							? true
							: false,
						automatic_submission: $(
							"#seopress_instant_indexing_automate_submission"
						).is(":checked")
							? true
							: false,
						_ajax_nonce: mainWPSEOPress.seopress_nonce,
					},
					success: function (data) {
						window.location.reload(true);
					},
				});
			});

		//Rich Snippets Media Uploader
		var mediaUploader;
		$("#seopress_rich_snippets_publisher_logo_upload").click(function (e) {
			e.preventDefault();
			// If the uploader object has already been created, reopen the dialog
			if (mediaUploader) {
				mediaUploader.open();
				return;
			}
			// Extend the wp.media object
			mediaUploader = wp.media.frames.file_frame = wp.media({
				multiple: false,
			});

			// When a file is selected, grab the URL and set it as the text field's value
			mediaUploader.on("select", function () {
				attachment = mediaUploader.state().get("selection").first().toJSON();
				$("#seopress_rich_snippets_publisher_logo_meta").val(attachment.url);
				$("#seopress_rich_snippets_publisher_logo_width").val(attachment.width);
				$("#seopress_rich_snippets_publisher_logo_height").val(
					attachment.height
				);
			});
			// Open the uploader dialog
			mediaUploader.open();
		});
	});
})(jQuery);
