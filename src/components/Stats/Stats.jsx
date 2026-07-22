import { motion } from 'framer-motion';
import { ThemeIcon } from '../../icons/registry.jsx';

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
                <ThemeIcon name={item.icon} fallback="home" />
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
