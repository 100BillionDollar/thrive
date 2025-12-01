import React from 'react'
import Image from 'next/image'
import Button from '../common/LinkButton'
import OutlineButton from '../common/OutlineButton'
export default function Banner() {
  return (
    <div className='relative '>
      <Image src={'/assets/images/home/banner.jpg'} alt='banner' className='w-screen lg:h-[auto]
       h-screen object-cover' height={2000} width={2000}/>
      <div className='content lg:px-0 px-[15px] w-full lg:w-[30%] left-[50%] lg:left-[20%] absolute transate-y-[-50%] translate-x-[-50%] top-[45%]' >
        <h1 className='text-[#fff] lg:text-[54px] text-[35px] leading-[1.] ivy_presto mb-[20px]'>Empowering Every Human to Thrive</h1>
        <p className='text-[#fff] lg:text-[26px] lg:max-w-[80%]'>A place for real people, real stories, and real growth</p>
        <div className='flex flex-wrap gap-[10px] mt-[30px]'>
        <Button text={'Explore Content'}/>
        <OutlineButton  text={'Join our Newsletter'}/>
        </div>
      </div>
    </div>
  )
}
 