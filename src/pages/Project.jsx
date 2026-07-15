import ProjectSingle from '../components/ProjectSingle/ProjectSingle.jsx';

/**
 * @param {{ data: object, project: object }} props
 */
export default function Project({ data, project }) {
  return <ProjectSingle data={data} project={project} />;
}
