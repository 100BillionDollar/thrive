 import React from 'react'
import Link from 'next/link'
export default function Button({link='',text}) {
  return (
    <Link className='bg-[var(--btn-color)] py-[12px] rounded-[30px] text-[#fff] px-[38px]' href={link}>
            {text}
    </Link>
  )
}
