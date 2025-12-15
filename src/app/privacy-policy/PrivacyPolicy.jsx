import next from 'react'
import Link from 'next/link'
import SecondaryHeading from "../components/common/SecondaryHeading";

export default function Privacy() {
  return (
    <section className="privacy_section bg-[#fff] py-10">
      <div className="container-custom">
         <div className="heading">
                  <SecondaryHeading customclass={`!text-[#000]`} text={`Privacy Policy`} />
                
                </div>
        <section className="mb-7">
            <h2 className="text-2xl font-semibold text-gray-900 mb-4">1. Introduction</h2>
            <p className="text-gray-700 leading-relaxed mb-4">
                ThriveHQ FZ-LLC ("ThriveHQ," "we," "our," or "us") respects your privacy and is committed to protecting the personal data you share with us through our website, social media channels, and related digital platforms. This Privacy Policy explains how we collect, use, store, and protect your information in accordance with applicable laws of the United Arab Emirates, including Federal Decree-Law No. 45 of 2021 on the Protection of Personal Data (PDPL).
            </p>
            <p className="text-gray-700 leading-relaxed">
                By accessing or using our website, you consent to the terms of this Privacy Policy.
            </p>
        </section>

        <section className="mb-7">
            <h2 className="text-2xl font-semibold text-gray-900 mb-4">2. Information We Collect</h2>
            <p className="text-gray-700 leading-relaxed mb-4">We may collect the following categories of information:</p>
            <ul className="space-y-2 text-gray-700 ml-6">
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Personal Identification Information</span>
                </li>
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Professional or Business Information</span>
                </li>
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Usage Data</span>
                </li>
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Cookies and Tracking Technologies</span>
                </li>
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Event and Program Data</span>
                </li>
            </ul>
        </section>

        <section className="mb-7">
            <h2 className="text-2xl font-semibold text-gray-900 mb-4">3. How We Use Your Information</h2>
            <p className="text-gray-700 leading-relaxed mb-4">We process your data to:</p>
            <ul className="space-y-2 text-gray-700 ml-6">
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Provide, manage, and improve our services and programs.</span>
                </li>
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Communicate newsletters, event invitations, updates, or partnership information.</span>
                </li>
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Personalise your user experience and content.</span>
                </li>
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Conduct analytics, research, and internal reporting.</span>
                </li>
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Comply with applicable laws and regulatory obligations.</span>
                </li>
            </ul>
        </section>

        <section className="mb-7">
            <h2 className="text-2xl font-semibold text-gray-900 mb-4">4. Legal Basis for Processing</h2>
            <p className="text-gray-700 leading-relaxed mb-4">Your personal data is processed on one or more legal bases under the UAE PDPL:</p>
            <ul className="space-y-2 text-gray-700 ml-6">
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Consent</span>
                </li>
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Legitimate interests</span>
                </li>
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Legal or contractual necessity</span>
                </li>
            </ul>
        </section>

        <section className="mb-7">
            <h2 className="text-2xl font-semibold text-gray-900 mb-4">5. Data Sharing and Disclosure</h2>
            <p className="text-gray-700 leading-relaxed mb-4">We may share your information with:</p>
            <ul className="space-y-2 text-gray-700 ml-6">
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Event partners or sponsors (with consent)</span>
                </li>
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>UAE governmental authorities when legally required</span>
                </li>
            </ul>
        </section>

        <section className="mb-7">
            <h2 className="text-2xl font-semibold text-gray-900 mb-4">6. Data Retention</h2>
            <p className="text-gray-700 leading-relaxed">
                We retain personal data only as long as necessary or as required by UAE law.
            </p>
        </section>

        <section className="mb-7">
            <h2 className="text-2xl font-semibold text-gray-900 mb-4">7. Data Security</h2>
            <p className="text-gray-700 leading-relaxed">
                ThriveHQ uses appropriate technical and organisational measures to protect your personal data.
            </p>
        </section>

        <section className="mb-7">
            <h2 className="text-2xl font-semibold text-gray-900 mb-4">8. International Data Transfers</h2>
            <p className="text-gray-700 leading-relaxed">
                If personal data is transferred outside the UAE, we ensure adequate protection consistent with UAE PDPL requirements.
            </p>
        </section>

        <section className="mb-7">
            <h2 className="text-2xl font-semibold text-gray-900 mb-4">9. Your Rights</h2>
            <p className="text-gray-700 leading-relaxed mb-4">Under UAE law, you may:</p>
            <ul className="space-y-2 text-gray-700 mb-4 ml-6">
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Access your data</span>
                </li>
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Request correction or deletion</span>
                </li>
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Withdraw consent</span>
                </li>
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Object to processing</span>
                </li>
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>File a complaint with the UAE Data Office</span>
                </li>
            </ul>
            <p className="text-gray-700 leading-relaxed">
                To exercise these rights, contact: <a href="mailto:media@themomshq.me" className="text-[#005057ab] hover:underline">media@themomshq.me</a>
            </p>
        </section>

        <section className="mb-7">
            <h2 className="text-2xl font-semibold text-gray-900 mb-4">10. Contact Us</h2>
            <div className="text-gray-700 leading-relaxed space-y-1">
                <p className="font-semibold">ThriveHQ FZ-LLC</p>
                <p>Dubai Media City, Dubai, UAE</p>
                <p><a href="mailto:media@themomshq.me" className="text-[#005057ab] hover:underline">media@themomshq.me</a></p>
                <p><a href="http://www.wearethrivehq.com" target="_blank" className="text-[#005057ab] hover:underline">www.wearethrivehq.com</a></p>
            </div>
        </section>

        <section>
            <h2 className="text-2xl font-semibold text-gray-900 mb-4">11. Updates to This Policy</h2>
            <p className="text-gray-700 leading-relaxed">
                We may update this policy periodically. Please review this page for changes.
            </p>
        </section>
        </div>
      
    </section>
  )
}
