/**
 * Repositorio central de iconos del theme.
 * Keys alineadas con assets/icons/{key}.svg y inc/helpers/theme-icons.php
 */

/** Iconos UI (stroke / currentColor) */
export const UI_ICONS = {
  heart: (
    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
  ),
  globe: (
    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
  ),
  shield: (
    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
  ),
  building: (
    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
  ),
  home: (
    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z" />
  ),
  users: (
    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
  ),
  star: (
    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
  ),
  clock: (
    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
  ),
  key: (
    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
  ),
  'map-pin': (
    <>
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
    </>
  ),
  check: (
    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
  ),
  award: (
    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
  ),
  sparkles: (
    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
  ),
  phone: (
    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
  ),
  handshake: (
    <>
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M2 9.5h3.25v5H2z" />
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M18.75 9.5H22v5h-3.25z" />
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M5.25 11c1.8 0 3.2.4 4.5 1.4 1 .8 1.7 1.7 2.25 2.5" />
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M18.75 11c-1.8 0-3.2.4-4.5 1.4-1 .8-1.7 1.7-2.25 2.5" />
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M7.25 10c1.5-1.6 3.1-2.35 4.75-2.35S14.25 8.4 15.75 10" />
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M8.5 15.75c1 .85 2.1 1.3 3.5 1.3s2.5-.45 3.5-1.3" />
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M9.75 12.75h4.5M10.25 11.35h3.5" />
    </>
  ),
  leaf: (
    <>
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M12 3c-4.5 3-7 6.5-7 10.5A7 7 0 0012 20.5 7 7 0 0019 13.5C19 9.5 16.5 6 12 3z" />
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M12 3v17.5" />
    </>
  ),
  scales: (
    <>
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M12 3v18M8 21h8" />
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M5 7h14M5 7l-2 6a3 3 0 006 0L7 7M19 7l-2 6a3 3 0 006 0l-2-6" />
    </>
  ),
  'chart-up': (
    <>
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M4 19V10M9 19V6M14 19v-7M19 19V4" />
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M3 16l6-6 4 3 7-8" />
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M16 5h4v4" />
    </>
  ),
  loyalty: (
    <>
      <ellipse cx="12" cy="12" rx="9" ry="4" transform="rotate(60 12 12)" strokeWidth="1.5" />
      <ellipse cx="12" cy="12" rx="9" ry="4" transform="rotate(-60 12 12)" strokeWidth="1.5" />
      <ellipse cx="12" cy="12" rx="9" ry="4" strokeWidth="1.5" />
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M12 10.2c-.7-.9-1.9-1-2.6-.3-.6.6-.5 1.6.2 2.3L12 14.8l2.4-2.6c.7-.7.8-1.7.2-2.3-.7-.7-1.9-.6-2.6.3z" />
    </>
  ),
  'globe-hands': (
    <>
      <circle cx="12" cy="9" r="5.5" strokeWidth="1.5" />
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M6.5 9h11M12 3.5c1.8 1.5 2.8 3.4 2.8 5.5S13.8 13.5 12 15M12 3.5C10.2 5 9.2 6.9 9.2 9s1 4 2.8 6" />
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M4 18.5c1.5-1.2 3.3-1.8 5.2-1.8h5.6c1.9 0 3.7.6 5.2 1.8" />
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M7 16.5v2.2c0 .7.4 1.3 1 1.5M17 16.5v2.2c0 .7-.4 1.3-1 1.5" />
    </>
  ),
  pool: (
    <>
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M7 4v8M7 6h3M7 9h3" />
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M4 15c1.5-1 3-1 4.5 0s3 1 4.5 0 3-1 4.5 0 3 1 4.5 0" />
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M4 18c1.5-1 3-1 4.5 0s3 1 4.5 0 3-1 4.5 0 3 1 4.5 0" />
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M4 21c1.5-1 3-1 4.5 0s3 1 4.5 0 3-1 4.5 0 3 1 4.5 0" />
    </>
  ),
  'green-areas': (
    <>
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M6 20v-4M6 16c-2 0-3.5-1.8-3-3.5C3.5 10.5 5 10 6 11c1-1 2.5-.5 3 1.5.5 1.7-1 3.5-3 3.5z" />
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M11 20v-3M11 17c-1.5 0-2.6-1.3-2.2-2.6.3-1.2 1.4-1.6 2.2-.8.8-.8 1.9-.4 2.2.8.4 1.3-.7 2.6-2.2 2.6z" />
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M15 12h5v3h-5zM15 12l2.5-3L20 12M17.5 15v5M15.5 20h4" />
    </>
  ),
  grill: (
    <>
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M8 9c0-2.2 1.8-4 4-4s4 1.8 4 4v1H8V9z" />
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M7 10h10a1 1 0 011 1v2c0 3.3-2.7 6-6 6s-6-2.7-6-6v-2a1 1 0 011-1z" />
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M9 4c.3-.8.8-1.5 1.5-2M15 4c-.3-.8-.8-1.5-1.5-2M12 3.5V2" />
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M10 20h4" />
    </>
  ),
  portico: (
    <>
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M4 20V9l8-5 8 5v11" />
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M9 20v-7h6v7" />
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M4 9h16" />
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M12 13v3" />
    </>
  ),
  search: (
    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
  ),
  eye: (
    <>
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
    </>
  ),
  card: (
    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
  ),
  document: (
    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
  ),
  smile: (
    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
  ),
};

/** Iconos de redes (fill / currentColor) */
export const SOCIAL_ICONS = {
  instagram: (
    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
  ),
  linkedin: (
    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 114.127 0 2.063 2.063 0 01-2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
  ),
  facebook: (
    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
  ),
  twitter: (
    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
  ),
  youtube: (
    <path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
  ),
  whatsapp: (
    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
  ),
};

/**
 * @param { name?: string, className?: string, fallback?: string } props
 */
export function ThemeIcon({ name = 'home', className = 'w-7 h-7 text-terracotta', fallback = 'home' }) {
  return (
    <svg className={className} fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
      {UI_ICONS[name] || UI_ICONS[fallback] || UI_ICONS.home}
    </svg>
  );
}

/**
 * @param { name?: string, className?: string, fallback?: string } props
 */
export function SocialIcon({ name = 'instagram', className = 'w-4 h-4', fallback = 'instagram' }) {
  return (
    <svg className={className} fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
      {SOCIAL_ICONS[name] || SOCIAL_ICONS[fallback] || SOCIAL_ICONS.instagram}
    </svg>
  );
}
