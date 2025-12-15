"use client"
import React from "react";
import Button from "../common/Button";
import { useState } from "react";
import SecondaryHeading from "../common/SecondaryHeading";

export default function NewsletterForm() {
    const [isChecked, setIsChecked] = useState(false);
    const [email, setEmail] = useState("");
    const [emailError, setEmailError] = useState("");
    const [isSubmitted, setIsSubmitted] = useState(false);

    // Email validation function
    const validateEmail = (email) => {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    };

    // Handle form submission
    const handleSubmit = (e) => {
        e.preventDefault();
        
        // Reset error
        setEmailError("");

        // Validate email
        if (!email) {
            setEmailError("Please enter your email address");
            return;
        }

        if (!validateEmail(email)) {
            setEmailError("Please enter a valid email address");
            return;
        }

        // If validation passes, show success message
        setIsSubmitted(true);
        
        // Reset form after 5 seconds
        setTimeout(() => {
            setIsSubmitted(false);
            setEmail("");
        }, 5000);
    };

    return (
        <div className="common_padding bg-[#1B1B1B]" id="newsletter">
            <div className="container-custom">
                <div className="lg:text-center mx-auto max-w-[800px]">

                    {/* Heading */}
                    <div className="heading">
                        <SecondaryHeading text={`Together, we're building a world Where Every Human Thrives.`}/>
                       
                        <p className="text-white text-[18px] opacity-80">
                            Subscribe for content, conversations, and updates that support<br></br> parents, mothers, children, and people of different abilities.
                        </p>
                    </div>

                    {/* Success Message */}
                    {isSubmitted ? (
                        <div className="pt-[40px]">
                            <div className="rounded-[18px] py-[30px] px-[20px] bg-[#29BFCF]/10 border border-[#29BFCF]">
                                <div className="flex items-center justify-center gap-3 mb-3">
                                    <svg className="w-8 h-8 text-[#29BFCF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <h3 className="text-[#29BFCF] text-[24px] font-semibold">Thank You for Subscribing!</h3>
                                </div>
                                <p className="text-white opacity-80 text-center">
                                    Welcome to our tribe! You'll start receiving our newsletter soon.
                                </p>
                            </div>
                        </div>
                    ) : (
                        <form onSubmit={handleSubmit} className="pt-[40px]">
                            <div className={`lg:flex rounded-[18px] py-[20px] p-[20px] items-center border gap-[20px] transition-all
                                ${emailError ? 'border-red-500' : 'border-[#9b989f] focus-within:border-[#5bc8d7]'}`}>
                                <input
                                    type="email"
                                    value={email}
                                    onChange={(e) => {
                                        setEmail(e.target.value);
                                        setEmailError(""); // Clear error on typing
                                    }}
                                    className="flex-1 lg:mb-0 mb-[20px] bg-transparent text-white placeholder:text-gray-400 placeholder:text-[16px] outline-none"
                                    placeholder="Subscribe to our Newsletter"
                                />

                                <Button type="submit" className={`px-[60px]`} text="Join Our Tribe" />
                            </div>

                            {/* Error Message */}
                            {emailError && (
                                <p className="text-red-500 text-[14px] mt-2 text-left lg:text-left">
                                    {emailError}
                                </p>
                            )}
                        </form>
                    )}
                </div>
            </div>
        </div>
    );
}