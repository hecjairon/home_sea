import { motion } from 'framer-motion';

const ICONS = {
  search: (
    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
  ),
  eye: (
    <>
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
    </>
  ),
  card: (
    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
  ),
  document: (
    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
  ),
  smile: (
    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
  ),
};

function StepIcon({ icon }) {
  return (
    <svg className="w-7 h-7 text-terracotta" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      {ICONS[icon] || ICONS.search}
    </svg>
  );
}

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
                  <StepIcon icon={step.icon} />
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
