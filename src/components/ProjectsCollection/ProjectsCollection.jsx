import { motion } from 'framer-motion';
import Navbar from '../Navbar/Navbar.jsx';
import Footer from '../Footer/Footer.jsx';

const BADGE_STYLES = {
  terracotta: 'text-terracotta bg-terracotta/10',
  gold: 'text-gold bg-gold/10',
  navy: 'text-navy bg-navy/10',
};

/**
 * Full proyectos collection — Navbar + grid (mismo layout de cards) + Footer.
 *
 * @param {{ data: object, items: object[] }} props
 */
export default function ProjectsCollection({ data, items }) {
  const section = data.projects || {};
  const homeUrl = typeof window !== 'undefined' ? window.homeSeaThemeData?.homeUrl || '/' : '/';

  return (
    <div className="min-h-screen bg-cream">
      <Navbar data={data.header} />

      <section className="py-24 lg:py-32" aria-labelledby="projects-collection-heading">
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
              {section.eyebrow || 'Desarrollos selectos'}
            </p>
            <h1 id="projects-collection-heading" className="font-display text-4xl lg:text-5xl font-bold text-navy">
              {section.title || 'Proyectos'}
            </h1>
          </motion.div>

          {items.length === 0 ? (
            <p className="text-gray-500">No hay proyectos publicados.</p>
          ) : (
            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
              {items.map((item, index) => {
                const link = item.url || item.details_url || '#';
                return (
                  <motion.article
                    key={item.list_key || item.id || `${link}-${index}`}
                    className="warm-surface rounded-3xl overflow-hidden group"
                    initial={{ opacity: 0, y: 32 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ duration: 0.6, delay: index * 0.05 }}
                  >
                    <div className="aspect-[16/10] overflow-hidden">
                      <img
                        src={item.image_url}
                        alt={item.image_alt}
                        className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                        loading="lazy"
                        width="800"
                        height="500"
                      />
                    </div>
                    <div className="p-6">
                      {item.badge ? (
                        <span
                          className={`text-xs font-semibold px-2.5 py-1 rounded-full ${BADGE_STYLES[item.badge_variant] || BADGE_STYLES.terracotta}`}
                        >
                          {item.badge}
                        </span>
                      ) : null}
                      <h2 className="font-display font-bold text-xl text-navy mt-3 mb-1">{item.title}</h2>
                      <p className="text-gray-500 text-sm mb-4">{item.location}</p>
                      <a
                        href={link}
                        className="inline-flex items-center gap-2 text-terracotta font-medium text-sm hover:text-terracotta-dark transition-colors"
                      >
                        Ver proyecto
                        <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                      </a>
                    </div>
                  </motion.article>
                );
              })}
            </div>
          )}
        </div>
      </section>

      <Footer data={data.footer} />
    </div>
  );
}
