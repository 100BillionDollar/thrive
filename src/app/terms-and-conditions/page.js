
import CommonLayout from "../components/common/CommonLayout";
import Banner from "./Banner";
import Termsuse from "./Termsuse";
export const metadata = {
  title: "ThriveHQ | Terms Of Use",
  description: "A place for real people, real stories, and real growth",
};
export default function Privax() {
  return (
        <CommonLayout>
        <Banner/>
        <Termsuse/> 
        </CommonLayout>
      
       
  );
}
