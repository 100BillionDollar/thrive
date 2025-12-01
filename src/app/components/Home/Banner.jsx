import React from 'react'
import Image from 'next/image'
import Button from '../common/LinkButton'
import OutlineButton from '../common/OutlineButton'
export default function Banner() {
  return (
    <div className='relative '>
      <Image src={'/assets/images/home/banner.jpg'} alt='banner' className='w-screen object-cover' height={2000} width={2000}/>
      <div className='content w-[30%] left-[20%] absolute transate-y-[50%] translate-x-[-50%] top-[45%]' >
        <h1 className='text-[#fff] text-[54px] leading-[1.] ivy_presto mb-[20px]'>Empowering Every Human to Thrive</h1>
        <p className='text-[#fff] text-[26px] max-w-[80%]'>A place for real people, real stories, and real growth</p>
        <div className='flex gap-[10px] mt-[30px]'>
        <Button text={'Explore Content'}/>
        <OutlineButton  text={'Join our Newsletter'}/>
        </div>
      </div>
    </div>
  )
}
 