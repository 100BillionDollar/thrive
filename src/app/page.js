
import CommonLayout from "./components/common/CommonLayout";
import Banner from "./components/Home/Banner";
import WhoweAre from "./components/Home/WhoweAre";
import CoreValues from "./components/Home/CoreValues";
import NewsletterForm from "./components/Home/NewsletterForm";
import Contactus from "./components/Home/Contactus";
export default function Home() {
  return (
    <CommonLayout>
        <Banner/> 
        <WhoweAre/> 
        <CoreValues/> 
        <NewsletterForm/>
        <Contactus/>
   </CommonLayout>
  );
}
