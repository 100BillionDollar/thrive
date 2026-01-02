import React from 'react'
import Image from 'next/image'
import Link from 'next/link';
import { FaFacebookF } from "react-icons/fa";
import { FaInstagram } from "react-icons/fa";
import { MdOutlineMailOutline } from "react-icons/md";

export default function Footer() {
    return (
        <div className='bg-[#fff]'>
            <div className='container-custom'>
                <div className=' py-[30px] flex flex-col  flex-wrap items-center justify-center'>
                <Link href="/">  
                <Image src={`/assets/images/logo-dark-1.png`} alt='' height={422} width={300} />
                 </Link>
                    <ul className='flex items-center mt-[25px] gap-5'>
                        <li>
                            <Link className='h-[75px] w-[75px] flex items-center justify-center rounded-[50%] bg-[#1B1B1B] block text-[#fff]' href={'https://www.instagram.com/parenting360hq/'} target='_blank'>
                                {/* <FaFacebookF  className='h-6 w-6' /> */}
                                <Image class="rounded-[50%]" src={`/assets/images/Parenting360.jpg`} alt='Parenting360' height={150} width={150}/>
                            </Link>
                        </li>
                        <li>
                            <Link className='h-[75px] w-[75px] flex items-center justify-center rounded-[50%] bg-[#1B1B1B] block text-[#fff]' href={'https://www.instagram.com/momshq/'} target='_blank'>
                                {/* <FaInstagram className='h-8 w-8' /> */}
                            <Image class="rounded-[50%]" src={`/assets/images/MomsHQ.jpg`} alt='MomsHQ' height={150} width={150}/>

                            </Link>
                        </li>
                        

                    </ul>
                    
                    <ul className=' flex items-center my-[35px] gap-[20px] '>
                        <li >
                            <Link className='' href={'privacy-policy'}>
                                Privacy Policy
                            </Link>
                        </li>
                        <li >
                            <Link className='' href={'terms-and-conditions'}>
                                Terms of Use

                            </Link>
                        </li>
                      
                    </ul>
                    <div className='flex items-center  gap-2'>
                        <MdOutlineMailOutline  className='h-5 w-5'/>
                        <a className='underline' href="mailto:media@themomshq.me">media@themomshq.me</a>
                    </div>
                </div>
                <div className='text-center py-[20px] border-t-[1px] border-[#00000033]'>
                       
                    <p>Copyright © 2025 ThriveHQ FZ-LLC. All rights reserved.</p>
                </div>
            </div>

        </div>
    )
}
