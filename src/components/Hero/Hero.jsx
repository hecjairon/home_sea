import { useState } from 'react';
import { motion } from 'framer-motion';

/**
 * @param {{ data: object }} props
 */
export default function Hero({ data }) {
  const [operation, setOperation] = useState('comprar');

  const handleSubmit = (e) => {
    e.preventDefault();
  };

  return (
    <section id="inicio" className="relative min-h-screen flex items-center overflow-hidden" aria-label="Sección principal">
      <div className="absolute inset-0 scale-110" aria-hidden="true">
        <img
          src={data.image_url}
          alt={data.image_alt}
          className="w-full h-full object-cover"
          width="1920"
          height="1080"
          fetchPriority="high"
        />
      </div>
      <div className="hero-warm-overlay absolute inset-0" aria-hidden="true" />
      <div className="blob-organic blob-organic-1 absolute top-1/4 -left-24 w-80 h-80" aria-hidden="true" />
      <div className="blob-organic blob-organic-2 absolute bottom-1/4 right-0 w-96 h-96" aria-hidden="true" />
      <div className="blob-organic blob-organic-3 absolute top-1/2 left-1/3 w-64 h-64" aria-hidden="true" />

      <div className="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 py-32 w-full">
        <div className="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
          <motion.div
            initial={{ opacity: 0, y: 32 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.8, ease: [0.16, 1, 0.3, 1] }}
          >
            <div className="terracotta-line mb-6" />
            <p className="text-gold text-sm font-medium tracking-[0.2em] uppercase mb-4">{data.eyebrow}</p>
            <h1 className="font-display text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-[1.15] mb-6">
              {data.title}
            </h1>
            <p className="text-lg text-white/80 leading-relaxed mb-10 max-w-xl">{data.subtitle}</p>
            <div className="flex flex-wrap gap-4">
              <a
                href={data.primary_url}
                className="btn-terracotta-glow inline-flex items-center px-8 py-3.5 bg-terracotta text-white text-sm font-semibold rounded-full hover:bg-terracotta-dark transition-all duration-300"
              >
                {data.primary_label}
              </a>
              <a
                href={data.secondary_url}
                className="inline-flex items-center px-8 py-3.5 border border-white/40 text-white text-sm font-semibold rounded-full hover:bg-white/10 transition-all duration-300"
              >
                {data.secondary_label}
              </a>
            </div>
          </motion.div>

          <motion.div
            initial={{ opacity: 0, x: 40 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.8, delay: 0.2, ease: [0.16, 1, 0.3, 1] }}
          >
            <form
              className="search-card rounded-3xl p-6 sm:p-8"
              role="search"
              aria-label="Buscador de propiedades"
              onSubmit={handleSubmit}
            >
              <h2 className="font-display text-navy font-bold text-xl mb-1">{data.search.title}</h2>
              <p className="text-gray-500 text-sm mb-6">{data.search.description}</p>
              <div className="space-y-5">
                <fieldset>
                  <legend className="text-terracotta text-xs uppercase tracking-wider mb-2 font-medium">
                    Operación
                  </legend>
                  <div className="flex gap-2">
                    {[
                      { value: 'comprar', label: 'Comprar' },
                      { value: 'alquilar', label: 'Alquilar' },
                    ].map((op) => (
                      <label key={op.value} className="flex-1">
                        <input
                          type="radio"
                          name="operacion"
                          value={op.value}
                          checked={operation === op.value}
                          onChange={() => setOperation(op.value)}
                          className="sr-only"
                        />
                        <span
                          className={`block text-center py-2.5 rounded-2xl text-sm font-medium cursor-pointer transition-all duration-300 border ${
                            operation === op.value
                              ? 'bg-terracotta text-white border-terracotta'
                              : 'text-gray-600 border-terracotta/20'
                          }`}
                        >
                          {op.label}
                        </span>
                      </label>
                    ))}
                  </div>
                </fieldset>
                <div>
                  <label htmlFor="tipo" className="text-terracotta text-xs uppercase tracking-wider mb-2 block font-medium">
                    Tipo
                  </label>
                  <select
                    id="tipo"
                    name="tipo"
                    className="w-full rounded-2xl px-4 py-3 text-gray-800 text-sm appearance-none cursor-pointer bg-white border border-terracotta/20"
                  >
                    {data.search.types.map((type) => (
                      <option key={type.value} value={type.value}>
                        {type.label}
                      </option>
                    ))}
                  </select>
                </div>
                <div>
                  <label htmlFor="ciudad" className="text-terracotta text-xs uppercase tracking-wider mb-2 block font-medium">
                    Zona
                  </label>
                  <input
                    type="text"
                    id="ciudad"
                    name="ciudad"
                    placeholder="Ej: Marbella, Mallorca, Niza..."
                    className="w-full rounded-2xl px-4 py-3 text-gray-800 placeholder-gray-400 text-sm bg-white border border-terracotta/20"
                  />
                </div>
                <div className="grid grid-cols-2 gap-4">
                  <div>
                    <label htmlFor="precio-min" className="text-terracotta text-xs uppercase tracking-wider mb-2 block font-medium">
                      Precio mín.
                    </label>
                    <input
                      type="number"
                      id="precio-min"
                      name="precio-min"
                      placeholder="€ 300.000"
                      className="w-full rounded-2xl px-4 py-3 text-gray-800 placeholder-gray-400 text-sm bg-white border border-terracotta/20"
                    />
                  </div>
                  <div>
                    <label htmlFor="precio-max" className="text-terracotta text-xs uppercase tracking-wider mb-2 block font-medium">
                      Precio máx.
                    </label>
                    <input
                      type="number"
                      id="precio-max"
                      name="precio-max"
                      placeholder="€ 3.000.000"
                      className="w-full rounded-2xl px-4 py-3 text-gray-800 placeholder-gray-400 text-sm bg-white border border-terracotta/20"
                    />
                  </div>
                </div>
                <button
                  type="submit"
                  className="btn-terracotta-glow w-full py-3.5 bg-terracotta text-white font-semibold rounded-2xl hover:bg-terracotta-dark transition-all duration-300 text-sm"
                >
                  {data.search.submit_label}
                </button>
              </div>
            </form>
          </motion.div>
        </div>
      </div>

      <div className="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce" aria-hidden="true">
        <svg className="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
        </svg>
      </div>
    </section>
  );
}
