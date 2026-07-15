import { motion } from 'framer-motion';
import Navbar from '../Navbar/Navbar.jsx';
import Footer from '../Footer/Footer.jsx';

/**
 * Full collection archive — Navbar + grid + Footer.
 *
 * @param {{ data: object, items: object[] }} props
 */
export default function PropertiesCollection({ data, items }) {
  const section = data.properties || {};
  const homeUrl = typeof window !== 'undefined' ? window.homeSeaThemeData?.homeUrl || '/' : '/';

  return (
    <div className="min-h-screen bg-cream">
      <Navbar data={data.header} />

      <section className="py-24 lg:py-32" aria-labelledby="collection-heading">
        <div className="max-w-7xl mx-auto px-6 lg:px-8">
          <motion.div
            className="mb-16"
            initial={{ opacity: 0, y: 24 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.7 }}
          >
            <a
              href={homeUrl}
              className="inline-flex items-center gap-2 text-sm text-terracotta font-medium hover:text-terracotta-dark transition-colors mb-6"
            >
              <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 19l-7-7 7-7" />
              </svg>
              Volver al inicio
            </a>
            <div className="terracotta-line mb-4" />
            <p className="text-terracotta text-sm font-medium tracking-[0.2em] uppercase mb-3">
              {section.eyebrow || 'Colección curada'}
            </p>
            <h1 id="collection-heading" className="font-display text-4xl lg:text-5xl font-bold text-navy">
              {section.title || 'Propiedades'}
            </h1>
          </motion.div>

          {items.length === 0 ? (
            <p className="text-gray-500">No hay propiedades publicadas.</p>
          ) : (
            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
              {items.map((item, index) => (
                <motion.article
                  key={item.id ?? `${item.details_url}-${index}`}
                  className="property-card rounded-3xl overflow-hidden"
                  initial={{ opacity: 0, y: 32 }}
                  animate={{ opacity: 1, y: 0 }}
                  transition={{ duration: 0.6, delay: index * 0.05 }}
                >
                  <div className="relative overflow-hidden aspect-[4/3]">
                    <img
                      src={item.image_url}
                      alt={item.image_alt}
                      className="property-image w-full h-full object-cover"
                      loading="lazy"
                      width="800"
                      height="600"
                    />
                    {item.badge ? (
                      <span
                        className="absolute top-4 left-4 px-3 py-1 text-xs font-semibold rounded-full text-white"
                        style={{ backgroundColor: item.badge_color || '#C45C26' }}
                      >
                        {item.badge}
                      </span>
                    ) : null}
                  </div>
                  <div className="p-6">
                    <p className="text-2xl font-bold text-navy mb-1">{item.price}</p>
                    <p className="text-gray-500 text-sm mb-4">{item.location}</p>
                    <div className="flex items-center gap-4 text-sm text-gray-600 mb-6">
                      <span>{item.beds} hab.</span>
                      <span>{item.baths} baños</span>
                      <span>{item.area}</span>
                    </div>
                    <a
                      href={item.details_url}
                      className="inline-flex w-full justify-center py-3 border border-terracotta text-terracotta text-sm font-semibold rounded-2xl hover:bg-terracotta hover:text-white transition-all duration-300"
                    >
                      Ver detalles
                    </a>
                  </div>
                </motion.article>
              ))}
            </div>
          )}
        </div>
      </section>

      <Footer data={data.footer} />
    </div>
  );
}
