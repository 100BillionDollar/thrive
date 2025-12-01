import React from 'react'
import Image from 'next/image'
import Button from './LinkButton'
import Link from 'next/link'
export default function Header() {
  return (
    <header className='absolute z-[99] px-[35px] flex justify-between items-center w-full'>
        <figure>
            <Image src={`/assets/images/logo.png`} alt='' height={100} width={246}/>
        </figure>

        <nav className='bg-[#005057ab] flex gap-[24px] px-[35px] py-[10px] rounded-[30px]' >
          <li className='list-none text-[#fff]'>
            <Link href={'#whoweare'}>Who We Are</Link>
            </li>
            <li className='list-none text-[#fff]'>
            <Link href={'#corevalue'}> Why We Are On This Journey</Link>
            </li>
            <li className='list-none text-[#fff]'>
            <Link href={'#newsletter'}>Newsletter</Link>
            </li>
          
        </nav>
        <Button text={'Contact'}/>
    </header>
  )
}
