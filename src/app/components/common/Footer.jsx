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
                
 <Image src={`/assets/images/logo.png`} alt='' height={422} width={300} />
                    <ul className='flex items-center gap-5'>
                        <li>
                            <Link className='h-[45px] w-[45px] flex items-center justify-center rounded-[50%] bg-[#1B1B1B] block text-[#fff]' href={'#'}>
                                <FaFacebookF  className='h-6 w-6' />
                            </Link>
                        </li>
                        <li>
                            <Link className='h-[45px] w-[45px] flex items-center justify-center rounded-[50%] bg-[#1B1B1B] block text-[#fff]' href={'#'}>
                                <FaInstagram className='h-8 w-8' />
                            </Link>
                        </li>
                        

                    </ul>
                    
                    <ul className=' flex items-center my-[35px] gap-[20px] '>
                        <li >
                            <Link className='' href={'#'}>
                                Privacy Policy
                            </Link>
                        </li>
                        <li >
                            <Link className='' href={'#'}>
                                Terms of Use

                            </Link>
                        </li>
                      
                    </ul>
                    <div className='flex  gap-2'>
                        <MdOutlineMailOutline  className='h-5 w-5'/>
                        <a className='underline' href="mailto:media@themomshq.me">media@themomshq.me</a>
                    </div>
                </div>
                <div className='text-center py-[20px] border-t-[1px] border-[#00000033]'>
                       
                    <p>Copyright notice:© Thrive	HQ</p>
                </div>
            </div>

        </div>
    )
}
