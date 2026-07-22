import { motion } from 'framer-motion';
import { ThemeIcon } from '../../icons/registry.jsx';

/**
 * @param {{ data: object }} props
 */
export default function About({ data }) {
  const showItems = data?.show_items !== false;
  const items = Array.isArray(data?.items) ? data.items : [];

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

        {showItems && items.length > 0 ? (
          <div className="flex flex-wrap justify-center gap-6">
            {items.map((item, index) => (
              <motion.article
                key={item.title}
                className="feature-card rounded-3xl p-8 w-full sm:w-[calc(50%-0.75rem)] lg:w-[calc(25%-1.125rem)] max-w-md"
                initial={{ opacity: 0, y: 24 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ duration: 0.6, delay: index * 0.1 }}
              >
                <div className="feature-icon w-14 h-14 rounded-3xl flex items-center justify-center mb-6">
                  <ThemeIcon name={item.icon} fallback="heart" />
                </div>
                <h3 className="font-semibold text-lg text-navy mb-2">{item.title}</h3>
                <p className="text-sm text-gray-500 leading-relaxed">{item.description}</p>
              </motion.article>
            ))}
          </div>
        ) : null}
      </div>
    </section>
  );
}
