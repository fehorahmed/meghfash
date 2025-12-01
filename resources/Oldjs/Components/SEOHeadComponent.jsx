import { Head } from "@inertiajs/react";
export default function SEOHeadComponent({
    title,
    description,
    keyword,
    image,
    url
}) {
  return (
    <Head title={title}>
        <meta name="title" property="og:title" content={title} />
        <meta name="description" property="og:description" content={description} />
        <meta name="keyword" property="og:keyword" content={keyword}/>
        <meta name="image" property="og:image" content={image} />
        <meta name="url" property="og:url" content={url} />
        <link rel="canonical" href={url} />
    </Head>
  )
}