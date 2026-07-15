import PropertiesCollection from '../components/PropertiesCollection/PropertiesCollection.jsx';

/**
 * @param {{ data: object, items: object[] }} props
 */
export default function PropertiesCollectionPage({ data, items }) {
  return <PropertiesCollection data={data} items={items} />;
}
