import React from 'react'
import Image from 'next/image'
export default function CoreValueIcon() {
  return (
    <div className='pt-[50px]'>
        <h6 className='text-[#D25238]'>Core Values</h6>

        <div className='mt-[50px] grid grid-cols-2 gap-[20px] lg:grid-cols-4'>
            <div className='text-center border-r-[1px] border-[#ffffff54] border-dashed'>
                <Image src={'/assets/images/home/corevalue/icon_1.svg'} className='mx-[auto] mb-[30px]' alt='icon' height={50} width={50}/>
                <h3 className='ivy_presto text-[#fff] text-[24px] tracking-[1.1] '>Integrity</h3>
            </div>
            <div className='text-center border-r-[1px] border-[#ffffff54] border-dashed'>
                <Image src={'/assets/images/home/corevalue/icon_2.svg'} className='mx-[auto] mb-[30px]' alt='icon' height={50} width={50}/>
                <h3 className='ivy_presto text-[#fff] text-[24px] tracking-[1.1] '>Inclusivity</h3>
            </div>
            <div className='text-center border-r-[1px] border-[#ffffff54] border-dashed'>
                <Image src={'/assets/images/home/corevalue/icon_3.svg'} className='mx-[auto] mb-[30px]' alt='icon' height={50} width={50}/>
                <h3 className='ivy_presto text-[#fff] text-[24px] tracking-[1.1] '>Apolitical</h3>
            </div>
            <div className='text-center'>
                <Image src={'/assets/images/home/corevalue/icon_4.svg'} className='mx-[auto] mb-[30px]' alt='icon' height={50} width={50}/>
                <h3 className='ivy_presto text-[#fff] text-[24px] tracking-[1.1] '>Family-First Culture.</h3>
            </div>
        </div>
      
    </div>
  )
}
