/** @type {import('next').NextConfig} */
const nextConfig = {
  output: 'export',
  trailingSlash: true,
  reactCompiler: true,

  images: {
    unoptimized: true,
    domains: ['localhost','https://wearethrivehq.com/'],
    remotePatterns: [
      {
        protocol: 'http',
        hostname: 'localhost',
        port: '',
        pathname: '/thrive/admin/assets/images/uploads/**',
      },
    ],
  },
};

export default nextConfig;
