import { motion } from 'framer-motion';

const ICONS = {
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
};

function FeatureIcon({ icon }) {
  return (
    <svg className="w-7 h-7 text-terracotta" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      {ICONS[icon] || ICONS.heart}
    </svg>
  );
}

/**
 * @param {{ data: object }} props
 */
export default function About({ data }) {
  return (
    <section id="nosotros" className="relative py-24 lg:py-32 bg-cream-dark overflow-hidden" aria-labelledby="why-heading">
      <div className="blob-organic blob-organic-3 absolute -right-32 top-1/3 w-96 h-96 opacity-40" aria-hidden="true" />
      <div className="max-w-7xl mx-auto px-6 lg:px-8 relative">
        <motion.div
          className="text-center max-w-2xl mx-auto mb-16"
          initial={{ opacity: 0, y: 24 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.7 }}
        >
          <div className="terracotta-line mx-auto mb-4" />
          <p className="text-terracotta text-sm font-medium tracking-[0.2em] uppercase mb-3">{data.eyebrow}</p>
          <h2 id="why-heading" className="font-display text-4xl lg:text-5xl font-bold text-navy">
            {data.title}
          </h2>
          <p className="text-gray-500 mt-4 leading-relaxed">{data.body}</p>
        </motion.div>

        <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
          {data.items.map((item, index) => (
            <motion.article
              key={item.title}
              className="feature-card rounded-3xl p-8"
              initial={{ opacity: 0, y: 24 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ duration: 0.6, delay: index * 0.1 }}
            >
              <div className="feature-icon w-14 h-14 rounded-3xl flex items-center justify-center mb-6">
                <FeatureIcon icon={item.icon} />
              </div>
              <h3 className="font-semibold text-lg text-navy mb-2">{item.title}</h3>
              <p className="text-sm text-gray-500 leading-relaxed">{item.description}</p>
            </motion.article>
          ))}
        </div>
      </div>
    </section>
  );
}
