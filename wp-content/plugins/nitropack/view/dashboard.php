<?php
$settings = new \NitroPack\WordPress\Settings();
$notifications = new \NitroPack\WordPress\Notifications\Notifications();

$conflictingPlugins = \NitroPack\WordPress\ConflictingPlugins::getInstance();
$conflictingPlugins_list = $conflictingPlugins->nitropack_get_conflicting_plugins();
if ( $conflictingPlugins_list ) {
	require_once NITROPACK_PLUGIN_DIR . 'view/modals/modal-plugin-deactivate.php';
}

$notifications->nitropack_display_admin_notices();
$dismissed_notices = get_option( 'nitropack-dismissed-notices' );

$nitro = get_nitropack_sdk();
$cache_warmup_stats = $nitro->getApi()->getWarmupStats();
$cache_warmup_enabled = ! empty( $cache_warmup_stats['status'] ) && $cache_warmup_stats['status'] === 1 ? true : false;

if ( empty( $dismissed_notices['skip_cache_warmup'] ) && ! $cache_warmup_enabled ) : ?>
	<div class="card cache-warmup">
		<div class="progress-wrapper mb-4">
			<div class="progress-bar">
				<div class="progress" style="width: 100%;"></div>
			</div>
			<div class="step"><?php esc_html_e( 'Step', 'nitropack' ); ?> 3/3</div>
		</div>
		<div class="card-body">
			<h3><?php esc_html_e( 'Enable proactive optimizations', 'nitropack' ); ?>
			</h3>
			<p><?php esc_html_e( 'Turn on Cache Warmup so NitroPack can start optimizing your pages immediately, without waiting for traffic. This guarantees a fast site for every visitor right from the start.', 'nitropack' ); ?>
			</p>
		</div>
		<div class="card-footer">
			<button id="enable-cache-warmup"
				class="btn btn-primary"><?php esc_html_e( 'Enable Cache Warmup', 'nitropack' ); ?></button>
			<a id="skip-cache-warmup" class="btn btn-secondary ml-2"><?php esc_html_e( 'Skip', 'nitropack' ); ?></a>
		</div>
	</div>
