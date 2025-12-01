import React from 'react'
import Image from 'next/image'
export default function Keypoint() {
    return (
        <div className='pt-[80px]'>
            <div className='grid grid-cols-12 gap-[70px]'>
                <div className='col-span-5'>
                    <Image src={`/assets/images/home/corevalue/key_point_right.jpg`} alt='right banner' className='rounded-[20px]' height={656} width={597} />
                </div>
                <div className='col-span-7 m-[auto]'>
                    <h2 className='text-[32px] max-w-[70%] text-[#fff] leading-[1.4] ivy_presto mb-[20px]'>Key Bullets Highlighting Operational Focus:</h2>
                    <ul className='mt-[40px]'>
                        <li className='text-[#fff] mb-[35px] flex  items-center gap-[10px] text-[18px]'> <span className='h-[10px] w-[10px] bg-[#D25238] block rounded-[50%]'></span> UAE as control market; GCC and India as growth markets. </li>

                        <li className='text-[#fff] mb-[35px] flex  items-center gap-[10px] text-[18px]'> <span className='h-[10px] w-[10px] bg-[#D25238] block rounded-[50%]'></span>Flexible program models for caregiving mothers. </li>

                        <li className='text-[#fff] text-[18px] flex  items-center gap-[10px] '> <span className='h-[10px] w-[10px] bg-[#D25238] block rounded-[50%]'></span>Corporate collaborations and project-based engagements. </li>

                    </ul>

                </div>
            </div>
        </div>
    )
}
