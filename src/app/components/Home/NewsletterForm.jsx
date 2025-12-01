"use client"
import React from "react";
import Button from "../common/Button";
import { useState } from "react";

export default function NewsletterForm() {
    const [isChecked, setIsChecked] = useState(false);

    return (
        <div className="common_padding bg-[#1B1B1B]"  id="newsletter">
            <div className="container-custom">
                <div className="text-center mx-auto max-w-[800px]">

                    {/* Heading */}
                    <div className="heading">
                        <h2 className="text-[40px] text-white leading-[1.3] ivy_presto mb-[20px]">
                            Together, We’re Building a World Where Every Human Is Thriving.
                        </h2>
                        <p className="text-white text-[18px] opacity-80">
                            Subscribe for content, conversations, and updates that support
                            mothers, parents, and children of all abilities.
                        </p>
                    </div>

                    {/* Form */}
                    <form className="pt-[40px]">
                        {/* Input Field */}
                        <div className="flex rounded-[18px] p-[25px] items-center border border-[#3f3d42] gap-[20px]  focus-within:border-[#5bc8d7] transition-all">
                            <input
                                type="email"
                                className="flex-1 bg-transparent text-white placeholder:text-gray-400 placeholder:text-[16px] outline-none"
                                placeholder="Signup form with email..."
                            />

                            <Button text="Join Our Tribe" />
                        </div>

                        {/* Custom Checkbox */}
                        {/* Custom Checkbox */}
                        <div className="flex gap-[12px] mt-[25px] items-start">
                            <label className="flex items-start gap-3 cursor-pointer select-none relative">
                                {/* Checkbox input */}
                                <input
                                    type="checkbox"
                                    className="sr-only"
                                    checked={isChecked}
                                    onChange={(e) => setIsChecked(e.target.checked)}
                                />

                                {/* Custom checkbox */}
                                <span className={`w-5 h-5 rounded border flex items-center justify-center text-white transition-all shrink-0
                         ${isChecked ? 'bg-[#29BFCF] border-[#29BFCF]' : 'border-gray-500'}`}>
                                    {isChecked && (
                                        <svg className="w-3 h-3 stroke-current"
                                            fill="none" strokeWidth="3" viewBox="0 0 24 24">
                                            <path d="M5 13l4 4L19 7" />
                                        </svg>
                                    )}
                                </span>

                                {/* Label text */}
                                <span className="text-white opacity-80 leading-[1.5]">
                                    Consent disclaimer about data privacy and opt-out.
                                </span>
                            </label>

                        </div>


                    </form>
                </div>
            </div>
        </div>
    );
}