<?php endif; ?>
<div class="grid grid-cols-2 gap-6 grid-col-1-tablet items-start nitropack-dashboard">
	<div class="col-span-1">
		<!-- Go to app Card -->
		<div class="card app-card">
			<div class="card-header">
				<h3><?php esc_html_e( 'Customize NitroPack\'s Optimization Settings in Your Account', 'nitropack' ); ?>
				</h3>
			</div>
			<div class="card-body">
				<div class="flex items-center justify-between">
					<div class="text-box">
						<p>
							<?php esc_html_e( 'You can further configure how NitroPack\'s optimization behaves through your account.', 'nitropack' ); ?>
						</p>
					</div>
					<?php
					function getNitropackDashboardUrl() {
						$siteId = nitropack_get_current_site_id();
						$dashboardUrl = 'https://app.nitropack.io/dashboard';

						if ( $siteId !== null ) {
							$dashboardUrl .= '?update_session_website_id=' . urlencode( $siteId );
						}

						return $dashboardUrl;
					}
					?>
					<a href="<?php echo esc_url( getNitropackDashboardUrl() ); ?>" target="_blank"
						class="btn btn-primary ml-2 flex-shrink-0"><?php esc_html_e( 'Go to app', 'nitropack' ); ?></a>
				</div>
			</div>
		</div>
		<!-- Go to app card End -->
		<!-- Optimized Pages Card -->
		<div class="card card-optimized-pages">
			<div class="card-header">
				<h3><?php esc_html_e( 'Optimized pages', 'nitropack' ); ?></h3>
				<div class="flex flex-row items-center" style="display: none;" id="pending-optimizations-section">
					<img src="<?php echo plugin_dir_url( __FILE__ ) . 'images/loading.svg'; ?>" alt="loading"
						class="w-4 h-4">
					<span class="ml-2 mr-1 text-primary"> <?php esc_html_e( 'Processing', 'nitropack' ); ?>
						<span id="pending-optimizations-count">X</span>
						<?php esc_html_e( 'page(s) in the background', 'nitropack' ); ?></span>
				</div>
			</div>
			<div class="card-body">
				<div class="card-body-inner">
					<div class="optimized-pages"><span data-optimized-pages-total>0</span></div>
					<div class="text-box">
						<div class="time-ago"><?php esc_html_e( 'Last cache purge', 'nitropack' ); ?>: <span
								data-last-cache-purge><?php esc_html_e( 'Never', 'nitropack' ); ?></span></div>
						<div class="reason"><?php esc_html_e( 'Reason', 'nitropack' ); ?>: <span
								data-purge-reason><?php esc_html_e( 'Unknown', 'nitropack' ); ?></span></div>
					</div>
					<button id="optimizations-purge-cache" type="button" class="btn btn-secondary"
						data-modal-target="modal-purge-cache"
						data-modal-toggle="modal-purge-cache"><?php esc_html_e( 'Purge cache', 'nitropack' ); ?></button>
				</div>
			</div>
			<?php require_once NITROPACK_PLUGIN_DIR . 'view/modals/modal-purge-cache.php'; ?>
		</div>
		<!-- Optimized Pages Card End -->
		<!-- Optimization Mode Card -->
		<?php $settings->optimization_level->render(); ?>
		<!-- Optimization Mode Card End -->
		<!-- Automated Behavior Card -->
		<div class="card card-automated-behavior">
			<div class="card-header">
				<h3><?php esc_html_e( 'Automated Behavior', 'nitropack' ); ?></h3>
			</div>
			<div class="card-body">
				<div class="options-container">
					<div class="nitro-option" id="purge-cache-widget">
						<div class="nitro-option-main">
							<div class="text-box">
								<h6><?php esc_html_e( 'Purge cache', 'nitropack' ); ?></h6>
								<p><?php esc_html_e( 'Purge affected cache when content is updated or published', 'nitropack' ); ?>
								</p>
							</div>
							<label class="inline-flex items-center cursor-pointer ml-auto">
								<input type="checkbox" value="" class="sr-only peer" name="purge_cache"
									id="auto-purge-status" <?php if ( $autoCachePurge )
										echo "checked"; ?>>
								<div class="toggle"></div>
							</label>
						</div>
					</div>
					<div class="nitro-option" id="page-optimization-widget">
						<div class="nitro-option-main">
							<div class="text-box">
								<h6><?php esc_html_e( 'Page optimization', 'nitropack' ); ?></h6>
								<p><?php esc_html_e( 'Select what post/page types get optimized', 'nitropack' ); ?></p>
							</div>
							<a data-modal-target="modal-posttypes" data-modal-toggle="modal-posttypes"
								class="btn btn-secondary btn-icon">
								<img src="<?php echo plugin_dir_url( __FILE__ ); ?>images/setting-icon.svg">
							</a>
						</div>
						<?php require_once NITROPACK_PLUGIN_DIR . 'view/modals/modal-posttypes.php'; ?>
					</div>
				</div>
			</div>
		</div>
		<!-- Automated Behavior Card End -->
		<!-- Go to app Card -->
		<div class="card exclusion-card">
			<div class="card-header">
				<h3><?php esc_html_e( 'Exclusions', 'nitropack' ); ?></h3>
			</div>
			<div class="card-body">
				<div class="options-container">
					<div class="nitro-option" id="ajax-shortcodes-widget">
						<?php $settings->shortcodes->render(); ?>
					</div>
				</div>
			</div>
		</div>
		<!-- Go to app card End -->
	</div>
	<div class="col-span-1">
		<!-- Subscription Card -->
		<?php $settings->subscription->render(); ?>

		<!-- Subscription Card End -->
		<!-- Basic Settings Card -->
		<div class="card card-basic-settings">
			<div class="card-header">
				<h3><?php esc_html_e( 'Basic Settings', 'nitropack' ); ?></h3>
			</div>
			<div class="card-body">
				<div class="options-container">

					<?php $settings->cache_warmup->render();
					$settings->test_mode->render(); ?>

					<div class="nitro-option" id="compression-widget">
						<div class="nitro-option-main">
							<div class="text-box">
								<h6><span
										id="detected-compression"><?php esc_html_e( 'HTML Compression', 'nitropack' ); ?>
									</span></h6>
								<p>
									<?php esc_html_e( 'Compressing the structure of your HTML, ensures faster page rendering and an optimized browsing experience for your users.', 'nitropack' ); ?>
									<a href="https://support.nitropack.io/en/articles/8390333-nitropack-plugin-settings-in-wordpress#h_29b7ab4836"
										class="text-blue"
										target="_blank"><?php esc_html_e( 'Learn more', 'nitropack' ); ?></a>
								</p>
							</div>
							<label class="inline-flex items-center cursor-pointer ml-auto">
								<input type="checkbox" id="compression-status" class="sr-only peer" <?php echo (int) $enableCompression === 1 ? "checked" : ""; ?>>
								<div class="toggle"></div>
							</label>
						</div>
						<div class="mt-4 text-primary">
							<a href="javascript:void(0);" id="compression-test-btn"
								class="text-primary"><?php esc_html_e( 'Run compression test', 'nitropack' ); ?></a>
							<div class="flex items-start msg-container hidden">
								<span class="msg"></span>
							</div>
						</div>
					</div>
					<?php if ( \NitroPack\Integration\Plugin\BeaverBuilder::isActive() ) { ?>
						<div class="nitro-option" id="beaver-builder-widget">
							<div class="nitro-option-main">
								<div class="text-box">
									<h6><span
											id="detected-compression"><?php esc_html_e( 'Sync NitroPack Purge with Beaver Builder', 'nitropack' ); ?>
										</span></h6>
									<p>
										<?php esc_html_e( 'When Beaver Builder cache is purged, NitroPack will perform a full cache purge keeping your site\'s content up-to-date.', 'nitropack' ); ?>
									</p>
								</div>
								<label class="inline-flex items-center cursor-pointer ml-auto">
									<input type="checkbox" class="sr-only peer" id="bb-purge-status" <?php if ( $bbCacheSyncPurge )
										echo "checked"; ?>>
									<div class="toggle"></div>
								</label>
							</div>
						</div>
					<?php } ?>
					<div class="nitro-option" id="can-editor-clear-cache-widget">
						<div class="nitro-option-main">
							<div class="text-box">
								<h6><?php esc_html_e( 'Allow Editors to purge cache', 'nitropack' ); ?></h6>
								<p><?php esc_html_e( 'Give Editors the right to purge cache when content is updated.', 'nitropack' ); ?>
								</p>
							</div>
							<label class="inline-flex items-center cursor-pointer ml-auto">
								<input type="checkbox" id="can-editor-clear-cache" class="sr-only peer" <?php echo (int) $canEditorClearCache === 1 ? "checked" : ""; ?>>
								<div class="toggle"></div>
							</label>
						</div>
					</div>
					<?php if ( nitropack_render_woocommerce_cart_cache_option() ) { ?>
						<div class="nitro-option" id="cart-cache-widget">
							<div class="nitro-option-main">
								<div class="text-box">
									<h6><?php esc_html_e( 'Cart cache', 'nitropack' ); ?></h6>
									<p>
										<?php esc_html_e( 'Your visitors will enjoy full site speed while browsing with items in cart. Fully optimized page cache will be served.', 'nitropack' ); ?>
									</p>

								</div>
								<label class="inline-flex items-center cursor-pointer ml-auto">
									<input type="checkbox" id="cart-cache-status" class="sr-only peer" <?php if ( nitropack_is_cart_cache_active() )
										echo "checked"; ?> 	<?php if ( ! nitropack_is_cart_cache_available() )
												   echo "disabled"; ?>>
									<div class="toggle"></div>
								</label>
							</div>
							<?php if ( ! nitropack_is_cart_cache_available() ) : ?>
								<div class="msg-container bg-success paid-msg">
									<p><svg width="20" height="20" viewBox="0 0 20 20" fill="none"
											xmlns="http://www.w3.org/2000/svg" class="text-success">
											<g clip-path="url(#clip0_1244_36215)">
												<path
													d="M10.0001 18.3333C14.6025 18.3333 18.3334 14.6023 18.3334 9.99996C18.3334 5.39759 14.6025 1.66663 10.0001 1.66663C5.39771 1.66663 1.66675 5.39759 1.66675 9.99996C1.66675 14.6023 5.39771 18.3333 10.0001 18.3333Z"
													stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
													stroke-linejoin="round"></path>
												<path d="M13.3334 9.99996L10.0001 6.66663L6.66675 9.99996" stroke="currentColor"
													stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
												<path d="M10 13.3333V6.66663" stroke="currentColor" stroke-width="1.5"
													stroke-linecap="round" stroke-linejoin="round"></path>
											</g>
											<defs>
												<clipPath id="clip0_1244_36215">
													<rect width="20" height="20" fill="white"></rect>
												</clipPath>
											</defs>
										</svg>
										<?php esc_html_e( 'This feature is available on Plus plan and above.', 'nitropack' ); ?>
										<a href="https://app.nitropack.io/subscription/buy" class="text-primary"
											target="_blank"><b><?php esc_html_e( 'Upgrade here', 'nitropack' ); ?></b></a>
									</p>
								</div>
							<?php endif; ?>
						</div>
						<div class="nitro-option" id="real-time-stock-refresh-widget">
							<div class="nitro-option-main">
								<div class="text-box">
									<h6><?php esc_html_e( 'Real-time Stock Refresh', 'nitropack' ); ?></h6>
									<p>
										<?php esc_html_e( 'Keep accurate product availability on your WooCommerce site. Turn on this feature if you display stock quantities, and enjoy automatic cache clearance when stock decreases.', 'nitropack' ); ?>
									</p>

								</div>
								<label class="inline-flex items-center cursor-pointer ml-auto">
									<input type="checkbox" id="woo-stock-reduce-status" class="sr-only peer" <?php echo (int) $stockReduceStatus === 1 ? "checked" : ""; ?>>
									<div class="toggle"></div>
								</label>
							</div>
						</div>
					<?php } ?>

				</div>
			</div>
			<div class="card-footer disconnect-container">
				<a class="text-primary btn-link"
					id="disconnect-btn"><?php esc_html_e( 'Disconnect NitroPack plugin', 'nitropack' ); ?></a>
				<?php require_once NITROPACK_PLUGIN_DIR . 'view/modals/modal-disconnect.php'; ?>
			</div>
		</div>
		<!-- Basic Settings Card End -->

	</div>
	<?php $notOptimizedCPTs = nitropack_filter_non_optimized();
	$notices = get_option( 'nitropack-dismissed-notices', [] );
	$optimizedCPT_notice = in_array( 'OptimizeCPT', $notices, true ) ? true : false;
	if ( ! $optimizedCPT_notice && ! empty( $notOptimizedCPTs ) )
		require_once NITROPACK_PLUGIN_DIR . 'view/modals/modal-not-optimized-CPT.php'; ?>

