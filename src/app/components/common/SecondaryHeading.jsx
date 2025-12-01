import React from 'react'

export default function SecondaryHeading({text,customclass}) {
  return (
    <h2 className={`ivy_presto mb-[20px] ${customclass} text-[#fff] tracking-[1.1] text-[20px] text-[35px] lg:text-[48px]`}>{text}</h2>
  )
}
