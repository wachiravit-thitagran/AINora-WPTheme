<?php
/**
 * Template Name: เข้าสู่ระบบ / สมัครเรียน (Auth)
 *
 * Branded sign-in / sign-up page. Uses WordPress' native login flow and, when
 * Tutor LMS is active, its student registration form — so submissions work
 * without any extra nightbing.
 *
 * @package Nora_Learn
 */

defined( 'ABSPATH' ) || exit;

// Where to send the learner after authenticating: the Tutor dashboard if
// available, otherwise the homepage.
$nora_dashboard = home_url( '/' );
if ( function_exists( 'tutor_utils' ) ) {
	$dash = tutor_utils()->get_tutor_dashboard_page_permalink();
	if ( $dash ) {
		$nora_dashboard = $dash;
	}
}

$nora_has_tutor   = function_exists( 'nora_learn_has_tutor_lms' ) ? nora_learn_has_tutor_lms() : function_exists( 'tutor' );
$nora_can_register = $nora_has_tutor || (bool) get_option( 'users_can_register' );

// Default tab: login, unless ?tab=register is explicitly requested and registration is enabled.
$nora_default_tab = ( isset( $_GET['tab'] ) && 'register' === $_GET['tab'] && $nora_can_register ) ? 'register' : 'login'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

// Where to send the learner after login: an explicit ?redirect_to (e.g. when
// sent here from a gated lesson) wins, otherwise the dashboard.
$nora_redirect = isset( $_GET['redirect_to'] ) ? esc_url_raw( wp_unslash( $_GET['redirect_to'] ) ) : $nora_dashboard; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

// Optional auth shortcode from a login/registration plugin, set at Appearance →
// Customize → ตั้งค่า Nora Learn → หน้าเข้าสู่ระบบ. When present it replaces the
// theme's built-in login/register forms — so a plugin can be dropped in without
// editing the parent theme, and the value (a theme mod in the database) survives
// theme updates. Developers can override it via the nora_learn_auth_shortcode filter.
$nora_auth_shortcode = trim( (string) apply_filters( 'nora_learn_auth_shortcode', get_theme_mod( 'nora_learn_auth_shortcode', '' ) ) );

get_header();

