
import CommonLayout from "./components/common/CommonLayout";
import Banner from "./components/Home/Banner";
import Ecosystem from "./components/Home/Ecosystem";
import CoreValues from "./components/Home/CoreValues";
import NewsletterForm from "./components/Home/NewsletterForm";
import Contactus from "./components/Home/Contactus";


async function fetchData(endpoint) {
  try {
    const res = await fetch(`${process.env.NEXT_PUBLIC_API_BASE_URL}${endpoint}`);
    const data = await res.json();
    return data.success ? data.data : [];
  } catch (error) {
    console.error(`Error fetching ${endpoint}:`, error);
    return [];
  }
}

export default async function Home() {
  const [banners, whoweare, ecosystem, settings] = await Promise.all([
    fetchData('banners.php'),
    fetchData('whoweare.php'),
    fetchData('ecosystem.php'),
    fetchData('settings.php')
  ]);

  const ecosystemHeading = settings.ecosystem_heading || 'The ThriveHQ Ecosystem';

  console.log('Fetched whoweare data:', settings);    
  return (
    <CommonLayout>
        <Banner banners={banners} /> 
        <Ecosystem ecosystemData={ecosystem} heading={ecosystemHeading} />
          <CoreValues whoweare={whoweare} />
          <NewsletterForm/>
          {/* <Contactus/> */}
    </CommonLayout>
    );
}
