import React from 'react'
import Image from 'next/image'
import SecondaryHeading from '../common/SecondaryHeading'
import Keypoint from './corevalues/Keypoint'
export default function CoreValues({ whoweare = [] }) {
console.log('CoreValues whoweare data:', whoweare);
  return (
  <div className='common_padding bg-[var(--green_light)]' id='corevalues'>
      <div className='container-custom'>
        <div className='heading'>
          <SecondaryHeading text={whoweare[0]?.title || "The Heart of Our Mission"} />
        </div>
        <Keypoint whoweare={whoweare} />
      </div>
    </div>
  )
}
