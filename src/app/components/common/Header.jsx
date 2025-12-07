"use client"
import React, { useState, useEffect } from 'react'
import Image from 'next/image'
import { HiMenuAlt3 } from 'react-icons/hi'
import { IoClose } from 'react-icons/io5'
import { gsap } from 'gsap'
import { ScrollToPlugin } from 'gsap/ScrollToPlugin'
import Button from './Button'
gsap.registerPlugin(ScrollToPlugin)

export default function Header() {
  const [isMenuOpen, setIsMenuOpen] = useState(false)
  const [isScrolled, setIsScrolled] = useState(false)

  const toggleMenu = () => {
    setIsMenuOpen(!isMenuOpen)
  }

  const scrollToSection = (sectionId) => {
    gsap.to(window, {
      duration: 1.2,
      scrollTo: { y: sectionId, offsetY: 80 }, 
      ease: "power3.inOut",
      onComplete: () => {
        if (isMenuOpen) toggleMenu() 
      }
    })
  }

  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 100)
    }
    window.addEventListener('scroll', handleScroll)
    return () => window.removeEventListener('scroll', handleScroll)
  }, [])

  return (
    <header className={`${isScrolled ? 'fixed top-0 bg-[#005057] shadow-lg animate-slideDown' : 'absolute'} z-[99] px-[15px] py-[15px] lg:px-[35px] flex justify-between items-center w-full transition-all duration-300`}>
      <figure>
        <Image className='lg:w-[auto] w-[180px]' src={`/assets/images/logo-white-1.png`} alt='Logo' height={100} width={246} />
      </figure>

      {/* Desktop Nav */}
      <nav className='bg-[#005057ab] hidden lg:flex gap-[40px] px-[35px] py-[12px] rounded-[30px]'>
        <li className='list-none text-[#fff] cursor-pointer' onClick={() => scrollToSection('#whoweare')}>
         The ThriveHQ Ecosystem
        </li>
        <li className='list-none text-[#fff] cursor-pointer' onClick={() => scrollToSection('#corevalues')}>
         The Heart of Our Mission    
        </li>
        <li className='list-none text-[#fff] cursor-pointer' onClick={() => scrollToSection('#newsletter')}>
          Newsletter
        </li>
      </nav>

      <div className='hidden lg:block'>
       <Button text={`Contact`}/>
      </div>

      {/* Mobile Menu Toggle */}
      <button 
        onClick={toggleMenu} 
        className='lg:hidden text-[#fff] text-[32px] z-[100]'
        aria-label='Toggle menu'
      >
        {isMenuOpen ? <IoClose className='text-[#000]' /> : <HiMenuAlt3 />}
      </button>

      {/* Mobile Menu */}
      <div className={`lg:hidden fixed top-0 right-0 w-[80%] h-screen bg-[#fff] z-[98] pt-[90px] px-[30px] transition-transform duration-300 ease-in-out ${isMenuOpen ? 'translate-x-0' : 'translate-x-full'}`}>
        <nav className='flex flex-col gap-[30px]'>
          <li className='list-none text-[#000] text-[18px] cursor-pointer' onClick={() => scrollToSection('#whoweare')}>
            Who We Are
          </li>
          <li className='list-none text-[#000] text-[18px] cursor-pointer' onClick={() => scrollToSection('#corevalues')}>
            Why We Are On This Journey
          </li>
          <li className='list-none text-[#000] text-[18px] cursor-pointer' onClick={() => scrollToSection('#newsletter')}>
            Newsletter
          </li>
          <div className='mt-[20px]'>
            <button 
              onClick={() => scrollToSection('#contact')} 
              className="bg-[#D25238] text-white px-6 py-2 rounded-full hover:bg-[#008085] transition w-full text-center"
            >
              Contact
            </button>
          </div>
        </nav>
      </div>

      {/* Backdrop */}
      <div 
        onClick={toggleMenu}
        className={`lg:hidden fixed top-0 left-0 w-full h-screen bg-black/50 z-[97] transition-opacity duration-300 ${isMenuOpen ? 'opacity-100 pointer-events-auto' : 'opacity-0 pointer-events-none'}`}
      />
    </header>
  )
}