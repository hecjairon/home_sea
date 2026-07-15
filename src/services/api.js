import { mockData } from './mockData.js';

const REQUIRED_KEYS = [
  'header',
  'hero',
  'stats',
  'properties',
  'about',
  'projects',
  'testimonials',
  'process',
  'location',
  'contact',
  'footer',
  'seo',
];

/**
 * Deep-merge objects; arrays from source replace defaults when non-empty.
 * Used only in development as a safety net.
 *
 * @param {object} defaults
 * @param {object} source
 * @returns {object}
 */
function mergeSiteData(defaults, source) {
  const out = { ...defaults };

  for (const key of Object.keys(source || {})) {
    const value = source[key];

    if (value === null || value === undefined) {
      continue;
    }

    if (Array.isArray(value)) {
      if (value.length > 0) {
        out[key] = value;
      }
      continue;
    }

    if (typeof value === 'object' && typeof defaults[key] === 'object' && !Array.isArray(defaults[key])) {
      out[key] = mergeSiteData(defaults[key] || {}, value);
      continue;
    }

    if (value !== '') {
      out[key] = value;
    }
  }

  return out;
}

/**
 * @param {object} payload
 */
function assertSitePayload(payload) {
  if (!payload || typeof payload !== 'object') {
    throw new Error('Respuesta de la API inválida.');
  }

  for (const key of REQUIRED_KEYS) {
    if (!(key in payload) || payload[key] === null || payload[key] === undefined) {
      throw new Error(`Payload incompleto: falta «${key}».`);
    }
  }
}

/**
 * Fetch site configuration for React from WordPress REST (`/theme/v1/site`).
 *
 * Production: REST only (defaults live in PHP `site-defaults.php` / CMB2).
 * Development: may fall back to mockData if the API is unreachable.
 *
 * @returns {Promise<object>}
 */
export async function getSiteData() {
  const apiUrl = window.homeSeaThemeData?.apiUrl;

  if (!apiUrl) {
    if (import.meta.env.DEV) {
      console.warn('[homesea_theme] homeSeaThemeData.apiUrl missing — using mockData.');
      return structuredClone(mockData);
    }

    throw new Error('API del theme no configurada.');
  }

  try {
    const response = await fetch(apiUrl, {
      headers: {
        Accept: 'application/json',
        'X-WP-Nonce': window.homeSeaThemeData?.nonce || '',
      },
      credentials: 'same-origin',
    });

    if (!response.ok) {
      throw new Error(`Error de API (${response.status}).`);
    }

    const payload = await response.json();
    assertSitePayload(payload);

    if (import.meta.env.DEV) {
      return mergeSiteData(structuredClone(mockData), payload);
    }

    return payload;
  } catch (error) {
    if (import.meta.env.DEV) {
      console.warn('[homesea_theme] REST unavailable, using mockData.', error);
      return structuredClone(mockData);
    }

    throw error instanceof Error ? error : new Error('No se pudo cargar la configuración del sitio.');
  }
}
