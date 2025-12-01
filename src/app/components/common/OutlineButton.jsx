import React from 'react'
import Link from 'next/link'
export default function OutlineButton({link='',text}) {
  return (
    <Link className='border-[1px] border-[solid] border-[var(--green_dark)]
     text-[var(--green_dark)] py-[12px] rounded-[30px] text-[#fff] px-[38px]' href={link}>
            {text}
    </Link>
  )
}
