 import React from 'react'
import Link from 'next/link'
export default function Button({event,text}) {
  return (
    <button className='bg-[var(--btn-color)] py-[12px] rounded-[30px] text-[#fff] px-[38px]' >
            {text}
    </button>
  )
}