while ( have_posts() ) :
	the_post();
	?>

	<main id="main" class="relative overflow-hidden">

		<?php
		$nora_content = get_the_content();
		$nora_is_elementor = isset( $_GET['elementor-preview'] ) || ( class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->preview->is_preview_mode() );
		if ( trim( $nora_content ) || $nora_is_elementor ) :
			?>
			<div class="container-nora mt-8">
				<div class="prose-nora mx-auto"><?php the_content(); ?></div>
			</div>
		<?php endif; ?>
	<section class="container-nora grid min-h-[70vh] items-stretch gap-0 py-12 lg:grid-cols-2 lg:py-16">

		<!-- Brand panel -->
		<div class="dashboard-hero hidden flex-col justify-between rounded-l-3xl rounded-r-none lg:flex">
			<div>
				<span class="inline-flex items-center gap-2 rounded-lg bg-white px-2 py-1 shadow-soft">
					<img src="<?php echo esc_url( NORA_LEARN_URI . '/assets/images/brand-logo.png' ); ?>" alt="<?php echo esc_attr( 'AINORA × PSU — ' . get_bloginfo( 'name' ) ); ?>" width="642" height="160" class="h-10 w-auto" />
				</span>
				<h1 class="dashboard-hero__title mt-8 max-w-sm leading-snug">
					<?php echo wp_kses_post( __( 'เรียนรู้ มรดกมโนราห์<br>ในยุค ดิจิทัล', 'nora-learn' ) ); ?>
				</h1>
			</div>
			<ul class="mt-10 space-y-3 text-sm text-white/90">
				<?php
				$nora_benefits = array(
					__( 'คอร์สเรียนออนไลน์ฟรี เปิดให้ทุกคน', 'nora-learn' ),
					__( 'เรียนได้ทุกที่ทุกเวลา ตามจังหวะของคุณ', 'nora-learn' ),
					__( 'ทำบทเรียนครบ รับเกียรติบัตรยืนยันการเรียนรู้', 'nora-learn' ),
				);
				foreach ( $nora_benefits as $nora_benefit ) :
					?>
					<li class="flex items-center gap-3">
						<span class="grid h-6 w-6 shrink-0 place-items-center rounded-full bg-white/15 text-gold-light"><?php echo nora_learn_icon( 'check', 'h-4 w-4' ); // phpcs:ignore ?></span>
						<?php echo esc_html( $nora_benefit ); ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<!-- Form panel -->
		<div class="flex flex-col justify-start rounded-3xl border border-paper-200 bg-white p-6 shadow-card sm:p-10 lg:rounded-l-none">

			<?php if ( '' !== $nora_auth_shortcode ) : ?>

				<div class="mx-auto w-full max-w-md">
					<?php
					/** Fires inside the auth form panel, before the Customizer auth shortcode. */
					do_action( 'nora_learn_before_auth_shortcode' );

					echo do_shortcode( $nora_auth_shortcode ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- shortcode output from a trusted plugin.

					/** Fires inside the auth form panel, after the Customizer auth shortcode. */
					do_action( 'nora_learn_after_auth_shortcode' );
					?>
				</div>

			<?php elseif ( is_user_logged_in() ) : ?>

				<?php $nora_user = wp_get_current_user(); ?>
				<div class="mx-auto w-full max-w-md text-center">
					<span class="mx-auto grid h-14 w-14 place-items-center rounded-full bg-success-light text-success"><?php echo nora_learn_icon( 'check', 'h-7 w-7' ); // phpcs:ignore ?></span>
					<h2 class="mt-5 font-sans text-2xl font-bold text-ink"><?php printf( esc_html__( 'เข้าสู่ระบบแล้ว สวัสดี %s', 'nora-learn' ), esc_html( $nora_user->display_name ) ); ?></h2>
					<p class="mt-2 text-ink-light"><?php esc_html_e( 'พร้อมเรียนรู้ต่อหรือยัง?', 'nora-learn' ); ?></p>
					<div class="mt-6 flex flex-col items-center gap-3 sm:flex-row sm:justify-center">
						<a href="<?php echo esc_url( $nora_dashboard ); ?>" class="btn-primary btn-lg"><?php esc_html_e( 'ไปที่แดชบอร์ดของฉัน', 'nora-learn' ); ?><?php echo nora_learn_icon( 'arrow', 'h-5 w-5' ); // phpcs:ignore ?></a>
						<a href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>" class="btn-ghost"><?php esc_html_e( 'ออกจากระบบ', 'nora-learn' ); ?></a>
					</div>
				</div>

			<?php else : ?>

				<style>
					/* Tab visibility is driven by the container's data-tab attribute, which
					   is set server-side and updated by Alpine on click. This keeps the
					   correct panel visible even if Alpine is delayed, blocked, or fails —
					   preventing both panels from rendering at once. */
					.nora-auth-tabs [data-auth-panel] { display: none; }
					.nora-auth-tabs[data-tab="login"] [data-auth-panel="login"] { display: block; }
					.nora-auth-tabs[data-tab="register"] [data-auth-panel="register"] { display: block; }
				</style>
				<div class="nora-auth-tabs mx-auto flex h-full w-full max-w-md flex-col"
					data-auth-tabs
					data-tab="<?php echo esc_attr( $nora_default_tab ); ?>"
					x-data="{ tab: '<?php echo esc_js( $nora_default_tab ); ?>' }"
					:data-tab="tab">

					<!-- Tabs -->
					<div class="grid grid-cols-2 gap-1 rounded-xl bg-paper-100 p-1">
						<button type="button" @click="tab = 'login'"
							class="rounded-lg px-4 py-2 text-sm font-semibold transition <?php echo $nora_can_register ? '' : 'col-span-2'; ?>"
							:class="tab === 'login' ? 'bg-white text-gold shadow-soft' : 'text-ink-light hover:text-ink'">
							<?php esc_html_e( 'เข้าสู่ระบบ', 'nora-learn' ); ?>
						</button>
						<?php if ( $nora_can_register ) : ?>
							<button type="button" @click="tab = 'register'"
								class="rounded-lg px-4 py-2 text-sm font-semibold transition"
								:class="tab === 'register' ? 'bg-white text-gold shadow-soft' : 'text-ink-light hover:text-ink'">
								<?php esc_html_e( 'สมัครเรียน', 'nora-learn' ); ?>
							</button>
						<?php endif; ?>
					</div>

					<div class="flex flex-1 flex-col justify-center">
						<!-- Login -->
						<div data-auth-panel="login" class="mt-7">
							<h2 class="font-sans text-2xl font-bold text-ink"><?php esc_html_e( 'เข้าสู่ระบบ', 'nora-learn' ); ?></h2>
							<p class="mt-1 text-sm text-ink-light"><?php esc_html_e( 'เข้าสู่ระบบเพื่อเรียนต่อและจัดการคอร์สของคุณ', 'nora-learn' ); ?></p>

							<div class="nora-auth-login mt-6">
								<?php
								$nora_pwd_disabled = false;
								if ( function_exists( '\Authorizenter\Core\authorizenter_core' ) ) {
									$adv = \Authorizenter\Core\authorizenter_core()->settings->get( 'advanced' );
									$nora_pwd_disabled = ! empty( $adv['disable_password_auth'] );
								}
								$nora_pwd_disabled = (bool) apply_filters( 'authorizenter_disable_password_auth', $nora_pwd_disabled );
								?>

								<?php if ( ! $nora_pwd_disabled ) : ?>
									<?php 
									wp_login_form( array(
										'redirect'       => $nora_redirect,
										'label_username' => __( 'ชื่อผู้ใช้ หรืออีเมล', 'nora-learn' ),
										'label_password' => __( 'รหัสผ่าน', 'nora-learn' ),
										'label_remember' => __( 'จดจำฉัน', 'nora-learn' ),
										'label_log_in'   => __( 'เข้าสู่ระบบ', 'nora-learn' ),
									) ); 
									?>
									<div class="mt-4 text-center sm:text-right">
										<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="text-sm font-semibold text-gold hover:underline"><?php esc_html_e( 'ลืมรหัสผ่าน?', 'nora-learn' ); ?></a>
									</div>
								<?php endif; ?>
								
								<?php if ( shortcode_exists( 'authorizenter_button' ) ) : ?>
									<?php if ( ! $nora_pwd_disabled ) : ?>
										<div class="my-6 flex items-center gap-3">
											<hr class="flex-1 border-paper-200">
											<span class="text-sm text-ink-light"><?php esc_html_e( 'หรือ', 'nora-learn' ); ?></span>
											<hr class="flex-1 border-paper-200">
										</div>
									<?php endif; ?>
									<div class="nora-auth-social">
										<?php 
										$nora_providers = array( 'google', 'facebook', 'line', 'oidc', 'oauth2' );
										foreach ( $nora_providers as $nora_provider ) {
											echo do_shortcode( sprintf( '[authorizenter_button context="default" provider="%s"]', $nora_provider ) );
										}
										?>
									</div>
								<?php endif; ?>
							</div>

							<?php if ( $nora_can_register ) : ?>
								<p class="mt-6 text-center text-sm text-ink-light">
									<?php esc_html_e( 'ยังไม่มีบัญชี?', 'nora-learn' ); ?>
									<button type="button" @click="tab = 'register'" class="font-semibold text-gold hover:underline"><?php esc_html_e( 'สมัครเรียนฟรี', 'nora-learn' ); ?></button>
								</p>
							<?php endif; ?>
						</div>

						<!-- Register -->
						<?php if ( $nora_can_register ) : ?>
							<div data-auth-panel="register" class="mt-7">
								<h2 class="font-sans text-2xl font-bold text-ink"><?php esc_html_e( 'สมัครเรียนฟรี', 'nora-learn' ); ?></h2>
								<p class="mt-1 text-sm text-ink-light"><?php esc_html_e( 'สร้างบัญชีเพื่อเข้าถึงคอร์สและบทเรียนทั้งหมด', 'nora-learn' ); ?></p>

								<div class="nora-auth-register mt-6">
									<?php if ( ! $nora_pwd_disabled ) : ?>
										<?php
										if ( $nora_has_tutor ) {
											// Tutor LMS student registration form (handles submission + validation).
											echo do_shortcode( '[tutor_student_registration_form]' );
										} else {
											// Native WordPress registration.
											?>
											<form method="post" action="<?php echo esc_url( wp_registration_url() ); ?>" class="space-y-4">
												<div>
													<label for="nora-user_login" class="field-label"><?php esc_html_e( 'ชื่อผู้ใช้', 'nora-learn' ); ?></label>
													<input id="nora-user_login" type="text" name="user_login" autocomplete="username" required class="field" />
												</div>
												<div>
													<label for="nora-user_email" class="field-label"><?php esc_html_e( 'อีเมล', 'nora-learn' ); ?></label>
													<input id="nora-user_email" type="email" name="user_email" autocomplete="email" required class="field" />
												</div>
												<p class="text-xs text-ink-light"><?php esc_html_e( 'ระบบจะส่งลิงก์ตั้งรหัสผ่านไปยังอีเมลของคุณ', 'nora-learn' ); ?></p>
												<button type="submit" class="btn-primary w-full"><?php esc_html_e( 'สมัครเรียน', 'nora-learn' ); ?></button>
											</form>
											<?php
										}
										?>
									<?php endif; ?>
									
									<?php if ( shortcode_exists( 'authorizenter_button' ) ) : ?>
										<?php if ( ! $nora_pwd_disabled ) : ?>
											<div class="my-6 flex items-center gap-3">
												<hr class="flex-1 border-paper-200">
												<span class="text-sm text-ink-light"><?php esc_html_e( 'หรือ', 'nora-learn' ); ?></span>
												<hr class="flex-1 border-paper-200">
											</div>
										<?php endif; ?>
										<div class="nora-auth-social">
											<?php 
											$nora_providers = array( 'google', 'facebook', 'line', 'oidc', 'oauth2' );
											foreach ( $nora_providers as $nora_provider ) {
												echo do_shortcode( sprintf( '[authorizenter_button context="default" provider="%s"]', $nora_provider ) );
											}
											?>
										</div>
									<?php endif; ?>
								</div>

								<p class="mt-6 text-center text-sm text-ink-light">
									<?php esc_html_e( 'มีบัญชีอยู่แล้ว?', 'nora-learn' ); ?>
									<button type="button" @click="tab = 'login'" class="font-semibold text-gold hover:underline"><?php esc_html_e( 'เข้าสู่ระบบ', 'nora-learn' ); ?></button>
								</p>
							</div>
						<?php endif; ?>
					</div>

				</div>

			<?php endif; ?>
		</div>
	</section>
</main>

<?php
endwhile;

get_footer();