</div>
<?php require_once NITROPACK_PLUGIN_DIR . 'view/modals/modal-unsaved-changes.php'; ?>
<script>
	($ => {
		var getOptimizationsTimeout = null;
		let isClearing = false;
		var paid_plan = false;
		$(window).on("load", function () {
			getOptimizations();
			<?php if ( $checkedCompression != 1 ) { ?>
				autoDetectCompression();
			<?php } ?>
		});

		/* Cache Purge begin */
		window.performCachePurge = () => {
			purgeCache();
		}

		let purgeCache = () => {
			let purgeEvent = new Event("cache.purge.request");
			window.dispatchEvent(purgeEvent);
		}

		var getOptimizations = _ => {
			var url = '<?php echo $optimizationDetailsUrl; ?>';
			((s, e, f) => {
				if (window.fetch) {
					fetch(url)
						.then(resp => resp.json())
						.then(s)
						.catch(e)
						.finally(f);
				} else {
					$.ajax({
						url: url,
						type: 'GET',
						dataType: 'json',
						success: s,
						error: e,
						complete: f
					})
				}
			})(data => {
				$('[data-last-cache-purge]').text(data.last_cache_purge.timeAgo);
				if (data.last_cache_purge.reason) {
					$('[data-purge-reason]').text(data.last_cache_purge.reason);
					$('[data-purge-reason]').attr('title', data.last_cache_purge.reason);
					$('#last-cache-purge-reason').show();
				} else {
					$('#last-cache-purge-reason').hide();
				}
				if (data.pending_count) {
					$("#pending-optimizations-count").text(data.pending_count);
					$("#pending-optimizations-section").show();
				} else {
					$("#pending-optimizations-section").hide();
				}

				$('[data-optimized-pages-total]').text(data.optimized_pages.total);

			}, __ => {
				console.error("An error occurred while fetching data for optimized pages");
			}, __ => {
				if (!getOptimizationsTimeout) {
					getOptimizationsTimeout = setTimeout(function () {
						getOptimizationsTimeout = null;
						getOptimizations();
					}, 60000);
				}
			});
		}
		window.addEventListener("cache.invalidate.success", getOptimizations);
		if ($('#np-onstate-cache-purge').length) {
			window.addEventListener("cache.purge.success", function () { setTimeout(function () { document.cookie = "nitropack_apwarning=1; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=<?php echo nitropack_cookiepath(); ?>"; window.location.reload() }, 1500) });
		} else {
			window.addEventListener("cache.purge.success", getOptimizations);
		}

		$(document).on('click', "#compression-test-btn", e => {
			e.preventDefault();
			autoDetectCompression();
		});
		/* Compression end */

		/* HTML Compression begin */
		var autoDetectCompression = function () {
			let msg_container = $('#compression-widget .msg-container'),
				msg_icon = msg_container.find('.icon'),
				msg_box = msg_container.find('.msg'),
				compression_setting = $('#compression-status'),
				compression_btn = $('#compression-test-btn');
			//add spinner here
			msg_box.html('<img src="<?php echo plugin_dir_url( __FILE__ ) . 'images/loading.svg'; ?>" alt="loading" class="icon"> <?php esc_html_e( 'Testing current compression status', 'nitropack' ); ?>');
			compression_btn.addClass('hidden');
			msg_container.removeClass('hidden');
			$.post(ajaxurl, {
				action: 'nitropack_test_compression_ajax',
				nonce: nitroNonce
			}, function (response) {
				var resp = JSON.parse(response);

				if (resp.status == "success") {
					if (resp.hasCompression) { // compression already enabled
						compression_setting.attr("checked", false);

						msg_box.text('<?php esc_html_e( 'Compression is already enabled on your server! There is no need to enable it in NitroPack.', 'nitropack' ); ?>')
					} else {
						compression_setting.attr("checked", true);
						msg_box.text('<?php esc_html_e( 'No compression was detected! We will now enable it in NitroPack.', 'nitropack' ); ?>');
					}
					NitropackUI.triggerToast(resp.type, resp.message);
				} else {
					msg_box.text('<?php esc_html_e( 'Could not determine compression status automatically. Please configure it manually.', 'nitropack' ); ?>');
				}
				setTimeout(function () {
					msg_container.addClass('hidden');
					compression_btn.removeClass('hidden');
				}, 5000);
			});
		}


		$("#compression-status").on("click", function (e) {
			$.post(ajaxurl, {
				action: 'nitropack_set_compression_ajax',
				nonce: nitroNonce,
				data: {
					compressionStatus: $(this).is(":checked") ? 1 : 0
				}
			}, function (response) {
				var resp = JSON.parse(response);
				NitropackUI.triggerToast(resp.type, resp.message);
			});
		});
		$("#can-editor-clear-cache").on("click", function (e) {
			$.post(ajaxurl, {
				action: 'nitropack_set_can_editor_clear_cache',
				nonce: nitroNonce,
				data: {
					canEditorClearCache: $(this).is(":checked") ? 1 : 0
				}
			}, function (response) {
				var resp = JSON.parse(response);
				NitropackUI.triggerToast(resp.type, resp.message);
			});
		});

		$("#auto-purge-status").on("click", function (e) {
			$.post(ajaxurl, {
				action: 'nitropack_set_auto_cache_purge_ajax',
				nonce: nitroNonce,
				autoCachePurgeStatus: $(this).is(":checked") ? 1 : 0
			}, function (response) {
				var resp = JSON.parse(response);
				NitropackUI.triggerToast(resp.type, resp.message);
			});
		});

		$("#cart-cache-status").on("click", function (e) {
			$.post(ajaxurl, {
				action: 'nitropack_set_cart_cache_ajax',
				nonce: nitroNonce,
				cartCacheStatus: $(this).is(":checked") ? 1 : 0
			}, function (response) {
				var resp = JSON.parse(response);
				NitropackUI.triggerToast(resp.type, resp.message);
			});
		});


		$("#woo-stock-reduce-status").on("click", function (e) {
			$.post(ajaxurl, {
				action: 'nitropack_set_stock_reduce_status',
				nonce: nitroNonce,
				data: {
					stockReduceStatus: $(this).is(":checked") ? 1 : 0
				}
			}, function (response) {
				var resp = JSON.parse(response);
				NitropackUI.triggerToast(resp.type, resp.message);
			});
		});

		$("#bb-purge-status").on("click", function (e) {
			$.post(ajaxurl, {
				action: 'nitropack_set_bb_cache_purge_sync_ajax',
				nonce: nitroNonce,
				bbCachePurgeSyncStatus: $(this).is(":checked") ? 1 : 0
			}, function (response) {
				var resp = JSON.parse(response);
				NitropackUI.triggerToast(resp.type, resp.message);
			});
		});


	})(jQuery);
</script>