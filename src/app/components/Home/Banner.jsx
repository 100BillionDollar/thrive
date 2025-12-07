'use client';
import React, { useState, useEffect } from 'react';
import Image from 'next/image';
import Button from '../common/LinkButton';
import { Swiper, SwiperSlide } from 'swiper/react';
import { EffectFade, Autoplay, Navigation, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/effect-fade';
import 'swiper/css/pagination';

export default function Banner() {
  const [isMounted, setIsMounted] = useState(false);

  const slides = [
    {
      img: '/assets/images/home/banner-one.jpg',
      alt: 'Banner 1',
      heading: 'Empowering Every Human to Thrive',
      sub: 'A place for real people, real stories, and real growth',
    },
    {
      img: '/assets/images/home/banner-two.jpg',
      alt: 'Banner 2',
     heading: 'Empowering Every Human to Thrive',
      sub: 'A place for real people, real stories, and real growth',
    },
    {
      img: '/assets/images/home/banner-three.jpg',
      alt: 'Banner 3',
       heading: 'Empowering Every Human to Thrive',
      sub: 'A place for real people, real stories, and real growth',
    },
  ];

  useEffect(() => {
    setIsMounted(true);
  }, []);

  if (!isMounted) {
    return (
      <div className="relative w-full h-screen bg-gray-200">
        <Image
          src={slides[0].img}
          alt={slides[0].alt}
          fill
          className="object-cover"
          priority
        />
      </div>
    );
  }

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
              height={1029}
              width={1920}
              className="object-cover w-full h-full"
              priority={idx === 0}
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
                  <Button text="Join Our Tribe" />
                </div>
              </div>
            </div>
          </SwiperSlide>
        ))}
      </Swiper>

    
    </div>
  );
}