
import CommonLayout from "../components/common/CommonLayout";
import Banner from "./Banner";
import PrivacyPolicy from "./PrivacyPolicy";
export const metadata = {
  title: "ThriveHQ | Privacy Policy",
  description: "A place for real people, real stories, and real growth",
};
export default function Privax() {
  return (
        <CommonLayout>
        <Banner/>
        <PrivacyPolicy/> 
        </CommonLayout>
      
       
  );
}
