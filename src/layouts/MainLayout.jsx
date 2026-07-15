import Navbar from '../components/Navbar/Navbar.jsx';
import Hero from '../components/Hero/Hero.jsx';
import Stats from '../components/Stats/Stats.jsx';
import Properties from '../components/Properties/Properties.jsx';
import About from '../components/About/About.jsx';
import Projects from '../components/Projects/Projects.jsx';
import Testimonials from '../components/Testimonials/Testimonials.jsx';
import Process from '../components/Process/Process.jsx';
import Location from '../components/Location/Location.jsx';
import Contact from '../components/Contact/Contact.jsx';
import Footer from '../components/Footer/Footer.jsx';

/**
 * @param {{ data: object }} props
 */
export default function MainLayout({ data }) {
  return (
    <div className="min-h-screen bg-cream">
      <Navbar data={data.header} />
      <Hero data={data.hero} />
      <Stats items={data.stats?.items ?? []} />
      <Properties data={data.properties} />
      <About data={data.about} />
      <Projects data={data.projects} />
      <Testimonials data={data.testimonials} />
      <Process data={data.process} />
      <Location data={data.location} />
      <Contact data={data.contact} />
      <Footer data={data.footer} />
    </div>
  );
}
