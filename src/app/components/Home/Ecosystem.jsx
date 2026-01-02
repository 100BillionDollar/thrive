import React from "react";
import Image from "next/image";
import SecondaryHeading from "../common/SecondaryHeading";

export default function Ecosystem({ ecosystemData = [], heading = 'The ThriveHQ Ecosystem' }) {
  const dataEcosystem =  ecosystemData.map(item => ({
    id: item.id,
    title: item.name,
    img: `${process.env.NEXT_PUBLIC_API_IMAGE_URL}${item.image_path}`,
    text: item.description,
  })) 

  console.log('Ecosystem Data:', heading);
  return (
        <div className="common_padding" id="whoweare">
      <div className="container-custom">
        <div className="heading">
          <SecondaryHeading customclass={`!text-[#000]`} text={heading} />
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-3 gap-[30px] mt-[50px]">
          {dataEcosystem.map((item,index) => (
            <div
              key={item.id}
              className={`relative overflow-hidden rounded-[20px] `}
            >
              <img
                src={item.img}
                className="w-full h-full object-cover"
                width={300}
                height={800}
                alt={item.title}
              />


              <div className={`absolute  ${dataEcosystem.length-1==index?'!pb-[80px]':''} h-full flex flex-col justify-end bottom-0 left-0 w-full bg-[linear-gradient(180deg,rgba(0,0,0,0)_30%,#004F55_90%)] p-[30px] pb-[60px]  px-[30px] lg:px-[40px] text-[#fff]`}>

                <div >
                  <h3 className="ivy_presto text-[32px] tracking-[1.1] mb-[10px]">
                    {item.title}
                  </h3>

                  <p>
                    {item.text}
                  </p>
                </div>

              </div>
            </div>
          ))}
        </div>
      </div>
    </div>

  );
}
