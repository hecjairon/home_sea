import { motion } from 'framer-motion';

/**
 * @param {{ data: { title: string, address: string, maps_url: string, cta_label: string } }} props
 */
export default function Location({ data }) {
  const patternBg =
    "url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23B8734A' fill-opacity='0.08'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E\")";

  return (
    <section className="relative" aria-labelledby="map-heading">
      <div className="map-container h-[400px] lg:h-[500px] w-full">
        <div className="absolute inset-0 opacity-40" style={{ backgroundImage: patternBg }} aria-hidden="true" />
        <div className="absolute inset-0 flex items-center justify-center">
          <motion.div
            className="text-center px-6"
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.6 }}
          >
            <h2 id="map-heading" className="sr-only">
              Ubicación de nuestras oficinas
            </h2>
            <div className="map-pin inline-flex flex-col items-center mb-6">
              <svg className="w-10 h-10 text-terracotta" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z" />
              </svg>
            </div>
            <p className="font-display text-2xl font-bold text-navy mb-2">{data.title}</p>
            <p className="text-gray-600 text-sm mb-6 whitespace-pre-line">{data.address}</p>
            <a
              href={data.maps_url}
              target="_blank"
              rel="noopener noreferrer"
              className="btn-terracotta-glow inline-flex items-center gap-2 px-8 py-3 bg-terracotta text-white text-sm font-semibold rounded-full hover:bg-terracotta-dark transition-all duration-300"
            >
              <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              {data.cta_label}
            </a>
          </motion.div>
        </div>
      </div>
    </section>
  );
}
