import ProjectsCollection from '../components/ProjectsCollection/ProjectsCollection.jsx';

/**
 * @param {{ data: object, items: object[] }} props
 */
export default function ProjectsCollectionPage({ data, items }) {
  return <ProjectsCollection data={data} items={items} />;
}
