import next from 'react'
import SecondaryHeading from "../components/common/SecondaryHeading";

export default function Privacy() {
  return (
    <section className="privacy_section bg-[#fff] py-10">
      <div className="container-custom">
         <div className="heading">
                          <SecondaryHeading customclass={`!text-[#000]`} text={`Terms Of Use`} />
                        
                        </div>
        <section className="mb-7">
            <h2 className="text-2xl font-semibold text-gray-900 mb-4">1. Acceptance of Terms</h2>
            <p className="text-gray-700 leading-relaxed mb-4">
                These Terms of Use ("Terms") govern your access to and use of the ThriveHQ website, including all content, media, community platforms, programs, campaigns, events, and digital services operated by ThriveHQ FZ-LLC ("ThriveHQ," "we," "our," or "us").
            </p>
            <p className="text-gray-700 leading-relaxed">
                By accessing or using this website, you agree to be bound by these Terms. If you do not agree, you must discontinue use of the website immediately.
            </p>
        </section>

        <section className="mb-7">
            <h2 className="text-2xl font-semibold text-gray-900 mb-4">2. About ThriveHQ – Social Impact Media Ecosystem</h2>
            <p className="text-gray-700 leading-relaxed mb-4">
                ThriveHQ is a UAE-based social impact media ecosystem that designs and delivers purpose-driven content, community platforms, programs, and events focused on parents, mothers, women, and families.
            </p>
            <p className="text-gray-700 leading-relaxed mb-4">
                ThriveHQ operates media-led initiatives and platforms including Parenting360, TheMomsHQ, and Diyaa which collectively aim to:
            </p>
            <ul className="space-y-2 text-gray-700 ml-6 mb-4">
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Amplify lived experiences and under-represented narratives</span>
                </li>
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Drive awareness and dialogue on social, parenting, and family-centric themes</span>
                </li>
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Enable education, connection, and community participation</span>
                </li>
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Support partnerships, campaigns, and events aligned with positive social outcomes</span>
                </li>
            </ul>
            <p className="text-gray-700 leading-relaxed">
                The website functions as an information, engagement, and participation platform for community members, partners, collaborators, and stakeholders aligned with ThriveHQ's mission.
            </p>
        </section>

        <section className="mb-7">
            <h2 className="text-2xl font-semibold text-gray-900 mb-4">3. Eligibility</h2>
            <p className="text-gray-700 leading-relaxed mb-4">
                You must be at least 18 years of age to access or use this website or submit any personal information.
            </p>
            <p className="text-gray-700 leading-relaxed">
                By using the website, you represent and warrant that you meet this requirement.
            </p>
        </section>

        <section className="mb-7">
            <h2 className="text-2xl font-semibold text-gray-900 mb-4">4. Use of Website and Community Standards</h2>
            <p className="text-gray-700 leading-relaxed mb-4">
                You agree to use the website and associated community platforms in a responsible, respectful, and lawful manner.
            </p>
            <p className="text-gray-700 leading-relaxed mb-4">You must not:</p>
            <ul className="space-y-2 text-gray-700 ml-6 mb-4">
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Violate any applicable UAE laws or regulations</span>
                </li>
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Misrepresent your identity or affiliation</span>
                </li>
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Post or transmit harmful, misleading, defamatory, discriminatory, or inappropriate content</span>
                </li>
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Disrupt community discussions, events, or digital platforms</span>
                </li>
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Attempt unauthorised access to systems, data, or networks</span>
                </li>
            </ul>
            <p className="text-gray-700 leading-relaxed">
                ThriveHQ reserves the right to moderate, restrict, suspend, or terminate access where conduct is inconsistent with its values as a social impact platform.
            </p>
        </section>

        <section className="mb-7">
            <h2 className="text-2xl font-semibold text-gray-900 mb-4">5. Intellectual Property and Media Rights</h2>
            <p className="text-gray-700 leading-relaxed mb-4">
                All content available on the website, including editorial content, media assets, videos, graphics, branding, campaigns, frameworks, designs, and materials, is the intellectual property of ThriveHQ or its content partners and licensors.
            </p>
            <p className="text-gray-700 leading-relaxed mb-4">
                You may view and share content for personal, non-commercial use only, provided that proper attribution is maintained.
            </p>
            <p className="text-gray-700 leading-relaxed">
                Any reproduction, commercial use, modification, or redistribution requires prior written consent from ThriveHQ.
            </p>
        </section>

        <section className="mb-7">
            <h2 className="text-2xl font-semibold text-gray-900 mb-4">6. User-Generated Content and Contributions</h2>
            <p className="text-gray-700 leading-relaxed mb-4">
                Where users submit content, stories, feedback, or materials to ThriveHQ:
            </p>
            <ul className="space-y-2 text-gray-700 ml-6 mb-4">
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>You confirm that the content is original, accurate, and lawful</span>
                </li>
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>You grant ThriveHQ a non-exclusive, royalty-free right to use, reproduce, and publish such content for editorial, community, awareness, and impact-driven purposes</span>
                </li>
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>You acknowledge that ThriveHQ may edit or moderate submissions for clarity, safety, or alignment with platform values</span>
                </li>
            </ul>
            <p className="text-gray-700 leading-relaxed">
                ThriveHQ does not claim ownership over personal stories but reserves editorial discretion in how content is presented.
            </p>
        </section>

        <section className="mb-7">
            <h2 className="text-2xl font-semibold text-gray-900 mb-4">7. Programs, Campaigns, Events, and Community Participation</h2>
            <p className="text-gray-700 leading-relaxed mb-4">
                Participation in ThriveHQ programs, campaigns, events, or community initiatives may be subject to additional guidelines, codes of conduct, or participation terms.
            </p>
            <p className="text-gray-700 leading-relaxed mb-4">ThriveHQ reserves the right to:</p>
            <ul className="space-y-2 text-gray-700 ml-6">
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Modify, reschedule, or cancel initiatives</span>
                </li>
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Limit participation to ensure safety, inclusivity, and alignment with impact goals</span>
                </li>
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Decline participation where behaviour is inconsistent with community standards</span>
                </li>
            </ul>
        </section>

        <section className="mb-7">
            <h2 className="text-2xl font-semibold text-gray-900 mb-4">8. Partnerships, Sponsorships, and Collaborations</h2>
            <p className="text-gray-700 leading-relaxed mb-4">
                ThriveHQ collaborates with brands, institutions, non-profits, and stakeholders aligned with its social impact mission.
            </p>
            <p className="text-gray-700 leading-relaxed mb-4">
                Any partnership, sponsorship, or co-branded initiative referenced on the website is subject to separate written agreements.
            </p>
            <p className="text-gray-700 leading-relaxed">
                Use of ThriveHQ branding, media assets, or community access for partnership purposes is not permitted without explicit authorisation.
            </p>
        </section>

        <section className="mb-7">
            <h2 className="text-2xl font-semibold text-gray-900 mb-4">9. Third-Party Platforms and Links</h2>
            <p className="text-gray-700 leading-relaxed mb-4">
                The website may include links to third-party platforms, media channels, or partner websites.
            </p>
            <p className="text-gray-700 leading-relaxed mb-4">
                ThriveHQ does not control or endorse external platforms and is not responsible for their content, policies, or practices.
            </p>
            <p className="text-gray-700 leading-relaxed">
                Accessing third-party links is at your own discretion and risk.
            </p>
        </section>

        <section className="mb-7">
            <h2 className="text-2xl font-semibold text-gray-900 mb-4">10. Disclaimer</h2>
            <p className="text-gray-700 leading-relaxed mb-4">
                All content on the website is provided for informational, educational, and awareness purposes only.
            </p>
            <p className="text-gray-700 leading-relaxed mb-4">
                While ThriveHQ aims to foster responsible dialogue and informed perspectives, content does not constitute professional, medical, legal, or financial advice.
            </p>
            <p className="text-gray-700 leading-relaxed">
                Views expressed in editorial or user-generated content reflect personal experiences and opinions.
            </p>
        </section>

        <section className="mb-7">
            <h2 className="text-2xl font-semibold text-gray-900 mb-4">11. Limitation of Liability</h2>
            <p className="text-gray-700 leading-relaxed mb-4">
                To the maximum extent permitted under UAE law, ThriveHQ shall not be liable for any direct or indirect loss, damage, or harm arising from:
            </p>
            <ul className="space-y-2 text-gray-700 ml-6">
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Use of or reliance on website content</span>
                </li>
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Participation in community initiatives, events, or campaigns</span>
                </li>
                <li className="flex items-start">
                    <span className="text-black-600 mr-2">•</span>
                    <span>Technical interruptions, data loss, or platform unavailability</span>
                </li>
            </ul>
        </section>

        <section className="mb-7">
            <h2 className="text-2xl font-semibold text-gray-900 mb-4">12. Privacy and Data Protection</h2>
            <p className="text-gray-700 leading-relaxed">
                Use of this website is governed by ThriveHQ's Privacy Policy, which outlines how personal data is collected, processed, and protected in accordance with UAE Federal Decree-Law No. 45 of 2021 on Personal Data Protection.
            </p>
        </section>

        <section className="mb-7">
            <h2 className="text-2xl font-semibold text-gray-900 mb-4">13. Amendments</h2>
            <p className="text-gray-700 leading-relaxed mb-4">
                ThriveHQ reserves the right to amend these Terms at any time.
            </p>
            <p className="text-gray-700 leading-relaxed">
                Updated Terms will be published on the website and become effective immediately upon posting.
            </p>
        </section>

        <section className="mb-7">
            <h2 className="text-2xl font-semibold text-gray-900 mb-4">14. Governing Law and Jurisdiction</h2>
            <p className="text-gray-700 leading-relaxed mb-4">
                These Terms are governed by the laws of the United Arab Emirates.
            </p>
            <p className="text-gray-700 leading-relaxed">
                Any disputes shall be subject to the exclusive jurisdiction of the courts of Dubai, UAE.
            </p>
        </section>

        <section className="mb-7">
            <h2 className="text-2xl font-semibold text-gray-900 mb-4">15. Contact Information</h2>
            <p className="text-gray-700 leading-relaxed mb-4">
                For questions or concerns regarding these Terms, please contact:
            </p>
            <div className="text-gray-700 leading-relaxed space-y-1">
                <p className="font-semibold">ThriveHQ FZ-LLC</p>
                <p>Dubai Media City</p>
                <p>Dubai, United Arab Emirates</p>
                <p className='flex items-center'>
<svg 
  className="w-5 h-5 mr-2 mt-1 text-[#005057ab]" 
  fill="none" 
  stroke="currentColor" 
  viewBox="0 0 24 24"
>
  <path 
    strokeLinecap="round" 
    strokeLinejoin="round" 
    strokeWidth="2" 
    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
  />
</svg>
                <a href="mailto:people@themomshq.me" className="text-[#005057ab] hover:underline">people@themomshq.me</a></p>
            </div>
        </section>

        </div>
      
    </section>
  )
}
