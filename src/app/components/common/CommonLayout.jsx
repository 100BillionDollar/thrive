import React from 'react'
import Header from './Header'
import Footer from './Footer'
export default function CommonLayout({children}) {
  return (
    <>
      <Header/>
      {children}
      <Footer/>
    </>
  )
}
