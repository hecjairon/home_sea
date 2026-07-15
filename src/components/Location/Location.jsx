import { motion } from 'framer-motion';

/**
 * Convert a Google Maps share/search URL into an embeddable iframe src.
 * Supports `?q=`, `/maps/place/…`, and existing `/maps/embed` or `output=embed` URLs.
 *
 * @param {string} mapsUrl
 * @param {string} [fallbackQuery]
 */
function toMapsEmbedUrl(mapsUrl, fallbackQuery = '') {
  const fallback = fallbackQuery
    ? `https://www.google.com/maps?q=${encodeURIComponent(fallbackQuery)}&z=15&output=embed`
    : '';

  if (!mapsUrl || typeof mapsUrl !== 'string') {
    return fallback;
  }

  const trimmed = mapsUrl.trim();
  if (!trimmed || trimmed === '#') {
    return fallback;
  }

  try {
    const url = new URL(trimmed);

    if (url.pathname.includes('/maps/embed') || url.searchParams.get('output') === 'embed') {
      if (!url.searchParams.has('output') && !url.pathname.includes('/maps/embed')) {
        url.searchParams.set('output', 'embed');
      }
      return url.toString();
    }

    const q = url.searchParams.get('q');
    if (q) {
      return `https://www.google.com/maps?q=${encodeURIComponent(q)}&z=15&output=embed`;
    }

    const placeMatch = url.pathname.match(/\/maps\/place\/([^/]+)/);
    if (placeMatch?.[1]) {
      const place = decodeURIComponent(placeMatch[1].replace(/\+/g, ' '));
      return `https://www.google.com/maps?q=${encodeURIComponent(place)}&z=15&output=embed`;
    }

    const atMatch = trimmed.match(/@(-?\d+\.?\d*),(-?\d+\.?\d*)/);
    if (atMatch) {
      const lat = atMatch[1];
      const lng = atMatch[2];
      return `https://www.google.com/maps?q=${encodeURIComponent(`${lat},${lng}`)}&z=15&output=embed`;
    }

    return `https://www.google.com/maps?q=${encodeURIComponent(trimmed)}&z=15&output=embed`;
  } catch {
    return fallback || `https://www.google.com/maps?q=${encodeURIComponent(trimmed)}&z=15&output=embed`;
  }
}

/**
 * @param {{ data: { title: string, address: string, maps_url: string, cta_label: string } }} props
 */
export default function Location({ data }) {
  const embedSrc = toMapsEmbedUrl(data.maps_url, data.address || data.title);

  return (
    <section className="relative" aria-labelledby="map-heading">
      <div className="map-container h-[400px] lg:h-[500px] w-full">
        {embedSrc ? (
          <iframe
            title="Mapa de ubicación"
            src={embedSrc}
            className="absolute inset-0 w-full h-full border-0"
            loading="lazy"
            referrerPolicy="no-referrer-when-downgrade"
            allowFullScreen
          />
        ) : null}

        <div className="absolute inset-0 bg-cream/55 pointer-events-none" aria-hidden="true" />

        <div className="absolute inset-0 flex items-center justify-center px-6">
          <motion.div
            className="text-center warm-surface rounded-3xl px-8 py-8 shadow-lg max-w-md"
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.6 }}
          >
            <h2 id="map-heading" className="sr-only">
              Ubicación de nuestras oficinas
            </h2>
            <div className="map-pin inline-flex flex-col items-center mb-6">
              <svg className="w-10 h-10 text-terracotta" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z" />
              </svg>
            </div>
            <p className="font-display text-2xl font-bold text-navy mb-2">{data.title}</p>
            <p className="text-gray-600 text-sm mb-6 whitespace-pre-line">{data.address}</p>
            <a
              href={data.maps_url || embedSrc}
              target="_blank"
              rel="noopener noreferrer"
              className="btn-terracotta-glow inline-flex items-center gap-2 px-8 py-3 bg-terracotta text-white text-sm font-semibold rounded-full hover:bg-terracotta-dark transition-all duration-300"
            >
              <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              {data.cta_label}
            </a>
          </motion.div>
        </div>
      </div>
    </section>
  );
}
