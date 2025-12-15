import "./globals.css";
import { Nunito } from "next/font/google";
const nunito = Nunito({
  subsets: ["latin"],
  variable:'--nunito',
  weight: ["200", "300", "400", "600", "700", "900"], // choose what you need
});
export const metadata = {
  title: "ThriveHQ",
  description: "A place for real people, real stories, and real growth",
};

export default function RootLayout({ children }) {
  return (
    <html lang="en">
      <body
        className={`${nunito.variable} font-nunito antialiased`}
      >
        
        {children}
      </body>
    </html>
  );
}
