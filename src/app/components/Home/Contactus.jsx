import React from 'react'
import Image from 'next/image'
import Form from '../common/Form'
export default function Contactus() {
    return (
        <div>
            <div className='grid bg-[#fff] grid-cols-1 lg:grid-cols-12'>
                <div className='lg:col-span-5'>
                    <Image src={`/assets/images/home/contact/contact-left.jpg`} alt='' className='h-full' height={811} width={795} />
                </div>
                <div className='lg:col-span-7 relative bg-[var(--green_dark)] '>
                    <img src={'/assets/images/home/contact/pattern.jpg'}  className='absolute top-0 left-0 h-full w-full bg-[var(--green_dark)]' alt='pattern'  />
                    <div className='lg:p-[80px] px-[15px] py-[40px] relative'>
                    <h2 className='ivy_presto text-[#fff] tracking-[1.1] text-[20px] text-[35px] lg:text-[40px]'>Contact Us</h2>
                    <p className='text-[#fff] mt-[10px] text-[18px]'>
                        Response	within	two	business	day
                    </p>
                       <Form/>
                    </div>
                 
                </div>
            </div>

        </div>
    )
}
 