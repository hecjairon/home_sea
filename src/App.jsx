import { useCallback, useEffect, useState } from 'react';
import Home from './pages/Home.jsx';
import { getSiteData } from './services/api.js';
import LoadingSkeleton from './components/LoadingSkeleton/LoadingSkeleton.jsx';
import ErrorState from './components/ErrorState/ErrorState.jsx';

export default function App() {
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

  return <Home data={data} />;
}
