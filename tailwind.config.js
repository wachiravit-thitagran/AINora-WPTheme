/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './**/*.php',
    './src/js/**/*.js',
    './tutor/**/*.php',
    '!./node_modules/**',
    '!./vendor/**',
  ],
  // Safelist classes that may be injected dynamically by Tutor LMS / WP and
  // therefore not present in the static .php source scanned above.
  safelist: [
    'is-active',
    'screen-reader-text',
    { pattern: /^(bg|text|border)-(gold|night|paper)(-(50|100|200|300|400|500|600|700|800|900))?$/ },
    { pattern: /^(bg|text|border)-(success|warning|danger|info)(-(light|dark))?$/ },
    // Dashboard kit component classes — kept available even before they are
    // referenced in templates (see "Dashboard kit" in src/css/main.css).
    'pill', 'pill-success', 'pill-warning', 'pill-danger', 'pill-info', 'pill-gold',
    'stat-card', 'stat-card__num', 'stat-card__label',
    'icon-chip', 'icon-chip-gold', 'icon-chip-success', 'icon-chip-warning', 'icon-chip-info',
    'progress', 'progress__bar', 'progress__bar--success', 'progress__bar--warning', 'progress__bar--info',
    'dashboard-hero', 'dashboard-hero__title', 'dashboard-hero__subtitle',
  ],
  theme: {
    container: {
      center: true,
      padding: {
        DEFAULT: '1.25rem',
        sm: '1.5rem',
        lg: '2rem',
      },
      screens: {
        '2xl': '1200px',
      },
    },
    extend: {
      colors: {
        // Primary — heritage gold, sampled live from ainora.psu.ac.th
        // (#D4AF37 base, #b5952f hover, highlight gradient end #F9E076).
        gold: {
          50: '#fdf9ec',
          100: '#faf1d2',
          200: '#f5e3a5',
          300: '#f9e076',
          400: '#e4c455',
          500: '#d4af37',
          DEFAULT: '#d4af37',
          600: '#b5952f',
          700: '#8a6f24',
          800: '#6b561e',
          900: '#4a3b16',
          light: '#f9e076',
          dark: '#8a6f24',
        },
        // Dark night surface — headline ink / dark panels (ainora headline
        // colour = Tailwind gray-900 family).
        night: {
          DEFAULT: '#1f2937',
          700: '#374151',
          800: '#111827',
          900: '#030712',
        },
        // Neutral "paper" — ainora.psu.ac.th backgrounds (white page,
        // gray-50 footer, gray-100 chips, gray-200 borders, gray-500 muted)
        paper: {
          50: '#f9fafb',
          100: '#f3f4f6',
          200: '#e5e7eb',
          300: '#d1d5db',
          400: '#9ca3af',
          500: '#6b7280',
          600: '#4b5563',
        },
        // Body text ink (ainora: gray-900 headings, gray-600 body)
        ink: {
          DEFAULT: '#111827',
          soft: '#374151',
          light: '#6b7280',
        },
        // Semantic status colors (retained from the previous design system). Used for stat cards, status pills, progress
        // bars, alerts and Tutor LMS quiz/result states.
        success: { DEFAULT: '#28c76f', light: '#e3fcef', dark: '#00875a' },
        warning: { DEFAULT: '#ff9f43', light: '#fff0e1', dark: '#b3701e' },
        danger:  { DEFAULT: '#ff4c51', light: '#ffe2e3', dark: '#b3353a' },
        info:    { DEFAULT: '#00bad1', light: '#e0f7fa', dark: '#00859a' },
      },
      fontFamily: {
        // Noto Sans Thai everywhere — the live ainora.psu.ac.th UI + display
        // face. Sarabun retained as a self-hosted fallback (ainora footer face).
        sans: ['Noto Sans Thai', 'Sarabun', 'system-ui', 'sans-serif'],
        serif: ['Noto Sans Thai', 'Sarabun', 'system-ui', 'sans-serif'],
      },
      fontSize: {
        '2xs': ['0.6875rem', { lineHeight: '1rem' }],
      },
      spacing: {
        18: '4.5rem',
      },
      maxWidth: {
        prose: '68ch',
        'screen-xl': '1200px',
      },
      borderRadius: {
        '4xl': '2rem',
      },
      boxShadow: {
        // Soft neutral elevation — matches ainora.psu.ac.th card shadows.
        soft: '0 4px 18px 0 rgba(17, 24, 39, 0.06)',
        stat: '0 4px 6px 0 rgba(0, 0, 0, 0.07)',
        card: '0 1px 2px rgba(17, 24, 39, 0.05), 0 10px 30px -8px rgba(0, 0, 0, 0.08)',
        'card-hover': '0 6px 16px -4px rgba(17, 24, 39, 0.10), 0 20px 44px -12px rgba(0, 0, 0, 0.16)',
        'inner-line': 'inset 0 -1px 0 rgba(212, 175, 55, 0.4)',
      },
      backgroundImage: {
        // Extremely subtle neutral dot for optional textured panels only.
        'paper-texture':
          'radial-gradient(rgba(17,24,39,0.03) 1px, transparent 1px)',
        // Heritage-gold wash (ainora logo gradient: #D4AF37 → #F9E076,
        // grounded with the darker gold-700 for white-text contrast).
        'gold-wash':
          'linear-gradient(135deg, #8a6f24 0%, #b5952f 55%, #d4af37 100%)',
        'night-wash':
          'linear-gradient(160deg, #1f2937 0%, #030712 100%)',
      },
      backgroundSize: {
        grain: '18px 18px',
      },
      keyframes: {
        'fade-up': {
          '0%': { opacity: '0', transform: 'translateY(16px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        'fade-in': {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
      },
      animation: {
        'fade-up': 'fade-up 0.6s cubic-bezier(0.22, 1, 0.36, 1) both',
        'fade-in': 'fade-in 0.8s ease both',
      },
      transitionTimingFunction: {
        'out-expo': 'cubic-bezier(0.16, 1, 0.3, 1)',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
};
