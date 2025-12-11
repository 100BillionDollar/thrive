"use client"
import React from "react";
import Button from "../common/Button";
import { useState } from "react";
import SecondaryHeading from "../common/SecondaryHeading";

export default function NewsletterForm() {
    const [isChecked, setIsChecked] = useState(false);

    return (
        <div className="common_padding bg-[#1B1B1B]"  id="newsletter">
            <div className="container-custom">
                <div className="lg:text-center mx-auto max-w-[800px]">

                    {/* Heading */}
                    <div className="heading">
                         <SecondaryHeading text={`Together, we’re building a world Where Every Human Thrives.`}/>
                       
                        <p className="text-white text-[18px] opacity-80">
                           Parenting360 brings trusted advisory, knowledge, compassion, and community to<br></br> guide and support parents through every phase of the parenthood journey.
                        </p>
                    </div>

                    <form className="pt-[40px]">
                        <div className="lg:flex rounded-[18px] py-[20px] p-[20px] items-center border border-[#9b989f] gap-[20px]  focus-within:border-[#5bc8d7] transition-all">
                           <input
                            type="email"
                            className="flex-1 lg:mb-0 mb-[20px] bg-transparent text-white placeholder:text-gray-400 placeholder:text-[16px] outline-none"
                            placeholder="Subscribe to our Newsletter"
                            />

                            <Button className={`px-[60px]`} text="Join Our Tribe" />
                        </div>

                       
                        {/* <div className="flex gap-[12px] mt-[25px] items-start">
                            <label className="flex items-start gap-3 cursor-pointer select-none relative">
                                <input
                                    type="checkbox"
                                    className="sr-only"
                                    checked={isChecked}
                                    onChange={(e) => setIsChecked(e.target.checked)}
                                />

                                <span className={`w-5 h-5 rounded border flex items-center justify-center text-white transition-all shrink-0
                         ${isChecked ? 'bg-[#29BFCF] border-[#29BFCF]' : 'border-gray-500'}`}>
                                    {isChecked && (
                                        <svg className="w-3 h-3 stroke-current"
                                            fill="none" strokeWidth="3" viewBox="0 0 24 24">
                                            <path d="M5 13l4 4L19 7" />
                                        </svg>
                                    )}
                                </span>

                                <span className="text-white opacity-80 leading-[1.5]">
                                    Consent disclaimer about data privacy and opt-out.
                                </span>
                            </label>

                        </div> */}


                    </form>
                </div>
            </div>
        </div>
    );
}
