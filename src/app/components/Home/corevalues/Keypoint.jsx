import React from 'react';
import Image from 'next/image';

export default function Keypoint({whoweare = []}) {
  return (
    <section className="relative">
      <div className=" mx-auto">
        <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
          <div className="lg:col-span-6">
            <div className="relative rounded-[20px] overflow-hidden shadow-lg">
              <img
                src={whoweare[0]?.image_path ? `${process.env.NEXT_PUBLIC_API_IMAGE_URL}${whoweare[0].image_path}` : `/assets/images/home/who_we_are.jpg`}
                alt="Mothers supporting each other – building a community of understanding and growth"
                height={985}
                width={1920}
                className="object-cover"
                sizes="(max-width: 1024px) 100vw, 50vw"
                priority
              />
            </div>
          </div>

          <div className="lg:col-span-6 order-1 lg:order-2 space-y-5 text-lg leading-relaxed  text-[#fff]">
            <div className='desc'>
            {whoweare[0]?.content ? (
              <div
                dangerouslySetInnerHTML={{ __html: whoweare[0].content }}/>
            ) : (
              <p>
                We are a group of passionate mothers who came together to build the space we once needed — a space where support is accessible, inclusion feels natural, and every story has a safe place to be heard. We are on this journey because, as mothers, we believe that every family deserves support, every story deserves to be understood, and every human deserves to be celebrated. Our lived experiences shaped our purpose: to create an ecosystem where real lives, real emotions, and real challenges are met with compassion, guidance, and connection. This is why we are building Thrive HQ.
              </p>
            )}
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}