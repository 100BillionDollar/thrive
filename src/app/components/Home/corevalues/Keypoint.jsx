import React from 'react';
import Image from 'next/image';

export default function Keypoint() {
  return (
    <section className=" pb-[80px] lg:pb-[100px]">
      <div className="container mx-auto px-4 lg:px-0">
        <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
          <div className="lg:col-span-6 order-2 lg:order-1">
            <div className="relative rounded-[20px] overflow-hidden shadow-lg">
              <Image
                src="/assets/images/home/corevalue/key_point_right_img.jpg"
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
            <p>
              We came together as mothers because we once needed a space like this ourselves — a space where you don’t have to explain your struggles, where support feels easy to reach, and where your story is met with kindness instead of judgement.
            </p>
            <p>
              We believe every family deserves that kind of space. Every mother deserves to feel understood. Every child deserves to feel seen. And every human deserves to be celebrated for who they are.
            </p>
            <p>
              Our own journeys — the highs, the doubts, the pressures, and the quiet moments no one talks about — are what shaped this mission. We built this ecosystem so mothers, families, and people of determination can access support without barriers.
            </p>
            <p>
              So every story is met with connection, compassion, and a pathway to growth.
            </p>
            <p className="text-xl text-[#fff] ">
              This is why we are building ThriveHQ.
            </p>
            <p className="text-lg text-[#fff] font-medium">
              We are building an ecosystem where growth is accessible, inclusion is normal, and every human is empowered to thrive.
            </p>
          </div>
        </div>
      </div>
    </section>
  );
}