import { motion } from 'framer-motion';

/**
 * @param {{ data: object }} props
 */
export default function Properties({ data }) {
  return (
    <section id="propiedades" className="py-24 lg:py-32 bg-cream" aria-labelledby="properties-heading">
      <div className="max-w-7xl mx-auto px-6 lg:px-8">
        <motion.div
          className="flex flex-col lg:flex-row lg:items-end lg:justify-between mb-16 gap-6"
          initial={{ opacity: 0, y: 24 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.7 }}
        >
          <div>
            <div className="terracotta-line mb-4" />
            <p className="text-terracotta text-sm font-medium tracking-[0.2em] uppercase mb-3">{data.eyebrow}</p>
            <h2 id="properties-heading" className="font-display text-4xl lg:text-5xl font-bold text-navy">
              {data.title}
            </h2>
          </div>
          <a
            href={data.catalog_url}
            className="inline-flex items-center gap-2 text-terracotta font-medium hover:text-terracotta-dark transition-colors group"
          >
            {data.catalog_label}
            <svg className="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
          </a>
        </motion.div>

        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          {(data.items || []).map((item, index) => (
            <motion.article
              key={item.list_key ?? `${item.id}-${index}`}
              className="property-card rounded-3xl overflow-hidden"
              initial={{ opacity: 0, y: 32 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ duration: 0.6, delay: index * 0.1 }}
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
      </div>
    </section>
  );
}
