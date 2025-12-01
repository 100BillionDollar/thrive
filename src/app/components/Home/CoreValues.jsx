import React from 'react'
import CoreValueIcon from './corevalues/CoreValueIcon'
import Keypoint from './corevalues/Keypoint'
export default function CoreValues() {
  return (
    <div className='common_padding bg-[var(--green_light)]' id='corevalues'>
        <div className='container-custom'>
                <div className='heading'>
                    <h2  className='text-[54px] text-[#fff] leading-[1.4] ivy_presto mb-[20px]'>Why We Are On This Journey</h2>
                    <p className='text-[#fff] leading-[1.8] font-[100]'>We are a group of passionate mothers who came together to build the space we once needed — a space where support is accessible, inclusion feels natural, and every story has a safe place to be heard. We are on this journey because, as mothers, we believe that every family deserves support, every story deserves to be understood, and every human deserves to be celebrated. Our lived experiences shaped our purpose: to create an ecosystem where real lives, real emotions, and real challenges are met with compassion, guidance, and connection. This is why we are building Thrive HQ. </p>
                    <p className='mt-[25px] text-[#fff]'>
                        <strong>We are envisioning an evolving ecosystem where growth is accessible, inclusion is normal,  and every human is empowered to thrive.</strong>
                    </p>

               
                </div>
                 <CoreValueIcon/>
                <Keypoint/>
        </div>
    </div>
  )
}
