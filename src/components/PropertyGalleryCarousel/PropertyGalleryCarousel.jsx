import { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';

function ChevronLeft() {
  return (
    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 19l-7-7 7-7" />
    </svg>
  );
}

function ChevronRight() {
  return (
    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 5l7 7-7 7" />
    </svg>
  );
}

/**
 * Gallery carousel for images after the propiedad description.
 *
 * @param {{ images: Array<{url: string, alt?: string}> }} props
 */
export default function PropertyGalleryCarousel({ images }) {
  const slides = Array.isArray(images) ? images.filter((img) => img?.url) : [];
  const [index, setIndex] = useState(0);

  if (slides.length === 0) {
    return null;
  }

  const total = slides.length;
  const prev = () => setIndex((i) => (i - 1 + total) % total);
  const next = () => setIndex((i) => (i + 1) % total);
  const current = slides[index];

  return (
    <div className="relative w-full h-[220px] sm:h-[320px] lg:h-[420px] overflow-hidden rounded-3xl bg-navy group">
      <AnimatePresence mode="wait">
        <motion.img
          key={current.url}
          src={current.url}
          alt={current.alt || ''}
          className="absolute inset-0 w-full h-full object-cover"
          width="1200"
          height="675"
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
          exit={{ opacity: 0 }}
          transition={{ duration: 0.45 }}
        />
      </AnimatePresence>

      {total > 1 ? (
        <>
          <button
            type="button"
            onClick={prev}
            className="absolute left-4 top-1/2 -translate-y-1/2 z-10 w-11 h-11 rounded-full bg-white/90 text-navy flex items-center justify-center shadow-md opacity-90 hover:opacity-100 transition-opacity"
            aria-label="Imagen anterior"
          >
            <ChevronLeft />
          </button>
          <button
            type="button"
            onClick={next}
            className="absolute right-4 top-1/2 -translate-y-1/2 z-10 w-11 h-11 rounded-full bg-white/90 text-navy flex items-center justify-center shadow-md opacity-90 hover:opacity-100 transition-opacity"
            aria-label="Imagen siguiente"
          >
            <ChevronRight />
          </button>
          <div className="absolute bottom-4 left-1/2 -translate-x-1/2 z-10 flex gap-2">
            {slides.map((slide, dotIndex) => (
              <button
                key={`${slide.url}-${dotIndex}`}
                type="button"
                aria-label={`Ir a imagen ${dotIndex + 1}`}
                aria-current={index === dotIndex}
                onClick={() => setIndex(dotIndex)}
                className={`h-2 rounded-full transition-all duration-300 ${index === dotIndex ? 'w-8 bg-white' : 'w-2 bg-white/50 hover:bg-white/80'}`}
              />
            ))}
          </div>
        </>
      ) : null}
    </div>
  );
}
