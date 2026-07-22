import { motion } from 'framer-motion';
import { ThemeIcon } from '../../icons/registry.jsx';

/**
 * @param {{ data: object }} props
 */
export default function Process({ data }) {
  return (
    <section className="py-24 lg:py-32 bg-cream-dark" aria-labelledby="process-heading">
      <div className="max-w-7xl mx-auto px-6 lg:px-8">
        <motion.div
          className="text-center max-w-2xl mx-auto mb-16"
          initial={{ opacity: 0, y: 24 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
        >
          <div className="terracotta-line mx-auto mb-4" />
          <p className="text-terracotta text-sm font-medium tracking-[0.2em] uppercase mb-3">{data.eyebrow}</p>
          <h2 id="process-heading" className="font-display text-4xl lg:text-5xl font-bold text-navy">
            {data.title}
          </h2>
        </motion.div>

        <div className="relative">
          <div className="timeline-line hidden lg:block absolute top-8 left-0 right-0 mx-16" aria-hidden="true" />
          <ol className="grid grid-cols-2 lg:grid-cols-5 gap-8 lg:gap-4 list-none">
            {data.steps.map((step, index) => (
              <motion.li
                key={step.number}
                className={`text-center ${index === data.steps.length - 1 ? 'col-span-2 lg:col-span-1' : ''}`}
                initial={{ opacity: 0, y: 24 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ duration: 0.5, delay: index * 0.1 }}
              >
                <div className="w-16 h-16 mx-auto rounded-3xl bg-white border-2 border-terracotta/20 flex items-center justify-center mb-4">
                  <ThemeIcon name={step.icon} fallback="search" />
                </div>
                <span className="text-gold text-xs font-bold tracking-wider">{step.number}</span>
                <h3 className="font-semibold text-navy mt-1 mb-1">{step.title}</h3>
                <p className="text-xs text-gray-500">{step.description}</p>
              </motion.li>
            ))}
          </ol>
        </div>
      </div>
    </section>
  );
}
