import React from "react";
import Image from "next/image";
import SecondaryHeading from "../common/SecondaryHeading";
const data = [
  {
    id: 1,
    title: "MomsHQ",
    img: "/assets/images/home/whoweare/1.jpg",
    text: "Where every phase of motherhood finds a home — your story, your community, your growth.",
  },
  {
    id: 2,
    title: "Parenting360",
    img: "/assets/images/home/whoweare/2.jpg",
    text: "Where every phase of motherhood finds a home — your story, your community, your growth.",
  },
  {
    id: 3,
    title: "Diyaa",
    img: "/assets/images/home/whoweare/3.jpg",
    text: "Where every phase of motherhood finds a home — your story, your community, your growth.",
  },
];

export default function WhoweAre() {
  return (
    <div className="common_padding" id="whoweare">
      <div className="container-custom">
        <div className="heading">
          <SecondaryHeading customclass={`!text-[#000]`} text={`Who We Are`} />
          <p>
            A home for parents, mothers, and humans of all abilities to learn,
            connect, and thrive together.
          </p>
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-3 gap-[30px] mt-[50px]">
          {data.map((item) => (
            <div
              key={item.id}
              className="relative overflow-hidden rounded-[20px] "
            >
              <Image
                src={item.img}
                className="w-full"
                width={300}
                height={800}
                alt={item.title}
              />

              <div className="absolute h-full flex flex-col justify-end bottom-0 left-0 w-full bg-[linear-gradient(180deg,rgba(0,0,0,0)_0%,#004F55_100%)] p-[30px] pb-[60px] px-[40px] text-[#fff]">

                <div >
                  <h3 className="ivy_presto text-[32px] tracking-[1.1] mb-[10px]">
                    {item.title}
                  </h3>

                  <p

                  >
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
