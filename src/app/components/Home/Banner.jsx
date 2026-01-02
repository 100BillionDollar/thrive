"use client";
import React from 'react';
import Image from 'next/image';
import Button from '../common/Button';
import { Swiper, SwiperSlide } from 'swiper/react';
import { EffectFade, Autoplay, Navigation, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/effect-fade';
import 'swiper/css/pagination';
import gsap from 'gsap';

export default function Banner({ banners = [] }) {
  const scrollToSection = (sectionId) => {
    gsap.to(window, {
      duration: 1.2,
      scrollTo: { y: sectionId, offsetY: 80 },
      ease: "power3.inOut",
      onComplete: () => {
        if (isMenuOpen) toggleMenu()
      }
    })
  }

 

  const slides = banners.map(banner => ({
    img: `${process.env.NEXT_PUBLIC_API_IMAGE_URL}${banner.image_path}`,
    alt: banner.title,
    heading: banner.title,
    sub: banner.content
  })) ;
  console.log('Banner slides:', slides);

  return (
    <div className="relative banner">
      <Swiper
        modules={[EffectFade, Autoplay, Navigation, Pagination]}
        effect="fade"
        fadeEffect={{ crossFade: true }}
        autoplay={{ delay: 4000, disableOnInteraction: false }}
        loop={true}
        speed={1000}
        pagination={{
          clickable: true,
        }}
        className="w-full h-[59vh] lg:h-screen"
      >
        {slides.map((slide, idx) => (
          <SwiperSlide key={idx} className='h-full'>
            <Image
              src={slide.img}
              alt={slide.alt}
              fill
              className="object-cover"
              unoptimized={true}
            />
            <div className="absolute inset-0 lg:bg-black/30 bg-black/60" />
            <div className="absolute inset-0 flex lg:pl-[100px] items-center pt-[40px] lg:pt-0   lg:items-end lg:pb-[140px]  lg:justify-start z-10">
              <div className="content lg:px-0 px-[15px] w-full  max-w-[82%] lg:max-w-[32%] text-left">
                <h1 className="text-[#fff] lg:text-[54px]  text-[35px] leading-[1.2] ivy_presto mb-[20px] animate-fadeIn">
                  {slide.heading}
                </h1>
                <p className="text-[#fff] lg:text-[26px] text-[20px] lg:max-w-[80%] animate-fadeIn animation-delay-300">
                  {slide.sub}
                </p>
                <div className="flex flex-wrap gap-[10px] mt-[45px] justify-start animate-fadeIn animation-delay-600">
                  <Button text="Join Our Tribe"  onClick={() => scrollToSection('#newsletter')}/>
                </div>
              </div>
            </div>
          </SwiperSlide>
        ))}
      </Swiper>


    </div>
  );
}