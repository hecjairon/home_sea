import { useEffect, useState } from 'react';
import { motion } from 'framer-motion';

function useSlidesPerView() {
  const [slidesPerView, setSlidesPerView] = useState(1);

  useEffect(() => {
    const update = () => {
      if (window.innerWidth >= 1024) setSlidesPerView(3);
      else if (window.innerWidth >= 768) setSlidesPerView(2);
      else setSlidesPerView(1);
    };
    update();
    window.addEventListener('resize', update);
    return () => window.removeEventListener('resize', update);
  }, []);

  return slidesPerView;
}

const BADGE_STYLES = {
  terracotta: 'text-terracotta bg-terracotta/10',
  gold: 'text-gold bg-gold/10',
  navy: 'text-navy bg-navy/10',
};

function ChevronLeft() {
  return (
    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 19l-7-7 7-7" />
    </svg>
  );
}

function ChevronRight() {
  return (
    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 5l7 7-7 7" />
    </svg>
  );
}

/**
 * @param {{ data: object }} props
 */
export default function Projects({ data }) {
  const [index, setIndex] = useState(0);
  const slidesPerView = useSlidesPerView();
  const total = data.items.length;
  const maxIndex = Math.max(0, total - slidesPerView);

  useEffect(() => {
    setIndex((i) => Math.min(i, maxIndex));
  }, [maxIndex]);

  const prev = () => setIndex((i) => Math.max(0, i - 1));
  const next = () => setIndex((i) => Math.min(maxIndex, i + 1));

  const slideWidth = 100 / slidesPerView;

  return (
    <section id="proyectos" className="py-24 lg:py-32 bg-cream" aria-labelledby="projects-heading">
      <div className="max-w-7xl mx-auto px-6 lg:px-8">
        <motion.div
          className="flex flex-col lg:flex-row lg:items-end lg:justify-between mb-12 gap-6"
          initial={{ opacity: 0, y: 24 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
        >
          <div>
            <div className="terracotta-line mb-4" />
            <p className="text-terracotta text-sm font-medium tracking-[0.2em] uppercase mb-3">{data.eyebrow}</p>
            <h2 id="projects-heading" className="font-display text-4xl lg:text-5xl font-bold text-navy">
              {data.title}
            </h2>
          </div>
          <div className="flex items-center gap-3">
            <button
              type="button"
              onClick={prev}
              disabled={index === 0}
              className="w-12 h-12 rounded-full border border-terracotta/30 flex items-center justify-center hover:bg-terracotta hover:text-white hover:border-terracotta transition-all duration-300 text-terracotta disabled:opacity-40 disabled:pointer-events-none"
              aria-label="Proyecto anterior"
            >
              <ChevronLeft />
            </button>
            <button
              type="button"
              onClick={next}
              disabled={index >= maxIndex}
              className="w-12 h-12 rounded-full border border-terracotta/30 flex items-center justify-center hover:bg-terracotta hover:text-white hover:border-terracotta transition-all duration-300 text-terracotta disabled:opacity-40 disabled:pointer-events-none"
              aria-label="Proyecto siguiente"
            >
              <ChevronRight />
            </button>
          </div>
        </motion.div>

        <div className="overflow-hidden">
          <motion.div
            className="flex"
            animate={{ x: `-${index * slideWidth}%` }}
            transition={{ duration: 0.6, ease: [0.16, 1, 0.3, 1] }}
          >
            {data.items.map((item) => (
              <article key={item.title} className="w-full md:w-1/2 lg:w-1/3 shrink-0 px-3">
                <div className="warm-surface rounded-3xl overflow-hidden group">
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
                    <span className={`text-xs font-semibold px-2.5 py-1 rounded-full ${BADGE_STYLES[item.badge_variant] || BADGE_STYLES.terracotta}`}>
                      {item.badge}
                    </span>
                    <h3 className="font-display font-bold text-xl text-navy mt-3 mb-1">{item.title}</h3>
                    <p className="text-gray-500 text-sm mb-4">{item.location}</p>
                    <a
                      href={item.url}
                      className="inline-flex items-center gap-2 text-terracotta font-medium text-sm hover:text-terracotta-dark transition-colors"
                    >
                      Ver proyecto
                      <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                      </svg>
                    </a>
                  </div>
                </div>
              </article>
            ))}
          </motion.div>

          <div className="flex justify-center gap-2 mt-8" role="tablist" aria-label="Indicadores de proyectos">
            {Array.from({ length: maxIndex + 1 }).map((_, dotIndex) => (
              <button
                key={dotIndex}
                type="button"
                role="tab"
                aria-selected={index === dotIndex}
                aria-label={`Ir al slide ${dotIndex + 1}`}
                onClick={() => setIndex(dotIndex)}
                className={`h-2 rounded-full transition-all duration-300 ${index === dotIndex ? 'w-8 bg-terracotta' : 'w-2 bg-terracotta/30 hover:bg-terracotta/50'}`}
              />
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
