 import React from 'react'
import Link from 'next/link'
export default function Button({onClick,text,className}) {
  return (
    <button onClick={onClick} className={`bg-[var(--btn-color)] cursor-pointer py-[12px] rounded-[30px] text-[#fff] px-[38px] ${className}`} >
            {text}
    </button>
  )
}
