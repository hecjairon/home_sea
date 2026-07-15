import { useCallback, useEffect, useState } from 'react';
import Home from './pages/Home.jsx';
import Property from './pages/Property.jsx';
import PropertiesCollectionPage from './pages/PropertiesCollection.jsx';
import Project from './pages/Project.jsx';
import ProjectsCollectionPage from './pages/ProjectsCollection.jsx';
import { getSiteData } from './services/api.js';
import LoadingSkeleton from './components/LoadingSkeleton/LoadingSkeleton.jsx';
import ErrorState from './components/ErrorState/ErrorState.jsx';

function getBoot() {
  if (typeof window === 'undefined') {
    return { view: 'home', propiedad: null, proyecto: null, collection: [] };
  }
  const boot = window.homeSeaThemeData || {};
  return {
    view: boot.view || 'home',
    propiedad: boot.propiedad || null,
    proyecto: boot.proyecto || null,
    collection: Array.isArray(boot.collection) ? boot.collection : [],
  };
}

export default function App() {
  const boot = getBoot();
  const [data, setData] = useState(null);
  const [status, setStatus] = useState('loading');
  const [error, setError] = useState(null);
  const [attempt, setAttempt] = useState(0);

  const retry = useCallback(() => {
    setAttempt((n) => n + 1);
  }, []);

  useEffect(() => {
    let cancelled = false;

    async function load() {
      setStatus('loading');
      setError(null);

      try {
        const siteData = await getSiteData();
        if (!cancelled) {
          setData(siteData);
          setStatus('ready');
        }
      } catch (err) {
        if (!cancelled) {
          setData(null);
          setError(err instanceof Error ? err.message : 'Error desconocido');
          setStatus('error');
        }
      }
    }

    load();

    return () => {
      cancelled = true;
    };
  }, [attempt]);

  if (status === 'loading') {
    return <LoadingSkeleton />;
  }

  if (status === 'error' || !data) {
    return (
      <ErrorState
        message={error || 'No se pudieron cargar los datos del sitio.'}
        onRetry={retry}
      />
    );
  }

  if (boot.view === 'propiedad' && boot.propiedad) {
    return <Property data={data} property={boot.propiedad} />;
  }

  if (boot.view === 'propiedades-collection') {
    return <PropertiesCollectionPage data={data} items={boot.collection} />;
  }

  if (boot.view === 'proyecto' && boot.proyecto) {
    return <Project data={data} project={boot.proyecto} />;
  }

  if (boot.view === 'proyectos-collection') {
    return <ProjectsCollectionPage data={data} items={boot.collection} />;
  }

  return <Home data={data} />;
}
