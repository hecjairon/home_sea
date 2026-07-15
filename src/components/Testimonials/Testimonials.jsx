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

function StarRating({ rating }) {
  return (
    <div className="flex gap-1 mb-4" aria-label={`${rating} estrellas`}>
      {Array.from({ length: rating }).map((_, i) => (
        <svg key={i} className="w-4 h-4 text-gold" fill="currentColor" viewBox="0 0 20 20">
          <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
        </svg>
      ))}
    </div>
  );
}

/**
 * @param {{ data: object }} props
 */
export default function Testimonials({ data }) {
  const [index, setIndex] = useState(0);
  const slidesPerView = useSlidesPerView();
  const total = data.items.length;
  const maxIndex = Math.max(0, total - slidesPerView);

  useEffect(() => {
    setIndex((i) => Math.min(i, maxIndex));
  }, [maxIndex]);
  const slideWidth = 100 / slidesPerView;

  const prev = () => setIndex((i) => Math.max(0, i - 1));
  const next = () => setIndex((i) => Math.min(maxIndex, i + 1));

  return (
    <section className="py-24 lg:py-32 bg-navy-dark relative overflow-hidden" aria-labelledby="testimonials-heading">
      <div className="blob-organic blob-organic-2 absolute top-0 left-1/4 w-96 h-96 opacity-30" aria-hidden="true" />
      <div className="max-w-7xl mx-auto px-6 lg:px-8 relative">
        <motion.div
          className="text-center max-w-2xl mx-auto mb-16"
          initial={{ opacity: 0, y: 24 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
        >
          <div className="terracotta-line mx-auto mb-4" />
          <p className="text-gold text-sm font-medium tracking-[0.2em] uppercase mb-3">{data.eyebrow}</p>
          <h2 id="testimonials-heading" className="font-display text-4xl lg:text-5xl font-bold text-white">
            {data.title}
          </h2>
        </motion.div>

        <div className="overflow-hidden">
          <motion.div
            className="flex"
            animate={{ x: `-${index * slideWidth}%` }}
            transition={{ duration: 0.7, ease: [0.16, 1, 0.3, 1] }}
          >
            {data.items.map((item) => (
              <article key={item.name} className="w-full md:w-1/2 lg:w-1/3 shrink-0 px-3">
                <div className="testimonial-warm-card rounded-3xl p-8 h-full">
                  <StarRating rating={item.rating} />
                  <blockquote className="text-white/85 text-sm leading-relaxed mb-6">&ldquo;{item.quote}&rdquo;</blockquote>
                  <div className="flex items-center gap-4">
                    <img
                      src={item.avatar_url}
                      alt={`Foto de ${item.name}`}
                      className="w-12 h-12 rounded-full object-cover ring-2 ring-gold/30"
                      loading="lazy"
                      width="48"
                      height="48"
                    />
                    <div>
                      <p className="text-white font-medium text-sm">{item.name}</p>
                      <p className="text-white/50 text-xs">{item.location}</p>
                    </div>
                  </div>
                </div>
              </article>
            ))}
          </motion.div>
        </div>

        <div className="flex justify-center gap-3 mt-10">
          <button
            type="button"
            onClick={prev}
            disabled={index === 0}
            className="w-10 h-10 rounded-full border border-gold/30 text-gold flex items-center justify-center hover:bg-gold hover:text-navy-dark transition-all disabled:opacity-40 disabled:pointer-events-none"
            aria-label="Testimonio anterior"
          >
            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 19l-7-7 7-7" />
            </svg>
          </button>
          <button
            type="button"
            onClick={next}
            disabled={index >= maxIndex}
            className="w-10 h-10 rounded-full border border-gold/30 text-gold flex items-center justify-center hover:bg-gold hover:text-navy-dark transition-all disabled:opacity-40 disabled:pointer-events-none"
            aria-label="Testimonio siguiente"
          >
            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 5l7 7-7 7" />
            </svg>
          </button>
        </div>
      </div>
    </section>
  );
}
