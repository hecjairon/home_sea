import { motion } from 'framer-motion';

const ICONS = {
  home: (
    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z" />
  ),
  users: (
    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
  ),
  clock: (
    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
  ),
  star: (
    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
  ),
};

function StatIcon({ icon }) {
  return (
    <svg className="w-7 h-7 text-terracotta" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      {ICONS[icon] || ICONS.home}
    </svg>
  );
}

/**
 * @param {{ items: Array<{id: string, label: string, value: string, icon: string}> }} props
 */
export default function Stats({ items }) {
  return (
    <section className="relative py-20 bg-cream-dark" aria-labelledby="stats-heading">
      <div className="section-divider absolute top-0 left-0 right-0" />
      <div className="max-w-7xl mx-auto px-6 lg:px-8">
        <h2 id="stats-heading" className="sr-only">
          Estadísticas de Villa Hermosa
        </h2>
        <div className="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
          {items.map((item, index) => (
            <motion.article
              key={item.id}
              className="warm-surface rounded-3xl p-8 text-center"
              initial={{ opacity: 0, y: 24 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true, margin: '-60px' }}
              transition={{ duration: 0.6, delay: index * 0.1 }}
            >
              <div className="w-14 h-14 mx-auto mb-4 rounded-3xl bg-terracotta/10 flex items-center justify-center" aria-hidden="true">
                <StatIcon icon={item.icon} />
              </div>
              <p className="text-3xl lg:text-4xl font-bold text-navy mb-1 tabular-nums">
                {item.value}
              </p>
              <p className="text-sm text-gray-500">{item.label}</p>
            </motion.article>
          ))}
        </div>
      </div>
    </section>
  );
}
