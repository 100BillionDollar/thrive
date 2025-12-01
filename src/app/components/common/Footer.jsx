import React from 'react'
import Image from 'next/image'
import Link from 'next/link';
import { FaFacebookF } from "react-icons/fa";
import { FaLinkedinIn } from "react-icons/fa6";
import { FaInstagram } from "react-icons/fa";
import { FaYoutube } from "react-icons/fa";

export default function Footer() {
    return (
        <div className=' bg-[#fff]'>
            <div className='container-custom'>
                <div className='common_padding flex justify-between'>
                    <Image src={`/assets/images/logo.png`} alt='' height={422} width={300} />
                    <ul className=''>
                        <li className='mb-4'>
                            <Link className='' href={'#'}>
                                Privacy Policy
                            </Link>
                        </li>
                        <li className='mb-4'>
                            <Link className='' href={'#'}>
                                Terms of Use

                            </Link>
                        </li>
                        <li>
                            <Link className='' href={'#'}>
                            </Link>
                        </li>
                        <li>
                            <Link className='' href={'#'}>
                                Contact Us
                            </Link>
                        </li>

                    </ul>

                </div>
                <div className='flex  justify-between py-[20px] border-t-[1px] border-[#00000033]'>
                    <ul className='flex items-center gap-5'>
                        <li>
                            <Link className='h-[25px] w-[25px] flex items-center justify-center rounded-[50%] bg-[#1B1B1B] block text-[#fff]' href={'#'}>
                                <FaFacebookF />
                            </Link>
                        </li>
                        <li>
                            <Link className='h-[25px] w-[25px] flex items-center justify-center rounded-[50%] bg-[#1B1B1B] block text-[#fff]' href={'#'}>
                                <FaLinkedinIn />
                            </Link>
                        </li>
                        <li>
                            <Link className='h-[25px] w-[25px] flex items-center justify-center rounded-[50%] bg-[#1B1B1B] block text-[#fff]' href={'#'}>
                                <FaInstagram />
                            </Link>
                        </li>
                        <li>
                            <Link className='h-[25px] w-[25px] flex items-center justify-center rounded-[50%] bg-[#1B1B1B] block text-[#fff]' href={'#'}>
                                <FaYoutube />
                            </Link>
                        </li>

                    </ul>
                    <p>Copyright notice:© Thrive	HQ</p>
                </div>
            </div>

        </div>
    )
}
