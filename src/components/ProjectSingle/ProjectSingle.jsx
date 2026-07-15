import { motion } from 'framer-motion';
import Navbar from '../Navbar/Navbar.jsx';
import Footer from '../Footer/Footer.jsx';
import PropertyGalleryCarousel from '../PropertyGalleryCarousel/PropertyGalleryCarousel.jsx';

const BADGE_STYLES = {
  terracotta: 'text-terracotta bg-terracotta/10',
  gold: 'text-gold bg-gold/10',
  navy: 'text-navy bg-navy/10',
};

/**
 * Single proyecto — featured hero background + descripción + galería.
 *
 * @param {{ data: object, project: object }} props
 */
export default function ProjectSingle({ data, project }) {
  if (!project) {
    return null;
  }

  const collectionUrl =
    typeof window !== 'undefined'
      ? window.homeSeaThemeData?.projectsCollectionUrl || `${window.homeSeaThemeData?.homeUrl || '/'}#proyectos`
      : '/proyectos/';
  const gallery = Array.isArray(project.images) ? project.images.filter((img) => img?.url) : [];
  const badgeClass = BADGE_STYLES[project.badge_variant] || BADGE_STYLES.terracotta;

  return (
    <div className="min-h-screen bg-cream">
      <Navbar data={data.header} />

      <section className="pb-24 lg:pb-32" aria-labelledby="project-title">
        <div className="relative w-full h-[240px] sm:h-[360px] lg:h-[480px] overflow-hidden bg-navy">
          {project.image_url ? (
            <img
              src={project.image_url}
              alt={project.image_alt || project.title}
              className="absolute inset-0 w-full h-full object-cover"
              width="1600"
              height="686"
            />
          ) : null}
        </div>

        <div className="max-w-7xl mx-auto px-6 lg:px-8 -mt-16 relative z-10">
          <motion.article
            className="warm-surface rounded-3xl p-8 lg:p-12"
            initial={{ opacity: 0, y: 24 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
          >
            <a
              href={collectionUrl}
              className="inline-flex items-center gap-2 text-sm text-terracotta font-medium hover:text-terracotta-dark transition-colors mb-6"
            >
              <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 19l-7-7 7-7" />
              </svg>
              Volver a proyectos
            </a>

            <div className="terracotta-line mb-4" />
            {project.badge ? (
              <span className={`inline-block mb-4 text-xs font-semibold px-2.5 py-1 rounded-full ${badgeClass}`}>
                {project.badge}
              </span>
            ) : null}
            <h1 id="project-title" className="font-display text-4xl lg:text-5xl font-bold text-navy mb-3">
              {project.title}
            </h1>
            {project.location ? (
              <p className="text-gray-500 text-base mb-8">{project.location}</p>
            ) : null}

            {project.description ? (
              <div
                className="prose prose-navy max-w-none text-gray-600 leading-relaxed [&_p]:mb-4 [&_a]:text-terracotta"
                dangerouslySetInnerHTML={{ __html: project.description }}
              />
            ) : null}

            {gallery.length > 0 ? (
              <div className="mt-10 pt-10 border-t border-terracotta/15">
                <h2 className="font-display text-2xl font-bold text-navy mb-6">Galería</h2>
                <PropertyGalleryCarousel images={gallery} />
              </div>
            ) : null}
          </motion.article>
        </div>
      </section>

      <Footer data={data.footer} />
    </div>
  );
}
