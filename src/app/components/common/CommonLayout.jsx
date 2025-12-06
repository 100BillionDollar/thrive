import React from 'react'
import Header from './Header'
import Footer from './Footer'
import ScrollSmootherWrapper from './ScrollSmoother'
export default function CommonLayout({children}) {
  return (
    <>
      <Header/>

          <ScrollSmootherWrapper>

      {children}
      <Footer/>
      </ScrollSmootherWrapper>
    </>
  )
}
