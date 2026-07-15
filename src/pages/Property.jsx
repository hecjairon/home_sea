import PropertySingle from '../components/PropertySingle/PropertySingle.jsx';

/**
 * @param {{ data: object, property: object }} props
 */
export default function Property({ data, property }) {
  return <PropertySingle data={data} property={property} />;
}
