import { motion } from 'framer-motion';
import { ThemeIcon } from '../../icons/registry.jsx';

/**
 * Nuestros valores — grid icono + texto (brochure).
 *
 * @param {{ data: { title?: string, items?: Array<{ icon: string, label: string }> } }} props
 */
export default function Values({ data }) {
  const items = Array.isArray(data?.items) ? data.items : [];
  if (items.length === 0) {
    return null;
  }

  return (
    <section id="valores" className="relative py-20 lg:py-28 bg-cream overflow-hidden" aria-labelledby="values-heading">
      <div className="max-w-5xl mx-auto px-6 lg:px-8 relative">
        <motion.h2
          id="values-heading"
          className="font-display text-3xl lg:text-4xl font-bold text-navy mb-14 lg:mb-16"
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.6 }}
        >
          {data.title || 'Nuestros valores:'}
        </motion.h2>

        <ul className="grid grid-cols-2 md:grid-cols-3 gap-x-8 gap-y-12 list-none m-0 p-0">
          {items.map((item, index) => (
            <motion.li
              key={`${item.label}-${index}`}
              className="flex flex-col items-center text-center"
              initial={{ opacity: 0, y: 24 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ duration: 0.5, delay: index * 0.06 }}
            >
              <div className="mb-4 text-terracotta [&_svg]:w-14 [&_svg]:h-14 lg:[&_svg]:w-16 lg:[&_svg]:h-16">
                <ThemeIcon name={item.icon} fallback="clock" className="w-14 h-14 lg:w-16 lg:h-16 text-terracotta" />
              </div>
              <p className="font-semibold text-navy text-sm lg:text-base tracking-[0.12em] uppercase m-0">
                {item.label}
              </p>
            </motion.li>
          ))}
        </ul>
      </div>
    </section>
  );
}
