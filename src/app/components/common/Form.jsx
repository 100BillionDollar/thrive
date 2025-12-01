"use client"
import React, { useState } from 'react';
import Button from './Button';
export default function Form() {
  const [formData, setFormData] = useState({
    fullName: '',
    workEmail: '',
    organisation: '',
    message: ''
  });

  const [errors, setErrors] = useState({});
  const [isSubmitted, setIsSubmitted] = useState(false);

  const validateForm = () => {
    const newErrors = {};

    // Full Name validation
    if (!formData.fullName.trim()) {
      newErrors.fullName = 'Full name is required';
    }

    // Work Email validation
    if (!formData.workEmail.trim()) {
      newErrors.workEmail = 'Work email is required';
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.workEmail)) {
      newErrors.workEmail = 'Please enter a valid email address';
    }

    // Organisation validation
    if (!formData.organisation.trim()) {
      newErrors.organisation = 'Organisation is required';
    }

    // Message validation
    if (!formData.message.trim()) {
      newErrors.message = 'Message is required';
    } else if (formData.message.trim().length < 10) {
      newErrors.message = 'Message must be at least 10 characters';
    }

    setErrors(newErrors);
    return Object.keys(newErrors).length === 0;
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: value
    }));
    
    // Clear error for this field when user starts typing
    if (errors[name]) {
      setErrors(prev => ({
        ...prev,
        [name]: ''
      }));
    }
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    
    if (validateForm()) {
      setIsSubmitted(true);
      console.log('Form submitted:', formData);
      
      // Reset form after 3 seconds
      setTimeout(() => {
        setFormData({
          fullName: '',
          workEmail: '',
          organisation: '',
          message: ''
        });
        setIsSubmitted(false);
      }, 3000);
    }
  };

  return (
      <div className="w-full max-w-2xl">
        
        <form onSubmit={handleSubmit} className="space-y-4 mt-6">
          <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <input
                type="text"
                name="fullName"
                placeholder="Full Name"
                value={formData.fullName}
                onChange={handleChange}
                className={`w-full px-4 py-[18px] bg-[#003E43] border ${
                  errors.fullName ? 'border-red-400' : 'border-[#FFFFFF66]'
                } rounded-[20px] text-white placeholder-[#C4C4C4] focus:outline-none focus:border-teal-400 transition-colors`}
              />
              {errors.fullName && (
                <p className="text-red-300 text-sm mt-1">{errors.fullName}</p>
              )}
            </div>

            <div>
              <input
                type="email"
                name="workEmail"
                placeholder="Work Email"
                value={formData.workEmail}
                onChange={handleChange}
                className={`w-full px-4 py-[18px] bg-[#003E43] border ${
                  errors.workEmail ? 'border-red-400' : 'border-[#FFFFFF66]'
                } rounded-[20px] text-white placeholder-[#C4C4C4] focus:outline-none focus:border-teal-400 transition-colors`}
              />
              {errors.workEmail && (
                <p className="text-red-300 text-sm mt-1">{errors.workEmail}</p>
              )}
            </div>
          </div>

          {/* Organisation */}
          <div>
            <input
              type="text"
              name="organisation"
              placeholder="Organisation"
              value={formData.organisation}
              onChange={handleChange}
              className={`w-full px-4 py-[18px] bg-[#003E43] border ${
                errors.organisation ? 'border-red-400' : 'border-[#FFFFFF66]'
              } rounded-[20px] text-white placeholder-[#C4C4C4] focus:outline-none focus:border-teal-400 transition-colors`}
            />
            {errors.organisation && (
              <p className="text-red-300 text-sm mt-1">{errors.organisation}</p>
            )}
          </div>

          {/* Message */}
          <div>
            <textarea
              name="message"
              placeholder="Message"
              rows="5"
              value={formData.message}
              onChange={handleChange}
              className={`w-full px-4 py-[18px] bg-[#003E43] border ${
                errors.message ? 'border-red-400' : 'border-[#FFFFFF66]'
              } rounded-[20px] text-white placeholder-[#C4C4C4] focus:outline-none focus:border-teal-400 transition-colors resize-none`}
            />
            {errors.message && (
              <p className="text-red-300 text-sm mt-1">{errors.message}</p>
            )}
          </div>

          {/* Submit Button */}
                <Button text={`Submit`}/>
          {/* Success Message */}
          {isSubmitted && (
            <p className="text-green-300 text-sm mt-2">
              Thank you! We'll respond within two business days.
            </p>
          )}
        </form>
    </div>
  );
}