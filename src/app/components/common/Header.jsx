"use client"
import React, { useState, useEffect } from 'react'
import Image from 'next/image'
import Button from './LinkButton'
import Link from 'next/link'
import { HiMenuAlt3 } from 'react-icons/hi'
import { IoClose } from 'react-icons/io5'

export default function Header() {
  const [isMenuOpen, setIsMenuOpen] = useState(false)
  const [isScrolled, setIsScrolled] = useState(false)

  const toggleMenu = () => {
    setIsMenuOpen(!isMenuOpen)
  }

  useEffect(() => {
    const handleScroll = () => {
      if (window.scrollY > 100) {
        setIsScrolled(true)
      } else {
        setIsScrolled(false)
      }
    }

    window.addEventListener('scroll', handleScroll)
    return () => window.removeEventListener('scroll', handleScroll)
  }, [])

  return (
    <header className={`${isScrolled ? 'fixed top-0 bg-[#005057] shadow-lg animate-slideDown' : 'absolute'} z-[99] px-[15px] lg:px-[35px] flex justify-between items-center w-full transition-all duration-300`}>
        <figure>
         {
          isScrolled?<Image src={`/assets/images/logo-white.png`} alt='' height={100} width={246}/>:<Image src={`/assets/images/logo.png`} alt='' height={100} width={246}/>
         }   
        </figure>

        {/* Desktop Navigation */}
        <nav className='bg-[#005057ab] hidden lg:flex gap-[24px] px-[35px] py-[10px] rounded-[30px]'>
          <li className='list-none text-[#fff]'>
            <Link href={'#whoweare'}>Who We Are</Link>
          </li>
          <li className='list-none text-[#fff]'>
            <Link href={'#corevalue'}>Why We Are On This Journey</Link>
          </li>
          <li className='list-none text-[#fff]'>
            <Link href={'#newsletter'}>Newsletter</Link>
          </li>
        </nav>

        {/* Desktop Contact Button */}
        <div className='hidden lg:block'>
          <Button text={'Contact'}/>
        </div>

        {/* Mobile Hamburger Icon */}
        <button 
          onClick={toggleMenu} 
          className='lg:hidden text-[#fff] text-[32px] z-[100]'
          aria-label='Toggle menu'
        >
          {isMenuOpen ? <IoClose /> : <HiMenuAlt3 />}
        </button>

        {/* Mobile Menu */}
        <div className={`lg:hidden fixed top-0 right-0 w-[70%] h-screen bg-[#005057] z-[98] pt-[120px] px-[30px] transition-transform duration-300 ease-in-out ${isMenuOpen ? 'translate-x-0' : 'translate-x-full'}`}>
          <nav className='flex flex-col gap-[30px]'>
            <li className='list-none text-[#fff] text-[18px]'>
              <Link href={'#whoweare'} onClick={toggleMenu}>Who We Are</Link>
            </li>
            <li className='list-none text-[#fff] text-[18px]'>
              <Link href={'#corevalues'} onClick={toggleMenu}>Why We Are On This Journey</Link>
            </li>
            <li className='list-none text-[#fff] text-[18px]'>
              <Link href={'#newsletter'} onClick={toggleMenu}>Newsletter</Link>
            </li>
            <div className='mt-[20px]'>
              <Button text={'Contact'}/>
            </div>
          </nav>
        </div>

        {/* Overlay */}
        <div 
          onClick={toggleMenu}
          className={`lg:hidden fixed top-0 left-0 w-full h-screen bg-black/50 z-[97] transition-opacity duration-300 ${isMenuOpen ? 'opacity-100 pointer-events-auto' : 'opacity-0 pointer-events-none'}`}
        />
    </header>
  )
}