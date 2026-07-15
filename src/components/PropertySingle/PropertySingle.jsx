import { motion } from 'framer-motion';
import Navbar from '../Navbar/Navbar.jsx';
import Footer from '../Footer/Footer.jsx';
import PropertyGalleryCarousel from '../PropertyGalleryCarousel/PropertyGalleryCarousel.jsx';

/**
 * Single propiedad page — featured hero + detalle + galería + Footer.
 *
 * @param {{ data: object, property: object }} props
 */
export default function PropertySingle({ data, property }) {
  if (!property) {
    return null;
  }

  const collectionUrl =
    typeof window !== 'undefined'
      ? window.homeSeaThemeData?.collectionUrl || `${window.homeSeaThemeData?.homeUrl || '/'}#propiedades`
      : '/propiedades/';
  const badgeColor = property.badge_color || '#C45C26';
  const gallery = Array.isArray(property.images) ? property.images.filter((img) => img?.url) : [];

  return (
    <div className="min-h-screen bg-cream">
      <Navbar data={data.header} />

      <section className="pb-24 lg:pb-32" aria-labelledby="property-title">
        <div className="relative w-full h-[240px] sm:h-[360px] lg:h-[480px] overflow-hidden bg-navy">
          {property.image_url ? (
            <img
              src={property.image_url}
              alt={property.image_alt || property.title}
              className="absolute inset-0 w-full h-full object-cover"
              width="1600"
              height="686"
            />
          ) : null}
        </div>

        <div className="max-w-7xl mx-auto px-6 lg:px-8 -mt-16 relative z-10">
          <motion.article
            className="warm-surface rounded-3xl p-8 lg:p-12"
            initial={{ opacity: 0, y: 24 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
          >
            <a
              href={collectionUrl}
              className="inline-flex items-center gap-2 text-sm text-terracotta font-medium hover:text-terracotta-dark transition-colors mb-6"
            >
              <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 19l-7-7 7-7" />
              </svg>
              Volver a propiedades
            </a>

            <div className="terracotta-line mb-4" />
            <p className="text-terracotta text-sm font-medium tracking-[0.2em] uppercase mb-3">{property.location}</p>
            <h1 id="property-title" className="font-display text-4xl lg:text-5xl font-bold text-navy mb-4">
              {property.title || property.location}
            </h1>
            {property.badge ? (
              <span
                className="inline-block mb-6 px-3 py-1 text-xs font-semibold rounded-full text-white"
                style={{ backgroundColor: badgeColor }}
              >
                {property.badge}
              </span>
            ) : null}
            <p className="text-3xl lg:text-4xl font-bold text-navy mb-8">{property.price}</p>

            <div className="flex flex-wrap items-center gap-6 text-sm text-gray-600 mb-10 pb-8 border-b border-terracotta/15">
              <span>{property.beds} hab.</span>
              <span>{property.baths} baños</span>
              <span>{property.area}</span>
            </div>

            {property.description ? (
              <div
                className="prose prose-navy max-w-none text-gray-600 leading-relaxed [&_p]:mb-4 [&_a]:text-terracotta"
                dangerouslySetInnerHTML={{ __html: property.description }}
              />
            ) : null}

            {gallery.length > 0 ? (
              <div className="mt-10 pt-10 border-t border-terracotta/15">
                <h2 className="font-display text-2xl font-bold text-navy mb-6">Galería</h2>
                <PropertyGalleryCarousel images={gallery} />
              </div>
            ) : null}
          </motion.article>
        </div>
      </section>

      <Footer data={data.footer} />
    </div>
  );
}
